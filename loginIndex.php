<?php
session_start();
if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>系統登入</title>
    <link href="css/style.css" rel="stylesheet" />
</head>
<body>
<nav id="navbar">
    <div id="homepagemark">
        <a href="index.php">
            <button id="gotohomepage">
                校外租屋系統
            </button>
        </a>
    </div>
    <div id="nav">
        <ul id="navbarul">
            <li><a href="loginIndex.php">登入</a></li>
            <li><a href="loginIndex.php">註冊</a></li>
            <li><a href="loginIndex.php">關於</a></li>
        </ul>
    </div>
</nav>
<div id="backround"></div>
<div id="logincontainer">
    <div id="loginmsg">
        系統登入
    </div>
    <div id="login">
        <form method="post" action="loginprocess.php">
            <div class="msgcontainer">
                <div class="identifiertext">
                    帳號
                </div>
                <div class="identifierinput">
                    <input type="text" class="textinput" name="account" placeholder="請輸入使用者帳號" required>
                    <span class="line"></span>
                </div>
            </div>
            <div class="msgcontainer">
                <div class="identifiertext">
                    密碼
                </div>
                <div class="identifierinput">
                    <input type="password" class="textinput" name="password" placeholder="請輸入使用者密碼" required>
                    <span class="line"></span>
                </div>
            </div>
            <div class="msgcontainer">
                <div id="submitbox">
                    <input type="submit" value="登入" id="trigger">
                </div>
                <div id="buttonbox">
                    <button id="backtohome">返回</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
