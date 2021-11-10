<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/class-list-util.php";

if(!isset($_SESSION['operator']['id'])) {
    exit ();
}

// Sorting
// Cleaning up the request from the other pages.
if(empty($_SESSION['previous_area'])) {
    $_REQUEST['sort']['sort'] = 'desc';
    $_REQUEST['sort']['field'] = 'id';

    $_SESSION['previous_area'] = 'truck';
}
else {
    if(($_SESSION['previous_area'] == 'cargo') || ($_SESSION['previous_area'] == 'matches')){
        $_REQUEST['sort']['sort'] = 'desc';
        $_REQUEST['sort']['field'] = 'id';

        $_SESSION['previous_area'] = 'truck';
    }
}

$sort  = ! empty($_REQUEST['sort']['sort']) ? $_REQUEST['sort']['sort'] : 'desc';
$field = ! empty($_REQUEST['sort']['field']) ? $_REQUEST['sort']['field'] : 'id';

// 25.01.2017. Removed the OR status=2 clause to clean-up the closed requests.
try {
    $result = DB::getMDB()->query ( "SELECT
                                        a.id as 'id', 
                                        DATE_FORMAT(a.expiration, %s) as 'expiration', 
                                        a.from_city as 'from_city', 
                                        f.city as 'to_city', 
                                        a.details as 'details', 
                                        a.status as 'status', 
                                        a.plate_number as 'plate_number', 
                                        a.cargo_type as 'cargo_type', 
                                        a.truck_type as 'truck_type', 
                                        DATE_FORMAT(a.loading_date, %s) as 'loading_date', 
                                        DATE_FORMAT(a.unloading_date, %s) as 'unloading_date', 
                                        a.freight as 'freight', 
                                        a.ameta as 'ameta',
                                        b.name as 'originator_name',
                                        b.username as 'originator_email',
                                        c.name as 'recipient_name', 
                                        c.username as 'recipient_email',
                                        d.name as 'originator_office',
                                        e.name as 'recipient_office',
                                        d.country as 'originator_country',
                                        e.country as 'recipient_country'
                                     FROM 
                                        cargo_truck a,
                                        cargo_users b, 
                                        cargo_users c, 
                                        cargo_offices d, 
                                        cargo_offices e,
                                        cargo_truck_stops f
                                     WHERE
                                        (
                                            (a.id = f.truck_id) 
                                            AND 
                                            (f.stop_id = (
                                                            SELECT max(stop_id) from cargo_truck_stops where truck_id=f.truck_id
                                                         )
                                            )
                                        )
                                        AND
                                        (
                                            (a.status < %d)
                                            OR 
                                            (
                                                (a.status = %d)
                                                AND
                                                (NOW() < DATE_ADD(a.SYS_UPDATE_DATE, INTERVAL %d DAY))
                                            )
                                        )
                                        AND
                                        (
                                            (a.originator_id=b.id and b.office_id=d.id)
                                            AND
                                            (a.recipient_id=c.id and c.office_id=e.id)
                                        )
                                        order by ".$field." ".$sort,
                                                Utils::$SQL_DATE_FORMAT,
                                                Utils::$SQL_DATE_FORMAT,
                                                Utils::$SQL_DATE_FORMAT,
                                                AppStatuses::$TRUCK_FULLY_SOLVED,
                                                AppStatuses::$TRUCK_FULLY_SOLVED,
                                                Utils::$SOLVED_TRUCK_DAYS,
                                    );

} catch (MeekroDBException $mdbe) {
    Utils::handleMySQLException($mdbe);
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

    return null;
} catch (Exception $e) {
    Utils::handleException($e);
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'General error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

    return null;
}

$data = $alldata = $result;

$datatable = array_merge(['pagination' => [], 'sort' => [], 'query' => []], $_REQUEST);

// search filter by keywords
$filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch'])
    ? $datatable['query']['generalSearch'] : '';
if ( ! empty($filter)) {
    $data = array_filter($data, function ($a) use ($filter) {
        return (boolean)preg_grep("/$filter/i", (array)$a);
    });
    unset($datatable['query']['generalSearch']);
}

// filter by field query
$query = isset($datatable['query']) && is_array($datatable['query']) ? $datatable['query'] : null;
if (is_array($query)) {
    $query = array_filter($query);
    foreach ($query as $key => $val) {
        $data = list_filter($data, [$key => $val]);
    }
}

$meta    = [];
$page    = ! empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
$perpage = ! empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

$pages = 1;
$total = count($data); // total items in array

// $perpage 0; get all data
if ($perpage > 0) {
    $pages  = ceil($total / $perpage); // calculate total pages
    $page   = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
    $page   = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
    $offset = ($page - 1) * $perpage;
    if ($offset < 0) {
        $offset = 0;
    }

    $data = array_slice($data, $offset, $perpage, true);
}

$meta = [
    'page'    => $page,
    'pages'   => $pages,
    'perpage' => $perpage,
    'total'   => $total,
];

// if selected all records enabled, provide all the ids
if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
    $meta['rowIds'] = array_map(function ($row) {
        foreach($row as $first) break;
        return $first;
    }, $alldata);
}


header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

$result = [
    'meta' => $meta + [
            'sort'  => $sort,
            'field' => $field,
        ],
    'data' => $data,
];

echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
