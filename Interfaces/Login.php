<?php
    require ("../Includes/Links.php");
    require ("../Connection/Config.php");

    session_start();
    # Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: Home.php");
        exit;
    }

    # Define variables and initialize with empty values
    $username = $password = "";
    $username_err = $password_err = $login_err = "";

    # when method used is POST do
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        
        # Check if username is empty
        if(empty(trim($_POST["username"]))){
            $username_err = "الرجاء إدخال اسم المستخدم";
        }   # assign value to variable 
        else { 
            $username = trim($_POST["username"]);   
        }

        # Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "الرجاء إدخال كلمة المرور";
        }   # assign value to variable 
        else { 
            $password = trim($_POST["password"]);   
        }

        # Deal with DB
        if(empty($username_err) && empty($password_err)){
            # select statement of Table
            $query = "SELECT ID_USER,NOM_USER,PWD_USER FROM utilisateur WHERE NOM_USER = ?";

            if($stmt = mysqli_prepare($db, $query)){
                # bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username); # bind is an alternative way to pass data to the database

                # assign value of username to $param_username
                $param_username = $username;

                # Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    # Store result of prepared statement (bool)
                    mysqli_stmt_store_result($stmt);

                    # Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        # Bind result variables
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        # fetch is the retrieval of data
                        if(mysqli_stmt_fetch($stmt)){
                            if(password_verify($password, $hashed_password)){

                                # Password is correct, so start a new session
                                session_start();
                                # Store data in session variables
                                $_SESSION['loggedin'] = true;
                                $_SESSION['id'] = $id;
                                $_SESSION['username'] = $username;

                                # Redirect To Home
                                sleep(1);
                                header("location: Home.php");

                            } else{
                                # Password is not valid
                                $login_err = "خطأ في اسم المستخدم أو كلمة مرور";
                            }

                        }

                    } else{
                        # Username doesn't exist
                        $login_err = "خطأ في اسم المستخدم أو كلمة مرور";
                    }
                } else{
                    echo "هناك خطأ ما. الرجاء اعادة المحاولة";
                }

                # close statement
                mysqli_stmt_close($stmt);
            }

        }
        # close connection
        mysqli_close($db);
    }
    
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>تسجيل الدخول </title>
</head>
<body>
    <div class="Container">
        <div class="wrapper" >
        <h2 class="login-header">تسجيل الدخول</h2>
            <?php
            if(!empty($login_err)){
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label class="form-label mt-4">اسم المستخدم</label>
                    <input type="text" name="username" class="form-control <?php echo 
                    (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group">
                    <label class="form-label mt-4">كلمة السر</label>
                    <input type="password" name="password" class="form-control <?php echo 
                    (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                     <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="تاكيد" >
                </div>
            </form>
        </div>
    </div>
</body>
</html>