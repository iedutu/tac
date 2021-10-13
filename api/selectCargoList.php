<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/class-list-util.php";

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

error_log($_REQUEST['sort']['field']);

// Sorting
// Cleaning up the request from the other pages.
if(empty($_SESSION['previous_area'])) {
    $_REQUEST['sort']['sort'] = 'desc';
    $_REQUEST['sort']['field'] = 'id';

    $_SESSION['previous_area'] = 'cargo';
}
else {
    if($_SESSION['previous_area'] == 'truck') {
        $_REQUEST['sort']['sort'] = 'desc';
        $_REQUEST['sort']['field'] = 'id';

        $_SESSION['previous_area'] = 'cargo';
    }
}

$sort  = ! empty($_REQUEST['sort']['sort']) ? $_REQUEST['sort']['sort'] : 'desc';
$field = ! empty($_REQUEST['sort']['field']) ? $_REQUEST['sort']['field'] : 'id';

// Filters
$filter = '';

$query = isset($_REQUEST['query']) && is_array($_REQUEST['query']) ? $_REQUEST['query'] : null;
if (is_array($query)) {
    $query = array_filter($query);
    foreach ($query as $key => $val) {
        $filter .= '('.$key.'="'.$val.'") and ';
    }
}

error_log('Filter to be applied: '.$filter);

// 25.01.2017. Removed the OR status=2 clause to clean-up the closed requests.
try {
    $result = DB::getMDB()->query ( "
                       SELECT
                            id,
                            DATE_FORMAT(expiration, %s) expiration,
                            client,
                            from_city,
                            to_city,
                            status,
                            ameta,
                            plate_number,
                            order_type,
                            originator_office,
                            recipient_office,
                            originator_name,
                            recipient_name
                       FROM 
                            cargo_request 
                       WHERE 
						(
							((status = 1) AND (SYSDATE() < (expiration + INTERVAL 1 DAY))) OR
							((status = 2) AND (SYSDATE() < (acceptance + INTERVAL %d DAY)))
						)
						AND
						(
							originator in (SELECT username FROM cargo_users WHERE ".$condition.") OR
							recipient in (SELECT username FROM cargo_users WHERE ".$condition.")
						)
					    order by ".$field." ".$sort, Utils::$SQL_DATE_FORMAT, Utils::$CARGO_PERIOD);

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
