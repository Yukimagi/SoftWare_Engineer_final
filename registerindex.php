<?php
include("SAS/connection.php");

$sql_query = "SELECT MAX(account_applications.id) as now FROM account_applications";
$result = $conn->query($sql_query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$currentid = $row['now'];
$numberPart = (int)substr($currentid, 2); // 提取數字部分，並轉換為整數
$newNumberPart = $numberPart + 1; // 增加 1
$new_id = "ap" . str_pad($newNumberPart, 5, "0", STR_PAD_LEFT); // 補齊零填充並連接回 "ap" 字母

?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>會員註冊</title>
    <link href="css/registerindex.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
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
            <form action="applyprocess.php" method="post">
                <div class="profile_input">
                    <input type="text" name="name" required>
                    <span>使用者姓名</span>
                    <i></i>
                </div>
                <div class="profile_input">
                    <input type="text" name="phone" required>
                    <span>使用者電話</span>
                    <i></i>
                </div>
                <div class="profile_input">
                    <input type="text" required>
                    <span>電子郵件</span>
                    <i></i>
                </div>
                <div class="profile_input">
                    <input type="text" name="reason" required>
                    <span>個人簡介</span>
                    <i></i>
                </div>
                <?php
                echo '<input type="hidden" name="id" value="' . $new_id . '">';
                ?>
                <div id="submit_button">
                    <input type="submit" value="提交" class="register_button" id="top_button">
                </div>
                <div id="backtoindex">
                    <input type="button" value="返回" class="register_button" id="bottom_button" onclick="backtoindex()">
                </div>
                <div id="backtoindex">
                    <input type="button" value="案件進度查詢" class="register_button" id="check_button" onclick="id_check()">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
