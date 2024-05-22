<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ad Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container">
        <h1 class="mt-5"></h1>
        <?php
        if (isset($_GET["r_place"])) {
            $r_place = $_GET["r_place"];

            $sql = "SELECT * FROM ad WHERE r_place = :r_place";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":r_place", $r_place);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo "<h2>" . htmlspecialchars($r_place) . "</h2>";
                
                echo "<p>規格：" . htmlspecialchars($row["r_format"]) . "</p>";
                echo "<p>租金： " . htmlspecialchars($row["r_money"]) . "</p>";
                echo "<p>押金： " . htmlspecialchars($row["r_deposit"]) . "</p>";
                echo "<p>水電費： " . htmlspecialchars($row["r_utilitybill"]) . "</p>";
                echo "<p>其他說明： " . htmlspecialchars($row["r_else"]) . "</p>";
                echo "<p>實景照： " . htmlspecialchars($row["r_else"]) . "</p>";

                $imgStyle = 'style="max-width:400px; max-height:400px; margin: 10px;"';
                
                if (!empty($row["r_post"])) {
                    echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($row["r_post"]) . '" ' . $imgStyle . ' /><br>';
                }
                if (!empty($row["r_photo1"])) {
                    echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($row["r_photo1"]) . '" ' . $imgStyle . ' /><br>';
                }
                if (!empty($row["r_photo2"])) {
                    echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($row["r_photo2"]) . '" ' . $imgStyle . ' /><br>';
                }
                if (!empty($row["r_photo3"])) {
                    echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($row["r_photo3"]) . '" ' . $imgStyle . ' /><br>';
                }
                if (!empty($row["r_photo4"])) {
                    echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($row["r_photo4"]) . '" ' . $imgStyle . ' /><br>';
                }
            } else {
                echo "No details found for r_place: " . htmlspecialchars($r_place);
            }
        } else {
            echo "No r_place specified.";
        }
        $conn = null;
        ?>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
