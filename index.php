<?php
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1){
    header("location:lobby.php");
    exit();
}
?>
<!DOCTYPE>
<html lang="zh-Hant">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>RMS HomePage</title>
        <link href="css/index.css" rel="stylesheet" />
    </head>
    <body>
    <header>
        <h1>租屋管理系統</h1>
    </header>
    <nav>
        <h2>功能選單</h2>
        <ul>
            <li><a href="index.php">首頁</a></li>
            <li><a href="#">廣告平台</a></li>
            <!-- 添加更多功能連結 -->
            <hr> <!-- 添加分隔線 -->
            <p>現在身分為：<span style="color:#b0c4de; display: inline;">訪客</span></p>
            <li class="LoginLink"><a href="loginIndex.php">使用者登入</a></li>
            <li class="ApplyLink"><a href="registerinstex.php">帳號申請</a></li>
        </ul>
    </nav>
    <div class="content">
        <h2>歡迎來到租屋管理系統</h2>
        <p>這裡是主要的內容區域，你可以在這裡添加租屋管理、交流平台和廣告平台的相關內容。</p>
        <p>這個模板還可以進一步改進，比如添加用戶登錄、搜索功能、統計信息等等。你可以根據自己的需求進行調整和擴展。</p>
    </div>
    </body>
</html>