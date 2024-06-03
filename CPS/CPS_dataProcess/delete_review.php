<?php

include("../../connection.php");

$select_db = @mysql_select_db("rentsystem");
if(!$select_db) {
    echo '<br>找不到数据库!<br>';
} else {

    //獲取前端傳的變數
    if (isset($_POST['uid']) && isset($_POST['objID'])) {
        $uid = $_POST['uid'];
        $objID = $_POST['objID'];

        //刪資料
        $sql_query = "DELETE FROM `user_obj` WHERE `uid` = '$uid' AND `objID` = '$objID'";
        $result = mysql_query($sql_query);
        
    } else {
        

        echo "未收到用戶ID或物件ID";
    }
}
?>
