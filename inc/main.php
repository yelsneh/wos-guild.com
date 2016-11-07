      <div class="row">
		<?php $leftquery = mysqli_query($con,"SELECT COUNT(id) AS numleftrows FROM Widgets WHERE ShowWidget=1 AND Side LIKE 'left'");
			  		$countleft = mysqli_fetch_assoc($leftquery);
					$numleftrows = $countleft['numleftrows'];
					
				$rightquery = mysqli_query($con,"SELECT COUNT(id) AS numrightrows FROM Widgets WHERE ShowWidget=1 AND Side LIKE 'right'");
			  		$countright = mysqli_fetch_assoc($rightquery);
					$numrightrows = $countright['numrightrows'];
					
					
		if ($numleftrows > 0){
		?>
		<div class="col-sm-3">
        	   <?php include('leftbar.php'); ?>
        </div>
        <?php } 
		if ($numleftrows == 0 && $numrightrows == 0){ 
        	echo '<div class="col-sm-12">';
		}
		elseif (($numleftrows == 0 && $numrightrows > 0) || ($numleftrows > 0 && $numrightrows == 0)){ 
        	echo '<div class="col-sm-9">';
		}
		else{
        	echo '<div class="col-sm-6">';
		}?>
                <h2>Latest News</h2>
              <?php include('latest.php'); ?>
              
              <?php $result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'posts'");
					$row = mysqli_fetch_assoc($result);
					$postsperpage = $row['option_value'];
	
					$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News ORDER BY date_posted DESC");
			  		$countrow = mysqli_fetch_assoc($query);
					$numrows = $countrow['numrows'];
					
					if ($numrows > $postsperpage){ ?>
              <p><a class="btn btn-default" href="/news/page2" role="button">&laquo; Previous</a></p>
              		<?php } ?>


        </div>
		<?php $rightquery = mysqli_query($con,"SELECT COUNT(id) AS numrightrows FROM Widgets WHERE Side LIKE 'left'");
			  		$countright = mysqli_fetch_assoc($rightquery);
					$numrightrows = $countright['numrightrows'];
					
					if ($numrightrows > 0){
		?>
		<div class="col-sm-3">
        	   <?php include('rightbar.php'); ?>
        </div>
        <?php } ?>
      </div>

