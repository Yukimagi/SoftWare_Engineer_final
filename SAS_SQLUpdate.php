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
                teacher_profile.t_name = :t_name,
                teacher_profile.t_rank = :t_rank,
                teacher_profile.t_tel = :t_tel,
                teacher_profile.t_mail = :t_mail,
                teacher_profile.t_address = :t_address,
                teacher_profile.t_officetel = :t_officetel
                WHERE teacher_profile.t_uid = :t_uid";
            $result = $conn->prepare($sql_query);
            $result->bindParam(":t_name", $name);
            $result->bindParam(":t_rank", $rank);
            $result->bindParam(":t_tel", $tel);
            $result->bindParam(":t_mail", $mail);
            $result->bindParam(":t_address", $location);
            $result->bindParam(":t_officetel", $phone);
            $result->bindParam(":t_uid", $user_id);
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
                basicinfo.SID = :SID,
                basicinfo.name = :name,
                basicinfo.grade = :grade,
                basicinfo.gender = :gender,
                basicinfo.phone = :phone,
                basicinfo.email = :email,
                basicinfo.HomeAddr = :HomeAddr,
                basicinfo.Hphone = :Hphone,
                basicinfo.Contactor = :Contactor,
                basicinfo.Cphone = :Cphone
                WHERE basicinfo.uid = :uid";
            $result = $conn->prepare($sql_query);
            $result->bindParam(":SID", $id);
            $result->bindParam(":name", $name);
            $result->bindParam(":grade", $grade);
            $result->bindParam(":gender", $gender);
            $result->bindParam(":phone", $phone);
            $result->bindParam(":email", $email);
            $result->bindParam(":HomeAddr", $haddr);
            $result->bindParam(":Hphone", $htel);
            $result->bindParam(":Contactor", $cont);
            $result->bindParam(":Cphone", $contphone);
            $result->bindParam(":user_id", $user_id);
            break;
        case 'L':
            $name = $_POST['landlord_name'];
            $gender = $_POST['landlord_gender'];
            $phone = $_POST['landlord_phone'];
            $line = $_POST['landlord_line'];

            $sql_query = "UPDATE landlord SET 
                landlord.l_name = :l_name,
                landlord.l_gender = :l_gender,
                landlord.l_phone = :l_phone,
                landlord.l_line = :l_line
                WHERE landlord.uid = :uid";
            $result = $conn->prepare($sql_query);
            $result->bindParam(":l_name", $name);
            $result->bindParam(":l_gender", $gender);
            $result->bindParam(":l_phone", $phone);
            $result->bindParam(":l_line", $line);
            $result->bindParam(":uid", $user_id);
            break;
    }
    if ($result->execute()) {
        if (isset($_POST['NotSAS']) && $_POST['NotSAS'] === "true"){
            echo '<script>updatemsg()</script>';
        }else{
            echo '<script>updatemsgForSAS()</script>';
        }
    } else {
        echo '<script>warning4()</script>';
    }
    exit;
}
?>