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

    $_SESSION['previous_area'] = 'matches';
}
else {
    if(($_SESSION['previous_area'] == 'cargo') || ($_SESSION['previous_area'] == 'truck')){
        $_REQUEST['sort']['sort'] = 'desc';
        $_REQUEST['sort']['field'] = 'id';

        $_SESSION['previous_area'] = 'matches';
    }
}

// Settings
$sort  = ! empty($_REQUEST['sort']['sort']) ? $_REQUEST['sort']['sort'] : 'desc';
$field = ! empty($_REQUEST['sort']['field']) ? $_REQUEST['sort']['field'] : 'availability';

// Filters
$filter = '';

$query = isset($_REQUEST['query']) && is_array($_REQUEST['query']) ? $_REQUEST['query'] : null;
if (is_array($query)) {
    $query = array_filter($query);
    foreach ($query as $key => $val) {
        $filter .= '('.$key.'="'.$val.'") and ';
    }
}

try {
    $result = DB::getMDB()->query ( "
                       SELECT
                            a.id 'id',
                            DATE_FORMAT(a.availability, %s) 'availability',
                            DATE_FORMAT(a.item_date, %s) 'item_date',
                            a.item_id 'item_id',
                            a.item_kind 'item_kind',
                            a.from_city 'from_city',
                            a.to_city 'to_city',
                            a.status 'status',
                            a.ameta 'ameta',
                            a.adr 'adr',
                            a.loading_meters 'loading_meters',
                            a.weight 'weight',
                            a.volume 'volume',
                            a.plate_number 'plate_number',
                            a.order_type 'order_type',
                            b.name 'originator_name',
                            c.name 'recipient_name',
                            d.name 'originator_office',
                            e.name 'recipient_office' 
                       FROM 
                            cargo_match a,
                            cargo_users b, 
                            cargo_users c, 
                            cargo_offices d, 
                            cargo_offices e
                       WHERE 
                        (
                            (a.originator_id=b.id and b.office_id=d.id)
                            AND
                            (a.recipient_id=c.id and c.office_id=e.id)
                        )
                        AND
						(
                            (a.originator_id=b.id AND b.country_id=1)
                            OR
                            (a.recipient_id=c.id AND c.country_id=1)
						)
					    order by ".$field." ".$sort, Utils::$SQL_DATE_FORMAT, Utils::$SQL_DATE_FORMAT);

    // error_log(DB::getMDB()->lastQuery());
}
catch (MeekroDBException $mdbe) {
    error_log("Database error: ".$mdbe->getMessage());
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Database error ('.$mdbe->getCode().':'.$mdbe->getMessage().'). Please contact your system administrator.';

    return 0;
}
catch (Exception $e) {
    error_log("Database error: ".$e->getMessage());
    $_SESSION['alert']['type'] = 'error';
    $_SESSION['alert']['message'] = 'Database error ('.$e->getCode().':'.$e->getMessage().'). Please contact your system administrator.';

    return 0;
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
