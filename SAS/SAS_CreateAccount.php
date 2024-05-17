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
    <link href="../css/SAS_CreateAccount.css" rel="stylesheet" />
    <script src="../js/scripts.js"></script>
</head>
<body>
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

            echo "<h1>請輸入新建使用者資料</h1>";       // 在這裡顯示用戶詳細資料
            echo '<hr>';

            switch ($new_identity) {
                case 'T':
                    echo '<div class="profile_form">';
                    echo '<form action="SAS_SQLCreate.php" method="post" onsubmit="return createconfirm()">';
                    echo '<table class="profile_table">';
                    echo '<tr>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
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
                    echo '<hr>';
                    echo '<div class="buttonbox">';
                    echo '<input type="hidden" name="uid" value="' . $new_Uid . '">';
                    echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
                    echo '<input type="submit" value="儲存" class="leftbutton">';
                    echo '<input type="button" value="返回" onclick="location.href=\'SAS_CreateAccountChoice.php\'" class="rightbutton">';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    break;
                case 'S':
                    echo '<div class="profile_form">';
                    echo '<form action="SAS_SQLCreate.php" method="post" onsubmit="return createconfirm()">';
                    echo '<table class="profile_table">';
                    echo '<tr>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
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
                    echo '<hr>';
                    echo '<div class="buttonbox">';
                    echo '<input type="hidden" name="uid" value="' . $new_Uid . '">';
                    echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
                    echo '<input type="submit" value="儲存" class="leftbutton">';
                    echo '<input type="button" value="返回" onclick="location.href=\'SAS_CreateAccountChoice.php\'" class="rightbutton">';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                    break;
                case 'L':
                    echo '<div class="profile_form">';
                    echo '<form action="SAS_SQLCreate.php" method="post" onsubmit="return createconfirm()">';
                    echo '<table class="profile_table">';
                    echo '<tr>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
                        echo '<th></th>';
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
                    echo '<hr>';
                    echo '<div class="buttonbox">';
                    echo '<input type="hidden" name="uid" value="' . $new_Uid . '">';
                    echo '<input type="hidden" name="identity" value="' . $new_identity . '">';
                    echo '<input type="submit" value="儲存" class="leftbutton">';
                    echo '<input type="button" value="返回" onclick="location.href=\'SAS_CreateAccountChoice.php\'" class="rightbutton">';
                    echo '</div>';
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
