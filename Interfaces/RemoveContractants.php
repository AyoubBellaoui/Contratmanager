<?php
  require ("../Connection/Config.php");
  
    #if I click on delete button 
    if(isset($_GET['id'])){
        # prepare a delete statement
        $query = "DELETE FROM contractant WHERE ID_CTR  = " . (int)$_GET['id'];
        if (mysqli_query($db,$query)) {
          header("location: Contractants.php");
        } else {
          echo "<script>
                alert(' احذف العقد لهذا المتعاقد اولا!');
                window.location.href='../Interfaces/Contractants.php';
                </script>";
        }
  }
    
  mysqli_close($db);
?>