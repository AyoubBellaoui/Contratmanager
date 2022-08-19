<?php
    error_reporting (E_ALL ^ E_NOTICE); 
    # hide all errors
    error_reporting(0);
    ini_set('display_errors', 0);
    
    ob_start();
    require ("../Connection/Config.php");
    require ("../Includes/Links.php");
    require ("../Includes/Nav.php");

    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: Login.php");
        exit;
    }

    # Define variables and initialize with empty values
    $TYPE_CT = $CODE_TYPE = "";
    $TYPE_CT_err = $CODE_TYPE_err = "";

    // Processing form data when form is submitted
    if(isset($_POST["id"]) && !empty($_POST["id"])){

    // Get hidden input value
    $id = $_POST["id"];

    # Check if Type of contract is empty
    $input_Type = trim($_POST["TYPE_CT"]);
    if(empty($input_Type)){
        $TYPE_CT_err = "الرجاء إدخال نوعية ";
    } else{
        $TYPE_CT = $input_Type;
    }

    # Check if Type of contract is empty
    $input_Code_Type = trim($_POST["CODE_TYPE"]);
    
        $CODE_TYPE = $input_Code_Type;
    

    // Check input errors before inserting in database
    if(empty($TYPE_CT_err) && empty($CODE_TYPE_err)){
        // Prepare an insert statement
        $query = "UPDATE type_contrat SET TYPE_CT=?, CODE_TYPE=? WHERE ID_TYPE=?";
        
        if($stmt = mysqli_prepare($db, $query)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_TYPE_CT, $param_CODE_TYPE, $param_id );
            
            // Set parameters
            $param_TYPE_CT = $TYPE_CT;
            $param_CODE_TYPE = $CODE_TYPE;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

               // Records created successfully. Redirect to landing page
                echo "<script>
                alert('تم تعديل البيانات بنجاح!');
                window.location.href='../Interfaces/Types.php';
                </script>";

            } else{
                echo "هناك خطأ ما. الرجاء اعادة المحاولة" . mysqli_error($db);
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db);

    } else {
        // Check existence of id parameter before processing further
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            // Get URL parameter
            $id =  trim($_GET["id"]);
            
            // Prepare a select statement
            $query = "SELECT * FROM type_contrat WHERE ID_TYPE = ?";
            if($stmt = mysqli_prepare($db, $query)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "i", $param_id);
                
                // Set parameters
                $param_id = $id;
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    $result = mysqli_stmt_get_result($stmt);
        
                    if(mysqli_num_rows($result) == 1){
                        /* Fetch result row as an associative array. Since the result set
                        contains only one row, we don't need to use while loop */
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                        // Retrieve individual field value
                        $TYPE_CT = $row["TYPE_CT"];
                        $CODE_TYPE = $row["CODE_TYPE"];

                    } else{
                        // URL doesn't contain valid id. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                    
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
            
            // Close connection
            mysqli_close($db);
        }  else{
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }
    
    ob_end_flush();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>إضافة نوعية</title>
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
            <span class="float-left2"><h4 class="page_name">نوعيةالعقود </h4></span>
            </h4>
            </div>
        </div>
        <!-- Card Welcome username -->

    <!-- Form -->
    <div class="form_centre">
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
        
            <div class="form-group1">
                <label class="form-label mt-4"> النوعية</label>
                <input type="text" name="TYPE_CT" autofocus="autofocus" class="form-control <?php echo 
                (!empty($TYPE_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $TYPE_CT; ?>">
                <span class="invalid-feedback"><?php echo $TYPE_CT_err; ?></span>
            </div>    
            
            <div class="form-group1">
                <label for="exampleSelect1" class="form-label mt-4">المواد المتغيرة</label>
                <select name="CODE_TYPE" class="form-select <?php echo 
                (!empty($CODE_TYPE_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $CODE_TYPE_err; ?></span>
                    <?php
                    $Arcs = array(
                        0 =>  "عقد فيه المادة 1",
                        1 =>  "عقد فيه المادة 1 و 2",
                        2 =>  "عقد فيه المادة 1 و 2 والديباجة"
                    );
                    ?>
                    <?php
                        foreach($Arcs as $key => $value):
                            echo '<option>'.$value.'</option>'; 
                        endforeach;
                    ?>
                </select>
            </div>

            <div class="form-group2">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <a href="Types.php" type="reset" class="btn btn-outline-dark" style="width: 47%;">رجوع</a>
                <input type="submit" class="btn btn-outline-success" style="width: 47%;" value="حفظ" >
            </div>
        </form>
    </div>
    <!-- Form -->

</body>
</html>
