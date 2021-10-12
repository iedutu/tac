<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!isset($_SESSION["operator_id"])) {
    header ( 'Location: index.php?page=login' );
    exit ();
}

$condition = '';
$separator = '';

if($_SESSION['operator_class']['turkey']) {
    $condition = $condition.'turkey = 1';
    $separator = ' OR ';
}
if($_SESSION['operator_class']['greece']) {
    $condition = $condition.$separator.'greece = 1';
    $separator = ' OR ';
}
if($_SESSION['operator_class']['serbia']) {
    $condition = $condition.$separator.'serbia = 1';
    $separator = ' OR ';
}
if($_SESSION['operator_class']['romania']) {
    $condition = $condition.$separator.'romania = 1';
}

if($_SESSION['operator_class']['moldova']) {
    $condition = $condition.$separator.'moldova = 1';
}

$sort  = ! empty($_REQUEST['sort']['sort']) ? $_REQUEST['sort']['sort'] : 'desc';
$field = ! empty($_REQUEST['sort']['field']) ? $_REQUEST['sort']['field'] : 'id';

// 25.01.2017. Removed the OR status=2 clause to clean-up the closed requests.
try {
    $result = DB::getMDB()->query ( "SELECT
                                        a.id id, 
                                        a.originator originator, 
                                        a.recipient recipient, 
                                        DATE_FORMAT(a.expiration, '%%d-%%m-%%Y') expiration, 
                                        a.from_city from_city, 
                                        b.city to_city, 
                                        a.details details, 
                                        a.status status, 
                                        a.plate_number plate_number, 
                                        a.cargo_type cargo_type, 
                                        a.order_type order_type, 
                                        a.truck_type truck_type, 
                                        DATE_FORMAT(a.loading_date, '%%d-%%m-%%Y') loading_date, 
                                        DATE_FORMAT(a.unloading_date, '%%d-%%m-%%Y') unloading_date, 
                                        a.freight freight, 
                                        a.ameta ameta
                                     FROM 
                                        cargo_truck a,
                                        cargo_truck_stops b
                                     WHERE
                                        (
                                            (a.id = b.truck_id) 
                                            AND 
                                            (b.stop_id = (
                                                            SELECT max(stop_id) from cargo_truck_stops where truck_id=b.truck_id
                                                         )
                                            )
                                        )
                                     AND
                                        ((status = 0) OR (status = 1))
                                     AND
                                        (
                                           originator in (SELECT username FROM cargo_users WHERE ".$condition.") OR
                                           recipient in (SELECT username FROM cargo_users WHERE ".$condition.")
                                        )
                                     order by ".$field." ".$sort, Utils::$CARGO_PERIOD);

    // error_log(DB::getMDB()->lastQuery());
}
catch (MeekroDBException $mdbe) {
    error_log("Database error: ".$mdbe->getMessage());
    return null;
}
catch (Exception $e) {
    error_log("Database error: ".$e->getMessage());
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
