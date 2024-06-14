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
        <!-- 上面的標籤-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="IS_teacher_records.php">IS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                        <li class="nav-item"><a class="nav-link" href="../lobby.php">Home</a></li>

                        <?php
                        if(($identity === "S")){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_personal_information.php">個人資料</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_student_search_record.php">查詢紀錄</a></li>';
                        }
                        else if($identity === "T"){
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_personal_information.php">個人資料</a></li>';
                            echo'<li class="nav-item"><a class="nav-link active" aria-current="page" href="../IS/IS_teacher_search_record.php">查詢紀錄</a></li>';
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
        

        $sql_school_year = "SELECT DISTINCT school_year FROM interview_record JOIN basicinfo ON basicinfo.uid = interview_record.s_uid and t_uid='$uid'";
        $stmt_school_year = $conn->query($sql_school_year);
        $school_years = $stmt_school_year->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the SQL query for fetching distinct semesters
        $sql_semester = "SELECT DISTINCT semester FROM interview_record JOIN basicinfo ON basicinfo.uid = interview_record.s_uid WHERE interview_record.school_year = :school_year and t_uid='$uid'";
        $stmt_semester = $conn->prepare($sql_semester);

        // Initialize an array to hold semesters for each school year
        $all_semesters = [];

        foreach ($school_years as $year) {
            // Bind the school year parameter and execute the query
            $stmt_semester->bindParam(':school_year', $year['school_year']);
            $stmt_semester->execute();

            // Fetch semesters for the current school year
            $semesters = $stmt_semester->fetchAll(PDO::FETCH_ASSOC);

            // Add the result to the all_semesters array
            $all_semesters[$year['school_year']] = $semesters;
        }

        // Initialize variables for selected values
        $selected_school_year = isset($_POST['school_year']) ? $_POST['school_year'] : '';
        $selected_semester = isset($_POST['semester']) ? $_POST['semester'] : '';
        

        // Initialize an empty array for students
        $sids = [];

        // If both school year and semester are selected, fetch students
        if ($selected_school_year && $selected_semester) {
            $sql_sid = "SELECT DISTINCT basicinfo.sid FROM interview_record 
                        JOIN basicinfo ON basicinfo.uid = interview_record.s_uid 
                        WHERE interview_record.school_year = :school_year 
                        AND interview_record.semester = :semester and t_uid='$uid'";
            $stmt_sid = $conn->prepare($sql_sid);
            $stmt_sid->bindParam(':school_year', $selected_school_year);
            $stmt_sid->bindParam(':semester', $selected_semester);
            $stmt_sid->execute();
            $sids = $stmt_sid->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>
        <?php       

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $form_identifier = $_POST["form_identifier"];
            if ($form_identifier == "form1") {
                $selected_sid = isset($_POST['s_uid']) ? $_POST['s_uid'] : '';
                if ($selected_sid) {
                    
                    $sql_records = "SELECT interview_record.* , basicinfo.major
                        FROM interview_record join basicinfo 
                        WHERE interview_record.s_uid=basicinfo.uid and basicinfo.sid = :s_uid
                        and interview_record.school_year = :school_year and interview_record.semester = :semester";
                    
                    $stmt_records = $conn->prepare($sql_records);
                    $stmt_records->bindParam(':s_uid', $selected_sid);
                    $stmt_records->bindParam(':school_year', $selected_school_year);
                    $stmt_records->bindParam(':semester', $selected_semester);
                    $stmt_records->execute();
                    $records = $stmt_records->fetch(PDO::FETCH_ASSOC);

                    $major = $records['major'];
                    
                    $s_uid = $records['s_uid'];
                    $school_year = $records['school_year'];
                    $semester = $records['semester'];
                    $date_time = $records['date_time'];
                    $landlord_name = $records['landlord_name'];
                    $landlord_phone = $records['landlord_phone'];
                    $address = $records['address'];
                    $housing_type = $records['housing_type'];
                    $room_type = $records['room_type'];
                    $money = $records['money'];
                    $deposit = $records['deposit'];
                    $q0 = $records['q0'];
                    $q1 = $records['q1'];
                    $q2 = $records['q2'];
                    $q3 = $records['q3'];
                    $q4 = $records['q4'];
                    $q5 = $records['q5'];
                    $q6 = $records['q6'];
                    $q7 = $records['q7'];
                    $q8 = $records['q8'];
                    $q9 = $records['q9'];
                    $q10 = $records['q10'];
                    $q11 = $records['q11'];
                    $q12 = $records['q12'];
                    $q13 = $records['q13'];

                    $tq0 = $records["tq0"];
                    $tq1 = $records["tq1"];
                    $tq2 = $records["tq2"];
                    $tq2_detail = $records["tq2_detail"];
                    $tq3 = $records["tq3"];
                    $tq3_detail = $records["tq3_detail"];
                    $tq4 = $records["tq4"];
                    $tq4_detail = $records["tq4_detail"];
                    $tq5 = $records["tq5"];
                    $tq6 = $records["tq6"];
                    $tq6_detail = $records["tq6_detail"];
                    $tq7 = $records["tq7"];
                    $tq8_1 = $records["tq8_1"];
                    $tq8_2 = $records["tq8_2"];
                    $tq8_3 = $records["tq8_3"];
                    $tq8_4 = $records["tq8_4"];
                    $tq8_detail = $records["tq8_detail"];
                }
            }
        }            
        ?>
        
        <div class="container">
            <div class="row">
            <div class="text-center my-5">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="myForm">
                <input type="hidden" name="form_identifier" value="form1">

                <label for="school_year"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學年：</span></label>
                <select id="school_year" name="school_year" required onchange="this.form.submit()">
                    <option value="" disabled <?php echo empty($selected_school_year) ? 'selected' : ''; ?>>選擇學年</option>
                    <?php foreach ($school_years as $row1) { ?>
                        <option value="<?php echo $row1['school_year']; ?>" <?php echo ($row1['school_year'] == $selected_school_year) ? 'selected' : ''; ?>>
                            <?php echo $row1['school_year']; ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="semester"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學期：</span></label>
                <select id="semester" name="semester" required onchange="this.form.submit()">
                    <option value="" disabled <?php echo empty($selected_semester) ? 'selected' : ''; ?>>選擇學期</option>
                    <?php
                    if (!empty($selected_school_year)) {
                        foreach ($all_semesters[$selected_school_year] as $semester) { ?>
                            <option value="<?php echo $semester['semester']; ?>" <?php echo ($semester['semester'] == $selected_semester) ? 'selected' : ''; ?>>
                                <?php echo $semester['semester']; ?>
                            </option>
                        <?php }
                    }
                    ?>
                </select>

                <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">選擇學生：</span></label>
                <select id="s_uid" name="s_uid" required>
                    <option value="" disabled selected>選擇學生</option>
                    <?php foreach ($sids as $row3) { ?>
                        <option value="<?php echo $row3['sid']; ?>"><?php echo $row3['sid']; ?></option>
                    <?php } ?>
                </select>

                <button class="btn btn-primary" type="submit" class="send-button">送出</button>
                <a class="btn btn-primary" href="IS_teacher_search_record.php">清除</a>

            </form>
            </div>
            <?php if (isset($records)) { ?>
                <form id="myForm" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="form_identifier" value="form2">

                    <div class="card mb-4">
                    <div class="text-center my-5">
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學年：<?php echo($selected_school_year);?></span></label>
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學期：<?php echo($selected_semester);?></span></label>
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">系名：<?php echo($major);?></span></label>
                    <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學生：<?php echo($selected_sid);?></span></label>
                    </div>
                    
                    <div class="text-center my-5">

                        <label for="date_time"><span style="color: black; font-weight: bold;">訪談日期(年/月/日)：</span></label>
                        <input type="date" id="date_time" name="date_time" value="<?php echo $date_time; ?>" class="underline-input">

                    </div>
                    </div>
                    <div class="card mb-4">
                        <div class="text-center my-5">
                            <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">學生填寫</span></label>
                        </div>
                    </div>
                    <div class="card mb-4">
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">校外賃居資料</span></label><br>
                    <p></p>

                    <div class="form-row">
                        <label for="landlord_name"><span style="color: black; font-weight: bold;">房東姓名：</span></label>
                        <input type="text" id="landlord_name" name="landlord_name" value="<?php echo $landlord_name; ?>" class="underline-input" readonly>
                        
                        <label for="landlord_phone"><span style="color: black; font-weight: bold;">房東電話：</span></label>
                        <input type="text" id="landlord_phone" name="landlord_phone" value="<?php echo $landlord_phone; ?>" class="underline-input" readonly>

                        <label for="address"><span style="color: black; font-weight: bold;">租賃地址：</span></label>
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>" class="underline-input" style="width: 400px;" readonly><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租屋型態：</span>
                        </label>

                        <input type="radio" id="detached" name="housing_type" value="獨棟透天" <?php if($housing_type == "獨棟透天") echo "checked"; ?> disabled>
                        <label for="detached" style="margin-right: 10px; <?php if($housing_type == "獨棟透天") echo "color: blue;"; ?>">獨棟透天</label>

                        <input type="radio" id="apartment" name="housing_type" value="公寓(五樓以下)" <?php if($housing_type == "公寓(五樓以下)") echo "checked"; ?> disabled>
                        <label for="apartment" style="margin-right: 10px; <?php if($housing_type == "公寓(五樓以下)") echo "color: blue;"; ?>">公寓(五樓以下)</label>

                        <input type="radio" id="highrise" name="housing_type" value="大樓(六樓以上)" <?php if($housing_type == "大樓(六樓以上)") echo "checked"; ?> disabled>
                        <label for="highrise" style="margin-right: 10px; <?php if($housing_type == "大樓(六樓以上)") echo "color: blue;"; ?>">大樓(六樓以上)</label>

                        <input type="radio" id="dorm" name="housing_type" value="大型學舍(為學生建設的宿舍)" <?php if($housing_type == "大型學舍(為學生建設的宿舍)") echo "checked"; ?> disabled>
                        <label for="dorm" style="margin-right: 10px; <?php if($housing_type == "大型學舍(為學生建設的宿舍)") echo "color: blue;"; ?>">大型學舍(為學生建設的宿舍)</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="room_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間類型：</span>
                        </label>

                        <input type="radio" id="suite" name="room_type" value="套房" <?php if($housing_type == "套房") echo "checked"; ?> disabled>
                        <label for="suite" style="margin-right: 10px; <?php if($room_type == "套房") echo "color: blue;"; ?>">套房</label>

                        <input type="radio" id="elegant_house" name="room_type" value="雅房" <?php if($housing_type == "雅房") echo "checked"; ?> disabled>
                        <label for="elegant_house" style="margin-right: 10px; <?php if($room_type == "雅房") echo "color: blue;"; ?>">雅房</label><br><br>
                    </div>

                    <div class="form-row">
                        <label for="rent"><span style="color: black; font-weight: bold;">每月租金：</span></label>
                        <input type="text" id="rent" name="rent" value="<?php echo $money; ?>" class="underline-input" readonly>
                        
                        <label for="deposit"><span style="color: black; font-weight: bold;">押金：</span></label>
                        <input type="text" id="deposit" name="deposit" value="<?php echo $deposit; ?>" class="underline-input" readonly>

                        <label for="Q0" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否推薦其他同學租賃？</span>
                        </label>

                        <input type="radio" id="yes0" name="Q0" value="是" <?php if($q0 == "是") echo "checked"; ?> disabled>
                        <label for="yes0" style="margin-right: 10px; <?php if($q0 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no0" name="Q0" value="否" <?php if($q1 == "否") echo "checked"; ?> disabled>
                        <label for="no0" style="margin-right: 10px; <?php if($q0 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    </div>
                    <div class="card mb-4">
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">賃居安全自主管理檢視資料</span></label><br>
                    <p></p>

                    <div class="form-row">
                        <label for="Q1" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所消防設備是否符合標準：</span>
                        </label>

                        <input type="radio" id="yes1" name="Q1" value="是" <?php if($q1 == "是") echo "checked"; ?> disabled>
                        <label for="yes1" style="margin-right: 10px; <?php if($q1 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no1" name="Q1" value="否" <?php if($q1 == "否") echo "checked"; ?> disabled>
                        <label for="no1" style="margin-right: 10px; <?php if($q1 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有火災警報器：</span>
                        </label>

                        <input type="radio" id="yes2" name="Q2" value="是" <?php if($q2 == "是") echo "checked"; ?> disabled>
                        <label for="yes2" style="margin-right: 10px; <?php if($q2 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no2" name="Q2" value="否" <?php if($q2 == "否") echo "checked"; ?> disabled>
                        <label for="no2" style="margin-right: 10px; <?php if($q2 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有消防栓、滅火器：</span>
                        </label>

                        <input type="radio" id="yes3" name="Q3" value="是" <?php if($q3 == "是") echo "checked"; ?> disabled>
                        <label for="yes3" style="margin-right: 10px; <?php if($q3 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no3" name="Q3" value="否" <?php if($q3 == "否") echo "checked"; ?> disabled>
                        <label for="no3" style="margin-right: 10px; <?php if($q3 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">有防火避難方向標示、逃生設備：</span>
                        </label>

                        <input type="radio" id="yes4" name="Q4" value="是" <?php if($q4 == "是") echo "checked"; ?> disabled>
                        <label for="yes4" style="margin-right: 10px; <?php if($q4 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no4" name="Q4" value="否" <?php if($q4 == "否") echo "checked"; ?> disabled>
                        <label for="no4" style="margin-right: 10px; <?php if($q4 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房東或租賃處所是否有投保火災保險：</span>
                        </label>

                        <input type="radio" id="yes5" name="Q5" value="是" <?php if($q5 == "是") echo "checked"; ?> disabled>
                        <label for="yes5" style="margin-right: 10px; <?php if($q5 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no5" name="Q5" value="否" <?php if($q5 == "否") echo "checked"; ?> disabled>
                        <label for="no5" style="margin-right: 10px; <?php if($q5 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">電線走火是否為套管走火或有整齊固定：</span>
                        </label>

                        <input type="radio" id="yes6" name="Q6" value="是" <?php if($q6 == "是") echo "checked"; ?> disabled>
                        <label for="yes6" style="margin-right: 10px; <?php if($q6 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no6" name="Q6" value="否" <?php if($q6 == "否") echo "checked"; ?> disabled>
                        <label for="no6" style="margin-right: 10px; <?php if($q6 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">大樓出入口或主要出口是否有鐵捲門或鐵柵門：</span>
                        </label>

                        <input type="radio" id="yes7" name="Q7" value="是" <?php if($q7 == "是") echo "checked"; ?> disabled>
                        <label for="yes7" style="margin-right: 10px; <?php if($q7 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no7" name="Q7" value="否" <?php if($q7 == "否") echo "checked"; ?> disabled>
                        <label for="no7" style="margin-right: 10px; <?php if($q7 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所是否有公安檢查合格或其他相關證明：</span>
                        </label>

                        <input type="radio" id="yes8" name="Q8" value="是" <?php if($q8 == "是") echo "checked"; ?> disabled>
                        <label for="yes8" style="margin-right: 10px; <?php if($q8 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no8" name="Q8" value="否" <?php if($q8 == "否") echo "checked"; ?> disabled>
                        <label for="no8" style="margin-right: 10px; <?php if($q8 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">是否有對外窗戶或通風口：</span>
                        </label>

                        <input type="radio" id="yes9" name="Q9" value="是" <?php if($q9 == "是") echo "checked"; ?> disabled>
                        <label for="yes9" style="margin-right: 10px; <?php if($q9 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no9" name="Q9" value="否" <?php if($q9 == "否") echo "checked"; ?> disabled>
                        <label for="no9" style="margin-right: 10px; <?php if($q9 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間內是否有廚房、瓦斯爐具：</span>
                        </label>

                        <input type="radio" id="yes10" name="Q10" value="是" <?php if($q10 == "是") echo "checked"; ?> disabled>
                        <label for="yes10" style="margin-right: 10px; <?php if($q10 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no10" name="Q10" value="否" <?php if($q10 == "否") echo "checked"; ?> disabled>
                        <label for="no10" style="margin-right: 10px; <?php if($q10 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間是否設置簡易型瓦斯警報器：</span>
                        </label>

                        <input type="radio" id="yes11" name="Q11" value="是" <?php if($q11 == "是") echo "checked"; ?> disabled>
                        <label for="yes11" style="margin-right: 10px; <?php if($q11 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no11" name="Q11" value="否" <?php if($q11 == "否") echo "checked"; ?> disabled>
                        <label for="no11" style="margin-right: 10px; <?php if($q11 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">房間內是否有配置飲水機：</span>
                        </label>

                        <input type="radio" id="yes12" name="Q12" value="是" <?php if($q12 == "是") echo "checked"; ?> disabled>
                        <label for="yes12" style="margin-right: 10px; <?php if($q12 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no12" name="Q12" value="否" <?php if($q12 == "否") echo "checked"; ?> disabled>
                        <label for="no12" style="margin-right: 10px; <?php if($q12 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="title" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">租賃處所附近生活機能良好：</span>
                        </label>

                        <input type="radio" id="yes13" name="Q13" value="是" <?php if($q13 == "是") echo "checked"; ?> disabled>
                        <label for="yes13" style="margin-right: 10px; <?php if($q13 == "是") echo "color: blue"; ?>">是</label>

                        <input type="radio" id="no13" name="Q13" value="否" <?php if($q13 == "否") echo "checked"; ?> disabled>
                        <label for="no13" style="margin-right: 10px; <?php if($q13 == "否") echo "color: blue"; ?>">否</label><br><br>
                    </div>
                    </div>
                    <div class="card mb-4">
                        <div class="text-center my-5">
                            <label for="s_uid"><span style="color: black; font-weight: bold; font-size: 20px;">導師填寫</span></label>
                        </div>
                    </div>
                    <div class="card mb-4">
                    <label for="title"><span style="color: black; font-weight: bold; font-size: 30px;">環境及作息評估</span></label>
                    <p></p>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">押金要求：</span>
                        </label>

                        <input type="radio" id="makesense" name="tq0" value="合理" <?php if($tq0 == "合理") echo "checked"; ?> disabled>
                        <label for="makesense" style="margin-right: 10px; <?php if($tq0 == "合理") echo "color: blue"; ?>">合理</label>

                        <input type="radio" id="nonsense" name="tq0" value="不合理(兩個月以上租金)" <?php if($tq0 == "不合理(兩個月以上租金)") echo "checked"; ?> disabled>
                        <label for="nonsense" style="margin-right: 10px; <?php if($tq0 == "不合理(兩個月以上租金)") echo "color: blue"; ?>">不合理(兩個月以上租金)</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">水電費要求：</span>
                        </label>

                        <input type="radio" id="makesense1" name="tq1" value="合理" <?php if($tq1 == "合理") echo "checked"; ?> disabled>
                        <label for="makesense1" style="margin-right: 10px; <?php if($tq1 == "合理") echo "color: blue"; ?>">合理</label>

                        <input type="radio" id="nonsense1" name="tq1" value="不合理" <?php if($tq1 == "不合理") echo "checked"; ?> disabled>
                        <label for="nonsense1" style="margin-right: 10px; <?php if($tq1 == "不合理") echo "color: blue"; ?>">不合理</label><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">居家環境：</span>
                        </label>

                        <input type="radio" id="makesense2" name="tq2" value="佳" <?php if($tq2 == "佳") echo "checked"; ?> disabled>
                        <label for="makesense2" style="margin-right: 10px; <?php if($tq2 == "佳") echo "color: blue"; ?>">佳</label>

                        <input type="radio" id="soso2" name="tq2" value="適中" <?php if($tq2 == "適中") echo "checked"; ?> disabled>
                        <label for="soso2" style="margin-right: 10px; <?php if($tq2 == "適中") echo "color: blue"; ?>">適中</label>

                        <input type="radio" id="nonsense2" name="tq2" value="欠佳" <?php if($tq2 == "欠佳") echo "checked"; ?> disabled>
                        <label for="nonsense2" style="margin-right: 10px; <?php if($tq2 == "欠佳") echo "color: blue"; ?>">欠佳</label>

                        <label for="tq2_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq2_detail" name="tq2_detail " value="<?php if($tq2_detail){echo $tq2_detail;}else{echo('無');} ?>" class="underline-input" readonly><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">生活設施：</span>
                        </label>

                        <input type="radio" id="makesense3" name="tq3" value="佳" <?php if($tq3 == "佳") echo "checked"; ?> disabled>
                        <label for="makesense3" style="margin-right: 10px; <?php if($tq3 == "佳") echo "color: blue"; ?>">佳</label>

                        <input type="radio" id="soso3" name="tq3" value="適中" <?php if($tq3 == "適中") echo "checked"; ?> disabled>
                        <label for="soso3" style="margin-right: 10px; <?php if($tq3 == "適中") echo "color: blue"; ?>">適中</label>

                        <input type="radio" id="nonsense3" name="tq3" value="欠佳" <?php if($tq3 == "欠佳") echo "checked"; ?> disabled>
                        <label for="nonsense3" style="margin-right: 10px; <?php if($tq3 == "欠佳") echo "color: blue"; ?>">欠佳</label>

                        <label for="tq3_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq3_detail" name="tq3_detail" value="<?php if($tq3_detail){echo $tq3_detail;}else{echo('無');} ?>" class="underline-input" readonly><br><br>
                    </div>
                    
                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">訪視現況：</span>
                        </label>

                        <input type="radio" id="makesense4" name="tq4" value="生活規律" <?php if($tq4 == "生活規律") echo "checked"; ?> disabled>
                        <label for="makesense4" style="margin-right: 10px; <?php if($tq4 == "生活規律") echo "color: blue"; ?>">生活規律</label>

                        <input type="radio" id="soso4" name="tq4" value="適中" <?php if($tq4 == "適中") echo "checked"; ?> disabled>
                        <label for="soso4" style="margin-right: 10px; <?php if($tq4 == "適中") echo "color: blue"; ?>">適中</label>

                        <input type="radio" id="nonsense4" name="tq4" value="待加強" <?php if($tq4 == "待加強") echo "checked"; ?> disabled>
                        <label for="nonsense4" style="margin-right: 10px; <?php if($tq4 == "待加強") echo "color: blue"; ?>">待加強</label>

                        <label for="tq4_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq4_detail" name="tq4_detail" value="<?php if($tq4_detail){echo $tq4_detail;}else{echo('無');} ?>" class="underline-input" readonly><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">
                        <label for="housing_type" style="margin-right: 10px;">
                            <span style="color: black; font-weight: bold;">主客相處：</span>
                        </label>

                        <input type="radio" id="makesense5" name="tq5" value="和睦" <?php if($tq5 == "和睦") echo "checked"; ?> disabled>
                        <label for="makesense5" style="margin-right: 10px; <?php if($tq5 == "和睦") echo "color: blue"; ?>">和睦</label>

                        <input type="radio" id="nonsense5" name="tq5" value="欠佳" <?php if($tq5 == "欠佳") echo "checked"; ?> disabled>
                        <label for="nonsense5" style="margin-right: 10px; <?php if($tq5 == "欠佳") echo "color: blue"; ?>">欠佳</label><br><br>
                    </div>


                    <div class="form-row" style="display: flex; align-items: center;">
                    <label for="housing_type" style="margin-right: 10px;">
                        <span style="color: black; font-weight: bold;">訪視結果：</span>
                    </label>

                        <input type="radio" id="makesense6" name="tq6" value="整體賃居狀況良好" <?php if($tq6 == "整體賃居狀況良好") echo "checked"; ?> disabled>
                        <label for="makesense6" style="margin-right: 10px; <?php if($tq6 == "整體賃居狀況良好") echo "color: blue"; ?>">整體賃居狀況良好</label>

                        <input type="radio" id="soso6" name="tq6" value="聯繫家長關注" <?php if($tq6 == "聯繫家長關注") echo "checked"; ?> disabled>
                        <label for="soso6" style="margin-right: 10px; <?php if($tq6 == "聯繫家長關注") echo "color: blue"; ?>">聯繫家長關注</label>

                        <input type="radio" id="nonsense6" name="tq6" value="安全堪慮請協助" <?php if($tq6 == "安全堪慮請協助") echo "checked"; ?> disabled>
                        <label for="nonsense6" style="margin-right: 10px; <?php if($tq6 == "安全堪慮請協助") echo "color: blue"; ?>">安全堪慮請協助</label>

                        <input type="radio" id="else6" name="tq6" value="其他" <?php if($tq6 == "其他") echo "checked"; ?> disabled>
                        <label for="else6" style="margin-right: 10px; <?php if($tq6 == "其他") echo "color: blue"; ?>">其他</label>

                        <label for="tq6_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq6_detail" name="tq6_detail" value="<?php if($tq6_detail){echo $tq6_detail;}else{echo('無');} ?>" class="underline-input" readonly><br><br>
                    </div>

                    <div class="form-row" style="display: flex; align-items: center;">

                        <label for="tq7"><span style="color: black; font-weight: bold;">其他記載或建議事項：</span></label>
                        <input type="text" id="tq7" name="tq7" value="<?php if($tq7){echo $tq7;}else{echo('無');} ?>" class="underline-input" readonly><br><br>

                    </div>

                    <label for="title"><span style="color: black; font-weight: bold; ">關懷宣導項目(懇請導師賃居訪視時多與關懷叮嚀)：</span></label>

                    <div class="form-row" style="display: flex; align-items: center;">

                        <input type="radio" id="traffic" name="tq8_1" value="交通安全" <?php if($tq8_1 == "交通安全") echo "checked"; ?> disabled>
                        <label for="traffic" style="margin-right: 10px; <?php if($tq8_1 == "交通安全") echo "color: blue"; ?>">交通安全</label>

                        <input type="radio" id="nosmoke" name="tq8_2" value="拒絕菸害" <?php if($tq8_2 == "拒絕菸害") echo "checked"; ?> disabled>
                        <label for="nosmoke" style="margin-right: 10px; <?php if($tq8_2 == "拒絕菸害") echo "color: blue"; ?>">拒絕菸害</label>

                        <input type="radio" id="nodrug" name="tq8_3" value="拒絕毒品" <?php if($tq8_3 == "拒絕毒品") echo "checked"; ?> disabled>
                        <label for="nodrug" style="margin-right: 10px; <?php if($tq8_3 == "拒絕毒品") echo "color: blue"; ?>">拒絕毒品</label>

                        <input type="radio" id="nomosquito" name="tq8_4" value="登革熱防治" <?php if($tq8_4 == "登革熱防治") echo "checked"; ?> disabled>
                        <label for="nomosquito" style="margin-right: 10px; <?php if($tq8_4 == "登革熱防治") echo "color: blue"; ?>">登革熱防治</label>

                        <input type="radio" id="else8" name="tq8_5" value="其他" <?php if($tq8_5 == "其他") echo "checked"; ?> disabled>
                        <label for="else8" style="margin-right: 10px; <?php if($tq8_5 == "其他") echo "color: blue"; ?>">其他</label>

                        <label for="tq8_detail"><span style="color: black; font-weight: bold;">說明：</span></label>
                        <input type="text" id="tq8_detail" name="tq8_detail" value="<?php if($tq8_detail){echo $tq8_detail;}else{echo('無');} ?>" class="underline-input" readonly><br><br>
                    </div>
                    </div>
                </form>
            </div>
            <?php }?>
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