# SoftWare_Engineer_final
## 各個檔案的功能(提供參考)

### 網頁PHP說明 - CPS個人資料相關PHP
----------------------------------
#### CPS_Home.php -> 個人頁面(主頁)

###### CPS_personal_publish.php -> 個人發布的文章
- CPS_Artical_Modify.php -> 個人文章修改(表單)
- CPS_Artical_Modify 2.php -> 個人文章修改(實際修改表單)
- CPS_dataProcess/delete_article.php -> 個人文章刪除

###### CPS_personal_keep.php -> 個人收藏的文章
- CPS_dataProcess/delete_keep.php -> 個人收藏刪除
###### CPS_personal_review.php -> 個人評價物件
----------------------------------

### 網頁PHP說明 - 交流平台相關PHP
----------------------------------
#### CPS_Communication.php -> 交流文章(注意!!!針對系統管理員，我有提供可以針對不符合的文章進行刪除)
-  CPS_dataProcess/update_keep.php&&CPS_dataProcess/update_love.php ->更新收藏與按讚!
- CPS_Publish_Artical.php -> 刊登文章
- CPS_Publish_Response.php -> 回覆文章(顯示完整文章回覆)
- CPS_Publish_Response2.php -> 回覆文章處理
- CPS_Communicate_search.php -> 搜尋文章標題處理(前頁傳要找的關鍵字，後一頁呼叫sql提供)
----------------------------------

### 網頁PHP說明 - 租屋物件評價平台相關PHP
----------------------------------
#### CPS_OBJ.php -> 物件評價
- CPS_addobj.php -> 新增物件
- CPS_Object_Review.php -> 物件評價
- CPS_OBJ_search.php -> 搜尋租屋物件標題(地址)
- css/star.css -> 評價星等的呈現
- CPS_dataProcess/delete_review.php -> 系統管理員刪除不合法留言的處理
----------------------------------

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
----------------------------------
  
## 本系統更新會依照完整的merge一個階段後才更新進度  
----------------------------------
----------------------------------
  
### 更新紀錄 - 24/05/07  
----------------------------------
Feat:
- 建構交流平台基本所有功能功能(以下詳細說明)
- 發布文章
- 文章新增、修改、刪除
- 瀏覽與查詢文章(利用標題查詢)
- 按讚與收藏(包含取消收藏)
- 個人收藏與管理
- 個人發布文章與管理
- 系統管理員查看符合規範的文章與管理並處理不符合規範的文章

Modifiy:
- 系統設計與session訪客處理

Fix:  
- 無
  
Docs:  
- 更新README.md

### 更新紀錄 - 24/05/30
----------------------------------
Feat:
- 建構租屋物件平台所有功能功能
- 建構新增租屋物件
- 建構使用者評價與留言(新增、修改、刪除)
- 個人評價管理
- 瀏覽與查詢(查詢可依照租屋物件內容與評價排序做查詢)
- 系統管理員查看符合規範的留言與管理並處理不符合規範的留言

Modify:
- 系統設計

Fix:
- 無

Style:
- 調整部分程式碼與註解區塊

Docs:
- 更新README.md

更新紀錄 - 24/06/03
----------------------------------
Feat:
- 無

Modify:
- 調整session撰寫方式
- 調整註解
- merge code
- 調整連結路徑

Fix:
- 無

Docs:
- 更新README.md
