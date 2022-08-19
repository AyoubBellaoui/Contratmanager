<?php

    ob_start();
    require ("../Connection/Config.php");
    require ("../Includes/Links.php");
    require ("../Includes/Nav.php");

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
    <title>المتعاقدين</title>
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

        <!-- View list table -->
	<div class="container">
		<div class="col-lg-12">
			<div class="col-lg-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                        <a href="../Interfaces/AddContractants.php" target="_self"><button type="button" class="btn btn-success" style="width: 200px; height: 40px; margin: 0px 0px 0px 0px;  ">إضافة متعاقد</button></a>
                        <a href="../Export/GenerateExcel_AllCTR.php" target="_blank"><button type="button" class="btn btn-success" style="width: 200px; height: 40px;">طباعة المتعاقدين</button></a>
                        <a><input type="search" id="search" class="form-control" placeholder="ابحث..." style="width: 313px; display: inline; margin-top: 5px;"></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            <?php                        
                            $query = "SELECT * FROM contractant";
                            if($result = mysqli_query($db, $query)){
                                if(mysqli_num_rows($result) > 0){
                            ?>
                                    <table class="table table-bordered table-hover table-sm table-striped" id="table" >
                                        <thead>
                                            <tr>
                                            <th>الاسم</th>
                                            <th>الهاتف </th>
                                            <th style='width: 210px;'>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while($row = mysqli_fetch_array($result)){
                                        ?> 
                                        <tr style='line-height: 45px;'>
                                            <td><?php echo $row['NOM_CTR'] ?></td>
                                            <td><?php echo $row['TEL_CTR'] ?></td>
                                            <td>
                                                <a href="UpdateContractant.php?id=<?php echo $row['ID_CTR']; ?>" class="btn btn-primary" style="margin: 5px auto; width: 120px; display: inline;">تعديل</a>
                                                <a href="RemoveContractants.php?id=<?php echo $row['ID_CTR']; ?>" onclick="return confirm('هل انت متاكد من حذف هذا السجل');" class="btn btn-danger"  style="margin: 5px auto; width: 120px; display: inline;">حذف</a>
                                                <a href="../Export/Generate_CTR.php?id=<?php echo $row['ID_CTR']; ?>" target="_blank" class="btn btn-light"  style="margin: 5px auto; width: 120px; display: inline;">طباعة</a>
                                            </td>
                                            </tr>
                                        
                                        <?php
                                    }
                                    ?>
                                        </tbody>
                                    </table>
                                
                                <?php
                                    mysqli_free_result($result);
                                    
                                }else{
                                    echo '<div dir="rtl" class="alert alert-danger"><em>لم يتم العثور على اي سجلات.</em></div>';
                                }
                            }else{
                                echo "هناك خطأ ما. الرجاء معاودة المحاولة في وقت لاحق.";
                            }
                            mysqli_close($db);
                            ?>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                </div>
                    <!-- /.panel -->
            </div>
				
		</div>
		
	</div>
        <!-- View list table -->
</div>
            <script>
                var $rows = $('#table tr');                                        
                $('#search').keyup(function() {
                    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
                    
                    $rows.show().filter(function() {
                        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                        return !~text.indexOf(val);
                    }).hide();
                });
            </script>

</body>
</html>