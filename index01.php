<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>租屋管理系統</title>
    <style>
        /* 全局樣式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            overflow: hidden;
        }

        /* 頁眉樣式 */
        header {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 32px;
        }

        /* 導航欄樣式 */
        nav {
            float: left;
            width: 200px;
            background: #2c3e50;
            color: #fff;
            box-sizing: border-box;
            height: 100vh;
            overflow-y: auto;
            transition: width 0.5s;
            position: relative;
        }

        nav hr {
            position: absolute;
            bottom: 23vh;
            width: 100%;
        }

        .LoginLink {
            position: absolute;
            bottom: 14vh;
            padding-left: 20px;
        }

        .ApplyLink {
            position: absolute;
            bottom: 10vh;
            padding-left: 20px;
        }

        /*
        nav:hover {
            width: 250px;
        }
        */

        nav h2 {
            margin-top: 0;
            padding-left: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }

        nav ul p {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            padding-left: 20px;
            position: absolute;
            bottom: 17vh;
        }

        nav ul li {
            padding-left: 20px;
        }

        nav ul li a {
            color: lightskyblue;
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            padding: 10px 0;
        }

        nav ul li a:hover {
            color: #3498db;
        }

        /* 內容區域樣式 */
        .content {
            float: left;
            width: calc(100% - 200px);
            padding: 20px;
            box-sizing: border-box;
            transition: width 0.5s;
        }

        /* 响应式样式 */
        @media only screen and (max-width: 768px) {
            nav, .content {
                width: 100%;
            }

            nav {
                width: 100%;
                height: auto;
                position: relative;
                margin-bottom: 20px;
            }

            nav:hover {
                width: 100%;
            }

            .content {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php
        session_start(); // 啟動 session

        if (isset($_GET['logged_in']) && $_GET['logged_in'] === 'false') {
            // 清除所有的 session 資料
            session_unset();
            // 銷毀 session
            session_destroy();
            // 重新導向到登入頁面或其他適合的頁面
            header('Location: index01.php');
            exit;
        }
    ?>
    <header>
        <h1>租屋管理系統</h1>
    </header>
    <nav>
        <h2>功能選單</h2>
        <ul>
            <li><a href="index01.php">首頁</a></li>
            <li><a href="#">廣告平台</a></li>
            <li><a href="CPS/CPS_Home.php">交流平台</a></li>
            <!-- 添加更多功能連結 -->
            <hr> <!-- 添加分隔線 -->
            <p>現在身分為：<span style="color:#b0c4de; display: inline;">訪客</span></p>
            <li class="LoginLink"><a href="loginIndex.php">使用者登入</a></li>
            <li class="ApplyLink"><a href="">帳號申請</a></li>
        </ul>
    </nav>
    <div class="content">
        <h2>歡迎來到租屋管理系統</h2>
        <p>這裡是主要的內容區域，你可以在這裡添加租屋管理、交流平台和廣告平台的相關內容。</p>
        <p>這個模板還可以進一步改進，比如添加用戶登錄、搜索功能、統計信息等等。你可以根據自己的需求進行調整和擴展。</p>
    </div>
</body>
</html>
