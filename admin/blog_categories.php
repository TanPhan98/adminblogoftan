<?php  
include "includes/database.php";
include "includes/categories.php";

$database = new database();
$db = $database->connect();
$category = new category($db);

if($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST['add'])) {
        $category->v_category_title = $_POST['category_title'];
        $category->v_category_meta_title = $_POST['category_meta_title'];
        $category->v_category_path = $_POST['category_path'];
        $category->d_date_created = date("Y-m-d",time());
        $category->d_time_created = date("h:i:s",time());
        if ($category->create()) {
            $flag = "Add category complete !";
        }
    }
}
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['edit'])) {
        $category->v_category_title = $_POST['category_title'];
        $category->v_category_meta_title = $_POST['category_meta_title'];
        $category->v_category_path = $_POST['category_path'];
        $category->d_date_created = date("Y-m-d",time());
        $category->d_time_created = date("h:i:s",time());
        $category->n_category_id=$_POST['category_id'];
        if ($category->update()) {
            $flag= "Edit complete !";
        }
    }
}
if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['delete'])) {
        $category->n_category_id=$_POST['category_id'];
        if ($category->delete()) {
            $flag = "Delete complete !";
        }
    }
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tan's blog</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <?php  
            include "header.php";
        ?>
        <!--/. NAV TOP  -->
        <?php  
            include "sidebar.php";
        ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Blog Categories
                        </h1>
                    </div>
                </div>
                <?php if (isset($flag)) { ?>
                    <div class="alert alert-info" >
                            <strong>Success!</strong> <?php echo $flag ?>
                   </div>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Category
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="POST" action="">
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input class="form-control" name="category_title" placeholder="Enter category">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Meta Title</label>
                                            <input class="form-control" name="category_meta_title" placeholder="Enter meta category">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Path</label>
                                            <input class="form-control" name="category_path" placeholder="Enter path category">
                                        </div>
                                        <button type="submit" name="add" name="add_category_btn" class="btn btn-default">Submit Button</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add Category
                            </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Meta Title</th>
                                            <th>Path</th>
                                            <th>Function</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                        $result = $category->read();
                                        $num = $result->rowCount();
                                        if ($num>0) {
                                            while ($row=$result->fetch()) {
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $row['n_category_id']; ?></td>
                                            <td><?php echo $row['v_category_title']; ?></td>
                                            <td><?php echo $row['v_category_meta_title']; ?></td>
                                            <td><?php echo $row['v_category_path']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-default">View</button>
                                                <button type="button" data-toggle="modal" data-target="#edit_category<?php echo $row['n_category_id'] ?>" class="btn btn-default">Edit</button>
                                                <button type="button" data-toggle="modal" data-target="#delete_category<?php echo $row['n_category_id'] ?>" class="btn btn-default">Delete</button>
                                            </td>
                                            <!-- Edit -->
                                            <div class="modal fade" id="edit_category<?php echo $row['n_category_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form role="form" method="POST" action="">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title" id="myModalLabel">Edit Blog Category</h4>
                                                        </div>
                                                        <div class="modal-body">                                  
                                                                <div class="form-group">
                                                                    <label>Category Name</label>
                                                                    <input class="form-control" value="<?php echo $row['v_category_title'] ?>" name="category_title" placeholder="Enter category">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Category Meta Title</label>
                                                                    <input class="form-control" value="<?php echo $row['v_category_meta_title'] ?>" name="category_meta_title" placeholder="Enter meta category">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Category Path</label>
                                                                    <input class="form-control" value="<?php echo $row['v_category_path'] ?>" name="category_path" placeholder="Enter path category">
                                                                </div>
                                                                <input type="hidden" name="category_id" value="<?php echo $row['n_category_id'] ?>">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete -->
                                             <div class="modal fade" id="delete_category<?php echo $row['n_category_id'] ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">                                                        
                                                        <div class="modal-content">
                                                            <form role="form" method="POST" action="">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Warning!!!</h4>
                                                            </div>
                                                            <div class="modal-body">                                      
                                                                    <h2>Do you wanna delete this Category ?</h2>
                                                                    <input type="hidden" name="category_id" value="<?php echo $row['n_category_id'] ?>">                                                    
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="submit" name="delete" class="btn btn-primary">Agree</button>
                                                            </div>
                                                            </form>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                        </tr>
                                    <?php } } ?>
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        </div>
                    <!-- /.panel -->
                </div>
                </div>
				<footer><p>&copy;2022</p></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>