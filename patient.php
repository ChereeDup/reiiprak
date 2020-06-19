<?php
    session_start();
    $patient = $_SESSION['User'];
    $id = $patient[0]['pat_id'];
    $name= $patient[0]['pat_name'];
    $surname = $patient[0]['pat_surname'];


?>

<!DOCTYPE html>
<html>
    <?php include('templates/header.php');
        include('myFunctions.php');
    ?>
        <h4 class='center'>Welcome, <?php echo $name ?>  <?php echo $surname ?></h4>
        <?php personalinfo($id); 
            medicalhistory($id);
        ?> 
        <div>
            <ul>
                <li><a href="index.php">Log Out</a></li>
            </ul>
        </div>
        
    <?php include('templates/footer.php'); ?>
</html>