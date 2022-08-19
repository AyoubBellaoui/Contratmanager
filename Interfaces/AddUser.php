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
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";
 
    # when method used is POST do
    if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    # Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "الرجاء إدخال اسم المستخدم";
    } else{
        # select statement of Table
        $query = "SELECT ID_USER FROM utilisateur WHERE NOM_USER = ?";
        
        if($stmt = mysqli_prepare($db, $query)){
            # Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            # assign value of username to $param_username
            $param_username = trim($_POST["username"]);
            
            # Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                # Store result of prepared statement (bool)
                mysqli_stmt_store_result($stmt);
                
                # Check if username exists and show msg
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "أسم المستخدم مأخوذ مسبقا";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "هناك خطأ ما. الرجاء اعادة المحاولة";
            }

            # Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    # Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "الرجاء إدخال كلمة المرور";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل";
    } else{
        $password = trim($_POST["password"]);
    }
    
    # Check if confirm password is empty 
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "الرجاء تأكيد كلمة المرور";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "كلمات المرور غير متطابقة";
        }
    }
    
    # Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        # Prepare an insert statement
        $query = "INSERT INTO  utilisateur (NOM_USER, PWD_USER) VALUES (?, ?)";
        

        if($stmt = mysqli_prepare($db, $query)){
            # Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            # assign value of username to $param_username
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); # Creates a password hash
            
            # Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                # Redirect to login page
                echo "<script>
                alert('تمت اضافة البيانات بنجاح!');
                window.location.href='../Interfaces/Profile.php';
                </script>";

            } else{
                echo "هناك خطأ ما. الرجاء اعادة المحاولة";
            }
            

            # Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    # Close connection
    mysqli_close($db);
}
ob_end_flush();
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>إضافة مستخدم</title>
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
            <span id="float-left"><h4 class="page_name">الملف الشخصي</h4></span>
            </h4>
            </div>
        </div>
        <!-- Card Welcome username -->

    <!-- Form -->
    <div class="form_centre">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group1">
            <label class="form-label mt-4">اسم المستخدم</label>
            <input type="text" name="username" autofocus="autofocus" class="form-control <?php echo 
            (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>    
        <div class="form-group1">
            <label class="form-label mt-4">كلمة السر</label>
            <input type="password" name="password" class="form-control <?php echo 
            (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group1">
            <label class="form-label mt-4">تاكيد كلمة السر </label>
            <input type="password" name="confirm_password" class="form-control <?php echo 
            (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group2">
            <a href="Profile.php" type="reset" class="btn btn-outline-primary" style="width: 47%;">رجوع</a>
            <input type="submit" class="btn btn-outline-success" style="width: 47%;" value="حفظ" >
        </div>
        </form>
        <!-- Form -->
    </div>
</body>
</html>
