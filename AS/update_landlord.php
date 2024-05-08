<?php
    //連結資料庫
    include("../connection.php");
?>




<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $l_name = $_POST['l_name'];
    $l_gender = $_POST['l_gender'];
    $l_phone = $_POST['l_phone'];
    $l_line = $_POST['l_line'];


    // SQL 更新語句
    $sql_update = "UPDATE landlord SET l_name='$l_name', l_gender='$l_gender', l_phone='$l_phone', l_line='$l_line' WHERE uid='$uid'";
    $result = mysql_query($sql_update);


    if ($result) {
        // Data updated successfully, redirect to AS_Landlord.php
        echo "<script>alert('資料已更新'); window.location.href='AS_Landlord.php';</script>";
       
        exit; // Ensure that script execution stops after redirection
    } else {
        echo "更新失敗：" . mysql_error();
    }
}
?>




