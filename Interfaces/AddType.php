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

    # when method used is POST do
    if($_SERVER["REQUEST_METHOD"] == "POST"){

    # Check if Type of contract is empty
    $input_Type = trim($_POST["TYPE_CT"]);
    if(empty($input_Type)){
        $TYPE_CT_err = "الرجاء إدخال نوعية ";
    } else {
        $TYPE_CT = $input_Type;
    }

    # Check if Type of contract is empty
    $input_Code_Type = trim($_POST["CODE_TYPE"]);
    
        $CODE_TYPE = $input_Code_Type;
    

    // Check input errors before inserting in database
    if(empty($TYPE_CT_err) && empty($CODE_TYPE_err)){
        // Prepare an insert statement
        $query = "INSERT INTO type_contrat (TYPE_CT, CODE_TYPE) VALUES (?, ?)";

        if($stmt = mysqli_prepare($db, $query)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_TYPE_CT, $param_CODE_TYPE);
            
            // Set parameters
            $param_TYPE_CT = $TYPE_CT;
            $param_CODE_TYPE = $CODE_TYPE;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                // Records created successfully. Redirect to landing page
                echo "<script>
                alert('تمت اضافة البيانات بنجاح!');
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
            <div class="form-group1">
                <label class="form-label mt-4"> النوعية</label>
                <input type="text" name="TYPE_CT" autofocus="autofocus" class="form-control <?php echo 
                (!empty($TYPE_CT_err)) ? 'is-invalid' : ''; ?>">
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
                <a href="Types.php" type="reset" class="btn btn-outline-primary" style="width: 47%;">رجوع</a>
                <input type="submit" class="btn btn-outline-success" style="width: 47%;" value="حفظ" >
            </div>
        </form>
    </div>
    <!-- Form -->

</body>
</html>