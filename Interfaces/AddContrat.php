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
    $NUM_CT = $DT_CT = $OBJ_CT = $ENTITE = $ID_TYPE_CT = $PRM_CT = $AR1_CT = $AR2_CT = $MNT_BRUT_LTR = $MNT_BRUT = $MNT_ARN_LTR
    = $MNT_ARN = $MNT_NET_LTR = $MNT_NET = $FILE_CT = $ID_CTR = $ID_TYPE = "";
    $NUM_CT_err = $DT_CT_err= $OBJ_CT_err = $ENTITE_err = $ID_TYPE_CT_err = $PRM_CT_err = $AR1_CT_err = $AR2_CT_err = $MNT_BRUT_LTR_err = $MNT_BRUT_err = 
    $MNT_ARN_LTR_err = $MNT_ARN_err = $MNT_NET_LTR_err = $MNT_NET_err = $FILE_CT_err = $ID_CTR_err = "";

    # when method used is POST do
    if($_SERVER["REQUEST_METHOD"] == "POST") { 

        # Check if NUM_CT is empty
        $input_num = trim($_POST["NUM_CT"]);
        if(empty($input_num)){
            $NUM_CT_err = "الرجاء ادخل رقم العقد ";
        } else {
            $duplicate = mysqli_query($db,"SELECT NUM_CT FROM contrat WHERE NUM_CT='$input_num'"); 
            if(mysqli_num_rows($duplicate)>0){
                $NUM_CT_err = " هذا الرقم موجود مسبقا !";
            }
        }

        $NUM_CT = $input_num;
        
        # Check if DT_CT is empty
        $input_date = trim($_POST["DT_CT"]);
        if(empty($input_date)){
            $DT_CT_err = "الرجاء ادخل تاريخ العقد";
        } else{
            $DT_CT = $input_date;
        }

        # Check if OBJ_CT is empty
        $input_obj = trim($_POST["OBJ_CT"]);
        if(empty($input_obj)){
            $OBJ_CT_err = "الرجاء ادخل موضوع العقد";
        } else {
            $OBJ_CT = $input_obj;
        }

        # Check if ENTITE is empty 
        $input_ent = trim($_POST["ENTITE"]);
        if(empty($input_ent)){
            $ENTITE_err = "الرجاء ادخل المركز ";
        } else {
            $ENTITE = $input_ent;
        }

        # Types of contracts
        $input_type = trim($_POST["ID_TYPE_CT"]);
        if(empty($input_type)){
            $ID_TYPE_CT_err = "الرجاء ادخل النوعية";
        } else {
            $ID_TYPE_CT = $input_type;
        }

        $input_prm = trim($_POST["PRM_CT"]);
        if(empty($input_prm)){
            $PRM_CT_err = "الرجاء ادخل الديباجة";
        } else {
            $PRM_CT = $input_prm;
        }
        
        $input_AR1 = trim($_POST["AR1_CT"]);
        if(empty($input_AR1)){
            $AR1_CT_err = "الرجاء ادخل المادة الأولى";
        } else {
            $AR1_CT = $input_AR1;
        }
        
        $input_AR2 = trim($_POST["AR2_CT"]);
        if(empty($input_AR2)){
            $AR2_CT_err = "الرجاء ادخل المادة الثانية";
        } else {
            $AR2_CT = $input_AR2;
        }

        # Select CTR 
        $input_CTR = trim($_POST["ID_CTR"]);
        if(empty($input_CTR)){
            $ID_CTR_err = "الرجاء اختر المتعاقد";
        } else {
            $ID_CTR = $input_CTR;
        }
        
        $input_MNTB = trim($_POST["MNT_BRUT"]);
        if(empty($input_MNTB)){
            $MNT_BRUT_err = "الرجاء ادخال المبلغ خام  ";
        }  else {
            $MNT_BRUT = $input_MNTB;
        }

        
        $input_MNTBL = trim($_POST["MNT_BRUT_LTR"]);
        if(empty($input_MNTBL)){
            $MNT_BRUT_LTR_err = "الرجاء ادخال المبلغ خام بالحروف ";
        } else {
            $MNT_BRUT_LTR = $input_MNTBL;
        }

        # 
        $input_MNTAR = trim($_POST["MNT_ARN"]);
        if(empty($input_MNTAR)){
            $MNT_ARN_err = "الرجاء ادخال المبلغ بدرهم الاعلى  ";
        } else {
            $MNT_ARN = $input_MNTAR;
        }

        # 
        $input_MNTARL = trim($_POST["MNT_ARN_LTR"]);
        if(empty($input_MNTARL)){
            $MNT_ARN_LTR_err = "الرجاء ادخال المبلغ بدرهم الاعلى بالحروف";
        } else {
            $MNT_ARN_LTR = $input_MNTARL;
        }

        # 
        $input_MNTNT = trim($_POST["MNT_NET"]);
        if(empty($input_MNTNT)){
            $MNT_NET_err = "الرجاء ادخل المبلغ الصافي";
        } else {
            $MNT_NET = $input_MNTNT;
        }

        # 
        $input_MNTNTL = trim($_POST["MNT_NET_LTR"]);
        if(empty($input_MNTNTL)){
            $MNT_NET_LTR_err = " الرجاء ادخل المبلغ الصافي بالحروف ";
        } else {
            $MNT_NET_LTR = $input_MNTNTL;
        }
        
        # File Upload
        $input_FILE = trim($_POST["FILE_CT"]);
        
            $FILE_CT = $input_FILE;


        // Check input errors before inserting in database
        if(empty($NUM_CT_err) && empty($DT_CT_err) && empty($OBJ_CT_err) && empty($ENTITE_err) && empty($ID_TYPE_CT_err) && empty($ID_CTR_err)
        && empty($MNT_BRUT_err) && empty($MNT_BRUT_LTR_err) && empty($MNT_ARN_err) && empty($MNT_ARN_LTR_err) && empty($MNT_NET_err) && empty($MNT_NET_LTR_err)){
        

        // Prepare an insert statement
        $query = "INSERT INTO contrat (NUM_CT, DT_CT, OBJ_CT, ENTITE, ID_CTR, ID_TYPE_CT, PRM_CT, AR1_CT, AR2_CT, MNT_BRUT, MNT_BRUT_LTR, MNT_ARN, MNT_ARN_LTR, MNT_NET, MNT_NET_LTR, FILE_CT) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($db, $query)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssiissssssssss", $param_NUM_CT, $param_DT_CT, $param_OBJ_CT, $param_ENTITE, $param_ID_CTR, $param_ID_TYPE_CT, $param_PRM_CT, 
            $param_AR1_CT, $param_AR2_CT, $param_MNT_BRUT, $param_MNT_BRUT_LTR, $param_MNT_ARN, $param_MNT_ARN_LTR, $param_MNT_NET, $param_MNT_NET_LTR, $param_FILE_CT);
            
            // Set parameters
            $param_NUM_CT = $NUM_CT;
            $param_DT_CT = $DT_CT;
            $param_OBJ_CT = $OBJ_CT;
            $param_ENTITE = $ENTITE;
            $param_ID_TYPE_CT = $ID_TYPE_CT;
            $param_PRM_CT = $PRM_CT;
            $param_AR1_CT = $AR1_CT;
            $param_AR2_CT = $AR2_CT;
            $param_ID_CTR = $ID_CTR;
            $param_MNT_BRUT = $MNT_BRUT;
            $param_MNT_BRUT_LTR = $MNT_BRUT_LTR;
            $param_MNT_ARN = $MNT_ARN;
            $param_MNT_ARN_LTR = $MNT_ARN_LTR;
            $param_MNT_NET = $MNT_NET;
            $param_MNT_NET_LTR = $MNT_NET_LTR;
            $param_FILE_CT = $FILE_CT;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                echo "<script>
                alert('تمت اضافة البيانات بنجاح!');
                window.location.href='../Interfaces/Contrats.php';
                </script>";

            } else{
                echo "هناك خطأ ما. الرجاء اعادة المحاولة" . mysqli_error($db);
            }
        }
        
        // Close statement
        //mysqli_stmt_close($stmt);mysqli_close($db);
    }

    }
    
    
    ob_end_flush();
    
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>إضافة عقد</title>
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
            <span class="float-left1"><h4 class="page_name">العقود</h4></span>
            </h4>
            </div>
        </div>
    <!-- Card Welcome username -->

    <!-- Form -->
    <div class="form_centre1">
        <form class="formCTR" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" name="form1" id="form1">
            
            <div class="form-group1">
                <label class="form-label mt-4"> رقم العقد</label>
                <input type="text" name="NUM_CT" autofocus="autofocus" class="form-control <?php echo 
                (!empty($NUM_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $NUM_CT; ?>">
                <span class="invalid-feedback"><?php echo $NUM_CT_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> تاريخ العقد</label>
                <input type="date" name="DT_CT" class="form-control <?php echo 
                (!empty($DT_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $DT_CT; ?>">
                <span class="invalid-feedback"><?php echo $DT_CT_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> موضوع العقد</label>
                <input type="text" name="OBJ_CT" class="form-control <?php echo 
                (!empty($OBJ_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $OBJ_CT; ?>">
                <span class="invalid-feedback"><?php echo $OBJ_CT_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> المرفق</label>
                <select name="ENTITE" class="form-select <?php echo 
                (!empty($ENTITE_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $ENTITE_err; ?></span>
                    <?php
                    $Arcs = array(
                        0 => "العمادة",
                        1 => "الأمانة العامة",
                        2 => "قسم الموارد البشرية والشؤون العامة والقانونية",
                        3 => "قسم الميزانية والمعدات",
                        4 => "قسـم التواصـل",
                        5 => "قسم الإفتحاص الداخلي ومراقبة التدبير",
                        6 => "مركز التهيئة اللغوية",
                        7 => "مركز البحث الديداكتيكي والبرامج البيداغوجية",
                        8 => "مركز الدراسات التاريخية والبيئية",
                        9 => "مركز الدراسات الأنتربولوجية والسوسيولوجية",
                        10 => "مركز الدراسات الفنية والدراسات الأدبية والإنتاج السمعي البصري",
                        11 => "مركز الترجمة والتوثيق والنشر", 
                        12 => "مركز الدراسات المعلومياتية وأنظمة الإعلام والإتصال"
                    );
                    ?>
                    <?php
                        foreach($Arcs as $key => $value):
                            echo '<option>'.$value.'</option>'; 
                        endforeach;
                    ?>
                </select>
            </div>
            
            <!-- Select Types -->
            <div class="form-group3">
            <fieldset class="border p-2">
                <label class="form-label mt-4">النوعية</label>
                <select id="SelectTypes" name="ID_TYPE_CT" class="form-control <?php echo 
                (!empty($ID_TYPE_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ID_TYPE_CT; ?>">
                    <?php
                    $query="SELECT ID_TYPE,TYPE_CT FROM type_contrat ";
                    echo '<option value="">اختر النوعية...</option>';
                    $result = mysqli_query($db, $query);
                    
                    while($row=mysqli_fetch_assoc($result))
                    {
                        echo '<option value="'.$row['ID_TYPE'].'">'.$row['ID_TYPE'].''.$row['TYPE_CT'].'</option>';
                    }
                    ?>
                </select>
                
            <div id="div_type1">
                <label class="form-label mt-4"> المادة 1 </label>
                <input type="text" name="AR1_CT" class="form-control <?php echo 
                (!empty($AR1_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $AR1_CT; ?>"></div>
                <div id="div_type2">
                <label class="form-label mt-4"> المادة 2 </label>
                <input type="text" name="AR2_CT" class="form-control <?php echo 
                (!empty($AR2_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $AR2_CT; ?>"></div>
                <div id="div_type3">
                <label class="form-label mt-4"> الديباجة </label>
                <input type="text" name="PRM_CT" class="form-control <?php echo 
                (!empty($PRM_CT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $PRM_CT; ?>"></div>
                </fieldset>
                <span class="invalid-feedback"><?php echo $ID_TYPE_CT; ?></span>
            </div>
            
            <!--Search A CTR ON DB-->
            <div class="form-group1">
                <script>
                    $(document).ready(function () {
                        $('#SelectCTR').selectize({
                            sortField: 'text',
                        });
                    });
                </script> 
                <label class="form-label mt-4">المتعاقد</label>
                
                <select id="SelectCTR" name="ID_CTR"  class="form-control <?php echo 
                (!empty($ID_CTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $ID_CTR; ?>">
                <?php
                    $query="SELECT ID_CTR,NOM_CTR,CIN_CTR FROM contractant ORDER BY NOM_CTR ASC";
                    echo '<option value="">اختر متعاقد...</option>';
                    $result = mysqli_query($db, $query);
                    
                    while($row=mysqli_fetch_assoc($result))
                    {
                        echo '<option value="'.$row['ID_CTR'].'">'.$row['CIN_CTR'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$row['NOM_CTR'].' '.$row['ID_CTR'].'</option>';
                    }
                ?>
                </select>
                <span class="invalid-feedback"><?php echo $ID_CTR_err; ?></span>
            </div>

            <div class="form-group1">
                <label class="form-label mt-4"> الضريبة على الدخل </label>
                <input type="text" name="ir" class="form-control" style="width: 30%;" value="30"> 
            </div> 

            <div class="form-group1">
                <input class="form-check-input" type="checkbox" name="Abattement" id="Abattement" value="Abattement" onclick="calcul()">
                <label class="form-check-label">
                خصم (%40)
                </label>
            </div>
            
            <div class="form-group1">
                <label class="form-label mt-4"> المبلغ الصافي  </label>
                <input type="text" name="MNT_NET" onkeypress="calcul()"  class="form-control <?php echo 
                (!empty($MNT_NET_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MNT_NET; ?>">
                <span class="invalid-feedback"><?php echo $MNT_NET_err; ?></span>
            </div> 
            
            <div class="form-group1">
                <label class="form-label mt-4"> المبلغ الصافي بالحروف </label>
                <input type="text" name="MNT_NET_LTR" class="form-control <?php echo 
                (!empty($MNT_NET_LTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MNT_NET_LTR; ?>">
                <span class="invalid-feedback"><?php echo $MNT_NET_LTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4">  المبلغ خام</label>
                <input type="text" name="MNT_BRUT" onchange="calcul()"  class="form-control <?php echo 
                (!empty($MNT_BRUT_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MNT_BRUT; ?>">
                <span class="invalid-feedback"><?php echo $MNT_BRUT_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> المبلغ خام بالحروف </label>
                <input type="text" name="MNT_BRUT_LTR" class="form-control <?php echo 
                (!empty($MNT_BRUT_LTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MNT_BRUT_LTR; ?>">
                <span class="invalid-feedback"><?php echo $MNT_BRUT_LTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4">  المبلغ بدرهم الاعلى</label>
                <input type="number" name="MNT_ARN" class="form-control <?php echo 
                (!empty($MNT_ARN_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MNT_ARN; ?>">
                <span class="invalid-feedback"><?php echo $MNT_ARN_err; ?></span>
            </div> 

            <div class="form-group1">
                <label class="form-label mt-4"> المبلغ بدرهم الاعلى بالحروف </label>
                <input type="text" name="MNT_ARN_LTR" class="form-control <?php echo 
                (!empty($MNT_ARN_LTR_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $MNT_ARN_LTR; ?>">
                <span class="invalid-feedback"><?php echo $MNT_ARN_LTR_err; ?></span>
            </div> 

            <div class="form-group1">
                <div class="mb-3">
                    <label for="formFile" class="form-label mt-4">الملف</label>
                    <input class="form-control" value="ارفع ملف" name="FILE_CT" type="file">
                </div>
            </div> 

            <div class="form-group2">
                <a href="Contrats.php" type="reset" class="btn btn-outline-primary" style="width: 47%">رجوع</a>
                <input type="submit" class="btn btn-outline-success" style="width: 47%;" value="حفظ" >
            </div>

        </form>
    </div>
    <!-- Form -->

    <!-- IR -->
    <script>

        function calcul(){
        if (document.form1.Abattement.checked==false){
        document.form1.MNT_BRUT.value = document.form1.MNT_NET.value/(1-document.form1.ir.value*0.01);
        }
        else
        {
        document.form1.MNT_BRUT.value = document.form1.MNT_NET.value/0.82;
        }
        document.form1.MNT_BRUT.value=Math.round(document.form1.MNT_BRUT.value*100)/100;
        }
        </script> 

    <!--Select Types of contracts-->
            <script>
                    $(document).ready(function () {
                        $('#SelectTypes').selectize({
                            sortField: 'text'
                        });
                        $("#SelectTypes").change(function() {
                            var $var_select=$("#SelectTypes").val();
                            if($var_select == 1 ){
                                $("#div_type1").show();
                                $("#div_type2").hide();
                                $("#div_type3").hide();
                            }
                            if($var_select == 2 ){
                                $("#div_type1").show();
                                $("#div_type2").hide();
                                $("#div_type3").hide();
                            }
                            if($var_select == 3 ){
                                $("#div_type1").show();
                                $("#div_type2").hide();
                                $("#div_type3").hide();
                            }
                            if($var_select == 4 ){
                                $("#div_type1").show();
                                $("#div_type2").hide();
                                $("#div_type3").hide();
                            }
                            if($var_select == 5 ){
                                $("#div_type1").show();
                                $("#div_type2").hide();
                                $("#div_type3").hide();
                            }
                            else if($var_select == 6){
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").hide();
                            }
                            else if($var_select == 7){
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").hide();
                            }
                            else if($var_select == 8)
                            {
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").show();
                            }
                            else if($var_select == 9)
                            {
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").show();
                            }
                            else if($var_select == 10)
                            {
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").show();
                            }
                            else if($var_select == 11)
                            {
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").show();
                            }
                            else if($var_select == 12)
                            {
                                $("#div_type1").show();
                                $("#div_type2").show();
                                $("#div_type3").show();
                            }
                        });
                    });
            </script>

    
</body>
</html>