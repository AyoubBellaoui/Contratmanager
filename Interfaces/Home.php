<?php
    ob_start();
    require ("../Includes/Links.php");
    require ("../Includes/Nav.php");
    require ("../Connection/Config.php");
      
    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: Login.php");
        exit;
    }
    ob_end_flush();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>تدبير العقود بالمعهد</title>
</head>
<body>
     <!-- Card Welcome username -->
     <div class="card" style="background-color: #f6f6f6;">
            <div class="card-header" style="background-color: #f6f6f6;">
            <h4>
            <span class="float-right"><strong>
            <span class="badge badge-lg badge-secondary text-black">
            <?php
            $username = $_SESSION['username']; 
            if (isset($username)) {
            echo $_SESSION['username'];
            }
            ?>
            </span>
            </strong>
            </span>
            <span class="float-left3"><h4 class="page_name">الصفحة الرئيسية </h4></span>
            </h4>
            </div>
        </div>
        <!-- Card Welcome username -->
</body>
</html>