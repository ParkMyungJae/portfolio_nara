<?php
header("Content-Type: application/json");
require("db.php");

$datetime = date("Y-m-d H:i:s");

$id = $_POST['id'];
$pw = $_POST['pw'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$birthday = $_POST['birthday'];
$sex = $_POST['sex'];
$profile = $_FILES['profileInput'];
$profileViewer = $_POST['profileViewer'];
$noProfile = "/upload/profile/notUser000.png";


$id = htmlentities($id);
$pw = htmlentities($pw);
$name = htmlentities($name);
$phone = htmlentities($phone);
$birthday = htmlentities($birthday);
$sex = htmlentities($sex);
$profileViewer = htmlentities($profileViewer);

if (empty($profileViewer) == true) {
    $sql = "INSERT INTO `user`(`id`, `password`, `name`, `phone`, `birthday`, `sex`, `profile`, `datetime`) VALUES (?, PASSWORD(?), ?, ?, ?, ?, ?, ?)";

    $cnt = query($con, $sql, $param = [$id, $pw, $name, $phone, $birthday, $sex, $noProfile, $datetime]);

    if ($cnt == 1) {
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
        exit;
    }
} else {
    // 고유 파일명, 파일확장자 분리
    $temp_name = uniqid('', TRUE);
    $file_path_info = pathinfo($profile['name']);
    $file_extension = $file_path_info['extension'];

    // 파일 확장자 확인
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($file_extension, $allowed_ext)) {
        exit;
    }

    // 파일업로드
    $file_name = $temp_name . '.' . $file_extension;
    $src = "../upload/profile/" . time() . "_" . $profile['name'];
    $file = $profile["tmp_name"];
    move_uploaded_file($file, $src);

    // 업로드된 이미지파일 정보를 가져옵니다
    $file = getimagesize($src);
    // 저용량 jpg 파일을 생성합니다
    if ($file['mime'] == 'image/png')
        $image = imagecreatefrompng($src);
    else if ($file['mime'] == 'image/gif')
        $image = imagecreatefromgif($src);
    else
        $image = imagecreatefromjpeg($src);

    // 파일 압축 및 업로드
    $thumb_src = "../upload/profile/" . time() . "_" . pathinfo($profile['name'], PATHINFO_FILENAME) . '_thumb.jpg';
    imagejpeg($image, $thumb_src, 75);

    $sql = "INSERT INTO `user`(`id`, `password`, `name`, `phone`, `birthday`, `sex`, `profile`, `datetime`) VALUES (?, PASSWORD(?), ?, ?, ?, ?, ?, ?)";

    $cnt = query($con, $sql, $param = [$id, $pw, $name, $phone, $birthday, $sex, $thumb_src, $datetime]);

    if ($cnt == 1) {
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
        exit;
    }
}
