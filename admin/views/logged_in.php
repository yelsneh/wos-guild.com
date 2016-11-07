<?php 

include('_header.php');
require_once("connect.php");

?>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="/" target="_blank"><?php echo SITE_NAME; ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          	<li><a href="/admin/profile">Hi, <?php echo $_SESSION['user_name']; ?>.</a></li>
            <li><a href="index.php?logout">Log Out</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="container-fluid">
    


      <div class="row">
		<?php include("sidebar.php"); ?>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        
            
<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$error.'</div>';;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$message.'</div>';
        }
    }
}
?>

<?php
// show potential errors / feedback (from registration object)
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$error.'</div>';;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$message.'</div>';
        }
    }
}
?>



        <?php 
		$p = isset($_GET['p']) ? $_GET['p'] : "settings";
error_log("p is ");
error_log($p);
error_log(gettype($p));
error_log(var_dump($_GET));
error_log($p);
error_log(debug_backtrace());
		include_once($p . ".php");
	?>

        </div>
      </div>
    </div>
   
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>

    <script>
			var path = window.location.pathname;
			path = path.replace(/\/$/, "");
			path = decodeURIComponent(path);
		
			$(".nav a").each(function () {
				var href = $(this).attr('href');
				if (path.substring(0, href.length) === href) {
					$(this).closest('li').addClass('active');
				}
			});
	</script>

<?php include('_footer.php'); ?>

