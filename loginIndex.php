<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>系統登入</title>
    <link href="css/style.css" rel="stylesheet" />
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <?php
    /*
        session_start();

        $location = "localhost"; //連到本機
        $account = "root";
        $password = "32438654";
        $link = mysql_pconnect($location,$account,$password);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fileid = $_POST["account"];
            $filename = $_POST["passwd"];

            $select_db = @mysql_select_db("rentsystem");
            if (!$select_db) {
                echo '<br>找不到資料庫!<br>';
            } else {
                $sql_query = "select * from user_profile where account='" . $fileid . "' AND password='" . $filename . "'";
                $result = mysql_query($sql_query);

                if (mysql_num_rows($result) != 0) {
                    $sql_query = "select * from user_profile where account='" . $fileid . "' AND password='" . $filename . "'";
                    $result = mysql_query($sql_query);
                    $row = mysql_fetch_array($result);
                    
                    // 設置使用者登入的相關 session 資料
                    $_SESSION['logged_in'] = true;
                    $_SESSION['identity'] = $row["identity"];
                    $_SESSION['uid'] = $row["uid"];

                    header("Location: index02.php"); // 重新導向到 test02.php

                    //header("Location: test02.php?identity=" . $row["identity"] . "&uid=" . $row["uid"]); // 將重新導向到 test02.php
                    exit();
                } else {
                    echo '<script>showAlert("登入失敗\n帳號或密碼輸入錯誤");</script>';
                }
            }
        }
    */?>
<nav id="navbar">
    <div id="homepagemark">
        <a href="newIndex.php">
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
        <form method="post" action="">
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
                    <input type="password" class="textinput" name="passwd" placeholder="請輸入使用者密碼" autocomplete="off" required>
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
