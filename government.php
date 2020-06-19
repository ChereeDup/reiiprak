<?php
    session_start();
    $user = $_SESSION['User'];
    $username= $user[0]['pat_name'];
    $usersurname = $user[0]['pat_surname'];

    $id ='';
    $password='';
    $name ='';
    $surname ='';
    $date ='';
    $gender = '';
    $race = '';
    $addr1 = '';
    $addr2 = '';
    $city = '';
    $output = 'No changes have been made';
    
    $errors = ['id'=>'','name'=>'','surname'=>'','date'=>'','gender'=>'','race'=>'','addr1'=>'','city'=>''];
    if(isset($_POST['submitBirth'])){
        if(empty($_POST['id'])){
            $errors['id'] = '*You need to enter an ID number';
        } else{
            $id=$_POST['id'];
        }
        if(empty($_POST['name'])){
            $errors['name'] = '*You need to enter a name';
        }else{
            $name=$_POST['name'];
        }
        if(empty($_POST['surname'])){
            $errors['surname'] = '*You need to enter a surname';
        }else{
            $surname=$_POST['surname'];
        }
        if(empty($_POST['date'])){
            $errors['date'] = '*You need to enter a date';
        }else{
            $date=$_POST['date'];
        }
        if(empty($_POST['gender'])){
            $errors['gender'] = '*You need to enter a gender';
        }else{
            $gender=$_POST['gender'];
        }
        if(empty($_POST['race'])){
            $errors['race'] = '*You need to enter a race';
        }else{
            $race=$_POST['race'];
        }
        if(empty($_POST['addr1'])){
            $errors['addr1'] = '*You need to enter a street';
        }else{
            $addr1=$_POST['addr1'];
        }
        
        $password = $_POST['id'];
        $addr2 = $_POST['addr2'];
        $role = 'Patient';
        $city = 'Potchefstroom';


        if(!array_filter($errors)){
            // connect to db
            $conn = mysqli_connect('localhost','myuser','reii414','medicaldb');
            //check connect
            if(!$conn){
                echo 'Connection error: ' . mysql_connect_error();
            }
      
            // POST data from table
            $sql = "INSERT INTO patients(pat_id, pat_passw, pat_surname, pat_name, pat_birthdate, pat_gender, pat_race, pat_role, addr_street, addr_subburb, addr_city) VALUES('$id','$password','$surname','$name','$date','$gender','$race','$role','$addr1','$addr2','$city')";

            if(mysqli_query($conn, $sql)){
                $output = "Records sucessfully updated";
            }else{
                $output = 'Query error: '.mysqli_error($conn);
            }
    
            //close the connection
            mysqli_close($conn);
            
            // print_r($use);
        }
    }
    

?>

<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>

    <h4 class='center'>Welcome, <?php echo $username ?>  <?php echo $usersurname ?></h4>
    <a href="patient.php">Personal Page</a>
    <h4 class='center red-text'>Government Access</h4>
    <p class='red-text'><?php echo $output ?></p>
    <div class='center'>
        <h3 class='center'>Issue Birth Certificate</h3>
        <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <h4>ID number</h4>
            <input type="text" name="id" id="id">
            <div class="red-text"><?php echo $errors['id']; ?></div>
            <h4>Name</h4>
            <input type="text" name="name" id="name">
            <div class="red-text"><?php echo $errors['name']; ?></div>
            <h4>Surname</h4>
            <input type="text" name="surname" id="surname">
            <div class="red-text"><?php echo $errors['surname']; ?></div>
            <h4>Date of Birth</h4>
            <input type="date" name="date" id="date" class="center">
            <div class="red-text"><?php echo $errors['date']; ?></div>
            <h4>Gender</h4><br>
                <label>    
                <input type="radio" id="male" name="gender" value="Male">
                <span>Male</span>
                </label><br>

                <label> 
                <input type="radio" id="female" name="gender" value="Female">
                <span>Female</span>
                </label><br>

                <label> 
                <input type="radio" id="other" name="gender" value="Other">
                <span>Other</span>
                </label>
                <div class="red-text"><?php echo $errors['gender']; ?></div>
            <h4>Race</h4>
            
                <label>    
                <input type="radio" id="white" name="race" value="White">
                <span>White</span>
                </label><br>

                <label> 
                <input type="radio" id="black" name="race" value="Black">
                <span>Black</span>
                </label><br>

                <label> 
                <input type="radio" id="coloured" name="race" value="Coloured">
                <span>Coloured</span>
                </label><br>

                <label> 
                <input type="radio" id="indian" name="race" value="Indian">
                <span>Indian</span>
                </label><br>

                <label> 
                <input type="radio" id="other" name="race" value="Other">
                <span>Other</span>
                </label><br>
                <div class="red-text"><?php echo $errors['race']; ?></div>
            <h4>Address</h4>
            
            <h4>Street</h4>
            <input type="text" name="addr1" id="addr1">
            <div class="red-text"><?php echo $errors['addr1']; ?></div>
            <h4>Suburb</h4>
            <input type="text" name="addr2" id="addr2">
            <!-- <h4>City</h4>
            <input type="text" name="city" id="city"> -->
            <label><h4>Please inform the parents of the child to complete all other information when available</h4></label>
            <div class="center">
                <input type="submit" name= "submitBirth" value="Create" class="btn mycolor">
            </div>

            
        </form>

    </div>

    <div class='center'>
        <h3 class='center'>Issue Death Certificate</h3>
        <form action="" method="POST">
            <h4>ID number</h4>
            <input type="text" name="id" id="id">
            <h4>Date of Death</h4>
            <input type="date" name="date" id="date" class="center">
            <h4>Cause of Death</h4>
            <input type="text" name="cause" id="cause">
            <div class="center">
                <input type="submit" name= "submitDeath" value="Create" class="btn">
            </div>

        </form> 
    </div>
    <div>
            <ul>
                <li><a href="index.php">Log Out</a></li>
            </ul>
        </div>
    <?php include('templates/footer.php'); ?>


    
</html>