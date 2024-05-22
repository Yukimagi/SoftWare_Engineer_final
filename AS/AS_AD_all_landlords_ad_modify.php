

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
        <style>
        .vertical-line {
          border-left: 1px solid #808080; /* 顏色與寬度等 */
          height: 50px; /* 線的長度 */
          margin: 0 20px; /* 位置 */
        }
        </style>
    </head>
    <body>
        <?php
        //連結資料庫
        include("../connection.php");
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
                <a class="navbar-brand" href="AS_Home.php">AS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


                        <li class="nav-item"><a class="nav-link" href="../lobby.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                       
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="AS_Home.php">廣告</a></li>
                        <!-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="AS_OBJ.php">物件評價</a></li> -->
                        <?php
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.php?logged_in=false">使用者登出</a></li>';
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
            <!-- <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">個人資料</h1>
                </div>
            </div> -->
        </header>
        <?php
        $title = $content = $format = $money = $deposit = $utilitybill = $photo = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $r_place = $_POST["r_place"];
            $r_format = $_POST["r_format"];
            $r_money = $_POST["r_money"];
            $r_deposit = $_POST["r_deposit"];
            $r_utilitybill = $_POST["r_utilitybill"];
            $rid = $_POST["rid"];

            // 处理文件上传
            $r_post = !empty($_FILES["r_post"]["tmp_name"]) ? base64_encode(file_get_contents($_FILES["r_post"]["tmp_name"])) : null;
            $r_photo1 = !empty($_FILES["r_photo1"]["tmp_name"]) ? base64_encode(file_get_contents($_FILES["r_photo1"]["tmp_name"])) : null;
            $r_photo2 = !empty($_FILES["r_photo2"]["tmp_name"]) ? base64_encode(file_get_contents($_FILES["r_photo2"]["tmp_name"])) : null;
            $r_photo3 = !empty($_FILES["r_photo3"]["tmp_name"]) ? base64_encode(file_get_contents($_FILES["r_photo3"]["tmp_name"])) : null;
            $r_photo4 = !empty($_FILES["r_photo4"]["tmp_name"]) ? base64_encode(file_get_contents($_FILES["r_photo4"]["tmp_name"])) : null;

            $content = $_POST["r_else"];

            // 检查地點是否已存在於資料庫中，但排除當前正在更新的記錄
            $sql_check = "SELECT COUNT(*) AS count FROM `ad` WHERE r_place = :r_place AND rid != :rid";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(":r_place", $r_place);
            $stmt_check->bindParam(":rid", $rid);
            $stmt_check->execute();
            $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
            $count = $row['count'];

            if ($count > 0) {
                // echo "此地點已存在於資料庫中。";
                echo "<script>alert('此地點已存在！'); window.location.href='AS_AD_all_landlords_ad.php';</script>";
                $stmt_check->close();
            } else {
                // 先从数据库中获取当前记录的现有值
                $sql_select = "SELECT r_post, r_photo1, r_photo2, r_photo3, r_photo4 FROM `ad` WHERE rid = :rid";
                $stmt_select = $conn->prepare($sql_select);
                $stmt_select->bindParam(":rid", $rid);
                $stmt_select->execute();
                $current_row = $stmt_select->fetch(PDO::FETCH_ASSOC);

                // 如果没有新的文件上传，则保留现有的值
                if (is_null($r_post)) {
                    $r_post = $current_row['r_post'];
                }
                if (is_null($r_photo1)) {
                    $r_photo1 = $current_row['r_photo1'];
                }
                if (is_null($r_photo2)) {
                    $r_photo2 = $current_row['r_photo2'];
                }
                if (is_null($r_photo3)) {
                    $r_photo3 = $current_row['r_photo3'];
                }
                if (is_null($r_photo4)) {
                    $r_photo4 = $current_row['r_photo4'];
                }

                $sql_query = "UPDATE `ad` SET r_place = :r_place, r_post = :r_post, r_photo1 = :r_photo1, r_photo2 = :r_photo2, r_photo3 = :r_photo3, r_photo4 = :r_photo4, r_format = :r_format, r_money = :r_money, r_deposit = :r_deposit, r_utilitybill = :r_utilitybill, r_else = :content WHERE rid = :rid";
                $result = $conn->prepare($sql_query);

                $result->bindParam(":r_place", $r_place);
                $result->bindParam(":r_post", $r_post);
                $result->bindParam(":r_photo1", $r_photo1);
                $result->bindParam(":r_photo2", $r_photo2);
                $result->bindParam(":r_photo3", $r_photo3);
                $result->bindParam(":r_photo4", $r_photo4);
                $result->bindParam(":r_format", $r_format);
                $result->bindParam(":r_money", $r_money);
                $result->bindParam(":r_deposit", $r_deposit);
                $result->bindParam(":r_utilitybill", $r_utilitybill);
                $result->bindParam(":content", $content);
                $result->bindParam(":rid", $rid);

                $result->execute();

                echo "<script>alert('廣告審核中！'); window.location.href='AS_AD_all_landlords_ad.php';</script>";
            }
        }
        ?>

        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
            
                <!-- Side widgets-->
                <div class="col-lg-4">
                
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">ad information</div>
                        <?php
                            if (!empty($identity) && !empty($uid)) {
                                if ($identity === "L") {
                                    // 設定查詢的資料表和欄位
                                    $table = "ad";
                                    $columns = "rid, r_place, r_post, r_photo1, r_photo2, r_photo3, r_photo4, r_format, r_money, r_deposit, r_utilitybill, r_else";
                                }

                                $location = $_GET['location'];

                                // SQL 查詢
                                $sql_query = "SELECT $columns FROM `$table` WHERE luid = '$uid' and r_place = '$location'";
                                $result = $conn->query($sql_query);
                                // echo($sql_query);

                                if ($result) {
                                    // 輸出查詢結果表單
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<div class="card-body">';
                                        echo '<form method="post" enctype="multipart/form-data" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" onsubmit="return confirmSubmission();">';
                                        foreach ($row as $key => $value) {
                                            if ($key === "r_place") {
                                                $key_text = "地點";
                                            } else if ($key === "r_post") {
                                                $key_text = "封面照片";
                                            } else if ($key === "r_photo1") {
                                                $key_text = "照片1";
                                            } else if ($key === "r_photo2") {
                                                $key_text = "照片2";
                                            } else if ($key === "r_photo3") {
                                                $key_text = "照片3";
                                            } else if ($key === "r_photo4") {
                                                $key_text = "照片4";
                                            } else if ($key === "r_format") {
                                                $key_text = "規格";
                                            } else if ($key === "r_money") {
                                                $key_text = "租金";
                                            } else if ($key === "r_deposit") {
                                                $key_text = "押金";
                                            } else if ($key === "r_utilitybill") {
                                                $key_text = "水電費";
                                            } else if ($key === "r_else") {
                                                $key_text = "其他";
                                            } else if ($key === "rid") {
                                                echo "<input type='hidden' name='$key' value='$value'>";
                                            }

                                            if ($key === "r_post" || $key === "r_photo1" || $key === "r_photo2" || $key === "r_photo3" || $key === "r_photo4") {
                                                if (!empty($value)) {
                                                    // 解碼圖片數據
                                                    $image_data = base64_decode($value);
                                                    echo "$key_text:<br>";

                                                    // 顯示圖片
                                                    echo '<img src="data:image/jpeg;base64,' . base64_encode($image_data) . '" style="max-width:200px; max-height:200px;"/><br>';
                                                    echo "<input type='file' name='$key' value='" . htmlspecialchars($value) . "'><br>";
                                                } else {
                                                    echo "$key_text: <input type='file' name='$key' value='" . htmlspecialchars($value) . "'><br>";
                                                }
                                            } else {
                                                // 輸出表單欄位，讓使用者修改資料
                                                echo "$key_text: <input type='text' name='$key' value='" . htmlspecialchars($value) . "'><br>";
                                            }
                                        }
                                        echo "<input type='submit' value='修改'>";
                                        echo '<button onclick="goBack()">返回</button>';
                                        echo "</form>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "查詢失敗：" . mysql_error();
                                }
                            } else {
                                echo "未提供足夠的訊息進行查詢";
                            }
                        ?>
                        <script>
                            function confirmSubmission() {
                                return confirm('該廣告即將下架，是否確定送出？');
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>

            
        <div>
            <h1 class="fw-bolder"></h1>
        </div>


        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Rent Management System 2024</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>




