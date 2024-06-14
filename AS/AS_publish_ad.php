<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>AS</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
            <!-- 引入 Bootstrap CSS -->
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
        .vertical-line {
          border-left: 1px solid #808080; /* 顏色與寬度等 */
          height: 50px; /* 線的長度 */
          margin: 0 20px; /* 位置 */
        }
        .center {
            margin: 0 auto; /* 居中 */
            width: 70%; 
        }
        </style>
    </head>
    <body>
        <?php
        //連結資料庫
        include("../SAS/connection.php");
        ?>
        <?php
            session_start(); // 啟動 session

            // 檢查使用者是否已登入，如果未登入則重新導向到其他頁面
            if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1)) {
                $identity = "訪客";
                $uid = "None";
            }
            else{
            // 從 session 中獲取使用者的身份和 ID
            $identity = $_SESSION['identity'];
            $uid = $_SESSION['uid'];
            }
            if (isset($identity) && $identity !== "SYS" && $identity !== "訪客") {

                switch ($identity){
                    case "S":
                        $sql_query = "select name from basicinfo where uid='" . $uid . "'";
                        break;
                    case "T":
                        $sql_query = "select t_name as name from teacher_profile where t_uid='" . $uid . "'";
                        break;
                    case "L":
                        $sql_query = "select l_name as name from landlord where uid='" . $uid . "'";

                        break;
                }
                $result = $conn->query($sql_query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $name = $row["name"];
            }
        ?>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="../AS_Home.php">AS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="AS_AD_Management.php">廣告管理</a></li>
                        <?php
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../logoutprocess.php?logged_in=false">使用者登出</a></li>';
                        }
                        ?>
                        <div class="vertical-line"></div><!-- 畫垂直線-->
                        <p><span style="color:#b0c4de; display: inline;">現在身分為：</span>
                    <?php
                    if (isset($identity) && $identity === "SYS") {
                        echo '<span style="color:#b0c4de; display: inline;">系統管理員</span>';
                    }
                    elseif (isset($identity) && $identity === "T") {
                        echo '<span style="color:#b0c4de; display: inline;">教師</span>';
                    }
                    elseif (isset($identity) && $identity === "S") {
                        echo '<span style="color:#b0c4de; display: inline;">學生</span>';
                    }
                    elseif (isset($identity) && $identity === "L") {
                        echo '<span style="color:#b0c4de; display: inline;">房東</span>';
                    }
                    elseif(isset($identity) && $identity === "訪客") {
                        echo '<span style="color:#b0c4de; display: inline;">訪客</span>';
                    }

                    if (isset($identity) && $identity !== "SYS"&& $identity !== "訪客") {
                        echo '<br>';
                        echo '<span style="color:#b0c4de; display: inline;">使用者姓名：</span><span style="color:#b0c4de; display: inline;">' . $name . '</span>';
                    }
                ?>
            </p>
            
            
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">刊登廣告</h1>
                    
                    
                </div>
            </div>
        </header>

        <?php
        $title = $content = $format = $money = $deposit = $utilitybill = $photo = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $r_place = $_POST["title"];
            $r_format = $_POST["format"];
            $r_money = $_POST["money"];
            $r_deposit = $_POST["deposit"];
            $r_utilitybill = $_POST["utilitybill"];

            // 處理文件上傳
            $r_photo_tmp_name = $_FILES["post"]["tmp_name"]; // 獲取上傳文件的臨時文件名
            $r_post = file_get_contents($r_photo_tmp_name); // 讀取上傳文件的内容
            $r_post = base64_encode($r_post); // 對文件内容進行編碼

            $r_photo_tmp_name1 = $_FILES["photo1"]["tmp_name"]; 
            $r_photo1 = file_get_contents($r_photo_tmp_name1); 
            $r_photo1 = base64_encode($r_photo1); 

            $r_photo_tmp_name2 = $_FILES["photo2"]["tmp_name"]; 
            $r_photo2 = file_get_contents($r_photo_tmp_name2); 
            $r_photo2 = base64_encode($r_photo2); 

            $r_photo_tmp_name3 = $_FILES["photo3"]["tmp_name"]; 
            $r_photo3 = file_get_contents($r_photo_tmp_name3); 
            $r_photo3 = base64_encode($r_photo3); 

            $r_photo_tmp_name4 = $_FILES["photo4"]["tmp_name"]; 
            $r_photo4 = file_get_contents($r_photo_tmp_name4); 
            $r_photo4 = base64_encode($r_photo4); 


            $content = $_POST["content"];

            // $select_db = mysql_select_db("rentsystem");
            // if (!$select_db) {
            //     echo '<br>找不到資料庫!<br>';
            // } else {
                $sql_query = "SELECT COUNT(*) AS total_rows FROM `ad`";
                $result = $conn->query($sql_query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $total_rows = $row['total_rows'];

                if ($total_rows == 0) {
                    $new_id = "A00000";
                } else {
                    $sql_query = "SELECT MAX(rid) AS max_id FROM `ad`";
                    $result = $conn->query($sql_query);
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $max_id = $row["max_id"];
                    $new_id = "A" . str_pad(substr($max_id, 1) + 1, 5, "0", STR_PAD_LEFT);
                }

                // 檢查地點是否已存在於資料庫中
                $sql_check = "SELECT COUNT(*) AS count FROM `ad` WHERE r_place = :r_place";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bindParam(":r_place", $r_place);
                $stmt_check->execute();
                $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
                $count = $row['count'];

                if ($count > 0) {
                    // echo "此地點已存在於資料庫中。";
                    echo "<script>alert('此地點已存在！'); window.location.href='AS_publish_ad.php';</script>";
                    $stmt_check->close();
                } else {
                    // 如果地點不存在於資料庫中，則執行插入操作
                    $sql_query = "INSERT INTO `ad` (rid, luid, r_place, r_post, r_photo1, r_photo2, r_photo3, r_photo4, r_format, r_money, r_deposit, r_utilitybill, r_else) VALUES ('$new_id','$uid', '$r_place', '$r_post', '$r_photo1', '$r_photo2', '$r_photo3', '$r_photo4', '$r_format', '$r_money', '$r_deposit', '$r_utilitybill', '$content')";
 
                    $result = $conn->prepare($sql_query);
                    $result->bindParam(":new_id", $new_id);
                    $result->bindParam(":uid", $uid);
                    $result->bindParam(":r_place", $r_place);
                    $result->bindParam(":r_post", $r_post);
                    $result->bindParam(":r_photo1", $r_photo1);
                    $result->bindParam(":r_photo2", $r_photo2);
                    $result->bindParam(":r_photo3", $r_photo3);
                    $result->bindParam(":r_photo4", $r_photo4);
                    // $result->bindParam(":r_photo", $photo_data);
                    $result->bindParam(":r_format", $r_format);
                    $result->bindParam(":r_money", $r_money);
                    $result->bindParam(":r_deposit", $r_deposit);
                    $result->bindParam(":r_utilitybill", $r_utilitybill);
                    $result->bindParam(":content", $content);
                    $result->execute();

                    echo "<script>alert('廣告審核中！'); window.location.href='AS_AD_Management.php';</script>";
                }

        }
        ?>

        
        <div class="container">
            <div class="center"> 
                <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="title"><span style="color: red; font-weight: bold; font-size: 24px;">廣告地點：</span></label><br>
                    <input type="text" id="title" name="title" value="<?php echo $r_place; ?>"style="width: 800px; height: 40px;" required><br><br>
                    
                    <label for="title"><span style="color: red; font-weight: bold; font-size: 24px;">規格：(如:套房、雅房...)</span></label><br>
                    <input type="text" id="format" name="format" value="<?php echo $r_format; ?>"style="width: 800px; height: 40px;" required><br><br>

                    <label for="title"><span style="color: red; font-weight: bold; font-size: 24px;">租金：</span></label><br>
                    <input type="text" id="money" name="money" value="<?php echo $r_money; ?>"style="width: 800px; height: 40px;" required><br><br>

                    <label for="title"><span style="color: red; font-weight: bold; font-size: 24px;">押金：</span></label><br>
                    <input type="text" id="deposit" name="deposit" value="<?php echo $r_deposit; ?>"style="width: 800px; height: 40px; required"><br><br>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">水電費：(如:台水台電)</span></label><br>
                    <input type="text" id="utilitybill" name="utilitybill" value="<?php echo $r_utilitybill; ?>"style="width: 800px; height: 40px;"><br><br>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">封面照：</span></label><br>
                    <input type="file" id="post" name="post" value="<?php echo $r_post; ?>"style="width: 800px; height: 40px;"><br><br>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">照片1：</span></label><br>
                    <input type="file" id="photo1" name="photo1" value="<?php echo $r_photo1; ?>"style="width: 800px; height: 40px;"><br><br>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">照片2：</span></label><br>
                    <input type="file" id="photo2" name="photo2" value="<?php echo $r_photo2; ?>"style="width: 800px; height: 40px;"><br><br>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">照片3：</span></label><br>
                    <input type="file" id="photo3" name="photo3" value="<?php echo $r_photo3; ?>"style="width: 800px; height: 40px;"><br><br>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">照片4：</span></label><br>
                    <input type="file" id="photo4" name="photo4" value="<?php echo $r_photo4; ?>"style="width: 800px; height: 40px;"><br><br>

                    <label for="content"><span style="color: black; font-weight: bold; font-size: 24px;">其他:</span></label><br>
                    <textarea id="content" name="content" style="width: 800px; height: 500px;"><?php echo $content; ?></textarea><br><br>
                    

                    <div style="text-align: right;">
                        <input type="submit" value="送出" class="btn btn-primary">
                        <p></p>
                    </div>
                    <!-- <input class="submitbutton" type="submit" value="送出"> -->
                </form>
            </div>
        </div>
        <?php       
                    // // 從資料庫中檢索圖片數據
                    // $sql_query = "SELECT r_photo FROM `ad` WHERE luid = :uid";
                    // $stmt = $conn->prepare($sql_query);
                    // $stmt->bindParam(":uid", $uid);
                    // $stmt->execute();
                    // $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // // 解碼圖片數據
                    // $image_data = base64_decode($row['r_photo']);

                    // // 顯示圖片
                    // // echo '<img src="data:image/jpeg;base64,' . base64_encode($image_data) . '" />';

                    
        ?>
        
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Rent Management System 2024</p></div>
        </footer>
    </body>
</html>
