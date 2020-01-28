<?php
require_once 'main.php';

try {
    $api = new Main();
    echo $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
