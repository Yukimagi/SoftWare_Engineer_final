<script src="js/scripts.js"></script>
<?php
include("connection.php");

session_start();
if(isset( $_POST['uid'])){
    $uid = $_POST['uid'];
    $identity = $_POST['identity'];

    switch ($identity){
        case 'T':
            $sql1 = 'DELETE FROM teacher_profile WHERE uid = "'.$uid.'"';
            $sql2 = 'DELETE FROM user_profile WHERE uid = "'.$uid.'"';
            break;

        case 'L':
            $sql1 = 'DELETE FROM landlord WHERE uid = "'.$uid.'"';
            $sql2 = 'DELETE FROM user_profile WHERE uid = "'.$uid.'"';
            break;

        case 'S':
            $sql1 = 'DELETE FROM basicinfo WHERE uid = "'.$uid.'"';
            $sql2 = 'DELETE FROM user_profile WHERE uid = "'.$uid.'"';
            break;
    }
    $stmt1 = $conn -> prepare($sql1);
    $stmt2 = $conn -> prepare($sql2);
    try{
        $stmt1 = $conn -> exec($sql1);

        try{
            $stmt2 = $conn -> exec($sql2);
            echo '<script>deletemsg()</script>';
        }catch (PDOException $e){
            echo '<script>warning5()</script>';
        }
    }catch (PDOException $e){
        echo '<script>warning6()</script>';
    }
}else{

}
?>
