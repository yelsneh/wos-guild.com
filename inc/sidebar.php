<?php 
		  
	$widgetresult = mysqli_query($con,"SELECT * FROM Widgets WHERE ShowWidget=1 ORDER BY Rank");
			
	while($widgetrow = mysqli_fetch_assoc($widgetresult)){
		$ID = $widgetrow['ID'];
		$name = $widgetrow['Name'];
		$showname = $widgetrow['ShowName'];
		$content = $widgetrow['Content'];
		
		if($ID==1){
			echo '<div class="sidebar-module">';
			
			if($showname==1){
			echo '<h3>'.$name.'</h3>';
			}
			echo $content;
			
			include('recruiting.php');
			if(!strpos($_SERVER['REQUEST_URI'], 'recruit')){ 
				echo '<p><a class="btn btn-default" href="https://forums.temerityofwindrunner.com/forums/2-Recruitment" target="_blank" role="button">Apply &raquo;</a></p>';
			}
			
			echo '</div>';
		}
		else if($ID==2){
			if(!strpos($_SERVER['REQUEST_URI'], 'achieve')){
				echo '<div class="sidebar-module">';
				
				if($showname==1){
				echo '<h3>'.$name.'</h3>';
				}
				echo $content;
				include('achievebox.php');
				echo '<p><a class="btn btn-default" href="/latest-achievements" role="button">See More &raquo;</a></p>';
			echo '</div>';
			}
			
		}	
		else if($ID==3){
			echo '<div class="sidebar-module">';
			
			if($showname==1){
			echo '<h3>'.$name.'</h3>';
			}
			echo $content;

			include('tags.php');
			echo '</div>';
		}	
		else if($ID==4){
			echo '<div class="sidebar-module">';
			
			if($showname==1){
			echo '<h3>'.$name.'</h3>';
			}
			echo $content;

			include('archive.php');
			echo '</div>';
		}	
		else if($ID==5){
			if(!strpos($_SERVER['REQUEST_URI'], 'media')){
				echo '<div class="sidebar-module">';
				
				if($showname==1){
				echo '<h3>'.$name.'</h3>';
				}
				echo $content;
				include('mediabox.php');
				echo '<p><a class="btn btn-default" href="/media" role="button">See More &raquo;</a></p>';
			echo '</div>';
			}
			
		}
		else{
			echo '<div class="sidebar-module">';
			
			if($showname==1){
			echo '<h3>'.$name.'</h3>';
			}
			echo $content;
			echo '</div>';

		}
		

			  
	}
		  
		  
?>
          
          
