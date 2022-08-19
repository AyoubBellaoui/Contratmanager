<?php
    error_reporting (E_ALL ^ E_NOTICE); 
    # hide all errors
    error_reporting(0);
    ini_set('display_errors', 0);
    
    ob_start();
    require ("../Includes/Links.php");
    require ("../Includes/Nav.php");
    require ("../Connection/Config.php");

    session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: Login.php");
        exit;
    }

    

    # Define variables and initialize with empty values
    $NOM_CTR = $CIN_CTR = $TYPE_CTR = $SEXE_CTR = $PROF_CTR = $DT_CTR = $DPL_CTR = $ADRES_CTR = 
    $EMAIL_CTR = $TEL_CTR = "";
    $NOM_CTR_err = $CIN_CTR_err = $TYPE_CTR_err = $SEXE_CTR_err = $PROF_CTR_err = $DT_CTR_err =
    $DPL_CTR_err = $ADRES_CTR_err = $EMAIL_CTR_err = $TEL_CTR_err = "";
    
    // Processing form data when form is submitted
    if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    

    $input_nom = trim($_POST["NOM_CTR"]);
    if(empty($input_nom)){
        $NOM_CTR_err = "الرجاء ادخل الاسم ";
    } elseif(!filter_var($input_nom, FILTER_VALIDATE_REGEXP, 
        array("options"=>array("regexp"=>"/^[\p{Arabic}a-zA-Z_\p{N}]+\h?[\p{N}\p{Arabic}a-zA-Z_]*$/u")))){
        $NOM_CTR_err = "لا يمكن أن يحتوي اسم المستخدم إلا على أحرف وأرقام وشرطات سفلية ";
    } else {
        $NOM_CTR = $input_nom;
    }

    $input_Cin = trim($_POST["CIN_CTR"]);
    if(empty($input_Cin)){
        $CIN_CTR_err = "الرجاء ادخل رقم البطاقة الوطنية ";
    } elseif(!filter_var($input_Cin, FILTER_VALIDATE_REGEXP, 
        array("options"=>array("regexp"=>"/^[\p{Arabic}a-zA-Z_\p{N}]+\h?[\p{N}\p{Arabic}a-zA-Z_]*$/u")))){
        $CIN_CTR_err = "لا يمكن أن يحتوي  رقم البطاقة الوطنية إلا على أحرف وأرقام وشرطات سفلية ";
    } else {
    $CIN_CTR = $input_Cin;
    }
         
    
    
    $input_type = trim($_POST["TYPE_CTR"]);
    
        $TYPE_CTR = $input_type;
    
 
    $input_sexe = trim($_POST["SEXE_CTR"]);
    
        $SEXE_CTR = $input_sexe;
    
 
    $input_prof = trim($_POST["PROF_CTR"]);
    if(empty($input_prof)){
        $PROF_CTR_err = "الرجاء ادخل المهنة ";
    // } elseif(!filter_var($input_prof, FILTER_VALIDATE_REGEXP, 
    //     array("options"=>array("regexp"=>"/^[\p{Arabic}a-zA-Z_\p{N}]+\h?[\p{N}\p{Arabic}a-zA-Z_]*$/u")))){
    //     $PROF_CTR_err = "لا يمكن أن يحتوي اسم المستخدم إلا على أحرف وأرقام وشرطات سفلية ";
    } else {
        $PROF_CTR = $input_prof;
    }
    
    
    $input_date = trim($_POST["DT_CTR"]);
    if(empty($input_date)){
        $DT_CTR_err = "الرجاء ادخل تاريخ الازدياد ";
    } else{
        $DT_CTR = $input_date;
    }

 
    $input_dpl = trim($_POST["DPL_CTR"]);
    if(empty($input_dpl)){
        $DPL_CTR_err = " الرجاء ادخل شهادة او  ديبلوم";
    // } elseif(!filter_var($input_dpl, FILTER_VALIDATE_REGEXP, 
    //     array("options"=>array("regexp"=>"/^[\p{Arabic}a-zA-Z_\p{N}]+\h?[\p{N}\p{Arabic}a-zA-Z_]*$/u")))){
    //     $DPL_CTR_err = "لا يمكن أن يحتوي اسم المستخدم إلا على أحرف وأرقام وشرطات سفلية ";
    } else {
        $DPL_CTR = $input_dpl;
    }

    
    $input_Adr = trim($_POST["ADRES_CTR"]);
    if(empty($input_Adr)){
        $ADRES_CTR_err = "الرجاء ادخل العنوان السكني";
    } else {
        $ADRES_CTR = $input_Adr;
    }

    
    $input_email = trim($_POST["EMAIL_CTR"]);
    if(empty($input_email)){
        $EMAIL_CTR_err = "الرجاء ادخل  البريد الكتروني";
    } else {
        $EMAIL_CTR = $input_email;
    }

 
    $input_tel = trim($_POST["TEL_CTR"]);
    if(empty($input_tel)){
        $TEL_CTR_err = "الرجاء ادخل  رقم الهاتف ";
    } else {
        $TEL_CTR = $input_tel;
    }
    
    // Check input errors before inserting in database
    if(empty($NOM_CTR_err) && empty($CIN_CTR_err) && empty($PROF_CTR_err) && empty($DT_CTR_err) && empty($DPL_CTR_err) && empty($ADRES_CTR_err) && empty($EMAIL_CTR_err) && empty($TEL_CTR_err)){
        // Prepare an insert statement
        if($SEXE_CTR == "1" || $SEXE_CTR == "2"){
            if($SEXE_CTR == "1"){
                $SEXE_CTR = "ذكر";
                
            }
            elseif($SEXE_CTR == "2"){
                $SEXE_CTR = "انثى";
            }

            // Prepare an update statement
            $query = "UPDATE contractant SET NOM_CTR= ?, CIN_CTR= ?, TYPE_CTR= ?, SEXE_CTR= ?, PROF_CTR= ?, DT_CTR= ?, DPL_CTR= ?, ADRES_CTR= ?, EMAIL_CTR= ?, TEL_CTR= ? WHERE ID_CTR= ?";

            if($stmt = mysqli_prepare($db, $query)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssssssssi", $param_NOM_CTR, $param_CIN_CTR, $param_TYPE_CTR, $param_SEXE_CTR, $param_PROF_CTR, $param_DT_CTR, $param_DPL_CTR, $param_ADRES_CTR, $param_EMAIL_CTR, $param_TEL_CTR, $param_id );

                // Set parameters
                $param_NOM_CTR = $NOM_CTR;
                $param_CIN_CTR = $CIN_CTR;
                $param_TYPE_CTR = $TYPE_CTR;
                $param_SEXE_CTR = $SEXE_CTR;
                $param_PROF_CTR = $PROF_CTR;
                $param_DT_CTR = $DT_CTR;
                $param_DPL_CTR = $DPL_CTR;
                $param_ADRES_CTR = $ADRES_CTR;
                $param_EMAIL_CTR = $EMAIL_CTR;
                $param_TEL_CTR = $TEL_CTR;
                $param_id = $id;


                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Records created successfully. Redirect to landing page
                    echo "<script>
                    alert('تم تعديل البيانات بنجاح!');
                    window.location.href='../Interfaces/Contractants.php';
                    </script>";

                } else{
                    echo "هناك خطأ ما. الرجاء اعادة المحاولة";
                }
            }
        }
        else{
            // Prepare an update statement
            $query = "UPDATE contractant SET NOM_CTR= ?, CIN_CTR= ?, TYPE_CTR= ?, SEXE_CTR= ?, PROF_CTR= ?, DT_CTR= ?, DPL_CTR= ?, ADRES_CTR= ?, EMAIL_CTR= ?, TEL_CTR= ? WHERE ID_CTR= ?";

            if($stmt = mysqli_prepare($db, $query)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "ssssssssssi", $param_NOM_CTR, $param_CIN_CTR, $param_TYPE_CTR, $param_SEXE_CTR, $param_PROF_CTR, $param_DT_CTR, $param_DPL_CTR, $param_ADRES_CTR, $param_EMAIL_CTR, $param_TEL_CTR, $param_id );

                // Set parameters
                $param_NOM_CTR = $NOM_CTR;
                $param_CIN_CTR = $CIN_CTR;
                $param_TYPE_CTR = $TYPE_CTR;
                $param_SEXE_CTR = $SEXE_CTR;
                $param_PROF_CTR = $PROF_CTR;
                $param_DT_CTR = $DT_CTR;
                $param_DPL_CTR = $DPL_CTR;
                $param_ADRES_CTR = $ADRES_CTR;
                $param_EMAIL_CTR = $EMAIL_CTR;
                $param_TEL_CTR = $TEL_CTR;
                $param_id = $id;

                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    
                    // Records created successfully. Redirect to landing page
                    echo "<script>
                    alert('تم تعديل البيانات بنجاح!');
                    window.location.href='../Interfaces/Contractants.php';
                    </script>";

                } else{
                    echo "هناك خطأ ما. الرجاء اعادة المحاولة";
                }
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
            $query = "SELECT * FROM contractant WHERE ID_CTR = ?";
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
                        $NOM_CTR = $row["NOM_CTR"];
                        $CIN_CTR = $row["CIN_CTR"];
                        $TYPE_CTR = $row["TYPE_CTR"];
                        $PROF_CTR = $row["PROF_CTR"];
                        $DT_CTR = $row["DT_CTR"];
                        $DPL_CTR = $row["DPL_CTR"];
                        $ADRES_CTR = $row["ADRES_CTR"];
                        $EMAIL_CTR = $row["EMAIL_CTR"];
                        $TEL_CTR = $row["TEL_CTR"];
                    } else{
                        // URL doesn't contain valid id. Redirect to error page
                        header("location: error.php");
                        exit();
                    }
                    
                } else{
                    echo "هناك خطأ ما. الرجاء اعادة المحاولة";
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
    <title>إضافة متعاقد</title>
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
            <span class="float-left"><h4 class="page_name">المتعاقدين</h4></span>
            </h4>
            </div>
        </div>
        <!-- Card Welcome username -->

    <!-- Form -->
    <div class="form_centre1">
        <form class="formCTR" action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">

            <div class="form-group1">
                <label class="form-label mt-4"> الاسم</label>
                <input type="text" name="NOM_CTR" autofocus="autofocus" class="form-control <?php echo 
                (!empty($NOM_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $NOM_CTR; ?>">
                <span class="invalid-feedback"><?php echo $NOM_CTR_err; ?></span>
            </div>    

            <div class="form-group1">
                <label class="form-label mt-4"> رقم البطاقة الوطنية</label>
                <input type="text" name="CIN_CTR" class="form-control <?php echo 
                (!empty($CIN_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $CIN_CTR; ?>" style="width: 40%;" maxlength="10">
                <span class="invalid-feedback"><?php echo $CIN_CTR_err; ?></span>
            </div>      

        <fieldset class="form-group1">
        <label class="form-label mt-4"> الصنف المتعاقد  </label>
        <div>
           <input type="radio" id="morale" name="TYPE_CTR" onclick="MyFunction()" value="معنوي" checked>
           <label class="form-check-label" >معنوي</label>
        </div>
        <div>
           <input type="radio" id="physique" name="TYPE_CTR" onclick="MyFunction()" value="ذاتي">
           <label class="form-check-label" >ذاتي</label>
        </div>
        </fieldset>
        <fieldset class="form-group1" id="SEXE_CTR">
        <div>
           <input type="radio" id="M" name="SEXE_CTR" value="1" >
           <label class="form-check-label" >ذكر</label>
        </div>
        <div>
           <input type="radio" id="F" name="SEXE_CTR" value="2" checked>
           <label class="form-check-label" >انثى</label>
         </div>
        </fieldset>
        <script>
            document.getElementById("SEXE_CTR").disabled = true;
            var radios = document.getElementsByName('TYPE_CTR');
            function MyFunction(){
            for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked) {
                if(radios[i].value == "ذاتي"){
                document.getElementById("SEXE_CTR").disabled = false;
                }
                else{
                document.getElementById("SEXE_CTR").disabled = true;
                }
                break;
                    }
                }
            }
        </script>
            <div class="form-group1">
                <label class="form-label mt-4"> المهنة</label>
                <input type="text" name="PROF_CTR"  class="form-control <?php echo 
                (!empty($PROF_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PROF_CTR; ?>">
                <span class="invalid-feedback"><?php echo $PROF_CTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> تاريخ الازدياد</label>
                <input type="date" name="DT_CTR" class="form-control <?php echo 
                (!empty($DT_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $DT_CTR; ?>">
                <span class="invalid-feedback"><?php echo $DT_CTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> ديبلوم</label>
                <input type="text" name="DPL_CTR" class="form-control <?php echo 
                (!empty($DPL_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $DPL_CTR; ?>">
                <span class="invalid-feedback"><?php echo $DPL_CTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> عنوان السكني</label>
                <input  type="text" name="ADRES_CTR" class="form-control <?php echo 
                (!empty($ADRES_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ADRES_CTR; ?>"></input>
                <span class="invalid-feedback"><?php echo $ADRES_CTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> البريد الالكتروني</label>
                <input type="email" name="EMAIL_CTR" class="form-control <?php echo 
                (!empty($EMAIL_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $EMAIL_CTR; ?>">
                <span class="invalid-feedback"><?php echo $EMAIL_CTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> الهاتف</label>
                <input type="text" name="TEL_CTR" class="form-control <?php echo 
                (!empty($TEL_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $TEL_CTR; ?>">
                <span class="invalid-feedback"><?php echo $TEL_CTR_err; ?></span>
            </div> 

            <div class="form-group2">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <a href="Contractants.php" type="reset" class="btn btn-outline-primary" style="width: 47%;">رجوع</a>
                <input type="submit" class="btn btn-outline-success" style="width: 47%;" value="حفظ" >
            </div>
        </form>
    </div>
    <!-- Form -->
</body>
</html>