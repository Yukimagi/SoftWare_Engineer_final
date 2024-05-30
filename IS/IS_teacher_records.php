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
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_personal_information.php">個人資料</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_record.php">查詢紀錄</a></li>';
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
                    <h1 class="fw-bolder">訪談紀錄表</h1>
                    <!-- <p class="lead mb-0">歡迎使用!</p> -->
                </div>
            </div>
        </header>
        <!-- Page content-->
        <?php       

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tq0 = $_POST["tq0"];
            $tq1 = $_POST["tq1"];
            $tq2 = $_POST["tq2"];
            $tq2_detail = $_POST["tq2_detail"];
            $tq3 = $_POST["tq3"];
            $tq3_detail = $_POST["tq3_detail"];
            $tq4 = $_POST["tq4"];
            $tq4_detail = $_POST["tq4_detail"];
            $tq5 = $_POST["tq5"];
            $tq6 = $_POST["tq6"];
            $tq6_detail = $_POST["tq6_detail"];
            $tq7 = $_POST["tq7"];
            $tq8_1 = $_POST["tq8_1"];
            $tq8_2 = $_POST["tq8_2"];
            $tq8_3 = $_POST["tq8_3"];
            $tq8_4 = $_POST["tq8_4"];
            $tq8_detail = $_POST["tq8_detail"];

            $sql_insert = "UPDATE interview_record SET tq0 = '$tq0', tq1 = '$tq1', tq2 = '$tq2', tq2_detail = '$tq2_detail', tq3 = '$tq3', tq3_detail = '$tq3_detail',
            tq4 = '$tq4', tq4_detail = '$tq4_detail', tq5 = '$tq5', tq6 = '$tq6', tq6_detail = '$tq6_detail', tq7 = '$tq7', tq8_1 = '$tq8_1', tq8_2 = '$tq8_2',
            tq8_3 = '$tq8_3', tq8_4 = '$tq8_4', tq8_detail = '$tq8_detail' where t_uid = '$uid'";

            echo($sql_insert);
            $result = $conn->query($sql_insert);
            echo "<script>alert('訪談填寫完成！'); window.location.href='IS_Home.php';</script>";

        }
        // Check if the teacher has already filled out the form
        // $sql_check = "SELECT COUNT(*) AS count FROM `interview_record` WHERE t_uid = '$uid'";
        // $stmt = $conn->prepare($sql_check);
        // $stmt->execute();
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // $has_filled_form = $row['count'] > 0;
        $has_filled_form = FALSE;

        if (!$has_filled_form) {
        ?>
        <?php
        // Assuming $conn is your database connection


        // Fetch all student s_uids for the dropdown
        $sql_students = "SELECT s_uid FROM interview_record where t_uid='$uid'";
        $result_students = $conn->query($sql_students);


        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $selected_s_uid = $_POST["s_uid"];


            // Fetch interview records for the selected student
            $sql_records = "SELECT * FROM interview_record WHERE s_uid = :s_uid";
            $stmt_records = $conn->prepare($sql_records);
            $stmt_records->bindParam(':s_uid', $selected_s_uid);
            $stmt_records->execute();
            $records = $stmt_records->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>



        
        <div class="container">
            <div class="center">
                
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學生：</span></label>
                    <select id="s_uid" name="s_uid" required>
                        <option value="" disabled selected>選擇學生</option>
                        <?php while ($row = $result_students->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['s_uid']; ?>"><?php echo $row['s_uid']; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit" class="send-button">送出</button>
                </form>



                <form id="myForm" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">校外賃居資料</span></label><br>
                    <p></p>

                    <div class="form-row">
                        <label for="landlord_name"><span style="color: black; font-weight: bold;">房東姓名：</span></label>
                        <input type="text" id="landlord_name" name="landlord_name" value="" class="underline-input" readonly>
                        
                        <label for="landlord_phone"><span style="color: black; font-weight: bold;">房東電話：</span></label>
                        <input type="text" id="landlord_phone" name="landlord_phone" value="" class="underline-input" readonly>

                        <label for="address"><span style="color: black; font-weight: bold;">租賃地址：</span></label>
                        <input type="text" id="address" name="address" value="" class="underline-input" style="width: 400px;" readonly><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租屋型態：</span>
                        </label>

                        <input type="radio" id="detached" name="housing_type" value="獨棟透天" readonly>
                        <label for="detached" style="margin-right: 10px;">獨棟透天</label>

                        <input type="radio" id="apartment" name="housing_type" value="公寓(五樓以下)" readonly>
                        <label for="apartment" style="margin-right: 10px;">公寓(五樓以下)</label>

                        <input type="radio" id="highrise" name="housing_type" value="大樓(六樓以上)" readonly>
                        <label for="highrise" style="margin-right: 10px;">大樓(六樓以上)</label>

                        <input type="radio" id="dorm" name="housing_type" value="大型學舍(為學生建設的宿舍)" readonly>
                        <label for="dorm" style="margin-right: 10px;">大型學舍(為學生建設的宿舍)</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="room_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間類型：</span>
                        </label>

                        <input type="radio" id="suite" name="room_type" value="套房" readonly>
                        <label for="suite" style="margin-right: 10px;">套房</label>

                        <input type="radio" id="elegant_house" name="room_type" value="雅房" readonly>
                        <label for="elegant_house" style="margin-right: 10px;">雅房</label><br><br>
                    </div>

                    <div class="form-row">
                        <label for="rent"><span style="color: black; font-weight: bold;">每月租金：</span></label>
                        <input type="text" id="rent" name="rent" value="" class="underline-input" readonly>
                        
                        <label for="deposit"><span style="color: black; font-weight: bold;">押金：</span></label>
                        <input type="text" id="deposit" name="deposit" value="" class="underline-input" readonly>

                        <label for="Q0" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否推薦其他同學租賃？</span>
                        </label>

                        <input type="radio" id="yes0" name="Q0" value="是" readonly>
                        <label for="yes0" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no0" name="Q0" value="否" readonly>
                        <label for="no0" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <p></p>
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">賃居安全自主管理檢視資料</span></label><br>
                    <p></p>

                    <div class="form-row">
                        <label for="Q1" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所消防設備是否符合標準：</span>
                        </label>

                        <input type="radio" id="yes1" name="Q1" value="是" readonly>
                        <label for="yes1" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no1" name="Q1" value="否" readonly>
                        <label for="no1" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有火災警報器：</span>
                        </label>

                        <input type="radio" id="yes2" name="Q2" value="是" readonly>
                        <label for="yes2" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no2" name="Q2" value="否" readonly>
                        <label for="no2" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有消防栓、滅火器：</span>
                        </label>

                        <input type="radio" id="yes3" name="Q3" value="是" readonly>
                        <label for="yes3" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no3" name="Q3" value="否" readonly>
                        <label for="no3" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有防火避難方向標示、逃生設備：</span>
                        </label>

                        <input type="radio" id="yes4" name="Q4" value="是" readonly>
                        <label for="yes4" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no4" name="Q4" value="否" readonly>
                        <label for="no4" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房東或租賃處所是否有投保火災保險：</span>
                        </label>

                        <input type="radio" id="yes5" name="Q5" value="是" readonly>
                        <label for="yes5" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no5" name="Q5" value="否" readonly>
                        <label for="no5" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">電線走火是否為套管走火或有整齊固定：</span>
                        </label>

                        <input type="radio" id="yes6" name="Q6" value="是" readonly>
                        <label for="yes6" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no6" name="Q6" value="否" readonly>
                        <label for="no6" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">大樓出入口或主要出口是否有鐵捲門或鐵柵門：</span>
                        </label>

                        <input type="radio" id="yes7" name="Q7" value="是" readonly>
                        <label for="yes7" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no7" name="Q7" value="否" readonly>
                        <label for="no7" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所是否有公安檢查合格或其他相關證明：</span>
                        </label>

                        <input type="radio" id="yes8" name="Q8" value="是" readonly>
                        <label for="yes8" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no8" name="Q8" value="否" readonly>
                        <label for="no8" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否有對外窗戶或通風口：</span>
                        </label>

                        <input type="radio" id="yes9" name="Q9" value="是" readonly>
                        <label for="yes9" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no9" name="Q9" value="否" readonly>
                        <label for="no9" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間內是否有廚房、瓦斯爐具：</span>
                        </label>

                        <input type="radio" id="yes10" name="Q10" value="是" readonly>
                        <label for="yes10" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no10" name="Q10" value="否" readonly>
                        <label for="no10" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間是否設置簡易型瓦斯警報器：</span>
                        </label>

                        <input type="radio" id="yes11" name="Q11" value="是" readonly>
                        <label for="yes11" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no11" name="Q11" value="否" readonly>
                        <label for="no11" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間內是否有配置飲水機：</span>
                        </label>

                        <input type="radio" id="yes12" name="Q12" value="是" readonly>
                        <label for="yes12" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no12" name="Q12" value="否" readonly>
                        <label for="no12" style="margin-right: 10px;">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所附近生活機能良好：</span>
                        </label>

                        <input type="radio" id="yes13" name="Q13" value="是" readonly>
                        <label for="yes13" style="margin-right: 10px;">是</label>

                        <input type="radio" id="no13" name="Q13" value="否" readonly>
                        <label for="no13" style="margin-right: 10px;">否</label><br><br>
                    </div>
                    
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">環境及作息評估(導師填寫)</span></label><br>
                    <p></p>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">押金要求：</span>
                        </label>

                        <input type="radio" id="makesense" name="tq0" value="合理" required>
                        <label for="makesense" style="margin-right: 10px;">合理</label>

                        <input type="radio" id="nonsense" name="tq0" value="不合理(兩個月以上租金)" required>
                        <label for="nonsense" style="margin-right: 10px;">不合理(兩個月以上租金)</label>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">水電費要求：</span>
                        </label>

                        <input type="radio" id="makesense1" name="tq1" value="合理" required>
                        <label for="makesense1" style="margin-right: 10px;">合理</label>

                        <input type="radio" id="nonsense1" name="tq1" value="不合理" required>
                        <label for="nonsense1" style="margin-right: 10px;">不合理</label>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">居家環境：</span>
                        </label>

                        <input type="radio" id="makesense2" name="tq2" value="佳" required>
                        <label for="makesense2" style="margin-right: 10px;">佳</label>

                        <input type="radio" id="soso2" name="tq2" value="適中" required>
                        <label for="soso2" style="margin-right: 10px;">適中</label>

                        <input type="radio" id="nonsense2" name="tq2" value="欠佳" required>
                        <label for="nonsense2" style="margin-right: 10px;">欠佳</label>

                        <label for="tq2_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq2_detail" name="tq2_detail" value="" class="underline-input">
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">生活設施：</span>
                        </label>

                        <input type="radio" id="makesense3" name="tq3" value="佳" required>
                        <label for="makesense3" style="margin-right: 10px;">佳</label>

                        <input type="radio" id="soso3" name="tq3" value="適中" required>
                        <label for="soso3" style="margin-right: 10px;">適中</label>

                        <input type="radio" id="nonsense3" name="tq3" value="欠佳" required>
                        <label for="nonsense3" style="margin-right: 10px;">欠佳</label>

                        <label for="tq3_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq3_detail" name="tq3_detail" value="" class="underline-input">
                    </div>
                    
                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">訪視現況：</span>
                        </label>

                        <input type="radio" id="makesense4" name="tq4" value="生活規律" required>
                        <label for="makesense4" style="margin-right: 10px;">生活規律</label>

                        <input type="radio" id="soso4" name="tq4" value="適中" required>
                        <label for="soso4" style="margin-right: 10px;">適中</label>

                        <input type="radio" id="nonsense4" name="tq4" value="待加強" required>
                        <label for="nonsense4" style="margin-right: 10px;">待加強</label>

                        <label for="tq4_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq4_detail" name="tq4_detail" value="" class="underline-input">
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">主客相處：</span>
                        </label>

                        <input type="radio" id="makesense5" name="tq5" value="和睦" required>
                        <label for="makesense5" style="margin-right: 10px;">和睦</label>

                        <input type="radio" id="nonsense5" name="tq5" value="欠佳" required>
                        <label for="nonsense5" style="margin-right: 10px;">欠佳</label>
                    </div>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">訪視結果(導師填寫)：</span></label><br>
                    <p></p>

                    <div class="form-row" style="display: flex; align-items: center;">

                        <input type="radio" id="makesense6" name="tq6" value="整體賃居狀況良好" required>
                        <label for="makesense6" style="margin-right: 10px;">整體賃居狀況良好</label>

                        <input type="radio" id="soso6" name="tq6" value="聯繫家長關注" required>
                        <label for="soso6" style="margin-right: 10px;">聯繫家長關注</label>

                        <input type="radio" id="nonsense6" name="tq6" value="安全堪慮請協助" required>
                        <label for="nonsense6" style="margin-right: 10px;">安全堪慮請協助</label>

                        <input type="radio" id="else6" name="tq6" value="其他" required>
                        <label for="else6" style="margin-right: 10px;">其他</label>

                        <label for="tq6_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq6_detail" name="tq6_detail" value="" class="underline-input">
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">

                        <label for="tq7"><span style="color: black; font-weight: bold;">其他記載或建議事項：</span></label>
                        <input type="text" id="tq7" name="tq7" value="" class="underline-input">

                    </div>

                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">關懷宣導項目(懇請導師賃居訪視時多與關懷叮嚀)：</span></label><br>
                    <p></p>

                    <div class="form-row" style="display: flex; align-items: center;">

                        <input type="radio" id="traffic" name="tq8_1" value="交通安全" >
                        <label for="traffic" style="margin-right: 10px;">交通安全</label>

                        <input type="radio" id="nosmoke" name="tq8_2" value="拒絕菸害" >
                        <label for="nosmoke" style="margin-right: 10px;">拒絕菸害</label>

                        <input type="radio" id="nodrug" name="tq8_3" value="拒絕毒品" >
                        <label for="nodrug" style="margin-right: 10px;">拒絕毒品</label>

                        <input type="radio" id="nomosquito" name="tq8_4" value="登革熱防治" >
                        <label for="nomosquito" style="margin-right: 10px;">登革熱防治</label>

                        <input type="radio" id="else8" name="tq8_5" value="其他" >
                        <label for="else8" style="margin-right: 10px;">其他</label>

                        <label for="tq8_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq8_detail" name="tq8_detail" value="" class="underline-input">
                    </div>

                    <p></p>
                    <div class="center">
                        <button type="submit" class="submit-button">提交</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        } else {
            echo "<div class='container'><div class='center'><p style='color: red; font-weight: bold; font-size: 18px;'>您已經填寫過訪談表單，無法再次提交。</p></div></div>";
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