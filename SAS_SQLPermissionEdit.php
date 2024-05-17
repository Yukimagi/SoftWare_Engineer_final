<script src="js/scripts.js"></script>
<?php
include("connection.php");
        
// 檢查是否有傳遞用戶ID
if (isset($_POST['uid'])) {
    $user_id = $_POST['uid'];
    $user_status = $_POST['status'];
    if ($user_status == 'VALID') {
        $user_status = 'INVALID';
    }else{
        $user_status = 'VALID';
    }

    $sql_query = "UPDATE user_profile SET 
                user_profile.status = :status
                WHERE user_profile.uid = :uid";
    $result = $conn->prepare($sql_query);
    $result->bindParam(":status", $user_status);
    $result->bindParam(":uid", $user_id);

    if ($result->execute()) {
        echo '<script>updatemsg_permission()</script>';
    } else {
        echo '<script>warning4()</script>';
    }
    exit;
}
?>