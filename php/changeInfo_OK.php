<?php
require("db.php");

if (!isset($_SESSION['user'])) {
    echo ('<script> window.location.href = "/"; </script>');
    exit;
}

$id = $_SESSION['user']->id;


$name = $_POST["name"];
$password = $_POST["password"];
$rePassword = $_POST["rePassword"];
$usePW = $_POST["usePW"];
$phone = $_POST["phone"];
$birthday = $_POST["birthday"];
$sex = $_POST["sex"];


$profileChangeViewer = $_POST["profileChangeViewer"];
$profile = $_FILES["profileInput"];

$secretSql = "SELECT * FROM `user` WHERE `id` = ? AND `password` = PASSWORD(?)";

$useUser = fetch($con, $secretSql, [$id, $usePW]);

if ($useUser == true) {
    if ($password != "" && $rePassword != "") {
        if (empty($profileChangeViewer) != true) {
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

            $sql = "UPDATE `user` SET `name`= ?, `password`= PASSWORD(?), `profile`= ?, `phone` = ?, `birthday` = ?, `sex` = ?
            WHERE `id` = ?";

            $cnt = query($con, $sql, $param = [$name, $password, $thumb_src, $phone, $birthday, $sex, $id]);

            if ($cnt == 1) {
                echo json_encode(
                    ['success' => true, 'type' => 'image', 'src' => $thumb_src],
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            $sql = "UPDATE `user` SET `name`= ?, `password`= PASSWORD(?), `phone` = ?, `birthday` = ?, `sex` = ? WHERE `id` = ?";

            $cnt = query($con, $sql, $param = [$name, $password, $phone, $birthday, $sex, $id]);

            if ($cnt == 1) {
                echo json_encode(
                    ['success' => true],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }
    } else {
        $password = $usePW;

        if (empty($profileChangeViewer) != true) {
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

            $sql = "UPDATE `user` SET `name`= ?, `password`= PASSWORD(?), `profile`= ?, `phone` = ?, `birthday` = ?, `sex` = ?
            WHERE `id` = ?";

            $cnt = query($con, $sql, $param = [$name, $password, $thumb_src, $phone, $birthday, $sex, $id]);

            if ($cnt == 1) {
                echo json_encode(
                    ['success' => true, 'type' => 'image', 'src' => $thumb_src],
                    JSON_UNESCAPED_UNICODE
                );
            }
        } else {
            $sql = "UPDATE `user` SET `name`= ?, `password`= PASSWORD(?), `phone` = ?, `birthday` = ?, `sex` = ? WHERE `id` = ?";

            $cnt = query($con, $sql, $param = [$name, $password, $phone, $birthday, $sex, $id]);

            if ($cnt == 1) {
                echo json_encode(
                    ['success' => true],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }
    }

    $id = $_SESSION['user']->id;

    unset($_SESSION['user']);

    $sql = "SELECT * FROM user WHERE id = ?";

    $user = fetch($con, $sql, [$id]);

    if ($user == true) {
        $_SESSION['user'] = $user;
    }
} else {
    //code : 0 = 정상 처리
    //code : 99 = 현재 비밀번호가 옳바르지 않음.

    echo json_encode(
        ['success' => false, 'code' => 99, 'id' => $id],
        JSON_UNESCAPED_UNICODE
    );
}
