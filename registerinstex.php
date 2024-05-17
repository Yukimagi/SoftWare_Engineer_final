<?php
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>會員註冊</title>
    <link href="css/registerindex.css" rel="stylesheet" />
</head>
<body>
<header>
    <h1>租屋管理系統</h1>
</header>
<div id="backround">
    <div id="info_container">
        <div id="icon_container">
            <div id="icon">
                <img src="assets/house.png" width="160" height="160">
            </div>
            <div id="college_mark">
                <img src="assets/logo_CMYK.jpg" width="160" height="160">
            </div>
        </div>
        <div id="info_input">
            <div id="title">
                <h1>註冊</h1>
            </div>
            <form action="registerprocess.php" method="post">
                <div class="profile_input">
                    <input type="text" required>
                    <span>使用者姓名</span>
                    <i></i>
                </div>
                <div class="profile_input">
                    <input type="text" required>
                    <span>使用者電話</span>
                    <i></i>
                </div>
                <div class="profile_input">
                    <input type="text" required>
                    <span>個人簡介</span>
                    <i></i>
                </div>
                <div id="submit_button">
                    <input type="submit" value="提交">
                </div>
                <div id="backtoindex">
                    <input type="button" value="返回">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
