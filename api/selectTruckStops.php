<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";

if(!isset($_SESSION["operator_id"])) {
    exit ();
}

try {
    $result = DB::getMDB()->query ( "SELECT
                                        *
                                     FROM 
                                        cargo_truck_stops
                                     WHERE
                                        truck_id=%d
                                     ORDER BY stop_id ASC", $_SESSION['entry-id']);
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
    'data' => $data,
];

// error_log(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
