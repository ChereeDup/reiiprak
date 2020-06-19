<?php
function personalinfo($id){ 
    $conn = mysqli_connect('localhost','myuser','reii414','medicaldb');
    if(!$conn){
        echo 'Connection error: ' . mysql_connect_error();
    }
    $sql = "SELECT * FROM patients WHERE pat_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $patient = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
    echo "<div class='center'>";
    echo "<h3 class='center'>Personal Info</h3>";
        echo "<div class='center white'>";
            echo "<p class='left-align'>Name: ".$patient[0]['pat_name']." ".$patient[0]['pat_surname']."</p>" ;   
            echo "<p class='left-align'>Date of Birth: ".$patient[0]['pat_birthdate']."</p>";
            echo "<p class='left-align'>Gender: ".$patient[0]['pat_gender']."</p>";
            echo "<p class='left-align'>Race: ".$patient[0]['pat_race']."</p>";
            echo "<p class='left-align'>Address:</p>";
            echo "<p class='left-align'>".$patient[0]['addr_street']."</p>";
            echo "<p class='left-align'>".$patient[0]['addr_subburb']."</p>";
            echo "<p class='left-align'>".$patient[0]['addr_city']."</p>";
            echo "<p class='left-align'>Phone Number: ".$patient[0]['pat_phone']."</p>";
            echo "<p class='left-align'>Email: ".$patient[0]['pat_email']."</p>";
            echo "<p class='left-align'>Medical Aid:</p>";
            echo "<p class='left-align'>".$patient[0]['pat_aid']."</p>";
            echo "<p class='left-align'>".$patient[0]['aid_num']."</p>";
            echo "<p class='left-align'>".$patient[0]['pat_plan']."</p>";
            echo "<p class='left-align'>House Doctor: ".$patient[0]['pat_doc']."</p>";
            echo "<p class='left-align'>Doctor with Temporary Access: ".$patient[0]['doc_auth']."</p>";
            echo "<p class='left-align'>Pharmacist with Temporary Access: ".$patient[0]['pharm_auth']."</p>";        
        echo "</div>";
    echo "</div>";
} 


function medicalhistory($id){ 
    $conn = mysqli_connect('localhost','myuser','reii414','medicaldb');
    if(!$conn){
        echo 'Connection error: ' . mysql_connect_error();
    }
    $sql = "SELECT * FROM history WHERE pat_id = '$id'";
    $result = mysqli_query($conn, $sql);
    $drvisits = mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
    echo "<div class='center'>";
    echo "<h3 class='center'>Medical History</h3>";
        echo "<div class='center white'>";
            echo "<div  class = 'tablecontent'>";
                echo "<table id = 'table'>";
                    echo "<tr>";
                        echo "<th>Consultation Date</th>";
                        echo "<th>Physician</th>";
                        echo "<th>Practice Number</th>";
                        echo "<th>Symptoms</th>";
                        echo "<th>Lab Tests</th>";
                        echo "<th>Lab Results</th>";
                        echo "<th>Prescription</th>";
                        echo "<th>Number of Repetitions</th>";
                    echo "</tr>";
                    foreach($drvisits as $visit){
                        echo"<tr><td>".$visit['disease_date']."</td><td>" .$visit['doc_name']."</td><td>" .$visit['doc_num']."</td><td>" .$visit['patient_symptom']."</td><td>" .$visit['lab_test']."</td><td>" 
                        .$visit['lab_result']."</td><td>" .$visit['doctor_prescript']."</td><td>" .$visit['prescript_rep']."</td></tr>";
                    }
                echo "</table>";
            echo "</div>";
        echo "</div>";
    echo "</div>";
} 
?>