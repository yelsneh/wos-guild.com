<h1 class="page-header">Streams</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$name = htmlentities($_POST['stream_name']);
				
		mysqli_query($con,"UPDATE Streams SET Name='$name' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$name.' updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$name = htmlentities($_POST['stream_name']);
				
		mysqli_query($con,"INSERT INTO Streams (Name) VALUES ('$name')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$name.' added.</div>';
	
	}
}
if(isset($_GET['delete'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Streams WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
				
	mysqli_query($con,"DELETE FROM Streams WHERE ID='$ID'");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>'.$name.' deleted. <a href="?undo&Name='.$name.'">Undo?</a></div>';
	
}	
if(isset($_GET['undo'])){
	$name = htmlentities($_GET['Name']);
					
	mysqli_query($con,"INSERT INTO Streams (Name) VALUES ('$name')");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>'.$name.' restored.</div>';
	
}		

if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Channel</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Channel</button></a>

<?php 

}
if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Streams WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$streamname = $row['Name'];
	?>
		
	<form method="post" action="" name="streamedit" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Channel</th></tr></thead>
		
	<tr><td>
	<label for="stream_name" class="sr-only">Channel Name</label>
	<div class="col-sm-4">
	<input id="stream_name" type="text" name="stream_name" class="form-control" placeholder="Channel Name" value="<?php echo $streamname; ?>" required />
	</div>
	</td></tr>
	<input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/streams"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>
		
	<?php 		
				
	}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){

?>


	<form method="post" action="" name="streamadd" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Add New Channel</th></tr></thead>
		
	<tr><td>
	<label for="stream_name" class="sr-only">Channel Name</label>
	<div class="col-sm-4">
	<input id="stream_name" type="text" name="stream_name" class="form-control" placeholder="Channel Name" required />
	</div>
	</td></tr>
	<input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/streams"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>

<h3>Current Streams</h3>
<table class="table table-hover" data-sortable>
<thead>
<tr><th class="col-sm-7">Channel Name</th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<?php

	$result = mysqli_query($con,"SELECT * FROM Streams ORDER BY Name");
	while($row = mysqli_fetch_assoc($result)){
		$streamname = $row['Name'];
		$streamID = $row['ID'];
		echo '<tr>';
		echo '<td>'.$streamname.'</td>';
		echo '<td><a alt="Preview" title="Preview" href="javascript:void(0);" onClick="window.open(\'http://twitch.tv/'.$streamname.'\',\'_blank\', \'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=200, width=1200, height=800\');"><span class="glyphicon glyphicon-eye-open"></span></a></td>';
		echo '<td><a href="?edit&ID='.$streamID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a href="?delete&ID='.$streamID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}
		


?>


</table>


</div>


