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
            <li><a href="AS/AS_Home.php">廣告平台</a></li>
            <li><a href="CPS/CPS_Home.php">交流平台</a></li>


            <!-- 添加更多功能連結 -->
            <hr> <!-- 添加分隔線 -->
            <p>現在身分為：<span style="color:#b0c4de; display: inline;">訪客</span></p>
            <li class="LoginLink"><a href="loginIndex.php">使用者登入</a></li>
            <li class="ApplyLink"><a href="registerindex.php">帳號申請</a></li>


        </ul>
    </nav>
    <div class="content">
        <h2>歡迎來到租屋管理系統</h2>
        <p>指導教授:林文揚</p>
        <p>開發者:</p>
        <p>組長:A1105505 林彧頎</p>
        <p>組員:A1105511 楊宗熹、A1105524 吳雨宣、A1105539 鄭玥晋、A1105545 潘妤揚、A1105549 杜佩真</p>
        <h2>本系統特色:</h2>
        <p>解決sql injection 資安問題、交流平台-提供使用者線上交流與租屋物件評價、廣告-提供使用者快速搜尋適合的租屋物件、訪談系統-租屋訪談紀錄、系統管理員-在各個子系統皆有相關的操作，特別是可以對權限與狀態(目前是否可繼續使用此帳號)做處理</p>
        <h2>本系統資料庫伺服器:</h2>
        <p>伺服器: localhost via TCP/IP、伺服器類別: MySQL、伺服器版本: 5.7.17-log - MySQL Community Server (GPL)、協定版本: 10</p>
        <h2>網頁伺服器:</h2>
        <p>Apache/2.4.25 (Win32) OpenSSL/1.0.2j PHP/5.6.30、PHP 版本： 5.6.30</p>
        <h2>phpMyAdmin:4.6.6</h2>

    </div>
    </body>
</html>
