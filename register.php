<!DOCTYPE html>
<html lang="ko">

<title>포폴나라 - 회원가입</title>
<?php require("./head.php"); ?>

<body>
    <?php require("navSticky.php"); ?>

    <?php require("./header.php"); ?>
    <div class="container">

        <h1 align="center" style="margin-top: 20px; color: #fff; font-size: 50px;">회원가입</h1>

        <div class="loginBox">
            <form method="POST" id="loginForm">
                <p style="color: red;">* 은 필수 항목 입니다.</p>

                <div class="input_form">
                    <label for="id">*아이디</label><br>

                    <div class="uk-inline" style="width: 100%;">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input" type="text" id="id" name="id">
                    </div>
                </div>

                <div class="input_form" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="input_form2a">
                        <label for="pw">*비밀번호</label><br>

                        <div class="uk-inline" style="width: 100%;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input type="password" class="uk-input" id="pw" name="pw">
                        </div>
                    </div>

                    <div class="input_form2a">
                        <label for="rePw">*비밀번호 확인</label><br>

                        <div class="uk-inline" style="width: 100%;">
                            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                            <input type="password" class="uk-input" id="rePw" name="rePw">
                        </div>
                    </div>
                </div>

                <div class="input_form" style="display: flex; justify-content: space-between;">
                    <div class="input_form2a">
                        <label for="name">*성함</label><br>
                        <input type="text" class="uk-input" id="name" name="name">
                    </div>

                    <div class="input_form2a">
                        <label for="phone">*연락처</label><br>
                        <input type="number" class="uk-input" id="phone" name="phone" placeholder="숫자만 입력하세요.">
                    </div>
                </div>

                <div class="input_form" style="display: flex; justify-content: space-between;">
                    <div class="input_form2a">
                        <label for="birthday">*생년월일</label><br>
                        <input type="date" id="birthday" name="birthday" class="uk-input">
                    </div>

                    <div class="input_form2a">
                        <label for="sex">*성별</label><br>

                        <div class="radio_box" style="display: flex; justify-content: space-around; align-items: center; padding: 10px;">
                            <label><input type="radio" name="sex" value="남" style="width: 20px; height: 20px;" checked> 남</label>
                            <label><input type="radio" name="sex" value="여" style="width: 20px; height: 20px;"> 여 </label>
                        </div>
                    </div>
                </div>

                <div class="input_form">
                    <label for="profileInput">프로필</label><br>

                    <div uk-form-custom="target: true" style="width: 100%; display: flex; justify-content: space-between; align-items: center; background-color: #fff; color: #444;">
                        <input type="file" id="profileInput" name="profileInput" style="background-color: #fff; color: #444;">
                        <input class="uk-input uk-form-width-medium profileViewer" id="profileViewer" name="profileViewer" type="text" placeholder="사진 찾기" readonly style="width: 100%; background-color: #fff !important; color: #444;">
                    </div>

                    <div class="profileBtnBox" style="display: flex; margin-top: 2px;">
                        <button type="button" class="uk-button uk-button-default profileUploadCancel" style="width: 50%; border: 1px solid #fff; margin-right: 1px;">취소</button>
                        <button type="button" class="uk-button uk-button-default profileUploadBtn" style="width: 50%; border: 1px solid #fff;">업로드</button>
                    </div>
                </div>

                <div class="input_form" style="display: flex; justify-content: flex-end; align-items: center;">
                    <button type="submit" onclick="return false;" class="btn btn-primary registerBtn">가입하기</button>
                </div>
            </form>
        </div>
    </div>
    </header>

    <script>
        $("header").css("height", "940px");
    </script>

    <?php require("./footer.php"); ?>
</body>

</html>