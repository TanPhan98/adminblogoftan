<?php  
include "includes/database.php";
include "includes/comments.php";

$database = new database();
$db = $database->connect();
$comment = new comment($db);


if ($_SERVER['REQUEST_METHOD']=='POST') {
   if(isset($_POST['delete'])){
        $comment->n_blog_comment_id = $_POST['blog_comment_id'];
        if($comment->delete()){
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
                                            <th>Blog Comment Parent ID</th>                       
                                            <th>Blog Post ID</th>
                                            <th>Comment Author</th>
                                            <th>Comment Author Email</th>
                                            <th>Comment</th>
                                            <th>Function</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                        $result = $comment->read();
                                        $num = $result->rowCount();
                                        if ($num>0) {
                                            while ($row=$result->fetch()) {
                                        
                                        ?>
                                        <tr>
                                            <td><?php echo $row['n_blog_comment_id']; ?></td>
                                            <td><?php echo $row['n_blog_comment_parent_id']; ?></td>
                                            <td><?php echo $row['n_blog_post_id']; ?></td>
                                            <td><?php echo $row['v_comment_author']; ?></td>
                                            <td><?php echo $row['v_comment_author_email']; ?></td>
                                            <td><?php echo $row['v_comment']; ?></td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#delete_comment<?php echo $row['n_blog_comment_id'] ?>" class="btn btn-default">Delete</button>
                                            </td>
                                            
                                            <!-- Delete -->
                                             <div class="modal fade" id="delete_comment<?php echo $row['n_blog_comment_id'] ?>" tabindex="1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">                                                        
                                                        <div class="modal-content">
                                                            <form role="form" method="POST" action="">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="myModalLabel">Warning!!!</h4>
                                                            </div>
                                                            <div class="modal-body">                                      
                                                                    <h2>Do you wanna delete this Comment ?</h2>                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <!-- <input type="hidden" name="form_name" value="delete_blog"> -->
                                                                <input type="hidden" name="blog_comment_id" value="<?php echo $row['n_blog_comment_id'] ?>">
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