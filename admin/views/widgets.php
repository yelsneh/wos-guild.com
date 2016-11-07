<h1 class="page-header">Sidebar Widgets</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$name = htmlspecialchars($_POST['widget_name']);
		$showname = $_POST['show_name'];
		$showwidget = $_POST['show_widget'];
		$content = mysqli_real_escape_string($con, $_POST['widget_content']);
		$side = $_POST['widget_side'];		
	
		mysqli_query($con,"UPDATE Widgets SET Name='$name', Content='$content', ShowName='$showname', ShowWidget='$showwidget', Side='$side' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Widget "'.$name.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$name = $_POST['widget_name'];
		$showname = $_POST['show_name'];
		$showwidget = $_POST['show_widget'];
		$content = mysqli_real_escape_string($con, $_POST['widget_content']);
		$side = $_POST['widget_side'];		
								
		$result = mysqli_query($con,"SELECT * FROM Widgets");
		$numrows = mysqli_num_rows($result);
		$rank = $numrows+1;


		mysqli_query($con,"INSERT INTO Widgets (Name,Rank,Content,ShowName,ShowWidget,Side) VALUES ('$name','$rank','$content','$showname','$showwidget','$side')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Widget "'.$name.'" added.</div>';
	
	}
}


if(isset($_GET['enable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE Widgets SET ShowWidget=1 WHERE ID='$ID'");	
}

if(isset($_GET['disable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE Widgets SET ShowWidget=0 WHERE ID='$ID'");	
}
	
if(isset($_GET['up'])){
	$ID = $_GET['ID'];
	$rank = $_GET['rank'];
	
	mysqli_query($con,"UPDATE Widgets SET Rank=$rank WHERE Rank=($rank-1)");	
	mysqli_query($con,"UPDATE Widgets SET Rank=($rank-1) WHERE ID='$ID'");	
}

if(isset($_GET['down'])){
	$ID = $_GET['ID'];
	$rank = $_GET['rank'];
	
	mysqli_query($con,"UPDATE Widgets SET Rank=$rank WHERE Rank=($rank+1)");	
	mysqli_query($con,"UPDATE Widgets SET Rank=($rank+1) WHERE ID='$ID'");	
}
	
	
if(isset($_GET['delete']) && !isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	if($ID<=6){
	echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Sorry, you can\'t delete this widget.</div>';		
	}
	else{
	$result = mysqli_query($con,"SELECT * FROM Widgets WHERE id='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
				
	echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Are you sure you want to delete widget "'.$name.'"? ';
	echo '<a href="?delete&confirm&ID='.$ID.'">Yes, delete it.</a> <a href="/admin/widgets">No, go back.</a></div>';
	}
}
if(isset($_GET['delete']) && isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	if($ID<=6){
	echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Sorry, you can\'t delete this widget.</div>';		
	}
	else{
	$result = mysqli_query($con,"SELECT * FROM Widgets WHERE id='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
	$rank = $row['Rank'];
				
	mysqli_query($con,"DELETE FROM Widgets WHERE id='$ID'");

	$result = mysqli_query($con,"SELECT * FROM Widgets WHERE Rank > $rank");
	while($row = mysqli_fetch_assoc($result)){
		$editID = $row['ID'];
		$editRank = $row['Rank'];
		mysqli_query($con,"UPDATE Widgets SET Rank=($editRank-1) WHERE ID=$editID");	
	}
	
	
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Widget "'.$name.'" deleted.</div>';
	}
}				

if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Widget</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Widget</button></a>

<?php 

}
if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Widgets WHERE ID='$ID' ORDER BY Rank");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
	$content = $row['Content'];
	$showname = $row['ShowName'];
	$showwidget = $row['ShowWidget'];
	$side = $row['Side'];

	?>
		
	<form method="post" action="" name="widgetedit" class="form-horizontal form-settings" role="form" enctype="application/x-www-form-urlencoded">
	
	<table class="table">
	<thead><tr><th>Edit Widget</th></tr></thead>
		
	<tr><td>
	<label for="widget_name" class="col-sm-1 control-label">Widget Name</label>
	<div class="col-sm-4">
	<input id="widget_name" type="text" name="widget_name" class="form-control" placeholder="Widget Name" value="<?php echo $name; ?>" required />
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="show_name" <?php if($showname==1){ echo 'checked';} ?> value="1" /> Show name above widget?
    </label>
	</div>
	</td></tr>  
    
    <tr><td>
	<label for="existing" class="col-sm-1 control-label">Widget Type</label>
	<div class="col-sm-4">
    <input type="text" readonly class="form-control"  value="<?php
		if($ID==1){ echo "Recruiting";} 
		else if($ID==2){ echo "Achievements";}
		else if($ID==3){ echo "Post Tags";}
		else if($ID==4){ echo "Post Archive";}
		else if($ID==6){ echo "Progression";}
		else if($ID==5){ echo "Media";} ?>" />
    </div>
	</td></tr>
    <tr><td>
    <label for="widget_side" class="col-sm-1 control-label">Sidebar?</label>
	<div class="col-sm-1">
	<select class="form-control" name="widget_side">    
    <?php
		echo '<option value="left" ';
		if($side=='left'){ echo "selected";}
		echo ' >Left</option>';
		echo '<option value="right" ';
		if($side=='right'){ echo "selected";}
		echo ' >Right</option>';	
	?>
	</select>
	</div>
    </td></tr>    
	<tr><td>
	<label for="widget_content" class="col-sm-1 control-label">Widget Content</label>
    <div class="col-sm-11">
	<textarea name="widget_content" class="form-control" id="edit" style="margin-top: 30px;"><?php echo $content; ?></textarea>
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="show_widget" <?php if($showwidget==1){ echo 'checked';} ?> value="1" /> Show widget?
    </label>
    </div>
	</td></tr>   
 
    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/widgets"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>
		
	<?php 		
				
	}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){

	$result = mysqli_query($con,"SELECT * FROM Pages");
	$pages = array();
	while($row = mysqli_fetch_assoc($result)){
		$Page = $row['Page'];
		array_push($pages, $Page);		
	}
	
?>


	<form method="post" action="" name="widgetadd" class="form-horizontal" role="form">
	
	<table class="table">
	<thead><tr><th>Add New Widget</th></tr></thead>
		
	<tr><td>
	<label for="widget_name" class="col-sm-1 control-label">Widget Name</label>
	<div class="col-sm-4">
	<input id="widget_name" type="text" name="widget_name" class="form-control" placeholder="Widget Name" required />
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="show_name" checked value="1" /> Show name above widget?
    </label>
	</div>
	</td></tr>
    <tr><td>
    <label for="widget_side" class="col-sm-1 control-label">Sidebar?</label>
	<div class="col-sm-1">
	<select class="form-control" name="widget_side">    
		<option value="left" selected>Left</option>
        <option value="right" selected>Right</option>
	</select>
    </div>
    </td></tr>  
	<tr><td>
	<label for="widget_content" class="col-sm-1 control-label">Widget Content</label>
    <div class="col-sm-11">
	<textarea name="widget_content" class="form-control" id="edit" style="margin-top: 30px;"></textarea>
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="show_widget" checked value="1" /> Show widget?
    </label>
    </div>
	</td></tr>   

    <input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/widgets"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>

<h3>Current Widgets</h3>
<table class="table table-hover" data-sortable>
<thead>
<tr><th class="col-sm-1">Order</th><th class="col-sm-1">Side</th><th class="col-sm-2">Type</th><th class="col-sm-4">Name</th><th class="col-sm-1"></th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<?php

	$result = mysqli_query($con,"SELECT * FROM Widgets ORDER BY Rank");
	$numrows = mysqli_num_rows($result);
	while($row = mysqli_fetch_assoc($result)){
		$ID = $row['ID'];
		$name = $row['Name'];
		$rank = $row['Rank'];
		$showwidget = $row['ShowWidget'];
		$side = $row['Side'];
		
		if($showwidget==1){$status='<a alt="Disable" title="Disable" href="?disable&ID='.$ID.'"><span class="glyphicon glyphicon-ban-circle"></span></a>';}
		else {$status='<a alt="Enable" title="Enable" href="?enable&ID='.$ID.'"><span class="glyphicon glyphicon-ok-circle"></span></a>';}
		
		echo '<tr>';
		echo '<td>';
		if($rank > 1){
			echo '<a alt="Up" title="Up" href="?up&ID='.$ID.'&rank='.$rank.'"><span class="glyphicon glyphicon-chevron-up"></span></a> ';
		}
		else { echo '<span class="glyphicon glyphicon-chevron-up" style="opacity:0.1"></span> ';}
		if ($rank <= $numrows - 1){
			echo '<a alt="Down" title="Down" href="?down&ID='.$ID.'&rank='.$rank.'"><span class="glyphicon glyphicon-chevron-down"></span></a>';
		}
		else { echo '<span class="glyphicon glyphicon-chevron-down" style="opacity:0.1"></span> ';}
		echo '</td>';
		echo '<td>'.$side.'</td>';
		if($ID == 1){
		echo '<td>Recruiting</td>';
		}
		else if($ID == 2){
		echo '<td>Achievements</td>';
		}
		else if($ID == 3){
		echo '<td>Tags</td>';
		}
		else if($ID == 4){
		echo '<td>Archive</td>';
		}
		else if($ID == 5){
		echo '<td>Media</td>';
		}
		else if($ID == 6){
		echo '<td>Progression</td>';
		}
		else {
		echo '<td>Custom</td>';
		}
		echo '<td>'.$name.'</td>';
		echo '<td>'.$status.'</td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		if($ID != 1 && $ID != 2 && $ID != 3 && $ID != 4 && $ID != 5 && $ID != 6){
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		}
		else {
		echo '<td></td>';
		}
		echo '</tr>';
	}

?>


</table>


</div>


