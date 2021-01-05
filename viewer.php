<?php
require("./php/db.php");

$sql = "SELECT * FROM board WHERE board_idx = ?";

$q = $con->prepare($sql);

if (isset($_GET['board_idx'])) {
    $id = $_GET['board_idx'];
} else {
    echo "<script> alert('잘못된 접근입니다.'); </script>";
    echo "<script> window.history.back(); </script>";
    exit;
}

$q->execute([$id]);
$data = $q->fetch(PDO::FETCH_OBJ);

if (!$data) {
    echo "<script> alert('이미 삭제되었거나 존재하지 않는 글입니다.'); </script>";
    echo "<script> window.history.back(); </script>";
    exit;
}

$sql = "SELECT * FROM `user` WHERE id = ?";
$userTable = fetch($con, $sql, [$data->userID]);


$sql = "UPDATE `board` SET `visitor`= ? WHERE board_idx = ?";

$visitor = query($con, $sql, [$data->visitor + 1, $data->board_idx]);

$result = false;

$sql = "SELECT * FROM `board` WHERE board_idx = ? AND userID = ?";
if (isset($_SESSION['user'])) {
    $result = fetch($con, $sql, [$_GET['board_idx'], $_SESSION['user']->id]);
}

?>

<!DOCTYPE html>
<html lang="ko">

<title>포폴나라</title>
<?php require("head.php"); ?>

<body>
    <?php require("header.php"); ?>
    <div class="container">
        <div class="headerBox">
            <div class="center">
                <p style="font-size: 34px;">짜잔! 멋진 포트폴리오가</p>
                <p style="font-size: 44px; font-weight: bold;">여러분을 기다리고 있습니다.</p>
            </div>
        </div>
    </div>
    </header>

    <div class="container">
        <div class="viewer">
            <div class="viewProfile" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                <div uk-lightbox>
                    <a href="<?= $userTable->profile ?>"><img src="<?= $userTable->profile ?>" alt="profile" class="ui small circular image" style="width: 180px; height: 180px; object-fit: cover; box-shadow: 1px 1px 12px rgba(0, 0, 0, 0.4);"></a>
                </div>
            </div>

            <div id="viewerInfo">
                <input type="text" class="all-white-border" style="width: 12.5%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none; text-align: center;" value="성함 : <?= $userTable->name ?>" readonly>
                <input type="text" class="all-white-border" style="width: 19.5%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none; text-align: center;" value="전화번호 : <?= $userTable->phone ?>" readonly>
                <input type="text" class="all-white-border" style="width: 19.5%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none; text-align: center;" value="생년월일 : <?= $userTable->birthday ?>" readonly>
                <input type="text" class="all-white-border" style="width: 8.7%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none; text-align: center;" value="성별 : <?= $userTable->sex ?>" readonly>
                <input type="text" class="all-white-border" style="width: 25.2%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none; text-align: center;" value="작성일 : <?= $data->datetime ?>" readonly>
                <input type="text" class="all-white-border" style="width: 13%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none; text-align: center;" value="조회수 : <?= $data->visitor + 1 ?>" readonly>
            </div>

            <div class="white-border" style="border: 1px solid #888; border-radius: 5px; margin: 10px 0; padding: 5px;">분류 :
                <a href="<?= $data->cat_src ?>" style="color: #1487e6;"><?= $data->category ?></a>
            </div>

            <div class="editor">
                <input type="text" name="editTitle" class="editTitle viewer-dark all-white-border" placeholder="제목을 입력하세요 " style="width: 100%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none;" value="제목 : <?= $id != 0 ? $data->title : "" ?>" readonly>

                <textarea id="editor" name="editor" readonly></textarea>

                <script>
                    let result = `<?= $data->content ?>`;

                    window.addEventListener("load", () => {
                        CKEDITOR.replace('editor');
                        CKEDITOR.instances.editor.setData(result);
                    });
                </script>
            </div>

            <?php if ($result == true) : ?>
                <!-- index -->
                <div style="text-align: right; margin: 40px 0;">
                    <a><button id="board_delete_btn" class="btn btn-danger">삭제</button></a>
                    <a href="newDocument.php?board_idx=<?= $data->board_idx ?>"><button class="btn btn-primary">수정</button></a>
                    <a href="<?= $data->cat_src ?>"><button class="btn btn-info">목록</button></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php require("footer.php"); ?>


    <script>
    let board_delete_btn = document.querySelector("#board_delete_btn");
    
        if (board_delete_btn) {
            board_delete_btn.addEventListener("click", () => {
                swal({
                    title: "정말 삭제하시겠습니까?",
                    text: "이 작업은 되돌릴 수 없습니다. 신중히 선택 부탁드립니다.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((val) => {
                    if (val) {
                        $.ajax({
                            type: "GET",
                            url: "/php/board_delete_OK.php?board_idx=<?= $data->board_idx ?>",
                            dataType: 'json',
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                if (response.success == true) {
                                    window.history.back();
                                } else if (response.success == false && response.code == -99) {
                                    swal("잘못된 접근입니다.\n게시판 번호가 확인되지 않습니다.", {
                                        icon: "error",
                                    });
                                    return;
                                } else if (response.success == false) {
                                    swal("자신의 포트폴리오만 삭제 가능합니다.", {
                                        icon: "error",
                                    });
                                    return;
                                } else {

                                }
                            },

                            error: function(response) {
                                swal("삭제할 권한이 없습니다.", {
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });
        }
    </script>
</body>

</html>