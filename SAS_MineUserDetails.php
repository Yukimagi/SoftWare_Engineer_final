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
                echo "<h1>User Details</h1>";       // 在這裡顯示用戶詳細資料

                switch ($identity) {
                    case 'T':
                        echo '<div class="profile_form">';
                        echo '<form action="SAS_SQLUpdate.php" method="post">';
                        echo '<table>';
                        echo '<tr>';
                            echo '<th style="width: 10%;"></th>';
                            echo '<th style="width: 25%;"></th>';
                            echo '<th style="width: 7%;"></th>';
                            echo '<th style="width: 40%;"></th>';
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
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存">';
                        echo '<input type="button" value="返回" onclick="location.href=\'lobby.php\'">';
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
                        echo '<form action="SAS_SQLUpdate.php" method="post">';
                        echo '<table>';
                        echo '<tr>';
                            echo '<th style="width: 10%;"></th>';
                            echo '<th style="width: 25%;"></th>';
                            echo '<th style="width: 7%;"></th>';
                            echo '<th style="width: 40%;"></th>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_name">學生姓名</label></td><td><input type="text" name="student_name" value="' . $user_profile_array[3] . '" readonly="true"></td>';
                            echo '<td><label for="student_id">學生學號</label></td><td><input type="text" name="student_id" value="' . $user_profile_array[2] . '" readonly="true"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_Tname">學生導師姓名</label></td><td><input type="text" name="student_Tname" value="' . $teacher_name . '"  readonly="true"></td>';
                            echo '<td></td><td></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_grade">學生年級</label></td><td><input type="text" name="student_grade" value="' . $user_profile_array[4] . '"></td>';
                            echo '<td><label for="student_gender">學生性別</label></td><td><input type="text" name="student_gender" value="' . $user_profile_array[5] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_phone">學生連絡電話</label></td><td><input type="text" name="student_phone" value="' . $user_profile_array[6] . '"></td>';
                            echo '<td><label for="student_email">學生E-mail</label></td><td><input type="text" name="student_email" value="' . $user_profile_array[7] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_haddr">學生家中地址</label></td><td><input type="text" name="student_haddr" value="' . $user_profile_array[8] . '"></td>';
                            echo '<td><label for="student_htel">學生家中電話</label></td><td><input type="text" name="student_htel" value="' . $user_profile_array[9] . '"></td>';
                        echo '</tr>';
                        echo '<tr>';
                            echo '<td><label for="student_cont">學生緊急聯絡人</label></td><td><input type="text" name="student_cont" value="' . $user_profile_array[10] . '"></td>';
                            echo '<td><label for="student_contphone">學生緊急聯絡人電話</label></td><td><input type="text" name="student_contphone" value="' . $user_profile_array[11] . '"></td>';
                        echo '</tr>';
                        echo '</table>';
                        echo '<br>';
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存">';
                        echo '<input type="button" value="返回" onclick="location.href=\'lobby.php\'">';
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
                        echo '<form action="SAS_SQLUpdate.php" method="post">';
                        echo '<table>';
                        echo '<tr>';
                            echo '<th style="width: 10%;"></th>';
                            echo '<th style="width: 25%;"></th>';
                            echo '<th style="width: 7%;"></th>';
                            echo '<th style="width: 40%;"></th>';
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
                        echo '<input type="hidden" name="uid" value="' . $uid . '">';
                        echo '<input type="hidden" name="identity" value="' . $identity . '">';
                        echo '<input type="hidden" name="NotSAS" value="true">';
                        echo '<input type="submit" value="儲存">';
                        echo '<input type="button" value="返回" onclick="location.href=\'lobby.php\'">';
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
                echo "找不到該用戶的資料。";
            }
        } else {
            echo "未提供用戶ID。";
        }
    ?>
</div>
</body>
</html>
