<?php
session_start();
    $user = $_SESSION['User'];
    $username = $user[0]['pat_name'];
    $usersurname = $user[0]['pat_surname'];
    $userid = $user[0]['pat_id'];

    $id ='';
    $prescript ='';

    $output = 'No changes have been made';
    
    $errors = ['id'=>'','symptoms'=>'','prescript'=>'','reps'=>'','date'=>'','docnum'=>''];
    if(isset($_POST['submit'])){
        if(empty($_POST['id'])){
            $errors['id'] = '*You need to enter an ID number';
        } else{
            $id=$_POST['id'];
        }

        if(empty($_POST['prescript'])){
            $errors['prescript'] = '*You need to enter a prescription';
        }else{
            $prescript=$_POST['prescript'];
        }


        if(!array_filter($errors)){
            // connect to db
            $conn = mysqli_connect('localhost','myuser','reii414','medicaldb');
            //check connect
            if(!$conn){
                echo 'Connection error: ' . mysql_connect_error();
            }
      
            // POST data from table
            $sql = "SELECT pharm_auth FROM patients WHERE pat_id='$id'";
            echo $sql;

            $result = mysqli_query($conn, $sql);
            $patient = mysqli_fetch_all($result,MYSQLI_ASSOC);

            $doc1 = $patient[0]['pharm_auth'];
            if($doc1==$userid ){
                $sql = "SELECT prescript_rep, entry_num FROM history WHERE pat_id='$id' AND doctor_prescript='$prescript'";
                echo $sql;
                $result = mysqli_query($conn, $sql);
                $prescrep = mysqli_fetch_all($result,MYSQLI_ASSOC);
                $rep = (int)($prescrep[0]['prescript_rep']);
                echo gettype ( $rep );
                $entrynum = $prescrep[0]['entry_num'];
                if($rep>0){
                    $rep-=1;
                    $sql1 = "UPDATE history SET prescript_rep='$rep' WHERE entry_num='$entrynum'";
                    if(mysqli_query($conn, $sql1)){
                        $output = "Records sucessfully updated";
                       }else{
                        $output = 'Query error: '.mysqli_error($conn);
                       }
                }else{
                    $output = 'Prescription already filled.';
                }
                
                 
            }else{
                $output = "Pharmasist does not have permission to edit records.";
            }
                //close the connection
                mysqli_close($conn);

        }

    }
    

?>
<!DOCTYPE html>
<html>
    <?php include('templates/header.php'); ?>
    <h4 class='center'>Welcome, <?php echo $username ?>  <?php echo $usersurname ?></h4>
    <a href="patient.php">Personal Page</a>
    <h4 class='center red-text'>Pharmacist Access</h4>
    <p class='red-text'><?php echo $output ?></p>
    <div class='center'>
        <h3 class='center'>Issue Patient Prescription</h3>
    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <h4>Patient ID number</h4>
            <input type="text" name="id" id="id">
            <div class="red-text"><?php echo $errors['id']; ?></div>
            <h4>Prescription</h4>
            <input type="text" name="prescript" id="prescript">
            <div class="red-text"><?php echo $errors['prescript']; ?></div>
            <div class="center">
                <input type="submit" name= "submit" value="Create Prescription" class="btn mycolor">
            </div>

            
        </form>
        <div>
            <ul>
                <li><a href="index.php">Log Out</a></li>
            </ul>
        </div>
    <?php include('templates/footer.php'); ?>
</html>