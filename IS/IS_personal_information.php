

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
                <?php if ($identity === "T") echo "<a class=\"navbar-brand\" href=\"IS_teacher_records.php\">IS</a>"; ?>
                <?php if ($identity === "S") echo "<a class=\"navbar-brand\" href=\"IS_Home.php\">IS</a>"; ?>               
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


                        <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                       
                        <!-- <li class="nav-item"><a class="nav-link active" aria-current="page" href="AS_OBJ.php">物件評價</a></li> -->
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
                    <h1 class="fw-bolder">個人資料</h1>
                </div>
            </div>
        </header>


       
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
               
                <!-- Side widget-->
                <div class="card mb-4">
                    <div class="card-header text-center">personal profile</div>
                    <div class="card-body text-center">
                        <?php
                            if (!empty($identity) && (!empty($uid))) {
                                if ($identity === "S") {
                                    // 設定查詢的資料表和欄位
                                    $table = "basicinfo";
                                    $columns = "Sid, name, grade, phone, email, HomeAddr, Hphone, Contactor, Cphone";
                                    $sql_query = "SELECT $columns FROM `$table` WHERE uid = '$uid'";
                                    $result = $conn->query($sql_query);
                                } else if($identity === "T") {
                                    $table = "teacher_profile";
                                    $columns = "t_name, t_rank, t_tel, t_mail, t_address, t_officetel";
                                    $sql_query = "SELECT $columns FROM `$table` WHERE t_uid = '$uid'";
                                    $result = $conn->query($sql_query);
                                }

                                if ($result) {
                                    // 輸出查詢結果表單
                                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<div class="card-body">';
                                        echo '<form method="post" action="update_information.php" class="text-left" style="display: inline-block; text-align: left;">'; // 修改後的資料提交到 update.php
                                        foreach ($row as $key => $value) {
                                            if ($key === "Sid") {
                                                $key_text = "學號";
                                            } else if ($key === "name" || $key === "t_name") {
                                                $key_text = "姓名";
                                            } else if ($key === "t_rank") {
                                                $key_text = "職級";
                                            } else if ($key === "grade") {
                                                $key_text = "年級";
                                            } else if ($key === "phone" || $key === "t_tel") {
                                                $key_text = "聯絡電話";
                                            } else if ($key === "email" || $key === "t_mail") {
                                                $key_text = "email";
                                            } else if ($key === "HomeAddr") {
                                                $key_text = "家中住址";
                                            } else if ($key === "t_address") {
                                                $key_text = "辦公室位置";
                                            } else if ($key === "t_officetel") {
                                                $key_text = "辦公室電話";
                                            } else if ($key === "Hphone") {
                                                $key_text = "家中電話";
                                            } else if ($key === "Contactor") {
                                                $key_text = "聯絡人";
                                            } else if ($key === "Cphone") {
                                                $key_text = "聯絡人電話";
                                            }
                                            // 輸出表單欄位，讓使用者修改資料
                                            if (!($key === "uid")) {
                                                if ($key === "Sid" || $key === "name" || $key === "t_name" || $key === "t_rank" || $key === "grade") {
                                                    echo'<label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">'.$key_text.'：'.'</span></label>';
                                                    echo "<input type='text' style='color: blue;'name='$key' value='$value'><br><br>";

                                                } else {
                                                    echo'<label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">'.$key_text.'：'.'</span></label>';
                                                    echo "<input type='text' style='color: blue;'name='$key' value='$value'><br><br>";

                                                }
                                            }
                                        }
                                        echo "<input type='hidden' name='identity' value='$identity'>";
                                        echo "<input type='hidden' name='uid' value='$uid'>"; // 保留 uid 的隱藏欄位
                                        echo "<input type='submit' class='btn btn-primary' value='更新'>";
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
                    </div>
                </div>

                <style>
                    .text-center {
                        text-align: center;
                    }
                    .text-left {
                        text-align: left;
                    }
                    .card-body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                </style>
            </div>
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




