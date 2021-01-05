<!DOCTYPE html>
<html lang="ko">

<title>포폴나라 - 로그인</title>
<?php require("./head.php"); ?>

<body>
    <?php require("navSticky.php"); ?>

    <?php require("./header.php"); ?>
    <div class="container">

        <h1 align="center" style="margin-top: 20px; color: #fff; font-size: 50px;">로그인</h1>

        <div class="loginBox">
            <form method="POST" id="loginForm" style="padding-top: 30px;">
                <div class="input_form">
                    <label for="id">*아이디</label><br>

                    <div class="uk-inline" style="width: 100%;">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input" type="text" id="id" name="id">
                    </div>
                </div>

                <div class="input_form">
                    <label for="pw">*비밀번호</label><br>

                    <div class="uk-inline" style="width: 100%;">
                        <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                        <input type="password" class="uk-input" id="pw" name="pw">
                    </div>
                </div>

                <div class="input_form" style="text-align: right;">
                    <a href="./searchUser.php" style="color: #217df7;">비밀번호를 잊으셨나요?</a><br>
                    <button type="submit" onclick="return false;" class="btn btn-primary loginBtn" style="margin-top: 10px;">로그인</button>
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