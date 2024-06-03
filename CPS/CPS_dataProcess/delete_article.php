<?php

include("../../connection.php");

$select_db = @mysql_select_db("rentsystem");
if(!$select_db) {
    echo '<br>找不到数据库!<br>';
} else {
    //獲取前端船的變數
    if (isset($_POST['uid']) && isset($_POST['articleID'])) {
        $uid = $_POST['uid'];
        $articleID = $_POST['articleID'];

        //刪資料
        $sql_query = "DELETE FROM `contact article` WHERE articleID = '$articleID'";
        $result = mysql_query($sql_query);
        
    } else {
        
        echo "未收到用戶ID或文章ID";
    }
}
?>
