<?php
require("db.php");

if (!isset($_SESSION['user'])) {
    echo ('<script> window.location.href = "/"; </script>');
    exit;
}

$id = $_SESSION['user']->id;
$usePW = $_POST['usePW'];

$status = "SELECT * FROM `user` WHERE `id` = ? AND `password` = PASSWORD(?)";
$check = fetch($con, $status, [$id, $usePW]);

if($check == true) {
    $sql = "DELETE FROM `user` WHERE id = ? AND `password` = PASSWORD(?)";
    $cnt = query($con, $sql, [$id, $usePW]);
    
    if ($cnt == 1) {
        unset($_SESSION['user']);
    
        echo json_encode(
            ['success' => true],
            JSON_UNESCAPED_UNICODE
        );
    
        exit;
    }    
}else {
    echo json_encode(
        ['success' => false],
        JSON_UNESCAPED_UNICODE
    );

    exit;
}


