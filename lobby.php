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
                <span><input type="button" id="manage_button" value="後台 - 帳號管理" onclick="showiframe1()"></span>
                <div class="option">
                    <li><a href="#" id="sys_function" onclick="showiframe4()">新增使用者帳戶</a></li>
                    <li><a href="#" id="sys_function">新增大量帳戶</a></li>
                    <li><a href="#" id="sys_function" onclick="showiframe2()">刪除使用者帳戶</a></li>
                    <li><a href="#" id="sys_function">變更使用者權限</a></li>
                </div>
            </div>
        ';
        if (isset($identity) && $identity === "SYS") {
            echo $managementlist;
        }
        ?>
        <div>
            <li><a href="IS/IS_Home.php">租屋管理</a></li>
        </div>
        <div>
            <li><a href="#">交流平台</a></li>
        </div>
        <div>
            <li><a href="AS/AS_Home.php">廣告平台</a></li>
        </div>
        <?php
        if (isset($identity) && $identity !== "SYS") {
            echo ' <li><a href="#" onclick="showiframe3()">個人帳戶管理</a></li>';
        }
        ?>
        <!-- 添加更多功能連結 -->
        <hr> <!-- 添加分隔線 -->
        <p id="statuspage">現在身分為：
            <?php
            if (isset($identity) && $identity === "SYS") {
                echo '<span style="color:#b0c4de; display: inline;">管理員</span>';
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
    <div id="iframe_container">
        <iframe id="user_profile" src="SAS.php"></iframe>
        <iframe id="user_delete" src="SAS_UserDelete.php"></iframe>
        <iframe id="personaluserdetail" src="SAS_MineUserDetails.php"></iframe>
        <iframe id="createaccountchoice" src="SAS_CreateAccountChoice.php"></iframe>
    </div>
</div>
</body>
</html>
