

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
                <a class="navbar-brand" href="AS_Home.php">AS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../lobby.php">Home</a></li>

                        
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
            <!-- <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">個人資料</h1>
                </div>
            </div> -->
        </header>


       
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
               
                <!-- Side widgets-->
                <div class="col-lg-4">
                   
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Advertisement</div>
                        <?php
                            if (!empty($identity) && !empty($uid)) {
                                if ($identity === "SYS") {
                                    // 設定查詢的資料表和欄位
                                    $table = "ad";
                                    $columns = "r_place";
                                }


                                // SQL 查詢
                                $sql_query = "SELECT $columns FROM $table where r_up = 0";
                                $result = $conn->query($sql_query);
                                

                                if ($result) {
                                    // 輸出查詢結果表單
                                    // while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    //     echo '<div class="card-body">';
                                    //     echo '<form method="get" action="AS_Home_review_information.php">';
                                    //     foreach ($row as $key => $value) {
                                    //         if ($key === "r_place") {
                                    //             $key_text = "地點";
                                    //             echo "<input type='hidden' name='r_place' value='$value'>";
                                    //         }
                                    //         // 輸出表單欄位，讓使用者修改資料
                                    //         echo "$key_text: $value";
                            
                                    //         echo '<div style="text-align: right;">';
                                    //             echo '<input type="submit" name="modify" value="查看">';
                                    //         echo '</div>';
                                    //     }
                                    //     echo "</form>";
                            

                            
                                    //     echo "</div>";
                                    // }
                                    if ($result->rowCount() > 0) {
                                        // 輸出查詢結果表單
                                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                            echo '<div class="card-body">';
                                            echo '<form method="get" action="AS_Home_review_information.php">';
                                            foreach ($row as $key => $value) {
                                                if ($key === "r_place") {
                                                    $key_text = "地點";
                                                    echo "<input type='hidden' name='r_place' value='" . htmlspecialchars($value) . "'>";
                                                }
                                                // 輸出表單欄位，讓使用者修改資料
                                                echo "$key_text: " . htmlspecialchars($value);
                            
                                                echo '<div style="text-align: right;">';
                                                echo '<input type="submit" name="modify" value="查看">';
                                                echo '</div>';
                                            }
                                            echo '</form>';
                                            echo '</div>';
                                        }
                                    } else {
                                        // 沒有需要審核的廣告
                                        echo "<p>所有廣告已審核完畢</p>";
                                    }
                                } else {
                                    echo "查失敗：" . mysql_error();
                                }
                            } else {
                                echo "未提供足夠的訊息進行查詢";
                            }
                        ?>



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




