<?php require("./php/db.php"); ?>

<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;

if (!is_numeric($page)) $page = 1;

$sql = "SELECT COUNT(*) AS cnt FROM board WHERE `share` = 1 AND `category` = ? ";
$data = fetch($con, $sql, ["IT개발"]);

$totalCnt = $data->cnt;
$ppn = 25; //페이지당 글의 수
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

$sql = "SELECT * FROM `board` WHERE `share` = 1 AND `category` = ? ORDER BY `board_idx` DESC Limit " . ($page - 1) * 25 . ", 25";
$result = fetchAll($con, $sql, ["IT개발"]);

?>

<!DOCTYPE html>
<html lang="ko">

<title>포폴나라 - IT개발</title>
<?php require("./head.php"); ?>

<body>
    <?php require("./header.php"); ?>
    <div class="container">
        <div class="headerBox profileHeaderBox">
            <div class="center">
                <p style="font-size: 34px; display: inline-block;">카테고리</p><br>
                <p style="font-size: 44px; font-weight: bold; display: inline-block;">IT개발</p>
            </div>
        </div>
    </div>
    </header>

    <div class="container">
        <div class="btn_box" style="text-align: right; margin: 19px;">
            <button onclick="window.location.href = 'newDocument.php';" class="ui inverted blue button">새 포트폴리오 작성</button>
        </div>

        <div class="publicData">
            <h1 align="center" style="margin: 15px 0;">#공유된 IT개발 포트폴리오</h1>
            <table class="table table-striped text-center table-hover table-set">
                <thead>
                    <tr>
                        <th scope="col" class="tableCat">분야</th>
                        <th scope="col" class="tableTitle">제목</th>
                        <th scope="col" class="tableID">아이디</th>
                        <th scope="col" class="tableDate">작성일자</th>
                        <th scope="col" class="tableVisitor">방문자 수</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($result as $item) : ?>
                        <tr>
                            <td class="tCat"><a href="<?= $item->cat_src ?>"><?= $item->category ?></a></td>
                            <td class="title"><a href="<?= "/viewer.php?board_idx=" . $item->board_idx ?>" class="title"><?= $item->title ?></a></td>
                            <td class="tId"><a href="/idViewer.php?userID=<?= $item->userID ?>"><?= $item->userID ?></a></td>
                            <td class="tDate"><?= $item->datetime ?></td>
                            <td class="tVisitor"><?= $item->visitor ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation" style="margin: 30px 0;">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= $prev ? "" : "disabled" ?>">
                    <a class="page-link" href="/cat_IT_development.php?page=<?= $startPage - 1 ?>" tabindex="-1">이전</a>
                </li>

                <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                    <li class="page-item <?= $i == $page ? "active" : "" ?>">
                        <a class="page-link" href="/cat_IT_development.php?page=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= $next ? "" : "disabled" ?>">
                    <a class="page-link" href="/cat_IT_development.php?page=<?= $endPage + 1 ?>">다음</a>
                </li>
            </ul>
        </nav>
    </div>

    <?php require("./footer.php"); ?>
</body>

</html>