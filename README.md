# SoftWare_Engineer_final
##### 2024/5/5 完成merge首頁與登入並製作CPS 首頁、template等等...功能
### 各個檔案的功能(提供參考)
#### CPS_Home.php -> 個人頁面(主頁)

##### CPS_personal_publish.php -> 個人發布的文章
###### CPS_Artical_Modify.php -> 個人文章修改(表單)
###### CPS_Artical_Modify 2.php -> 個人文章修改(實際修改表單)
###### CPS_dataProcess/delete_article.php -> 個人文章刪除

##### CPS_personal_keep.php -> 個人收藏的文章
###### CPS_dataProcess/delete_keep.php -> 個人收藏刪除

#### CPS_Communication.php -> 交流文章
##### update_keep.php/update_love.php ->更新收藏與按讚!
###### CPS_Publish_Artical.php -> 刊登文章
###### CPS_Publish_Response.php -> 回覆文章(顯示完整文章)

## connection.php範本
```php
    <?php
    //連結資料庫
    $location="localhost";//連結本機
    $account="";//帳號
    $password="";//密碼
    if(isset($location)&&isset($account)&&isset($password))
    {
    $link=mysql_pconnect($location,$account,$password);//mysql_pconnect連結狀況給link
    if(!$link)
    {
    echo'無法連結資料庫';
    exit();
    }
    else
    echo '';
    }
    ?>
```
