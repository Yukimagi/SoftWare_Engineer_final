<script src="../js/scripts.js"></script>
<?php
include("connection.php");

session_start();
if(isset( $_POST['uid'])){
    $uid = $_POST['uid'];
    $identity = $_POST['identity'];

    switch ($identity){
        case 'T':
            $sql0 = 'SELECT COUNT(*) FROM teacher_profile WHERE t_uid = :uid';
            $sql1 = 'DELETE FROM teacher_profile WHERE t_uid = :uid';
            $sql2 = 'DELETE FROM user_profile WHERE uid = :uid';
            break;

        case 'L':
            $sql0 = 'SELECT COUNT(*) FROM landlord WHERE uid = :uid';
            $sql1 = 'DELETE FROM landlord WHERE uid = :uid';
            $sql2 = 'DELETE FROM user_profile WHERE uid = :uid';
            break;

        case 'S':
            $sql0 = 'SELECT COUNT(*) FROM basicinfo WHERE uid = :uid';
            $sql1 = 'DELETE FROM basicinfo WHERE uid = :uid';
            $sql2 = 'DELETE FROM user_profile WHERE uid = :uid';
            break;
    }
    $stmt0 = $conn->prepare($sql0);
    $stmt2 = $conn->prepare($sql2);
    $stmt0->bindParam(':uid', $uid);
    $stmt2->bindParam(':uid', $uid);

    $stmt0->execute();
    $count = $stmt0->fetchColumn();
    if($count !== 0){
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bindParam(':uid', $uid);
        if($stmt1->execute()){
            if($stmt2->execute()){
                echo '<script>deletemsg()</script>';
            }else{
                echo '<script>warning5()</script>';
            }
        }else{
            echo '<script>warning5()</script>';
        }
    }else{
        if($stmt2->execute()){
            echo '<script>deletemsg()</script>';
        }else{
            echo '<script>warning5()</script>';
        }
    }
/*
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
*/
}else{

}
?>
