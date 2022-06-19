<?php  
include "includes/database.php";
include "includes/blogs.php";
include "includes/tags.php";

$database = new database();
$db = $database->connect();
$blogs = new blog($db);

if ($_SERVER['REQUEST_METHOD']=='POST') {
    if (isset($_POST['update'])) {
        $target_file = "../images/upload/";
        if(!empty($_FILES['main_image']['name'])){
            $main_image = $_FILES['main_image']['name'];
            move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file.$main_image);
        }else{
            $main_image=$_POST['old_main_image'];
        }

        if(!empty($_FILES['alt_image']['name'])){
            $alt_image = $_FILES['alt_image']['name'];
            move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file.$alt_image);
        }else{
            $alt_image=$_POST['old_alt_image'];
        }

        $blogs->n_blog_post_id = $_POST['blog_id'];
        $blogs->n_category_id = $_POST['select_category'];
        $blogs->v_post_title = $_POST['title'];
        $blogs->v_post_meta_title = $_POST['meta_title'];
        $blogs->v_post_path = $_POST['blog_path'];
        $blogs->v_post_summary = $_POST['blog_summary'];
        $blogs->v_post_content = $_POST['blog_content'];
        $blogs->v_main_image_url = $main_image;
        $blogs->v_alt_image_url = $alt_image;
        $blogs->n_blog_post_views = $_POST['post_view'];
        $blogs->n_home_page_place = $_POST['opt_place'];
        $blogs->f_post_status = $_POST['status'];
        $blogs->d_date_created = $_POST['date_created'];
        $blogs->d_time_created = $_POST['time_created'];
        $blogs->d_date_updated = date("Y-m-d",time());
        $blogs->d_time_updated = date("h:i:s",time());

        if($blogs->update()){
            $flag = "Update successful!";        
        }
        $new_tag =new tag($db);
        $new_tag->n_blog_post_id = $blogs->n_blog_post_id;
        $new_tag->v_tag = $_POST['blog_tags'];
        $new_tag->update();
    }
}

if ($_SERVER['REQUEST_METHOD']=='POST'){
    if (isset($_POST['write_blog'])) {
        $target_file = "../images/upload/";
        if(!empty($_FILES['main_image']['name'])){
            $main_image = $_FILES['main_image']['name'];
            move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file.$main_image);
        }else{
            $main_image="";
        }

        if(!empty($_FILES['alt_image']['name'])){
            $alt_image = $_FILES['alt_image']['name'];
            move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file.$alt_image);
        }else{
            $alt_image="";
        }
        $blogs->v_post_title = $_POST['title'];
        $blogs->v_post_meta_title = $_POST['meta_title'];
        $blogs->n_category_id = $_POST['select_category'];
        $blogs->v_main_image_url = $main_image;
        $blogs->v_alt_image_url = $alt_image;
        $blogs->v_post_summary = $_POST['blog_summary'];
        $blogs->v_post_content = $_POST['blog_content'];
        $blogs->v_post_path = $_POST['blog_path'];
        $blogs->n_blog_post_views = 0;
        $blogs->f_post_status = 1;
        $blogs->n_home_page_place = empty($_POST['opt_place'])?0:$_POST['opt_place'];
        $blogs->d_date_created = date("Y-m-d",time());
        $blogs->d_time_created = date("h:i:s",time());
        if ($blogs->create()) {
            $flag = "Write complete !";
        }
        $new_tag =new tag($db);
        $new_tag->n_blog_post_id = $blogs->last_id();
        $new_tag->v_tag = $_POST['blog_tags'];
        $new_tag->create();
    }
}

if ($_SERVER['REQUEST_METHOD']=='POST') {
   if(isset($_POST['delete'])){
        $new_tag = new tag($db);
        $new_tag->n_blog_post_id = $_POST['blog_id'];
        $new_tag->delete();

        if($_POST['main_image']!=""){
            unlink("../images/upload/".$_POST['main_image']);
        }

        if($_POST['alt_image']!=""){
            unlink("../images/upload/".$_POST['alt_image']);
        }

        $blogs->n_blog_post_id = $_POST['blog_id'];
        if($blogs->delete()){
            $flag = "Delete successful!";
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
                            Blogs
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
                                Blog post
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
                                        $result = $blogs->read();
                                        $num = $result->rowCount();
                                        if ($num>0) {
                                            while ($row=$result->fetch()) {
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $row['n_blog_post_id']; ?></td>
                                            <td><?php echo $row['v_post_title']; ?></td>
                                            <td><?php echo $row['v_post_meta_title']; ?></td>
                                            <td><?php echo $row['v_post_path']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-default">View</button>
                                                <button class="btn btn-default" onclick="location.href='edit_blogs.php?id=<?php echo $row['n_blog_post_id']?>'">Edit</button>

                                                <button type="button" data-toggle="modal" data-target="#delete_category<?php echo $row['n_blog_post_id'] ?>" class="btn btn-default">Delete</button>
                                            </td>
                                            
                                            <!-- Delete -->
                                             <div class="modal fade" id="delete_category<?php echo $row['n_blog_post_id'] ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">                                                        
                                                        <div class="modal-content">
                                                            <form role="form" method="POST" action="">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Warning!!!</h4>
                                                            </div>
                                                            <div class="modal-body">                                      
                                                                    <h1>Do you wanna delete this Blog ?</h1>                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <input type="hidden" name="main_image" value="<?php echo $row['v_main_image_url'] ?>">
                                                                <input type="hidden" name="alt_image" value="<?php echo $row['v_alt_image_url'] ?>">
                                                                <input type="hidden" name="blog_id" value="<?php echo $row['n_blog_post_id']; ?>">
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