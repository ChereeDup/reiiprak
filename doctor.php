<?php
session_start();
    $user = $_SESSION['User'];
    $username = $user[0]['pat_name'];
    $userid = $user[0]['pat_id'];
    $usersurname = $user[0]['pat_surname'];

    $id ='';
    $symptoms ='';
    $prescript ='';
    $reps ='';
    $date = date("Y-m-d");
    $docname = 'Dr. '.$usersurname;
    $docnum ='';
    $doc1 ='';
    $doc2 ='';

           
    $output = 'No changes have been made';
    
    $errors = ['id'=>'','symptoms'=>'','prescript'=>'','reps'=>'','date'=>'','docnum'=>''];
    if(isset($_POST['submit'])){
        if(empty($_POST['id'])){
            $errors['id'] = '*You need to enter an ID number';
        } else{
            $id=$_POST['id'];
        }
        if(empty($_POST['symptoms'])){
            $errors['symptoms'] = '*You need to enter a symptom';
        }else{
            $symptoms=$_POST['symptoms'];
        }

        if(empty($_POST['prescript'])){
            $errors['prescript'] = '*You need to enter a prescription';
        }else{
            $prescript=$_POST['prescript'];
        }

        if(empty($_POST['reps'])){
            $errors['reps'] = '*You need to enter the number of reps';
        }else{
            $reps=$_POST['reps'];
        }
        if(empty($_POST['docnum'])){
            $errors['docnum'] = '*You need to enter the number of reps';
        }else{
            $docnum=$_POST['docnum'];
        }
        
        


        if(!array_filter($errors)){
            // connect to db
            $conn = mysqli_connect('localhost','myuser','reii414','medicaldb');
            //check connect
            if(!$conn){
                echo 'Connection error: ' . mysql_connect_error();
            }
      
            // POST data from table
            $sql = "SELECT pat_doc,doc_auth FROM patients WHERE pat_id='$id'";
            
            $result = mysqli_query($conn, $sql);
            $patient = mysqli_fetch_all($result,MYSQLI_ASSOC);
            $doc1 = $patient[0]['pat_doc'];
            $doc2 = $patient[0]['doc_auth'];
            if(($doc1==$userid )||($doc2==$userid )){
                $sql1 = "INSERT INTO history(pat_id, disease_date, doc_num, doc_name, patient_symptom, doctor_prescript, prescript_rep) VALUES('$id','$date','$docnum','$docname','$symptoms','$prescript','$reps')";
                if(mysqli_query($conn, $sql1)){
                 $output = "Records sucessfully updated";
                }else{
                 $output = 'Query error: '.mysqli_error($conn);
                }
            }else{
                $output = "Doctor does not have permission to edit records.";
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
    <h4 class='center red-text'>Doctor Access</h4>
    <p class='red-text'><?php echo $output ?></p>
    <div class='center'>
        <h3 class='center'>Issue Patient Prescription</h3>
    <form  action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <h4>Doctor's Licence Number</h4>
            <input type="text" name="docnum" id="docnum">
            <div class="red-text"><?php echo $errors['docnum']; ?></div>
            <h4>Patient ID number</h4>
            <input type="text" name="id" id="id">
            <div class="red-text"><?php echo $errors['id']; ?></div>
            <h4>Symptoms</h4>
            <input type="text" name="symptoms" id="symptoms">
            <div class="red-text"><?php echo $errors['symptoms']; ?></div>
            <h4>Prescription</h4>
            <input type="text" name="prescript" id="prescript">
            <div class="red-text"><?php echo $errors['prescript']; ?></div>
            <h4>Number of Repetitions</h4>
            <input type="text" name="reps" id="reps">
            <div class="red-text"><?php echo $errors['reps']; ?></div>

        
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