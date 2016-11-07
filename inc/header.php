<?php 
if(isset($_GET['p'])){
?>
<style>
body {
 padding-bottom: 20px;
  min-height:1500px;
  padding-top: 50px;
}
</style>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
<?php } else { ?>
    <!-- Not-Fixed navbar -->
    <div class="navbar navbar-default" role="navigation">

<?php } ?>
	    <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><?php 
		  
			$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key='logo'");
			$row = mysqli_fetch_assoc($result);
			$logo = $row['option_value'];
			
			if($logo != ''){  
			  echo '<img src="'.$logo.'" title="'.SITE_NAME.'" alt="'.SITE_NAME.'" id="logo" />';
		  	}
			else{echo SITE_NAME;}
		  
		  
		  ?></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          
          <?php 
		  
			$result = mysqli_query($con,"SELECT * FROM Navigation WHERE Visible=1 ORDER BY Rank");
			while($row = mysqli_fetch_assoc($result)){
				$navname = $row['Name'];
				$navlink = $row['Link'];
		  
			  if($navlink=="/forums" || strpos($navlink, 'http') !== false){
				  echo '<li><a href="'.$navlink.'" target="_blank">'.$navname.'</a></li>';
			  }
			  else{
				  echo '<li><a href="'.$navlink.'">'.$navname.'</a></li>';
			  }
			  
		  	}
		  
		  
		  ?>

          </ul>
            <p class="navbar-text navbar-right"><?php include('social.php');?></p>
        </div><!--/.nav-collapse -->
      </div>
    </div>
