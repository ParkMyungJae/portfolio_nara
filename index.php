<?php require("./php/db.php"); ?>
<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (!is_numeric($page)) $page = 1;

$sql = "SELECT COUNT(*) AS cnt FROM board WHERE `share` = 1";
$data = fetch($con, $sql);

$totalCnt = $data->cnt;
$ppn = 15; //페이지당 글의 수
$totalPage = ceil($totalCnt / $ppn);

$cpp = 6; // 챕터당 페이지수

$endPage = ceil($page / $cpp) * $cpp;
$startPage = $endPage - $cpp + 1;

$prev = true;
$next = true;

if ($endPage >= $totalPage) {
    $endPage = $totalPage;
    $next = false;
}

if ($startPage == 1) {
    $prev = false;
}

$sql = "SELECT * FROM `board` WHERE `share` = 1  ORDER BY `board_idx` DESC Limit " . ($page - 1) * 15 . ", 15";
$result = fetchAll($con, $sql);


$topSql = "SELECT * FROM `board` INNER JOIN `user` ON board.userID = user.id ORDER BY `visitor` DESC LIMIT 3";
$top3 = fetchAll($con, $topSql);

?>
<!DOCTYPE html>
<html lang=ko>
<title>포폴나라</title>
<?php require("./head.php"); ?>
<body>
<?php require("./header.php"); ?>
<div class=container>
<div class=headerBox>
<div class=center>
<p style=font-size:34px>워드 작업 하듯이 간편하게</p>
<p style=font-size:44px;font-weight:bold>자신의 능력을 알려주세요!</p>
</div>
</div>
</div>
</header>
<div class=container>
<div class=main>
<?php require("card_intro.php"); ?>
</div>
<div class=top3 style="width:100%;margin:20px 0">
<h1 align=center style="margin:15px 0">#방문자 Top3 게시글</h1>
<div class="ui cards" style=width:100%;display:flex;justify-content:space-between;align-items:center;margin:0>
<?php foreach ($top3 as $item) :  ?>
<div class=card style=width:306px>
<div class="blurring dimmable image">
<div class="ui dimmer">
<div class=content>
<div class=center>
<div class="ui inverted button" onclick="window.location.href='viewer.php?board_idx=<?= $item->board_idx ?>'">포트폴리오 보러가기</div>
</div>
</div>
</div>
<img src=<?= $item->profile ?> style=width:100%!important;height:300px;object-fit:cover>
</div>
<div class=content>
<a href="viewer.php?board_idx=<?= $item->board_idx ?>" class=header><?= $item->title ?></a>
<div class=meta>
<span class=date><a href="/idViewer.php?userID=<?= $item->userID ?>"><?= $item->userID ?></a></span>
</div>
</div>
<div class="extra content">
<a>
<i class="users icon"></i>
<?= $item->visitor . "회" ?>
</a>
</div>
</div>
<?php endforeach; ?>
</div>
<script>$(".cards .image").dimmer({on:"hover"});</script>
</div>
<div class=publicData>
<h1 align=center style="margin:15px 0">#공유한 인재들의 포트폴리오</h1>
<table class="table table-striped text-center table-hover table-set">
<thead>
<tr>
<th scope=col class=tableCat>분야</th>
<th scope=col class=tableTitle>제목</th>
<th scope=col class=tableID>아이디</th>
<th scope=col class=tableDate>작성일자</th>
<th scope=col class=tableVisitor>방문자 수</th>
</tr>
</thead>
<tbody>
<?php foreach ($result as $item) : ?>
<tr>
<td class=tCat><a href=<?= $item->cat_src ?>><?= $item->category ?></a></td>
<td class=title><a href=<?= "/viewer.php?board_idx=" . $item->board_idx ?> class=title><?= $item->title ?></a></td>
<td class=tId><a href="/idViewer.php?userID=<?= $item->userID ?>"><?= $item->userID ?></a></td>
<td class=tDate><?= $item->datetime ?></td>
<td class=tVisitor><?= $item->visitor ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<nav aria-label="Page navigation" style="margin:30px 0">
<ul class="pagination justify-content-center">
<li class="page-item <?= $prev ? "" : "disabled" ?>">
<a class=page-link href="/?page=<?= $startPage - 1 ?>" tabindex=-1>이전</a>
</li>
<?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
<li class="page-item <?= $i == $page ? "active" : "" ?>">
<a class=page-link href="/?page=<?= $i ?>">
<?= $i ?>
</a>
</li>
<?php endfor; ?>
<li class="page-item <?= $next ? "" : "disabled" ?>">
<a class=page-link href="/?page=<?= $endPage + 1 ?>">다음</a>
</li>
</ul>
</nav>
</div>
<?php require("./footer.php"); ?>
</body>
</html>