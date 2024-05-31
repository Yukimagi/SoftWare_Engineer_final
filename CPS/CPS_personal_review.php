<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>CPS</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/star.css" rel="stylesheet" />
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
            if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
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
                $result = mysql_query($sql_query);
                $row = mysql_fetch_array($result);
                $name = $row["name"];
            }
            ?>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="CPS_Home.php">CPS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="../index02.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        
                        <?php
                        if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_addobj.php">新增物件</a></li>';
                        }
                        ?>
                        <?php
                        if (!($identity === "SYS"||$identity === "L"|| $identity === "訪客")) {
                        echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>';
                        }
                        ?>
                        <!--<li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>-->
                        <?php
                        if(!($identity === "訪客")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../index01.php?logged_in=false">使用者登出</a></li>';
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
                    <h1 class="fw-bolder">個人評論紀錄</h1>
                    
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="assets/review_warn.png" alt="..." /></a>
                        <div class="card-body">

                        </div>
                    </div>
                    <?php
                        $select_db=@mysql_select_db("rentsystem");//選擇資料庫
                        if(!$select_db) {
                            echo'<br>找不到資料庫!<br>';
                        } else {
                            
                            
                            // 查table
                            $sql_query = "SELECT * FROM `user_obj` WHERE uid = '$uid'";
                            $result = mysql_query($sql_query);

                            // 查所有文章
                            while ($row = mysql_fetch_assoc($result)) {
                                $objID = $row['objID'];
                                $score = $row['score'];
                                $msg = $row['msg'];

                                $sql_query2 = "SELECT * FROM `contact_object` WHERE objID = '$objID'";
                                $result2 = mysql_query($sql_query2);
                                while ($row2 = mysql_fetch_assoc($result2)) {
                                    $name = $row2['name'];

                                    // 輸出文章
                                    echo '<div class="card mb-4">';
                                    echo '<div class="card-body">';
                                    echo '<p class="card-text"><strong>' . $name . '</strong>:</p>';
                                    
                                    // 顯示星等
                                    echo '<div class="star-rating" style="margin-left: 20px;">';
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $score) {
                                            echo '<span class="star" style="color: gold;">&#9733;</span>'; // 填滿的星星
                                        } else {
                                            echo '<span class="star" style="color: lightgray;">&#9734;</span>'; // 空的星星
                                        }
                                    }
                                    echo '</div>';
                                    
                                    echo '<p class="card-text" style="margin-left: 20px;">' . $msg . '</p>';
                                    echo'<a class="btn btn-primary btn-sm custom-btn" href="CPS_Object_Review.php?objID=' . $objID . '">Read more review →</a></li>';
                                    echo '</form>';

                                    echo '</div>';
                                    echo '</div>';
                                }
                            }
                            
                        }
                    ?>
                    
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">personal profile</div>
                        <?php
                            if (!empty($identity) && !empty($uid)) {
                                if ($identity === "T") {
                                    // 查教師的資料
                                    $table = "teacher_profile";
                                    $columns = "t_uid, t_name, t_rank, t_tel, t_mail, t_officetel";
                                } elseif ($identity === "S") {
                                    // 查學生的資料
                                    $table = "basicinfo";
                                    $columns = "uid, SID, name, grade, gender, phone, email";
                                }
                            
                                // SQL 查
                                $sql_query = "SELECT $columns FROM `$table` WHERE t_uid = '$uid'";
                                if ($identity === "S") {
                                    $sql_query = "SELECT $columns FROM `$table` WHERE uid = '$uid'";
                                }
                            
                                $result = mysql_query($sql_query);
                            
                                if ($result) {
                                    // 輸出結果
                                    while ($row = mysql_fetch_assoc($result)) {
                                        // 输出指定的列
                                        echo '<div class="card-body">';
                                        foreach ($row as $key => $value) {
                                            if ($key === "t_uid" || $key === "uid") {
                                                $key_text = "UID";
                                            } else if ($key === "t_name" || $key === "name") {
                                                $key_text = "姓名";
                                            } else if ($key === "t_rank") {
                                                $key_text = "職等";
                                            } else if ($key === "t_tel" || $key === "phone") {
                                                $key_text = "電話";
                                            } else if ($key === "t_mail" || $key === "email") {
                                                $key_text = "信箱";
                                            } else if ($key === "t_officetel") {
                                                $key_text = "辦公室電話";
                                            } else if ($key === "SID") {
                                                $key_text = "學號";
                                            } else if ($key === "grade") {
                                                $key_text = "年級";
                                            } else if ($key === "gender") {
                                                $key_text = "性別";
                                            }
                                            echo "$key_text: $value <br>";
                                        }
                                        echo "</div>";
                                    }
                                } else {
                                    echo "查失敗：" . mysql_error();
                                }
                            } else {
                                echo "為提供殂購的訊息進行查詢";
                            }
                            
                        ?>
                        
                    </div>
                </div>
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
