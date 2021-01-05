<?php
header("Content-Type: application/json");
require("db.php");

if (!isset($_SESSION['user'])) {
    echo ('<script> window.location.href = "/"; </script>');
    exit;
}

/*  문서 작성 POST  */
$categoryName = $_POST["categoryName"];
$editTitle = $_POST["editTitle"];
$editer = (string)$_POST["editorTemp"];
$date = date("Y-m-d H:i:s");
$cat_src = null;

$categoryName = htmlentities($categoryName);
$editTitle = htmlentities($editTitle);
// $editer = htmlentities($editer);
$date = htmlentities($date);

$board_idx_sql = "SELECT `board_id` FROM `board` ORDER BY `board_id` DESC LIMIT 1;";
$board_idx = fetch($con, $board_idx_sql);

if(isset($_POST["share"])) {
    $share = $_POST["share"];
}else {
    $share = 0;
}

// 수정모드
$doc_id = $_POST['doc_id'];
$doc_id = htmlentities($doc_id);

/*  카테고리 SRC 분류  */
if ($categoryName == "마케팅") {
    $cat_src = "/cat_marketing.php";
}

if ($categoryName == "디자인") {
    $cat_src = "/cat_design.php";
}

if ($categoryName == "번역/통역") {
    $cat_src = "/cat_translation.php";
}

if ($categoryName == "IT개발") {
    $cat_src = "/cat_IT_development.php";
}

if ($categoryName == "비즈니스문서") {
    $cat_src = "/cat_businessDocument.php";
}

if ($categoryName == "창작/작문") {
    $cat_src = "/cat_production.php";
}

if ($categoryName == "음악/더빙") {
    $cat_src = "/cat_music.php";
}

if ($categoryName == "영상콘텐츠") {
    $cat_src = "/cat_videoContent.php";
}

if ($categoryName == "전문가컨설팅") {
    $cat_src = "/cat_consulting.php";
}

if ($categoryName == "운세/상담") {
    $cat_src = "/cat_fortune_telling.php";
}

if ($categoryName == "생활서비스") {
    $cat_src = "/cat_lifeService.php";
}

if ($categoryName == "핸드메이드") {
    $cat_src = "/cat_handmade.php";
}

if ($categoryName == "여행플랜") {
    $cat_src = "/cat_travelPlan.php";
}

if ($categoryName == "레슨") {
    $cat_src = "/cat_lesson.php";
}

if ($categoryName == "행사/이벤트") {
    $cat_src = "/cat_event.php";
}

if ($categoryName == "자유게시판") {
    $cat_src = "/cat_freeBoard.php";
}


if ($doc_id == 0) {
    // 새 글쓰기 모드
    $sql = "INSERT INTO `board`(`userID`, `title`, `content`, `share`, `category`, `cat_src`, `datetime`) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $cnt = query($con, $sql, $param = [$_SESSION['user']->id, $editTitle, $editer, $share, $categoryName, $cat_src, $date]);

    echo json_encode(
        ['success' => true],
        JSON_UNESCAPED_UNICODE
    );
    exit;
} else {
    // 수정 모드

    $sql = "UPDATE `board` SET `userID`= ?,`title`= ?,`content`= ?,`share`= ?,`category`= ?,`cat_src`= ?,`datetime`= ? WHERE `board_idx` = ?";
    $cnt = query($con, $sql, $param = [$_SESSION['user']->id, $editTitle, $editer, $share, $categoryName, $cat_src, $date, $doc_id]);

    echo json_encode(
        ['success' => true],
        JSON_UNESCAPED_UNICODE
    );
    exit;
}
