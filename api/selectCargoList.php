<?php
session_start();

include $_SERVER["DOCUMENT_ROOT"]."/lib/includes.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/lib/class-list-util.php";

if(!isset($_SESSION['operator']['id'])) {
    exit ();
}

$default_sort_order = 'desc';
$default_sort_key = 'id';

$data = $alldata = DB_utils::selectCargoList();

$datatable = array_merge(array('pagination' => array(), 'sort' => array(), 'query' => array()), $_REQUEST);

// search filter by keywords
$filter = isset($datatable['query']['generalSearch']) && is_string($datatable['query']['generalSearch']) ? $datatable['query']['generalSearch'] : '';
if (!empty($filter)) {
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
        $data = list_filter($data, array($key => $val));
    }
}

$sort = !empty($datatable['sort']['sort']) ? $datatable['sort']['sort'] : $default_sort_order;
$field = !empty($datatable['sort']['field']) ? $datatable['sort']['field'] : $default_sort_key;

$meta = array();
$page = !empty($datatable['pagination']['page']) ? (int)$datatable['pagination']['page'] : 1;
$perpage = !empty($datatable['pagination']['perpage']) ? (int)$datatable['pagination']['perpage'] : -1;

$pages = 1;
$total = 0;
if(!empty($data)) {
    $total = count($data); // total items in array

    // sort
    usort($data, function ($a, $b) use ($sort, $field) {
        if (!isset($a[$field]) || !isset($b[$field])) {
            return -1;
        }
    
        if ($sort === 'asc') {
            return $a[$field] > $b[$field] ? 1 : -1;
        }

        return $a[$field] < $b[$field] ? 1 : -1;
    });
}

// $perpage 0; get all data
if ($perpage > 0) {
    $pages = ceil($total / $perpage); // calculate total pages
    $page = max($page, 1); // get 1 page when $_REQUEST['page'] <= 0
    $page = min($page, $pages); // get last page when $_REQUEST['page'] > $totalPages
    $offset = ($page - 1) * $perpage;
    if ($offset < 0) {
        $offset = 0;
    }

    $data = array_slice($data, $offset, $perpage, true);
}

$meta = array(
    'page' => $page,
    'pages' => $pages,
    'perpage' => $perpage,
    'total' => $total,
);

// if selected all records enabled, provide all the ids
if (isset($datatable['requestIds']) && filter_var($datatable['requestIds'], FILTER_VALIDATE_BOOLEAN)) {
    $meta['rowIds'] = array_map(function ($row) {
        foreach ($row as $first) break;
        return $first;
    }, $alldata);
}


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');

$result = array(
    'meta' => $meta + array(
            'sort' => $sort,
            'field' => $field,
        ),
    'data' => $data
);

echo json_encode($result, JSON_PRETTY_PRINT);