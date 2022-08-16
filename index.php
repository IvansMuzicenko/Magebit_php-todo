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




if (isset($_GET["api-name"])) {
    switch ($_GET["api-name"]) {
        case 'add-todo':
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
            break;

        case 'remove-todo':
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
            break;

        default:
            $output['status'] = true;
            $output['entries'] = $data;
            break;
    }
}

echo json_encode($output, JSON_PRETTY_PRINT);
