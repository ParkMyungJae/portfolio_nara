<?php require("./php/db.php"); ?>

<?php
if (!isset($_SESSION['user'])) {
    echo ('<script> window.location.href = "/"; </script>');
}
?>

<!DOCTYPE html>
<html lang="ko">
<title><?= $_SESSION["user"]->name ?>님의 정보 수정</title>
<?php require("head.php"); ?>

<body>
    <?php require("header.php"); ?>

    <div class="container">
        <div class="headerBox profileHeaderBox">
            <div class="center">
                <p style="font-size: 34px; display: inline-block;"><?= $_SESSION['user']->name ?>님의</p><br>
                <p style="font-size: 44px; font-weight: bold; display: inline-block;">정보 수정</p>
            </div>

            <div class="right">
                <div uk-lightbox>
                    <a href="<?= $_SESSION['user']->profile ?>"><img src="<?= $_SESSION['user']->profile ?>" alt="profile" class="ui large circular image"></a>
                </div>
            </div>
        </div>
    </div>

    </header>
    <div class="container">
        <form action="./php/changeInfo_OK.php" id="changeInfoForm" method="POST" enctype="multipart/form-data" style="margin: 100px 0;">

            <div class="ui form" style="margin: 30px 0;">
                <div class="field">
                    <label>*성함</label>
                    <input name="name" id="name" placeholder="name" type="text" value="<?= $_SESSION['user']->name ?>">
                </div>

                <div class="field">
                    <label>새 비밀번호</label>
                    <input name="password" id="password" placeholder="새 비밀번호" type="password">
                </div>

                <div class="field">
                    <label>새 비밀번호 확인</label>
                    <input name="rePassword" id="rePassword" placeholder="새 비밀번호 확인" type="password">
                </div>

                <div class="field">
                    <label for="phone">*연락처</label>
                    <input type="number" id="phone" name="phone" placeholder="숫자만 입력하세요." value="<?= $_SESSION['user']->phone ?>">
                </div>

                <div class="field">
                    <label for="birthday">*생년월일</label>
                    <input type="date" id="birthday" name="birthday" value="<?= $_SESSION['user']->birthday ?>">
                </div>

                <div class="field">
                    <label for="sex">*성별</label>

                    <div class="radio_box" style="width: 100px; display: flex; justify-content: space-between; align-items: center;">
                        <label><input type="radio" name="sex" value="남" style="width: 20px; height: 20px;"> 남</label>
                        <label><input type="radio" name="sex" value="여" style="width: 20px; height: 20px;"> 여 </label>
                    </div>

                    <script>
                        //DB에 저장된 성별 가져오기
                        $('input[name="sex"]').val([`<?= $_SESSION['user']->sex ?>`]);
                    </script>
                </div>



                <div class="field">
                    <label>* 현재 비밀번호</label>
                    <input name="usePW" id="usePW" placeholder="* 현재 비밀번호" type="password">
                </div>

                <div class="field" style="width: 100%;">
                    <label>프로필 변경</label>

                    <div class="flex" style="width: 100%;">
                        <input name="profileChangeViewer" placeholder="프로필 변경" type="text" style="width: 100%; margin-bottom: 5px;" class="profileChange" id="profileChangeViewer" readonly> <br>

                        <div class="ui buttons" style="width: 100% !important;">
                            <input type="button" class="ui button active inputCancel" value="취소">
                            <div class="or"></div>
                            <button type="button" class="ui positive button" id="profileUploadBtn">업로드</button>
                        </div>

                        <input type="file" id="profileChangeInput" style="display: none;" name="profileInput">
                    </div>
                </div>

                <!-- 밑의 스크립트는 프로필 변경 부분 -->
                <script>
                    profile();

                    function profile() {
                        let profileChangeInput = document.querySelector("#profileChangeInput");
                        let profileUploadBtn = document.querySelector("#profileUploadBtn");

                        profileUploadBtn.addEventListener("click", () => {
                            profileChangeInput.click();
                        });

                        profileChangeInput.addEventListener("input", () => {
                            if (profileChangeInput.files[0].name != undefined) {
                                pathpoint = profileChangeInput.value.lastIndexOf('.');
                                filepoint = profileChangeInput.value.substring(pathpoint + 1, profileChangeInput.length);
                                filetype = filepoint.toLowerCase();

                                if (filetype == 'jpg' || filetype == 'gif' || filetype == 'png' || filetype == 'jpeg' || filetype == 'bmp') {
                                    // 정상적인 이미지 확장자 파일인 경우
                                    profileChangeViewer.value = profileChangeInput.files[0].name;

                                    // 사이즈체크
                                    let maxSize = 10 * 1024 * 1024;
                                    let fileSize = 0;

                                    // 브라우저 확인
                                    let browser = navigator.appName;

                                    // 익스플로러일 경우
                                    if (browser == "Microsoft Internet Explorer") {
                                        let oas = new ActiveXObject("Scripting.FileSystemObject");
                                        fileSize = oas.getFile(profileChangeInput.value).size;
                                    }
                                    // 익스플로러가 아닐경우
                                    else {
                                        fileSize = profileChangeInput.files[0].size;
                                    }

                                    if (fileSize > maxSize) {
                                        swal({
                                            title: '오류',
                                            text: '첨부파일 사이즈는 10MB 이내로 등록 가능합니다.',
                                            icon: 'error'
                                        });
                                        profileChangeInput.value = "";
                                        profileChangeViewer.value = "";
                                        return;
                                    }

                                } else {
                                    swal({
                                        title: '오류',
                                        text: '이미지 파일만 업로드가 가능합니다.',
                                        icon: 'error'
                                    });
                                    profileChangeInput.value = "";
                                    profileChangeViewer.value = "";
                                    return;
                                }
                            }
                        });

                        document.querySelector(".inputCancel").addEventListener("click", () => {
                            profileChangeViewer.value = "";
                            profileChangeInput.value = "";
                        });
                    }
                </script>

                <div class="submitBtnBox" style="margin: 20px 0; text-align: right;">
                    <button type="button" class="ui inverted red button" id="userDelete">탈퇴하기</button>

                    <button type="button" class="ui inverted green button" id="changeInfoBtn">수정하기</button>
                    <input type="submit" id="changeInfoSubmit" style="display: none;">
                </div>

                <!-- 내정보 수정 버튼 스크립트 -->
                <script>
                    let btn = document.querySelector('#changeInfoBtn');

                    let name = document.querySelector("#name");
                    let password = document.querySelector("#password");
                    let rePassword = document.querySelector("#rePassword");
                    let usePW = document.querySelector("#usePW");

                    let userDelete = document.querySelector("#userDelete");

                    //회원탈퇴 PS
                    userDelete.addEventListener("click", () => {
                        let formData = new FormData($("#changeInfoForm")[0]);

                        if ($.trim(usePW.value) == "") {
                            swal({
                                title: '필수 값 누락',
                                text: "정보 변경을 위해 현재 비밀번호를 입력해주세요.",
                                icon: 'error'
                            });

                            $(usePW).parent().addClass("error");
                            return;
                        } else {
                            $(usePW).parent().removeClass("error");

                            swal({
                                title: "정말 탈퇴하시겠습니까?",
                                text: "이 작업은 되돌릴 수 없습니다. 신중히 선택 부탁드립니다.",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            }).then((willDelete) => {
                                if (willDelete) {
                                    $.ajax({
                                        type: "POST",
                                        url: "./php/removeUser.php",
                                        contentType: false,
                                        processData: false,
                                        data: formData,
                                        dataType: "json",
                                        success: function(response) {
                                            if (response.success == true) {
                                                swal("탈퇴가 완료되었습니다. 이용해주셔서 감사합니다.", {
                                                    icon: "success",
                                                }).then((val) => {
                                                    window.location.href = "/";
                                                });
                                            } else {
                                                swal("현재 비밀번호가 옳바르지 않습니다.", {
                                                    icon: "error",
                                                });
                                            }
                                        },

                                        error: function(response) {
                                            swal("시스템 에러가 발생하였습니다.", {
                                                icon: "error",
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });

                    btn.addEventListener("click", () => {
                        let formData = new FormData($("#changeInfoForm")[0]);

                        if ($.trim(name.value) == "") {
                            $(name).parent().addClass("error");
                        } else {
                            $(name).parent().removeClass("error");
                        };

                        if ($.trim(phone.value) == "") {
                            $(phone).parent().addClass("error");
                        } else {
                            $(phone).parent().removeClass("error");
                        };

                        if ($.trim(birthday.value) == "") {
                            $(birthday).parent().addClass("error");
                        } else {
                            $(birthday).parent().removeClass("error");
                        };

                        if ($.trim(password.value) != "" && $.trim(rePassword.value) == "") {
                            $(rePassword).parent().addClass("error");
                            swal({
                                title: '새 비밀번호 확인 누락',
                                text: "새 비밀번호 확인이 누락되었습니다.",
                                icon: 'error'
                            });
                            return;
                        } else {
                            $(rePassword).parent().removeClass("error");
                        };

                        if ($.trim(name.value) == "" || $.trim(phone.value) == "" || $.trim(birthday.value) == "") {
                            swal({
                                title: '필수 값 누락',
                                text: "필수 값이 공백이면 안됩니다.",
                                icon: 'error'
                            });
                            return;
                        }

                        if ($.trim(usePW.value) == "") {
                            swal({
                                title: '필수 값 누락',
                                text: "정보 변경을 위해 현재 비밀번호를 입력해주세요.",
                                icon: 'error'
                            });

                            $(usePW).parent().addClass("error");
                            return;
                        } else {
                            $(usePW).parent().removeClass("error");

                            if ($.trim(password.value) != "" && $.trim(rePassword.value) != "") {
                                let num = password.value.search(/[0-9]/g);
                                let eng = password.value.search(/[a-z]/ig);
                                let spe = password.value.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

                                if (password.value.length < 8 || password.value.length > 20) {
                                    swal({
                                        title: '실패',
                                        text: "8자리 ~ 20자리 이내로 입력해주세요.",
                                        icon: 'error'
                                    });
                                    return false;

                                } else if (password.value.search(/\s/) != -1) {
                                    swal({
                                        title: '실패',
                                        text: "비밀번호는 공백 없이 입력해주세요.",
                                        icon: 'error'
                                    });
                                    return false;

                                } else if (num < 0 || eng < 0 || spe < 0) {
                                    swal({
                                        title: '실패',
                                        text: "영문, 숫자, 특수문자를 혼합하여 입력해주세요.",
                                        icon: 'error'
                                    });
                                    return false;

                                } else if (password.value !== rePassword.value) {
                                    swal({
                                        title: '실패',
                                        text: "비밀번호와 비밀번호 확인이 다릅니다.",
                                        icon: 'error'
                                    });
                                    return false;

                                }
                            }

                            swal({
                                title: "수정하시겠습니까?",
                                text: "오기재하신 부분은 없는지 신중히 확인 부탁드립니다.",
                                icon: "warning",
                                buttons: true,
                                dangerMode: true,
                            }).then((value) => {
                                if (value) {
                                    let formData = new FormData($("#changeInfoForm")[0]);

                                    $.ajax({
                                        type: "POST",
                                        url: "./php/changeInfo_OK.php",
                                        contentType: false,
                                        processData: false,
                                        dataType: "json",
                                        data: formData,

                                        success: function(response) {
                                            if (response.success == true) {
                                                swal({
                                                    title: '내정보 변경 성공',
                                                    text: "정보 수정이 정상처리되었습니다.",
                                                    icon: 'success'
                                                }).then((result) => {
                                                    window.location.href = "/";
                                                });

                                            } else if (response.code == 99) {
                                                swal({
                                                    title: '내정보 변경 실패',
                                                    text: "현재 비밀번호가 옳바르지 않습니다.",
                                                    icon: 'error'
                                                });
                                                return;
                                            }
                                        },

                                        error: function(response) {
                                            swal({
                                                title: '시스템 에러',
                                                text: "시스템 에러가 발생하였습니다. \n F12키를 눌러 Console창을 확인하세요.",
                                                icon: 'error'
                                            });
                                        }
                                    });
                                }
                            });
                        }
                    });
                </script>
            </div>
        </form>
    </div>

    <?php require("./footer.php"); ?>
</body>

</html>