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
                        <li class="nav-item"><a class="nav-link" href="test.php">TEST</a></li>
                        <li class="nav-item"><a class="nav-link" href="../index02.php">Home</a></li>
                        <!--<li class="nav-item"><a class="nav-link" href="#!">About</a></li>-->
                        <!--<li class="nav-item"><a class="nav-link" href="#!">sign in</a></li>-->
                        
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_Communicate.php">交流平台</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="CPS_OBJ.php">物件評價</a></li>
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
                    <h1 class="fw-bolder">租屋交流平台</h1>
                    <p class="lead mb-0">歡迎使用!</p>
                </div>
            </div>
        </header>
        <?php
        if(($identity === "SYS"||$identity === "L"|| $identity === "訪客")){
            
        echo'<div class="container">';
            echo'<div class="row">';
                echo'<!-- Blog entries-->';
                echo'<div class="col-lg-8">';
                    echo'<!-- Featured blog post-->';
                    echo'<div class="card mb-4">';
                        echo'<a href="#!"><img class="card-img-top" src="assets/CPS_INFO_WARN.png" alt="..." /></a>';
                        echo'<div class="card-body">';
                        echo'</div>';
                    echo'</div>';
                echo'</div>';
            echo'</div>';
        echo'</div>';
        }
        else{
        ?>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="assets/CPS_INFO_WARN.png" alt="..." /></a>
                        <div class="card-body">
                        </div>
                    </div>
                    <!-- Nested row for non-featured blog posts-->
                    <div class="row">

                            <!-- Blog post-->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="small text-muted">個人發布文章</div>
                                    <a class="btn btn-primary btn-sm custom-btn" href="CPS_personal_publish_article.php">Read more →</a>
                                </div>
                            </div>
                            <!-- Blog post-->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="small text-muted">個人收藏文章</div>
                                    <a class="btn btn-primary btn-sm custom-btn" href="CPS_personal_keep_article.php">Read more →</a>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="small text-muted">個人評價物件</div>
                                    <a class="btn btn-primary btn-sm custom-btn" href="#">Read more →</a>
                                </div>
                            </div>

                        
                    </div>

                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">personal profile</div>
                        <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
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
