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
            $_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];
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
        <!-- 上面的標籤-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="AS_Home.php">AS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <li class="nav-item"><a class="nav-link" href="../lobby.php">Home</a></li>

                        <?php
                        if(($identity === "L")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../AS/AS_AD_Management.php">廣告管理</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../AS/AS_Landlord.php">個人資料</a></li>';
                        }
                        else if ($identity === "S"){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../AS/AS_Home_ad_favorite.php">收藏清單</a></li>';
                        }
                        else if ($identity === "SYS"){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../AS/AS_Home_review_ads.php">審核廣告</a></li>';
                        }
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
        <!-- 大標題-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Advertisement</h1>
                    <!-- <p class="lead mb-0">歡迎使用!</p> -->
                </div>
            </div>
        </header>
        <!-- Page content-->
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <form>
                        <?php
                            
                            $sql = "SELECT r_place, r_post FROM `ad` where r_up = 1";
                            $result = $conn->query($sql);

                            if ($result->rowCount() > 0) {
                                echo "<table class='table table-striped'>";
                                echo "<tbody>";
                                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                    $default_image = 'assets/house.jpg';
                                    // 將 r_place 作為 URL 參數傳遞
                                    echo '<tr><td>';
                                    echo '<a href="AS_Home_ad_information.php?r_place=' . ($row["r_place"]) . '">';

                                    // 判断是否存在 r_post 數據，如果不存在則使用默認圖片
                                    // $image_src = !empty($row["r_post"]) ? 'data:image/jpeg;base64,' . $row["r_post"] . '" style="max-width:200px; max-height:200px;"' : 'src="' . $default_image . '" style="max-width:200px; max-height:200px;"';
                                    if(!empty($row["r_post"])){
                                       echo '<img src="data:image/jpeg;base64,' . ($row["r_post"]) . '" style="max-width:200px; max-height:200px;"/>';
                                    }
                                    else{
                                       echo '<img src="' . $default_image . '" style="max-width:200px; max-height:200px;"/>';
                                    }
                                    // echo '<img src="data:image/jpeg;base64,' . ($row["r_post"]) . '" style="max-width:200px; max-height:200px;"/>';
                                    
                                    echo '</a>';
                                    echo '<p>';
                                    echo($row["r_place"]);
                                    echo '</p>';
                                    echo '</td></tr>';
                                    
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "0 results";
                            }
                        ?>
                    </form>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">找好房</div>
                        <div class="card-body">
                        <form id="search-form" action="search.php" method="POST">
                            <div class="input-group mb-3">
                                <input class="form-control" id="search-input" name="search-term" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                            </div>
                        </form>
                        </div>
                    </div>
                    
                    <!-- Categories widget-->
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body">
                            <div class="row">
                            <form id="search-form" action="search_more.php" method="POST">
                                <div class="form-row" style="display: flex; align-items: center;">
                                    <label for="housing_type" style="margin-right: 10px;">
                                        <span style="color: black; font-weight: bold;">租屋型態：</span>
                                    </label>
                                    <input type="radio" id="suite" name="housing_type" value="套房">
                                    <label for="suite" style="margin-right: 10px;">套房</label>
                                    <input type="radio" id="shared" name="housing_type" value="雅房">
                                    <label for="shared" style="margin-right: 10px;">雅房</label>
                                </div>
                                <div class="form-row" style="display: flex; align-items: center;">
                                    <label for="rent" style="margin-right: 10px;">
                                        <span style="color: black; font-weight: bold;">租金：</span>
                                    </label>
                                    <input type="radio" id="above5000" name="rent" value=">=5000">
                                    <label for="above5000" style="margin-right: 10px;">5000以上</label>
                                    <input type="radio" id="below5000" name="rent" value="<=5000">
                                    <label for="below5000" style="margin-right: 10px;">5000以下</label>
                                </div>
                                <div class="form-row" style="display: flex; align-items: center;">
                                    <label for="deposit" style="margin-right: 10px;">
                                        <span style="color: black; font-weight: bold;">設備：</span>
                                    </label>
                                    <input type="radio" id="air_conditioner" name="air_conditioner" value="冷氣">
                                    <label for="air_conditioner" style="margin-right: 10px;">冷氣</label>
                                    <input type="radio" id="refrigerator" name="refrigerator" value="冰箱">
                                    <label for="refrigerator" style="margin-right: 10px;">冰箱</label>
                                    <input type="radio" id="washing_machine" name="washing_machine" value="洗衣機">
                                    <label for="washing_machine" style="margin-right: 10px;">洗衣機</label>
                                    <input type="radio" id="internet" name="internet" value="網路">
                                    <label for="internet" style="margin-right: 10px;">網路</label>
                                    <input type="radio" id="heater" name="heater" value="熱水器">
                                    <label for="heater" style="margin-right: 10px;">熱水器</label>
                                </div>
                                <div class="form-row" style="display: flex; align-items: center;">
                                    <button class="btn btn-primary" id="button-search_more" type="submit">Go!</button>
                                </div>
                            </form>

                            </div>
                        </div>
                    </div>
                    <script>
                        document.querySelectorAll('input[type=radio]').forEach(function(radio) {
                            radio.addEventListener('click', function() {
                                if (this.previousChecked) {
                                    this.checked = false;
                                    this.previousChecked = false;
                                } else {
                                    this.previousChecked = true;
                                    // let isAnySelected = true;
                                }
                            });
                        });
                    </script>
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
