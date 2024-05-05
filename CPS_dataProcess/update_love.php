<?php
//連結資料庫
include("connection.php");
?>
<?php

$select_db=@mysql_select_db("rentsystem");//選擇資料庫
if(!$select_db)
{
echo'<br>找不到資料庫!<br>';
}
else
{//獲取前端船的變數
    $articleID = $_POST['articleID'];
    //$articleID = $_GET['articleID'];
    echo "Article ID received: " . $articleID;

    //查資料
    $sql_query = "SELECT lovenum FROM `contact article` WHERE articleID = '$articleID'";
    $result = mysql_query($sql_query);
    $row = mysql_fetch_assoc($result);
    $lovenum = $row['lovenum'];

    //更新
    $lovenum++;
    $update_query = "UPDATE `contact article` SET lovenum = $lovenum WHERE articleID = '$articleID'";
    if (mysql_query($update_query)) {
        // 回傳
        echo $lovenum;
    } else {
        echo "更新喜欢数失败: " . mysql_error();
    }
}
?>
        