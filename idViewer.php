<?php require("./php/db.php"); ?>

<?php
if (isset($_GET['userID'])) {
    $id = $_GET['userID'];

    $id = htmlentities($id);

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    if (!is_numeric($page)) $page = 1;

    if (isset($_SESSION['user']->id) == $id) {
        $sql = "SELECT COUNT(*) AS cnt FROM board WHERE `userID` = ?";
        $data = fetch($con, $sql, [$id]);
    } else {
        $sql = "SELECT COUNT(*) AS cnt FROM board WHERE `userID` = ? AND `share` = 1";
        $data = fetch($con, $sql, [$id]);
    }

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

    if (isset($_SESSION['user']->id) == $id) {
        $sql = "SELECT * FROM `board` WHERE  `userID` = ? ORDER BY `board_idx` DESC Limit " . ($page - 1) * 25 . ", 25";
        $result = fetchAll($con, $sql, [$id]);
    } else {
        $sql = "SELECT * FROM `board` WHERE  `userID` = ? AND `share` = 1 ORDER BY `board_idx` DESC Limit " . ($page - 1) * 25 . ", 25";
        $result = fetchAll($con, $sql, [$id]);
    }

    $sql = "SELECT * FROM `user` WHERE `id` = ?";
    $userID = fetch($con, $sql, [$id]);
?>

    <!DOCTYPE html>
    <html lang="ko">

    <title>포폴나라 - <?= $id ?></title>
    <?php require("./head.php"); ?>

    <body>
        <?php require("./header.php"); ?>
        <div class="container">
            <div class="headerBox profileHeaderBox">
                <div class="center">
                    <?php if($userID != null) : ?>
                        <p style="font-size: 34px; display: inline-block;">아이디 정보</p><br>
                    <p style="font-size: 44px; font-weight: bold; display: inline-block;"><?= $id ?></p>
                    <?php else : ?>
                        <p style="font-size: 34px; display: inline-block;"><?= $id ?>의 아이디가</p><br>
                        <p style="font-size: 44px; font-weight: bold; display: inline-block;">존재하지 않습니다.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </header>

        <div class="container">
            <div class="btn_box" style="text-align: right; margin: 19px;">
                <button onclick="window.location.href = 'newDocument.php';" class="ui inverted blue button">새 포트폴리오 작성</button>
            </div>

            <div class="publicData">
                <div style="display: flex; justify-content: center; align-items: center;">
                    <div uk-lightbox>
                        <?php if ($userID != null) : ?>
                            <a href="<?= $userID->profile ?>"><img src="<?= $userID->profile ?>" alt="profile" class="ui small circular image" style="width: 150px; height: 150px;"></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($userID != null) : ?>
                    <h1 align="center" style="margin: 15px 0;">#공유된 <?= $id ?>님의 포트폴리오</h1>
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
                                    <td class="tId"><?= $item->userID ?></td>
                                    <td class="tDate"><?= $item->datetime ?></td>
                                    <td class="tVisitor"><?= $item->visitor ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php else : ?>
                    <h1 align="center">해당 아이디가 존재하지 않습니다.</h1>
                <?php endif; ?>

            </div>

            <nav aria-label="Page navigation" style="margin: 30px 0;">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $prev ? "" : "disabled" ?>">
                        <a class="page-link" href="/cat_lesson.php?page=<?= $startPage - 1 ?>" tabindex="-1">이전</a>
                    </li>

                    <?php for ($i = $startPage; $i <= $endPage; $i++) : ?>
                        <li class="page-item <?= $i == $page ? "active" : "" ?>">
                            <a class="page-link" href="/cat_lesson.php?page=<?= $i ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $next ? "" : "disabled" ?>">
                        <a class="page-link" href="/cat_lesson.php?page=<?= $endPage + 1 ?>">다음</a>
                    </li>
                </ul>
            </nav>
        </div>

        <?php require("./footer.php"); ?>
    </body>

    </html>

<?php
} else {
?>
    <!DOCTYPE html>
    <html lang="ko">

    <title>포폴나라 - 아이디 검색</title>
    <?php require("./head.php"); ?>

    <body>
        <?php require("./header.php"); ?>
        <div class="container">
            <div class="headerBox profileHeaderBox">
                <div class="center">
                    <p style="font-size: 34px; display: inline-block;">&lt;아이디 검색&gt;</p><br>
                    <p style="font-size: 44px; font-weight: bold; display: inline-block;">아이디를 입력해주세요.</p>
                </div>
            </div>
        </div>
        </header>

        <div class="container">
            <div class="ui form" style="width: 100%; height: 450px; display: flex; justify-content: center; align-items: center; margin-bottom: 50px;">
                <div style="width: 100%;">
                    <div class="field" style="width: 100%;">
                        <label>*아이디</label>
                        <input name="userID" id="userID" placeholder="userID" type="text">
                    </div>

                    <div class="field" style="width: 100%; display: flex; justify-content: flex-end; align-items: center;">
                        <button class="btn btn-outline-primary px-4 idSearchBtn" style="text-align: right;">검색</button>
                    </div>

                    <script>
                        document.querySelector(".idSearchBtn").addEventListener("click", () => {
                            if (document.querySelector("#userID").value.trim() == "") {
                                swal({
                                    title: '검색 실패',
                                    text: "검색할 아이디가 누락되었습니다.",
                                    icon: 'error'
                                });

                                document.querySelector("#userID").style.border = "2px solid red";
                            } else {
                                document.querySelector("#userID").style.border = "1px solid rgba(34,36,38,.15)";

                                window.location.href = "./idViewer.php?userID=" + document.querySelector("#userID").value.trim();
                            }
                        });
                    </script>
                </div>
            </div>
        </div>

        <?php require("./footer.php"); ?>
    </body>

    </html>

<?php
}
?>