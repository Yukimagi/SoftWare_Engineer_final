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
        $sql_query = "DELETE FROM `user_keep_article` WHERE uid = '$uid' AND articleID = '$articleID'";
        $result = mysql_query($sql_query);
        

        //查資料
        $sql_query = "SELECT keepnum FROM `contact article` WHERE articleID = '$articleID'";
        $result = mysql_query($sql_query);
        $row = mysql_fetch_assoc($result);
        $keepnum = $row['keepnum'];

        //收藏數-1
        $keepnum--;
        $update_query = "UPDATE `contact article` SET keepnum = $keepnum WHERE articleID = '$articleID'";
        $result =mysql_query($update_query);

        
    } else {
        
        echo "未收到用戶ID或文章ID";
    }
}
?>
