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
    <title>用戶詳細資料</title>
    <link href="css/lobby.css" rel="stylesheet" />
    <script src="js/scripts.js"></script>
    <style>
        .content table {
            margin: 0 auto; /* 讓表格置中 */
            border-collapse: collapse; /* 合併邊框 */
        }

        .content th,
        .content td {
            /*border: 1px solid black; /* 添加框線 */
            padding: 8px; /* 設置儲存格內距 */
            /*text-align: center;*/
        }
        div table {
            width: 100%;
        }

        input[readonly]{
            background-color: grey;
        }
    </style>
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
                    <li><a href="SAS_UserDelete.php" id="sys_function">刪除使用者帳戶</a></li>
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
            echo ' <li><a href="#">個人帳戶管理</a></li>';
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
    <?php
        include("connection.php");
        
        // 檢查是否有傳遞用戶ID
        if (isset($_POST['identity'])) {
            $new_identity = $_POST['identity'];

            $sql_query = "SELECT MAX(user_profile.uid) as now FROM user_profile";
            $result = $conn->query($sql_query);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $currentUid = $row['now'];
            $numberPart = (int)substr($currentUid, 1); // 提取數字部分，並轉換為整數
            $newNumberPart = $numberPart + 1; // 增加 1
            $new_Uid = "U" . str_pad($newNumberPart, 5, "0", STR_PAD_LEFT); // 補齊零填充並連接回 "U" 字母

            echo "<h1>請輸入使用者資料</h1>";       // 在這裡顯示用戶詳細資料

            switch ($new_identity) {
                case 'T':
                    echo '<div class="profile_form">';
                    echo '<form action="SAS_SQLCreate.php" method="post" onsubmit="return createconfirm()">';
                    echo '<table>';
                    echo '<tr>';
                        echo '<th style="width: 10%;"></th>';
                        echo '<th style="width: 25%;"></th>';
                        echo '<th style="width: 7%;"></th>';
                        echo '<th style="width: 40%;"></th>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="teacher_name">教師姓名</label></td><td><input type="text" name="teacher_name"></td>';
                        echo '<td><label for="teacher_rank">教師職級</label></td><td><input type="text" name="teacher_rank"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="teacher_tel">教師連絡電話</label></td><td><input type="text" name="teacher_tel"></td>';
                        echo '<td><label for="teacher_mail">教師E-mail</label></td><td><input type="text" name="teacher_mail"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="office_location">辦公室位置</label></td><td><input type="text" name="office_location"></td>';
                        echo '<td><label for="office_phone">辦公室電話</label></td><td><input type="text" name="office_phone"></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<br>';
                    echo '<input type="hidden" name="uid" value="' . $new_Uid . '">';
                    echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
                    echo '<input type="submit" value="儲存">';
                    echo '<input type="button" value="返回" onclick="location.href=\'SAS.php\'">';
                    echo '</form>';
                    echo '</div>';
                    break;
                case 'S':
                    echo '<div class="profile_form">';
                    echo '<form action="SAS_SQLCreate.php" method="post" onsubmit="return createconfirm()">';
                    echo '<table>';
                    echo '<tr>';
                        echo '<th style="width: 10%;"></th>';
                        echo '<th style="width: 25%;"></th>';
                        echo '<th style="width: 7%;"></th>';
                        echo '<th style="width: 40%;"></th>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="student_name">學生姓名</label></td><td><input type="text" name="student_name"></td>';
                        echo '<td><label for="student_id">學生學號</label></td><td><input type="text" name="student_id"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="student_Tname">學生導師姓名</label></td><td><input type="text" name="student_Tname"></td>';
                        echo '<td></td><td></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="student_grade">學生年級</label></td><td><input type="text" name="student_grade"></td>';
                        echo '<td><label for="student_gender">學生性別</label></td><td><input type="text" name="student_gender"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="student_phone">學生連絡電話</label></td><td><input type="text" name="student_phone"></td>';
                        echo '<td><label for="student_email">學生E-mail</label></td><td><input type="text" name="student_email"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="student_haddr">學生家中地址</label></td><td><input type="text" name="student_haddr"></td>';
                        echo '<td><label for="student_htel">學生家中電話</label></td><td><input type="text" name="student_htel"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="student_cont">學生緊急聯絡人</label></td><td><input type="text" name="student_cont"></td>';
                        echo '<td><label for="student_contphone">學生緊急聯絡人電話</label></td><td><input type="text" name="student_contphone"></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<br>';
                    echo '<input type="hidden" name="uid" value="' . $new_Uid . '">';
                    echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
                    echo '<input type="submit" value="儲存">';
                    echo '<input type="button" value="返回" onclick="location.href=\'SAS.php\'">';
                    echo '</form>';
                    echo '</div>';
                    break;
                case 'L':
                    echo '<div class="profile_form">';
                    echo '<form action="SAS_SQLCreate.php" method="post" onsubmit="return createconfirm()">';
                    echo '<table>';
                    echo '<tr>';
                        echo '<th style="width: 10%;"></th>';
                        echo '<th style="width: 25%;"></th>';
                        echo '<th style="width: 7%;"></th>';
                        echo '<th style="width: 40%;"></th>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="landlord_name">房東姓名</label></td><td><input type="text" name="landlord_name"></td>';
                        echo '<td><label for="landlord_gender">房東性別</label></td><td><input type="text" name="landlord_gender"></td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td><label for="landlord_phone">房東連絡電話</label></td><td><input type="text" name="landlord_phone"></td>';
                        echo '<td><label for="landlord_line">房東LineID</label></td><td><input type="text" name="landlord_line"></td>';
                    echo '</tr>';
                    echo '</table>';
                    echo '<br>';
                    echo '<input type="hidden" name="uid" value="' . $new_Uid . '">';
                    echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
                    echo '<input type="submit" value="儲存">';
                    echo '<input type="button" value="返回" onclick="location.href=\'SAS.php\'">';
                    echo '</form>';
                    echo '</div>';
                    break;
            }
        } else {
            echo "未提供用戶ID。";
        }
    ?>
</div>
</body>
</html>
