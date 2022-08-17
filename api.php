<?php
require "Tasks.php";
header('Content-Type: application/json');

const DATA_FILE = "data.json";

// url

$data = [];

$tasks = new Tasks();

$data = $tasks->getAllTasks();


$output = ['status' => false];




if (isset($_GET["api-name"])) {
    switch ($_GET["api-name"]) {
        case 'add-todo':
            if (isset($_POST["newItem"]) && !in_array($_POST["newItem"], $data)) {
                $tasks->addTask($_POST['newItem']);
                $data = $tasks->getAllTasks();
                $output = [
                    'status' => true,
                    'message' => 'new item added',
                    "data" => $data
                ];
            }
            break;

        case 'remove-todo':
            if (isset($_POST['removeItem'])) {
                $tasks->deleteTask($_POST['removeItem']);
                $data = $tasks->getAllTasks();
                $output = [
                    'status' => true,
                    'message' => 'item removed',
                    "data" => $data
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
