# RMS 租屋管理系統

## ●開發者介紹:
#### 指導教授:
#####          林文揚  
#### 組長:
##### A1105505 林彧頎
#### 組員:
##### A1105511 楊宗熹
##### A1105524 吳雨宣
##### A1105539 鄭玥晋
##### A1105545 潘妤揚
##### A1105549 杜佩真

### ●因為有個資問題，因此connection請額外設定:
#### 1.請在SoftWare_Engineer_final/資料夾中添加connection.php
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
        else{
            mysql_select_db("rentsystem");
            echo '';
        }
    }
    ?>
```
#### 2.請在SoftWare_Engineer_final/資料夾中添加另一個connection.php(由於此連接方式與1不同，此使用binding方法，因此需要額外連結)
```php
<?php
$DB_severname = 'localhost';
$DB_username = '';
$DB_password = '';
$DB_database = 'rentsystem';
try{
    $conn = new PDO("mysql:host=$DB_severname;dbname=$DB_database", $DB_username, $DB_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    echo "資料庫連接失敗" . $e->getMessage();
}
```
### ●本系統環境的版本說明:
#### ●本系統特色:
##### 解決sql injection 資安問題
##### 交流平台-提供使用者線上交流與租屋物件評價
##### 廣告-提供使用者快速搜尋適合的租屋物件
##### 訪談系統-租屋訪談紀錄
##### 系統管理員-在各個子系統皆有相關的操作，特別是可以對權限與狀態(目前是否可繼續使用此帳號)做處理</p>
#### ●本系統資料庫伺服器:
##### 伺服器: localhost via TCP/IP
##### 伺服器類別: MySQL
##### 伺服器版本: 5.7.17-log - MySQL Community Server (GPL)
##### 協定版本: 10
##### 伺服器字元集: UTF-8 Unicode (utf8)
#### ●網頁伺服器:
##### Apache/2.4.25 (Win32) OpenSSL/1.0.2j PHP/5.6.30
##### PHP 版本： 5.6.30
#### ●phpMyAdmin:
##### 版本資訊: 4.6.6
