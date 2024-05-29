<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>IS</title>
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
        <!-- 上面的標籤-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="IS_Home.php">IS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <li class="nav-item"><a class="nav-link" href="../lobby.php">Home</a></li>

                        <?php
                        if(($identity === "S" || $identity === "T")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_personal_infprmation.php">個人資料</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_record.php">查詢紀錄</a></li>';
                        }
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
        <!-- 大標題-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">訪談紀錄表</h1>
                    <!-- <p class="lead mb-0">歡迎使用!</p> -->
                </div>
            </div>
        </header>
        <!-- Page content-->
        <?php       

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $landlord_name = $_POST["landlord_name"];
            $landlord_phone = $_POST["landlord_phone"];
            $address = $_POST["address"];
            $housing_type = $_POST["housing_type"];
            $room_type = $_POST["room_type"];
            $money = $_POST["rent"];
            $deposit = $_POST["deposit"];
            $q0 = $_POST["Q0"];
            $q1 = $_POST["Q1"];
            $q2 = $_POST["Q2"];
            $q3 = $_POST["Q3"];
            $q4 = $_POST["Q4"];
            $q5 = $_POST["Q5"];
            $q6 = $_POST["Q6"];
            $q7 = $_POST["Q7"];
            $q8 = $_POST["Q8"];
            $q9 = $_POST["Q9"];
            $q10 = $_POST["Q10"];
            $q11 = $_POST["Q11"];
            $q12 = $_POST["Q12"];
            $q13 = $_POST["Q13"];

            $sql_query = "SELECT COUNT(*) AS total_rows FROM `interview_record`";
            $result = $conn->query($sql_query);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $total_rows = $row['total_rows'];

            if ($total_rows == 0) {
                $new_id = "I00000";
            } else {
                $sql_query = "SELECT MAX(record_uid) AS max_id FROM `interview_record`";
                $result = $conn->query($sql_query);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $max_id = $row["max_id"];
                $new_id = "I" . str_pad(substr($max_id, 1) + 1, 5, "0", STR_PAD_LEFT);
            }

            $sql_insert = "INSERT INTO interview_record values ('$new_id', '$uid', '$landlord_name', '$landlord_phone', '$address', '$housing_type',
            '$room_type', '$money', '$deposit', '$q0', '$q1', '$q2', '$q3', '$q4', '$q5', '$q6', '$q7', '$q8', '$q9', '$q10', '$q11', '$q12', '$q13')";
            echo($sql_insert);
            $result = $conn->query($sql_insert);
            echo "<script>alert('訪談填寫完成！'); window.location.href='IS_Home.php';</script>";

        }
        ?>

        
        <div class="container">
            <div class="center"> 
                <form id="myForm" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">校外賃居資料</span></label><br>
                    <p></p> 

                    <div class="form-row">
                        <label for="titile"><span style="color: black; font-weight: bold;">房東姓名：</span></label>
                        <input type="text" id="landlord_name" name="landlord_name" value="<?php echo $r_format; ?>" class="underline-input">
                        
                        <label for="titile"><span style="color: black; font-weight: bold;">房東電話：</span></label>
                        <input type="text" id="landlord_phone" name="landlord_phone" value="<?php echo $r_money; ?>" class="underline-input">

                        <label for="titile"><span style="color: black; font-weight: bold;">租賃地址：</span></label>
                        <input type="text" id="address" name="address" value="<?php echo $r_money; ?>" class="underline-input"  style="width: 400px;"><br><br>
                    </div>


                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租屋型態：</span>
                        </label>

                        <input type="radio" id="detached" name="housing_type" value="獨棟透天">
                        <label for="detached" style="margin-right: 10px;">獨棟透天</label>

                        <input type="radio" id="apartment" name="housing_type" value="公寓(五樓以下)">
                        <label for="apartment" style="margin-right: 10px;">公寓(五樓以下)</label>

                        <input type="radio" id="highrise" name="housing_type" value="大樓(六樓以上)">
                        <label for="highrise" style="margin-right: 10px;">大樓(六樓以上)</label>

                        <input type="radio" id="dorm" name="housing_type" value="大型學舍(位學生建設的宿舍)">
                        <label for="dorm" style="margin-right: 10px;">大型學舍(為學生建設的宿舍)</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間類型：</span>
                        </label>

                        <input type="radio" id="suite" name="room_type" value="套房">
                        <label for="suite" style="margin-right: 10px;">套房</label>

                        <input type="radio" id="elegant_house" name="room_type" value="雅房">
                        <label for="elegant_house" style="margin-right: 10px;">雅房</label><br><br>
                    </div>

                    <div class="form-row">
                        <label for="rent"><span style="color: black; font-weight: bold;">每月租金：</span></label>
                        <input type="text" id="rent" name="rent" value="<?php echo $r_format; ?>" class="underline-input">
                        
                        <label for="deposit"><span style="color: black; font-weight: bold;">押金：</span></label>
                        <input type="text" id="deposit" name="deposit" value="<?php echo $r_money; ?>" class="underline-input">

                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否推薦其他同學租賃？</span>
                        </label>

                        <input type="radio" id="yes0" name="Q0" value="是">
                        <label for="yes0" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no0" name="Q0" value="否">
                        <label for="no0" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <p><p>
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 24px;">賃居安全自主管理檢視資料</span></label><br>
                    <p></p> 

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">木造隔間或鐵皮加蓋：</span>
                        </label>

                        <input type="radio" id="yes1" name="Q1" value="是">
                        <label for="yes1" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no1" name="Q1" value="否">
                        <label for="no1" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有火警警報器或偵煙器：</span>
                        </label>

                        <input type="radio" id="yes2" name="Q2" value="是">
                        <label for="yes2" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no2" name="Q2" value="否">
                        <label for="no2" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">逃生通道暢通且標示清楚：</span>
                        </label>

                        <input type="radio" id="yes3" name="Q3" value="是">
                        <label for="yes3" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no3" name="Q3" value="否">
                        <label for="no3" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">門禁及鎖具良好管理：</span>
                        </label>

                        <input type="radio" id="yes4" name="Q4" value="是">
                        <label for="yes4" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no4" name="Q4" value="否">
                        <label for="no4" style="margin-right: 10px;">否</label><br><br>
                    </div>
                    
                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有安裝照明設備(停車場及周邊)：</span>
                        </label>

                        <input type="radio" id="yes5" name="Q5" value="是">
                        <label for="yes5" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no5" name="Q5" value="否">
                        <label for="no5" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">瞭解熟悉電路安全及逃生要領：</span>
                        </label>

                        <input type="radio" id="yes6" name="Q6" value="是">
                        <label for="yes6" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no6" name="Q6" value="否">
                        <label for="no6" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">熟悉派出所、醫療、消防隊、學校校安專線電話：</span>
                        </label>

                        <input type="radio" id="yes7" name="Q7" value="是">
                        <label for="yes7" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no7" name="Q7" value="否">
                        <label for="no7" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">使用多種電器(高耗能)、是否同時插在同一條延長線：</span>
                        </label>

                        <input type="radio" id="yes8" name="Q8" value="是">
                        <label for="yes8" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no8" name="Q8" value="否">
                        <label for="no8" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有滅火器且功能正常：</span>
                        </label>

                        <input type="radio" id="yes9" name="Q9" value="是">
                        <label for="yes9" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no9" name="Q9" value="否">
                        <label for="no9" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">熱水器(電熱式及瓦斯式)安全良好、無一氧化碳中毒疑慮：</span>
                        </label>

                        <input type="radio" id="yes10" name="Q10" value="是">
                        <label for="yes10" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no10" name="Q10" value="否">
                        <label for="no10" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">分開六個以上房間或十個以上床位：</span>
                        </label>

                        <input type="radio" id="yes11" name="Q11" value="是">
                        <label for="yes11" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no11" name="Q11" value="否">
                        <label for="no11" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有安裝監視器設備：</span>
                        </label>

                        <input type="radio" id="yes12" name="Q12" value="是">
                        <label for="yes12" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no12" name="Q12" value="否">
                        <label for="no12" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">使用內政部定型化租賃契約：</span>
                        </label>

                        <input type="radio" id="yes13" name="Q13" value="是">
                        <label for="yes13" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no13" name="Q13" value="否">
                        <label for="no13" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div style="text-align: right;">
                        <input type="submit" value="送出" onclick="confirmSubmission(event)">
                    </div>
                    <script>
                        function confirmSubmission(event) {
                            event.preventDefault(); // 阻止表单的默认提交行为
                            const userConfirmed = confirm("你确定要提交吗？");

                            if (userConfirmed) {
                                document.getElementById("myForm").submit(); // 如果用户确认，则提交表单
                            }
                        }
                    </script>
                </form>
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