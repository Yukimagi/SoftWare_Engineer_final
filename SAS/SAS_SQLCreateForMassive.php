<script src="../js/scripts.js"></script>
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

            $sql_query = "INSERT INTO teacher_profile(t_uid, t_name, t_rank, t_tel, t_mail, t_address, t_officetel) VALUES ";
            $sql_query .= "(:t_uid, :t_name, :t_rank, :t_tel, :t_mail, :t_address, :t_officetel)";
            $result = $conn->prepare($sql_query);
            $result->bindParam(":t_uid", $user_id);
            $result->bindParam(":t_name", $name);
            $result->bindParam(":t_rank", $rank);
            $result->bindParam(":t_tel", $tel);
            $result->bindParam(":t_mail", $mail);
            $result->bindParam(":t_address", $location);
            $result->bindParam(":t_officetel", $phone);
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

            $sql_query = "select * from teacher_profile where t_name='" . $Tname . "'";
            $result = $conn->query($sql_query);
            if ($result->rowCount() > 0) {
                $teacher_profile = $result->fetch(PDO::FETCH_ASSOC);
                $Tid = $teacher_profile['t_uid'];
            }

            $sql_query = "INSERT INTO basicinfo(`uid`, `tuid`, `SID`, `name`, `grade`, `gender`, `phone`, `email`, `HomeAddr`, `Hphone`, `Contactor`, `Cphone`) VALUES ";
            $sql_query .= "(:uid, :tuid, :SID, :name, :grade, :gender, :phone, :email, :HomeAddr, :Hphone, :Contactor, :Cphone)";
            $result = $conn->prepare($sql_query);
            $result->bindParam(":uid", $user_id);
            $result->bindParam(":tuid", $Tid);
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
            break;
        case 'L':
            $name = $_POST['landlord_name'];
            $gender = $_POST['landlord_gender'];
            $phone = $_POST['landlord_phone'];
            $line = $_POST['landlord_line'];

            $sql_query = "INSERT INTO landlord(`uid`, `l_name`, `l_gender`, `l_phone`, `l_line`) VALUES ";
            $sql_query .= "(:uid, :l_name, :l_gender, :l_phone, :l_line)";
            $result = $conn->prepare($sql_query);
            $result->bindParam(":uid", $user_id);
            $result->bindParam(":l_name", $name);
            $result->bindParam(":l_gender", $gender);
            $result->bindParam(":l_phone", $phone);
            $result->bindParam(":l_line", $line);
            break;
    }
    if ($result->execute()) {
        echo '<script>updatemsg_relog()</script>';
    } else {
        echo '<script>warning4()</script>';
    }
    exit;
}
?>