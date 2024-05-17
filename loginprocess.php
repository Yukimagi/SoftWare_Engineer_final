<script src="js/scripts.js"></script>
<?php
include("SAS/connection.php");

session_start();
$account = $_POST['account'];
$password = $_POST['password'];

$sql_query = "SELECT * FROM user_profile WHERE account = :account AND password = :password";
$result = $conn->prepare($sql_query);
$result->bindParam(":account", $account);
$result->bindParam(":password", $password);
$result->execute();

if($result->rowCount() == 1){
    $_SESSION['loggedin'] = 1;
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $_SESSION['uid'] = $row['uid'];
    $_SESSION['identity'] = $row['identity'];
    $uid = $row['uid'];
    $identity = $row['identity'];

    if (isset($identity) && $identity !== "SYS") {
        switch ($identity){
            case "S":
                $sql_query = "select name from basicinfo where uid= '$uid'";
                break;
            case "T":
                $sql_query = "select t_name as name from teacher_profile where t_uid='$uid'";
                break;
            case "L":
                $sql_query = "select l_name as name from landlord where uid='$uid'";
                break;
        }
        $result = $conn->query($sql_query);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $_SESSION['name'] = $row["name"];
    }elseif (isset($identity) && $identity == "SYS"){
        $_SESSION['name'] ='系統管理員';
    }
    header("location:lobby.php");
}else{
    echo '<script type="text/javascript">warning1()</script>';
}
$conn = null;
?>
