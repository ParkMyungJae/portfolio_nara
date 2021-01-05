<?php require("./php/db.php"); ?>

<?php
if (!isset($_SESSION['user'])) {
    echo ('<script> alert("로그인 후 포트폴리오를 작성하실 수 있습니다."); window.location.href = "/login.php"; </script>');
    exit;
}

$mod = 0; // 글 작성모드
if (isset($_GET['board_idx'])) {
    //글 수정 모드
    $mod = $_GET['board_idx'];
    $sql = "SELECT * FROM `board` WHERE board_idx = ?";
    $q = $con->prepare($sql);
    $q->execute([$_GET['board_idx']]);
    $data = $q->fetch(PDO::FETCH_OBJ);

    if (!$data) {
        echo "존재하지 않는 글입니다.";
        exit;
    }

    $sql = "SELECT * FROM `board` WHERE board_idx = ? AND userID = ?";
    $result = fetch($con, $sql, [$_GET['board_idx'], $_SESSION['user']->id]);

    if ($result != true) {
        echo "잘못된 접근입니다.";
        exit;
    }
}

if (!isset($_SESSION['user']) && $mod == 0) {
    echo ('<script> window.location.href = "/"; </script>');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ko">

<?php require("./head.php"); ?>
<!-- <script src="./js/newDocument.js"></script> -->

<body>
    <?php require("./header.php"); ?>
    <div class="container">
        <div class="headerBox">
            <div class="center">
                <p style="font-size: 34px;">나의 능력을 표현해주세요.</p>
                <p style="font-size: 44px; font-weight: bold;">새 포트폴리오 작성하기</p>
            </div>
        </div>
    </div>
    </header>

    <div class="container">
        <div class="viewer">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <?php if ($mod == 0) : ?>
                    <h1 style="color: #373a3c; margin: 10px 0;">새 문서 만들기</h1>
                <?php else : ?>
                    <h1 style="color: #373a3c; margin: 10px 0;">문서 수정하기</h1>
                <?php endif; ?>
            </div>

            <form method="POST" id="newDocumentForm" enctype="multipart/form-data">
                <div class="white-border" style="border: 1px solid #888; border-radius: 5px; margin: 10px 0; padding: 5px;">분류 :
                    <select class="viewer-dark" name="categoryName" id="categoryName" style="margin-left: 5px; outline: none; padding: 3px; padding-right: 5px;">
                        <option value="0">카테고리 선택</option>
                        <option value="마케팅">마케팅</option>
                        <option value="디자인">디자인</option>
                        <option value="번역/통역">번역/통역</option>
                        <option value="IT개발">IT개발</option>
                        <option value="비즈니스문서">비즈니스문서</option>
                        <option value="창작/작문">창작/작문</option>
                        <option value="음악/더빙">음악/더빙</option>
                        <option value="영상콘텐츠">영상콘텐츠</option>
                        <option value="전문가컨설팅">전문가컨설팅</option>
                        <option value="운세/상담">운세/상담</option>
                        <option value="생활서비스">생활서비스</option>
                        <option value="핸드메이드">핸드메이드</option>
                        <option value="여행플랜">여행플랜</option>
                        <option value="레슨">레슨</option>
                        <option value="레슨">행사/이벤트</option>
                        <option value="자유게시판">자유게시판</option>
                    </select>
                </div>

                <div class="editer">
                    <input type="hidden" class="form-control" name="doc_id" value="<?= $mod ?>">
                    <input type="text" name="editTitle" class="editTitle viewer-dark all-white-border" placeholder="제목을 입력하세요 " style="width: 100%; border: 1px solid #888; margin: 10px 0; padding: 10px; font-size: 16px; outline: none;" value="<?= $mod != 0 ? $data->title : "" ?>">

                    <textarea id="editor" name="editor"></textarea>
                    <textarea name="editorTemp" id="editorTemp" style="display: none;"></textarea>

                    <script>
                        window.addEventListener("load", () => {
                            CKEDITOR.replace('editor');
                            let result = `<?= $mod != 0 ? $data->content : "" ?>`;
                            CKEDITOR.instances.editor.setData(result);

                            let cat = `<?= $mod != 0 ? $data->category : "" ?>`;
                            $("#categoryName > option[value='" + cat + "']").attr("selected", true);
                        });
                    </script>
                </div>

                <div style="height: 100px; text-align: right; display: flex; justify-content: flex-end; align-items: center;">
                    <label style="font-size: 18px; margin: 0; margin-right: 10px; display: flex; align-items: center;"><input type="checkbox" name="share" style="width: 25px; height: 25px; margin-right: 5px;" value="1" checked> 공유하기</label>
                    <button type="submit" onclick="return false;" class="ui inverted primary button uploadBtn" style="margin: 0;">새 문서 만들기</button>
                </div>
            </form>
        </div>
    </div>

    <?php require("./footer.php"); ?>

    <script>
        let editTitle = document.querySelector(".editTitle");
        let editer = document.querySelector("#editor");
        let uploadBtn = document.querySelector(".uploadBtn");

        uploadBtn.addEventListener("click", () => {
            if (document.querySelector("#categoryName").value == 0) {
                swal({
                    title: '카테고리 미설정',
                    text: "카테고리를 설정해주세요.",
                    icon: 'error'
                });

                $("#categoryName").css("border", "2px solid red");
                return;
            } else {
                $("#categoryName").css("border", "1px solid #767676");
            }

            $("#editorTemp").val(CKEDITOR.instances.editor.getData());

            if ($.trim(editTitle.value) != "") {
                let formData = new FormData($("#newDocumentForm")[0]);

                $.ajax({
                    type: "POST",
                    url: "/php/documentWrite.php",
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    data: formData,
                    success: function(response) {
                        if (response.success == true) {
                            window.location.href = "myProfile.php";
                        } else {
                            swal({
                                title: '업로드 실패',
                                text: "시스템에 문제가 발생하였습니다.",
                                icon: 'error'
                            });
                        }
                    },

                    error: function(res) {
                        swal({
                            title: '업로드 실패',
                            text: "시스템에 문제가 발생하였습니다.",
                            icon: 'error'
                        });
                        console.log(res);
                    }
                });
            } else {
                swal({
                    title: '오류',
                    text: '제목은 필수 항목입니다.',
                    icon: 'error'
                });
                return;
            }
        });
    </script>
</body>

</html>