window.addEventListener("load", () => {
    let app = new App();

    // CKEDITOR.replace('editor');

    // let data = CKEDITOR.instances.editor.getData();
});

class App {
    constructor() {
        this.header();
        this.register();
        this.login();
    }

    header() {
        window.addEventListener("scroll", (e) => {
            if (document.documentElement.scrollTop >= 900) {
                $(".navHeader").hide();
                $(".navSticky").fadeIn();
            } else {
                $(".navSticky").hide();
                $(".navHeader").fadeIn();
            }
        });
    }

    register() {
        let id = document.querySelector("#id");
        let pw = document.querySelector("#pw");
        let rePw = document.querySelector("#rePw");
        let name = document.querySelector("#name");
        let phone = document.querySelector("#phone");
        let birthday = document.querySelector("#birthday");
        let profileInput = document.querySelector("#profileInput");
        let profileViewer = document.querySelector(".profileViewer");
        let profileUploadCancel = document.querySelector(".profileUploadCancel");
        let profileUploadBtn = document.querySelector(".profileUploadBtn");
        let registerBtn = document.querySelector(".registerBtn");

        //업로드 기능
        if (profileUploadBtn) {
            profileUploadBtn.addEventListener("click", () => {
                profileInput.click();
            });
        }

        if (profileUploadCancel) {
            profileUploadCancel.addEventListener("click", () => {
                profileInput.value = "";
                profileViewer.value = "";
            });
        }

        if (profileInput) {
            profileInput.addEventListener("input", () => {
                let pathpoint = profileInput.value.lastIndexOf('.');
                let filepoint = profileInput.value.substring(pathpoint + 1, profileInput.length);
                let filetype = filepoint.toLowerCase();

                if (filetype == 'jpg' || filetype == 'gif' || filetype == 'png' || filetype == 'jpeg' || filetype == 'bmp') {
                    // 사이즈체크
                    let maxSize = 10 * 1024 * 1024;
                    let fileSize = 0;

                    // 브라우저 확인
                    let browser = navigator.appName;

                    // 익스플로러일 경우
                    if (browser == "Microsoft Internet Explorer") {
                        let oas = new ActiveXObject("Scripting.FileSystemObject");
                        fileSize = oas.getFile(profileInput.value).size;
                    }
                    // 익스플로러가 아닐경우
                    else {
                        fileSize = profileInput.files[0].size;
                    }

                    if (fileSize > maxSize) {
                        swal({ title: '오류', text: '첨부파일 사이즈는 10MB 이내로 등록 가능합니다.', icon: 'error' });
                        profileInput.value = "";
                        profileViewer.value = "";
                        return;
                    }

                } else {
                    swal({ title: '오류', text: '이미지 파일만 업로드가 가능합니다.', icon: 'error' });
                    profileInput.value = "";
                    profileViewer.value = "";
                    return;
                }
            });
        }

        if (registerBtn) {
            registerBtn.addEventListener("click", (e) => {
                if (id.value.trim() == "") {
                    $(id).css("border", "2px solid red");
                } else {
                    $(id).css("border", "1px solid #dadada");
                }

                if (pw.value.trim() == "") {
                    $(pw).css("border", "2px solid red");
                } else {
                    $(pw).css("border", "1px solid #dadada");
                }

                if (rePw.value.trim() == "") {
                    $(rePw).css("border", "2px solid red");
                } else {
                    $(rePw).css("border", "1px solid #dadada");
                }

                if (name.value.trim() == "") {
                    $(name).css("border", "2px solid red");
                } else {
                    $(name).css("border", "1px solid #dadada");
                }

                if (phone.value.trim() == "") {
                    $(phone).css("border", "2px solid red");
                } else {
                    $(phone).css("border", "1px solid #dadada");
                }

                if (birthday.value.trim() == "") {
                    $(birthday).css("border", "2px solid red");
                } else {
                    $(birthday).css("border", "1px solid #dadada");
                }

                if (id.value.trim() == "" || pw.value.trim() == "" || rePw.value.trim() == "" || name.value.trim() == "" || phone.value.trim() == "" || birthday.value.trim() == "" || $("input[name=sex]:checked").val() == undefined) {
                    swal({
                        title: "오류",
                        text: "누락된 값이 있습니다.",
                        icon: "error",
                        button: "확인",
                    });

                    return;
                } else {
                    let pw = $("#pw").val();
                    let rePw = $("#rePw").val();
                    let num = pw.search(/[0-9]/g);
                    let eng = pw.search(/[a-z]/ig);
                    let spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

                    if (pw.length < 8 || pw.length > 20) {
                        swal({ title: '실패', text: "8자리 ~ 20자리 이내로 입력해주세요.", icon: 'error' });
                        return false;

                    } else if (pw.search(/\s/) != -1) {
                        swal({ title: '실패', text: "비밀번호는 공백 없이 입력해주세요.", icon: 'error' });
                        return false;

                    } else if (num < 0 || eng < 0 || spe < 0) {
                        swal({ title: '실패', text: "영문, 숫자, 특수문자를 혼합하여 입력해주세요.", icon: 'error' });
                        return false;

                    } else if (pw !== rePw) {
                        swal({ title: '실패', text: "비밀번호와 비밀번호 확인이 다릅니다.", icon: 'error' });
                        return false;

                    } else {
                        let formData = new FormData($("#loginForm")[0]);

                        $.ajax({
                            type: "POST",
                            url: "/php/register_OK.php",
                            dataType: 'json',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                if (response.result == true) {
                                    swal({ title: '회원가입 성공', text: `${name.value}님의 회원가입을 축하합니다.`, icon: 'success' }).then((value) => {
                                        window.location.href = "/";
                                    });
                                } else if (response.result == false) {
                                    swal({ title: '회원가입 실패', text: `${name.value}님의 아이디가 이미 존재합니다.`, icon: 'error' });

                                } else {
                                    swal({ title: '회원가입 실패', text: "시스템에 문제가 발생하였습니다.", icon: 'error' }).then((value) => {
                                        window.location.href = "/";
                                    });
                                }
                            },

                            error: function (response) {
                                swal({ title: '회원가입 실패', text: "시스템에 문제가 발생하였습니다.", icon: 'error' }).then((value) => {
                                    window.location.href = "/";
                                });
                            }
                        });
                    }
                }
            });
        }
    }

    login() {
        let loginId = document.querySelector("#id");
        let loginPw = document.querySelector("#pw");
        let btn = document.querySelector(".loginBtn");

        if (btn) {
            btn.addEventListener("click", () => {
                if (loginId.value.trim() == "") {
                    $(loginId).css("border", "2px solid red");
                } else {
                    $(loginId).css("border", "1px solid #dadada");
                }

                if (loginPw.value.trim() == "") {
                    $(loginPw).css("border", "2px solid red");
                } else {
                    $(loginPw).css("border", "1px solid #dadada");
                }

                if (loginId.value.trim() == "" || loginPw.value.trim() == "") {
                    swal({ title: '실패', text: "누락된 항목이 있습니다.", icon: 'error' });
                    return;
                } else {
                    let formData = new FormData($("#loginForm")[0]);

                    $.ajax({
                        type: "POST",
                        url: "/php/login_OK.php",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function (response) {
                            if (response.result == true) {
                                window.location.href = "/";
                            } else {
                                console.log(response);
                                swal({ title: '실패', text: "아이디 또는 비밀번호가 올바르지 않습니다.", icon: 'error' });
                            }
                        }
                    });
                }
            });
        }
    }
}