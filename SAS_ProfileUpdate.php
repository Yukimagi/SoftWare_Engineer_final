<script src="js/scripts.js"></script>
<?php
include("connection.php");
        
// 檢查是否有傳遞用戶ID
if (isset($_POST['uid'])) {
    $user_id = $_POST['uid'];
    $user_identity = $_POST['identity'];

    switch ($user_identity) {
        case 'T':
            $name = $_POST['teacher_name'];
            $rank = $_POST['teacher_rank'];
            $tel = $_POST['teacher_tel'];
            $mail = $_POST['teacher_mail'];
            $location = $_POST['office_location'];
            $phone = $_POST['office_phone'];

            $sql_query = "UPDATE teacher_profile SET 
                teacher_profile.t_name = '$name',
                teacher_profile.t_rank = '$rank',
                teacher_profile.t_tel = '$tel',
                teacher_profile.t_mail = '$mail',
                teacher_profile.t_address = '$location',
                teacher_profile.t_officetel = '$phone'
                WHERE teacher_profile.t_uid = '$user_id'";
            break;
        case 'S':
            $name = $_POST['student_name'];
            $id = $_POST['student_id'];
            $Tname = $_POST['student_Tname'];
            $grade = $_POST['student_grade'];
            $gender = $_POST['student_gender'];
            $phone = $_POST['student_phone'];
            $email = $_POST['student_email'];
            $haddr = $_POST['student_haddr'];
            $htel = $_POST['student_htel'];
            $cont = $_POST['student_cont'];
            $contphone = $_POST['student_contphone'];

            $sql_query = "UPDATE basicinfo SET 
                basicinfo.SID = '$id',
                basicinfo.name = '$name',
                basicinfo.grade = '$grade',
                basicinfo.gender = '$gender',
                basicinfo.phone = '$phone',
                basicinfo.email = '$email',
                basicinfo.HomeAddr = '$haddr',
                basicinfo.Hphone = '$htel',
                basicinfo.Contactor = '$cont',
                basicinfo.Cphone = '$contphone'
                WHERE basicinfo.uid = '$user_id'";
            break;
        case 'L':
            $name = $_POST['landlord_name'];
            $gender = $_POST['landlord_gender'];
            $phone = $_POST['landlord_phone'];
            $line = $_POST['landlord_line'];

            $sql_query = "UPDATE landlord SET 
                landlord.l_name = '$name',
                landlord.l_gender = '$gender',
                landlord.l_phone = '$phone',
                landlord.l_line = '$line'
                WHERE landlord.uid = '$user_id'";
            break;
    }
    $result = $conn->query($sql_query);
    if ($result === false) {
        // SQL語句執行失敗
        echo '<script>warning3()</script>';
    } else {
        // SQL語句執行成功
        if ($result->execute()) {
            echo '<script>updatemsg()</script>';
        } else {
            echo '<script>warning4()</script>';
        }
    }
    exit;
}
?>