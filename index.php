<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

const DATA_FILE = "data.json";

// url

$data = [];
if (file_exists(DATA_FILE)) {
    $content = file_get_contents(DATA_FILE);
    $data = json_decode($content, true);
    if (!is_array($data)) {
        $data = [];
    }
}


$output = ['status' => false];

if (isset($_GET)) {
    $output['status'] = true;
    $output['entries'] = $data;
}

if (isset($_POST)) {
    if (isset($_POST["newItem"]) && !in_array($_POST["newItem"], $data)) {
        $data[] = $_POST["newItem"];
        $content = json_encode($data);
        file_put_contents(DATA_FILE, $content);
        $output = [
            'status' => true,
            'message' => 'new item added',
            "data" => $content
        ];
    }
    if (isset($_POST['removeItem'])) {
        $data = array_flip($data);
        unset($data[$_POST['removeItem']]);
        $data = array_keys($data);
        $content = json_encode($data);
        file_put_contents(DATA_FILE, $content);
        $output = [
            'status' => true,
            'message' => 'item removed',
            "data" => $content
        ];
    }
}
echo json_encode($output, JSON_PRETTY_PRINT);
