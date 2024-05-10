<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>系統登入</title>
    <link href="css/loginindex.css" rel="stylesheet" />
</head>
<body>
<header>
    <h1>租屋管理系統</h1>
</header>
<div id="backround"></div>
<div id="logincontainer">
    <div id="loginmsg">
        <div id="loginiconbox">
            <img src="assets/user-interface.png" id="icon">
        </div>
        <div id="logintextbox">
            系統登入
        </div>
    </div>
    <div id="login">
        <form method="post" action="loginprocess.php">
            <div class="msgcontainer">
                <div class="identifiertext">
                    帳號
                </div>
                <div class="identifierinput">
                    <input type="text" class="textinput" name="account" placeholder="請輸入使用者帳號" autocomplete="off" required>
                    <span class="line"></span>
                </div>
            </div>
            <div class="msgcontainer">
                <div class="identifiertext">
                    密碼
                </div>
                <div class="identifierinput">
                    <input type="password" class="textinput" name="password" placeholder="請輸入使用者密碼" autocomplete="off" required>
                    <span class="line"></span>
                </div>
            </div>
            <div class="msgcontainer">
                <div id="submitbox">
                    <input type="submit" value="登入" id="trigger">
                </div>
            </div>
        </form>
            <div id="buttonbox">
                <a href="index.php" id="back">
                    <button id="backtohome">返回</button>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
