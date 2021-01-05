<?php
header("Content-Type: application/json");
require("db.php");

if (!isset($_SESSION['user'])) {
    echo ('<script> window.location.href = "/"; </script>');
    exit;
}


if (isset($_GET['board_idx'])) {
    $id = $_GET['board_idx'];

    $loadSql = "SELECT * FROM `board` WHERE  board_idx = ? AND userID = ?";
    $loadData = fetch($con, $loadSql, $param = [$id, $_SESSION['user']->id]);

    if ($loadData == true) {
        $sql = "DELETE FROM `board` WHERE board_idx = ?";
        $cnt = query($con, $sql, $param = [$id]);

        echo json_encode(
            ['success' => true],
            JSON_UNESCAPED_UNICODE
        );
        exit;
    } else {
        echo json_encode(
            ['success' => false],
            JSON_UNESCAPED_UNICODE
        );
        exit;
    }
} else {
    echo json_encode(
        ['success' => false,'code' => -99],
        JSON_UNESCAPED_UNICODE
    );
    exit;
}
