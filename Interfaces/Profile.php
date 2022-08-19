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
        <title>الملف الشخصي</title>
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
        
        <!-- View list table -->
	<div class="container">
		<div class="col-lg-12">
			<div class="col-lg-12">
                <div class="panel panel-default">
                        <div class="panel-heading">
                        <a href="../Interfaces/AddUser.php" target="_self"><button type="button" class="btn btn-success" style="width: 200px; height: 40px; margin-right: 0px; ">إضافة مستخدم</button></a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            <?php                        
                            $query = "SELECT * FROM utilisateur";
                            if($result = mysqli_query($db, $query)){
                                if(mysqli_num_rows($result) > 0){
                            ?>
                                    <table class="table table-bordered table-hover table-sm table-striped">
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>اسم المستخدم</th>
                                            <th>أنشئ في</th>
                                            <th style='width: 160px;'>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        while($row = mysqli_fetch_array($result)){
                                        ?>
                                        <tr style='line-height: 45px;'>
                                            <td><?php echo $row['ID_USER']  ?></td>
                                            <td><?php echo $row['NOM_USER'] ?></td>
                                            <td><?php echo $row['Cree_a'] ?></td>
                                            <td>
                                                
                                                <a href="UpdateUser.php?id=<?php echo $row['ID_USER']; ?>"  class="btn btn-primary" style="margin: 5px 5px; width: 100px; display: inline;">تعديل</a>
                                                <a href="RemoveUser.php?id=<?php echo $row['ID_USER']; ?>" class="btn btn-danger"  style="margin: 5px 5px; width: 100px; display: inline;" onclick="return confirm('هل أنت متأكد أنك تريد حذف البيانات ')">حذف</a>
                                                
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

    </body>
</html>