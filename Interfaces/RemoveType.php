<?php
  require ("../Connection/Config.php");

    #if I click on delete button 
    if(isset($_GET['id'])){
        # prepare a delete statement
        $query = "DELETE FROM type_contrat WHERE ID_TYPE  = " . (int)$_GET['id'];
        if (mysqli_query($db,$query)) {
          header("location: Types.php");
        } else {
          echo "Error deleting record: " . mysqli_error($db);
        }
  }
    
  mysqli_close($db);
?>