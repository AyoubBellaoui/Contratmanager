<?php
  require ("../Connection/Config.php");
  
    #if I click on delete button 
    if(isset($_GET['id'])){
        # prepare a delete statement
        $query = "DELETE FROM contrat WHERE ID_CT  = " . (int)$_GET['id'];
        if (mysqli_query($db,$query)) {
          header("location: Contrats.php");
        } else {
          echo "Error deleting record: " . mysqli_error($db);
        }
  }
    
  mysqli_close($db);
?>