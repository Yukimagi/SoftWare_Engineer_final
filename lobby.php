<?php
session_start();
$identity = $_SESSION['identity'];
$name = $_SESSION['name'];
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>HomePage</title>
    <link href="css/lobby.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
</head>
<body>
<header>
    <h1>租屋管理系統</h1>
</header>
<nav>
    <h2>功能選單</h2>
    <ul>
        <div>
            <li><a href="lobby.php">首頁</a></li>
        </div>
        <?php
        $managementlist = '
            <div id="management_function">
                <span><li><a href="SAS.php">後台 - 帳號管理</a></li></span>
                <div class="option">
                    <li><a href="SAS_CreateAccountChoice.php" id="sys_function">新增使用者帳戶</a></li>
                    <li><a href="#" id="sys_function">新增大量帳戶</a></li>
                    <li><a href="#" id="sys_function">刪除使用者帳戶</a></li>
                    <li><a href="#" id="sys_function">變更使用者權限</a></li>
                </div>
            </div>
        ';
        if (isset($identity) && $identity === "SYS") {
            echo $managementlist;
        }
        ?>
        <div>
            <li><a href="#">租屋管理</a></li>
        </div>
        <div>
            <li><a href="#">交流平台</a></li>
        </div>
        <div>
            <li><a href="#">廣告平台</a></li>
        </div>
        <?php
        if (isset($identity) && $identity !== "SYS") {
            echo ' <li><a href="SAS_MineUserDetails.php">個人帳戶管理</a></li>';
        }
        ?>
        <!-- 添加更多功能連結 -->
        <hr> <!-- 添加分隔線 -->
        <p>現在身分為：
            <?php
            if (isset($identity) && $identity === "SYS") {
                echo '<span style="color:#b0c4de; display: inline;">系統管理員</span>';
            }
            elseif (isset($identity) && $identity === "T") {
                echo '<span style="color:#b0c4de; display: inline;">教師</span>';
            }
            elseif (isset($identity) && $identity === "S") {
                echo '<span style="color:#b0c4de; display: inline;">學生</span>';
            }
            elseif (isset($identity) && $identity === "L") {
                echo '<span style="color:#b0c4de; display: inline;">房東</span>';
            }


            if (isset($identity) && $identity !== "SYS") {
                echo '<br>';
                echo '使用者姓名：<span style="color:#b0c4de; display: inline;">' . $name . '</span>';
            }
            ?>
        </p>
        <li class="LoginLink"><a href="logoutprocess.php">使用者登出</a></li>
    </ul>
</nav>
<div class="content">
    <h2>歡迎來到租屋管理系統</h2>
    <p>這裡是主要的內容區域，你可以在這裡添加租屋管理、交流平台和廣告平台的相關內容。</p>
    <p>這個模板還可以進一步改進，比如添加用戶登錄、搜索功能、統計信息等等。你可以根據自己的需求進行調整和擴展。</p>
</div>
</body>
</html>
