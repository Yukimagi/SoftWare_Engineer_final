<?php
session_start();
$identity = $_SESSION['identity'];
$name = $_SESSION['name'];
$uid = $_SESSION['uid'];
?>
<!DOCTYPE>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>用戶詳細資料</title>
    <link href="../css/SAS_MineUserDetails.css" rel="stylesheet" />
    <script src="../js/scripts.js"></script>
</head>
<body>
<div class="content">
    <?php
        include("connection.php");
        
        // 檢查是否有傳遞用戶ID
        if (isset($_SESSION['uid'])) {
            switch ($identity) {
                case 'T':
                    $sql_query = "select * from teacher_profile where t_uid='" . $uid . "'";
                    break;
                case 'S':
                    $sql_query = "select * from basicinfo where uid='" . $uid . "'";
                    break;
                case 'L':
                    $sql_query = "select * from landlord where uid='" . $uid . "'";
                    break;
            }
            $result = $conn->query($sql_query);
            if ($result->rowCount() > 0) {
                $user_profile = $result->fetch(PDO::FETCH_ASSOC);
                $user_profile_array = array_values($user_profile);
                echo "<h1>個人帳戶資料</h1>";       // 在這裡顯示用戶詳細資料
                echo '<hr>';

                $sql_query = "select * from user_profile where uid='" . $uid . "'";
                $result = $conn->query($sql_query);
                if ($result->rowCount() > 0) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                }

                switch ($identity) {
                    case 'T':
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLUpdate.php" method="post" onsubmit="return updateconfirm()">';
                        echo '<table class="profile_table">';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">帳號</label></td><td><input type="text" name="account" value="' . $row['account'] . '"></td>';
                            echo '<td><label for="teacher_rank">密碼</label></td><td><input type="text" name="passwd" value="' . $row['password'] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">教師姓名</label></td><td><input type="text" name="teacher_name" value="' . $user_profile_array[1] . '" readonly="true"></td>';
                            echo '<td><label for="teacher_rank">教師職級</label></td><td><input type="text" name="teacher_rank" value="' . $user_profile_array[2] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_tel">教師連絡電話</label></td><td><input type="text" name="teacher_tel" value="' . $user_profile_array[3] . '"></td>';
                            echo '<td><label for="teacher_mail">教師E-mail</label></td><td><input type="text" name="teacher_mail" value="' . $user_profile_array[4] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="office_location">辦公室位置</label></td><td><input type="text" name="office_location" value="' . $user_profile_array[5] . '"></td>';
                            echo '<td><label for="office_phone">辦公室電話</label></td><td><input type="text" name="office_phone" value="' . $user_profile_array[6] . '"></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<hr>';
                        echo '<div class="buttonbox">';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存" class="leftbutton">';
                        echo '<input type="button" value="返回" onclick="backtolobby" class="rightbutton">';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        /*
                        echo "<p>教師姓名：" . $user_profile_array[1] . "</p>";
                        echo "<p>教師職級：" . $user_profile_array[2] . "</p>";
                        echo "<p>教師連絡電話：" . $user_profile_array[3] . "</p>";
                        echo "<p>教師E-mail：" . $user_profile_array[4] . "</p>";
                        echo "<p>辦公室位置：" . $user_profile_array[5] . "</p>";
                        echo "<p>辦公室電話：" . $user_profile_array[6] . "</p>";
                        */
                        break;
                    case 'S':
                        $sql_query = "select * from teacher_profile where t_uid='" . $user_profile_array[1] . "'";
                        $result = $conn->query($sql_query);
                        if ($result->rowCount() > 0) {
                            $teacher_profile = $result->fetch(PDO::FETCH_ASSOC);
                            $teacher_name = $teacher_profile['t_name'];
                        }
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLUpdate.php" method="post" onsubmit="return updateconfirm()">';
                        echo '<table class="profile_table">';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">帳號</label></td><td><input type="text" name="account" value="' . $row['account'] . '"></td>';
                            echo '<td><label for="teacher_rank">密碼</label></td><td><input type="text" name="passwd" value="' . $row['password'] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_name">學生姓名</label></td><td><input type="text" name="student_name" value="' . $user_profile_array[3] . '" readonly="true"></td>';
                            echo '<td><label for="student_id">學生學號</label></td><td><input type="text" name="student_id" value="' . $user_profile_array[2] . '" readonly="true"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_Tname">學生主修系所</label></td><td><input type="text" name="student_major" value="' . $user_profile_array[4] . '"></td>';
                            echo '<td><label for="student_Tname">學生導師姓名</label></td><td><input type="text" name="student_Tname" value="' . $teacher_name . '"  readonly="true"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_grade">學生年級</label></td><td><input type="text" name="student_grade" value="' . $user_profile_array[5] . '"></td>';
                            echo '<td><label for="student_gender">學生性別</label></td><td><input type="text" name="student_gender" value="' . $user_profile_array[6] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_phone">學生連絡電話</label></td><td><input type="text" name="student_phone" value="' . $user_profile_array[7] . '"></td>';
                            echo '<td><label for="student_email">學生E-mail</label></td><td><input type="text" name="student_email" value="' . $user_profile_array[8] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_haddr">學生家中地址</label></td><td><input type="text" name="student_haddr" value="' . $user_profile_array[9] . '"></td>';
                            echo '<td><label for="student_htel">學生家中電話</label></td><td><input type="text" name="student_htel" value="' . $user_profile_array[10] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_cont">學生緊急聯絡人</label></td><td><input type="text" name="student_cont" value="' . $user_profile_array[11] . '"></td>';
                            echo '<td><label for="student_contphone">學生緊急聯絡人電話</label></td><td><input type="text" name="student_contphone" value="' . $user_profile_array[12] . '"></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<hr>';
                        echo '<div class="buttonbox">';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存" class="leftbutton">';
                        echo '<input type="button" value="返回" onclick="backtolobby()" class="rightbutton">';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        /*
                        echo "<p>學生導師姓名：" . $teacher_name . "</p>";
                        echo "<p>學生學號：" . $user_profile_array[2] . "</p>";
                        echo "<p>學生姓名：" . $user_profile_array[3] . "</p>";
                        echo "<p>學生年級：" . $user_profile_array[4] . "</p>";
                        echo "<p>學生性別：" . $user_profile_array[5] . "</p>";
                        echo "<p>學生連絡電話：" . $user_profile_array[6] . "</p>";
                        echo "<p>學生E-mail：" . $user_profile_array[7] . "</p>";
                        echo "<p>學生家中地址：" . $user_profile_array[8] . "</p>";
                        echo "<p>學生家中電話：" . $user_profile_array[9] . "</p>";
                        echo "<p>學生緊急聯絡人：" . $user_profile_array[10] . "</p>";
                        echo "<p>學生緊急聯絡人電話：" . $user_profile_array[11] . "</p>";
                        */
                        break;
                    case 'L':
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLUpdate.php" method="post" onsubmit="return updateconfirm()">';
                        echo '<table class="profile_table">';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">帳號</label></td><td><input type="text" name="account" value="' . $row['account'] . '"></td>';
                            echo '<td><label for="teacher_rank">密碼</label></td><td><input type="text" name="passwd" value="' . $row['password'] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="landlord_name">房東姓名</label></td><td><input type="text" name="landlord_name" value="' . $user_profile_array[1] . '" readonly="true"></td>';
                            echo '<td><label for="landlord_gender">房東性別</label></td><td><input type="text" name="landlord_gender" value="' . $user_profile_array[2] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="landlord_phone">房東連絡電話</label></td><td><input type="text" name="landlord_phone" value="' . $user_profile_array[3] . '"></td>';
                            echo '<td><label for="landlord_line">房東LineID</label></td><td><input type="text" name="landlord_line" value="' . $user_profile_array[4] . '"></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<hr>';
                        echo '<div class="buttonbox">';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存" class="leftbutton">';
                        echo '<input type="button" value="返回" onclick="backtolobby()" class="rightbutton">';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        /*
                        echo "<p>房東姓名：" . $user_profile_array[1] . "</p>";
                        echo "<p>房東性別：" . $user_profile_array[2] . "</p>";
                        echo "<p>房東連絡電話：" . $user_profile_array[3] . "</p>";
                        echo "<p>房東LineID：" . $user_profile_array[4] . "</p>";
                        */
                        break;
                }
            } else {
                //echo "找不到該用戶的資料。";
                echo "<h1>個人帳戶資料</h1>";       // 在這裡顯示用戶詳細資料
                echo '<hr>';
                
                $sql_query = "select * from user_profile where uid='" . $uid . "'";
                $result = $conn->query($sql_query);
                if ($result->rowCount() > 0) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                }

                switch ($identity) {
                    case 'T':
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLCreateForMassive.php" method="post" onsubmit="return updateconfirm()">';
                        echo '<table class="profile_table">';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">帳號</label></td><td><input type="text" name="account" value="' . $row['account'] . '" required></td>';
                            echo '<td><label for="teacher_rank">密碼</label></td><td><input type="text" name="passwd" value="' . $row['password'] . '" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">教師姓名</label></td><td><input type="text" name="teacher_name" required></td>';
                            echo '<td><label for="teacher_rank">教師職級</label></td><td><input type="text" name="teacher_rank" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_tel">教師連絡電話</label></td><td><input type="text" name="teacher_tel" required></td>';
                            echo '<td><label for="teacher_mail">教師E-mail</label></td><td><input type="text" name="teacher_mail" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="office_location">辦公室位置</label></td><td><input type="text" name="office_location" required></td>';
                            echo '<td><label for="office_phone">辦公室電話</label></td><td><input type="text" name="office_phone" required></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<hr>';
                        echo '<div class="buttonbox">';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存" class="leftbutton">';
                        echo '<input type="button" value="返回" onclick="backtolobby" class="rightbutton">';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        break;
                    case 'S':
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLCreateForMassive.php" method="post" onsubmit="return updateconfirm()">';
                        echo '<table class="profile_table">';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">帳號</label></td><td><input type="text" name="account" value="' . $row['account'] . '" required></td>';
                            echo '<td><label for="teacher_rank">密碼</label></td><td><input type="text" name="passwd" value="' . $row['password'] . '" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_name">學生姓名</label></td><td><input type="text" name="student_name" required></td>';
                            echo '<td><label for="student_id">學生學號</label></td><td><input type="text" name="student_id" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_Tname">學生導師姓名</label></td><td><input type="text" name="student_Tname" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_grade">學生年級</label></td><td><input type="text" name="student_grade" required></td>';
                            echo '<td><label for="student_gender">學生性別</label></td><td><input type="text" name="student_gender" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_phone">學生連絡電話</label></td><td><input type="text" name="student_phone" required></td>';
                            echo '<td><label for="student_email">學生E-mail</label></td><td><input type="text" name="student_email" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_haddr">學生家中地址</label></td><td><input type="text" name="student_haddr" required></td>';
                            echo '<td><label for="student_htel">學生家中電話</label></td><td><input type="text" name="student_htel" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_cont">學生緊急聯絡人</label></td><td><input type="text" name="student_cont" required></td>';
                            echo '<td><label for="student_contphone">學生緊急聯絡人電話</label></td><td><input type="text" name="student_contphone" required></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<hr>';
                        echo '<div class="buttonbox">';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存" class="leftbutton">';
                        echo '<input type="button" value="返回" onclick="backtolobby()" class="rightbutton">';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        break;
                    case 'L':
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLCreateForMassive.php" method="post" onsubmit="return updateconfirm()">';
                        echo '<table class="profile_table">';
                        echo '<tr>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                            echo '<th></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="teacher_name">帳號</label></td><td><input type="text" name="account" value="' . $row['account'] . '" required></td>';
                            echo '<td><label for="teacher_rank">密碼</label></td><td><input type="text" name="passwd" value="' . $row['password'] . '" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="landlord_name">房東姓名</label></td><td><input type="text" name="landlord_name" required></td>';
                            echo '<td><label for="landlord_gender">房東性別</label></td><td><input type="text" name="landlord_gender" required></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="landlord_phone">房東連絡電話</label></td><td><input type="text" name="landlord_phone" required></td>';
                            echo '<td><label for="landlord_line">房東LineID</label></td><td><input type="text" name="landlord_line" required></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<hr>';
                        echo '<div class="buttonbox">';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存" class="leftbutton">';
                        echo '<input type="button" value="返回" onclick="backtolobby()" class="rightbutton">';
                        echo '</div>';
                        echo '</form>';
                        echo '</div>';
                        break;
                }
            }
        } else {
            echo "未提供用戶ID。";
        }
    ?>
</div>
</body>
</html>
