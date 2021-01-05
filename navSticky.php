<div class="nav navSticky" style="display: none; z-index: 12345;">
    <div class="container">
        <div class="navBox" style="padding: 10px;">
            <div class="logoBox">
                <i class="fa fa-bars" style="font-size: 30px; color: #fff; margin-right: 20px; cursor: pointer;" uk-toggle="target: #offcanvas-reveal"></i>

                <h2><a href="/" style="color: #fff;">포폴나라</a></h2>
            </div>

            <div class="loginBox">
                <a class="userBtn mobileSearch fa fa-search" href="#modal-full" uk-toggle style="color: #fff; font-size: 24px; margin-right: 20px;"></a>

                <div id="modal-full" class="dark-mode uk-modal-full uk-modal" uk-modal>
                    <div class="dark-mode uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
                        <button class="uk-modal-close-full" type="button" uk-close></button>
                        <form action="search.php" method="GET" class="uk-search uk-search-large" style="padding: 5px;">
                            <input name="search" class="dark-mode uk-search-input uk-text-center" type="search" placeholder="Search" autofocus style="padding: 10px;">
                        </form>
                    </div>
                </div>

                <?php if (!isset($_SESSION['user'])) : ?>
                    <button class="btn btn-outline-light mx-2" onclick="location.href = './login.php';">로그인</button>
                    <button class="btn btn-outline-light" onclick="location.href = './register.php';">회원가입</button>
                <?php else : ?>
                    <a href="./myProfile.php" style="margin-right: 20px;"><img class="ui mini circular image" uk-tooltip="title: 내 정보; pos: bottom" src="<?= $_SESSION['user']->profile ?>" style="width: 45px; height: 45px;"></a>
                    <button class="btn btn-outline-light logout" onclick="return false;">로그아웃</button>

                    <script>
                        document.querySelector(".logout").addEventListener("click", () => {
                            $.ajax({
                                type: "GET",
                                url: "./php/logout.php",
                                success: function(response) {
                                    swal({
                                        title: '성공',
                                        text: "정상적으로 로그아웃 되었습니다.",
                                        icon: 'success'
                                    }).then((value) => {
                                        window.location.reload();
                                    });
                                }
                            });
                        });
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['user'])) : ?>
    <style>
        .navBox {
            padding: 5px !important;
        }
    </style>
<?php endif; ?>