<?php
    session_start();
    $id ='';
    $password='';
    $errors = ['id'=>'','password'=>''];
    if(isset($_POST['submit'])){
        if(empty($_POST['id'])){
            $errors['id'] = '*You need to enter an ID number';
        } else{
            $id=$_POST['id'];
        }
        if(empty($_POST['password'])){
            $errors['password'] = '*You need to enter a password';
        }else{
            $password=$_POST['password'];
        }
        // check if there are any errors, if not, do:
        if(!array_filter($errors)){
            // connect to db
            $conn = mysqli_connect('localhost','myuser','reii414','medicaldb');
            //check connect
            if(!$conn){
                echo 'Connection error: ' . mysql_connect_error();
            }
            
            //get data from table
            $sql = "SELECT pat_id, pat_name, pat_surname, pat_role FROM patients WHERE pat_id='$id' AND pat_passw='$password'";
            $result = mysqli_query($conn, $sql);

            //get data from result
            $user = mysqli_fetch_all($result,MYSQLI_ASSOC);
            $_SESSION['User']=$user;
            //free result from memory
            mysqli_free_result($result);

            //close the connection
            mysqli_close($conn);
            if($user[0]['pat_role']=="Government"){
                header('Location: http://35.223.253.147/reiiprak/government.php');
            }elseif($user[0]['pat_role']=="Doctor"){
                header('Location: http://35.223.253.147/reiiprak/doctor.php');
            }elseif($user[0]['pat_role']=="Pharmacists"){
                header('Location: http://35.223.253.147/reiiprak/pharmacist.php');
            }elseif($user[0]['pat_role']=="Patient"){
                header('Location: http://35.223.253.147/reiiprak/patient.php');
            }
            
            // print_r($use);
        }
        
    }

    // if(isset($_GET['logout'])){
    //     session_destroy();
    //     unset($_SESSION['username']);
    //     header('location: index.php');
    // }
?>


<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>

    <section class="container">
        <h4 class="center ">Please enter your login details below.</h4>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <label>ID number</label>
            <input type="text" name="id" id="id" value="<?php echo $id ?>">
            <div class="red-text"><?php echo $errors['id']; ?></div>
            <label>Password</label>
            <input type="password" name="password" id="password" value="<?php echo $password ?>">
            <div class="red-text"><?php echo $errors['password']; ?></div>
            <div class="center">
                <input type="submit" name= "submit" value="Login" class="btn mycolor">
            </div>

        </form>

    </section>
       
    <?php include('templates/footer.php'); ?>
</html>