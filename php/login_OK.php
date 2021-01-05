<?php
header("Content-Type: application/json");
require("db.php");

$id = $_POST['id'];
$pw = $_POST['pw'];

$sql = "SELECT * FROM `user` WHERE `id` = ? AND `password` = PASSWORD(?)";

$user = fetch($con, $sql, [$id, $pw]);

if ($user == true) {
    $_SESSION['user'] = $user;

    echo json_encode(
        ['result' => true],
        JSON_UNESCAPED_UNICODE
    );

    exit;
} else {
    echo json_encode(
        ['result' => false],
        JSON_UNESCAPED_UNICODE
    );
}
