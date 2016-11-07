<h1 class="page-header">Ranks</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$oldrank = htmlentities($_POST['old_rank']);
		$name = htmlentities($_POST['rank_name']);
				
		mysqli_query($con,"UPDATE Ranks SET Name='$name' WHERE ID='$ID'");
		mysqli_query($con,"UPDATE Roster SET Rank='$name' WHERE Rank='$oldrank'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Rank "'.$name.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$name = htmlentities($_POST['rank_name']);

		$result = mysqli_query($con,"SELECT * FROM Ranks");
		$numrows = mysqli_num_rows($result);
		$rank = $numrows+1;
						
		mysqli_query($con,"INSERT INTO Ranks (Name, Level) VALUES ('$name','$rank')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Rank "'.$name.'" added.</div>';
	
	}
}

if(isset($_GET['delete']) && !isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Ranks WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
					
	echo '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button><b>Caution! Deleting a rank will leave members of that rank without one!</b> Are you sure you want to delete rank "'.$name.'"? ';
	echo '<a href="?delete&confirm&ID='.$ID.'">Yes, delete it.</a> <a href="/admin/ranks">No, go back.</a></div>';
	
}
if(isset($_GET['delete']) && isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Ranks WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
	$rank = $row['Level'];
				
	mysqli_query($con,"DELETE FROM Ranks WHERE id='$ID'");
	mysqli_query($con,"UPDATE Roster SET Rank='' WHERE Rank='$name'");

	$result = mysqli_query($con,"SELECT * FROM Ranks WHERE Level > $rank");
	while($row = mysqli_fetch_assoc($result)){
		$editID = $row['ID'];
		$editRank = $row['Level'];
		mysqli_query($con,"UPDATE Widgets SET Level=($editRank-1) WHERE ID=$editID");	
	}
	

	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Rank "'.$name.'" deleted. <b>Make sure to assign a new rank to affected members.</b></div>';
	
}		

if(isset($_GET['up'])){
	$ID = $_GET['ID'];
	$rank = $_GET['rank'];
	
	mysqli_query($con,"UPDATE Ranks SET Level=$rank WHERE Level=($rank-1)");	
	mysqli_query($con,"UPDATE Ranks SET Level=($rank-1) WHERE ID='$ID'");	
}

if(isset($_GET['down'])){
	$ID = $_GET['ID'];
	$rank = $_GET['rank'];
	
	mysqli_query($con,"UPDATE Ranks SET Level=$rank WHERE Level=($rank+1)");	
	mysqli_query($con,"UPDATE Ranks SET Level=($rank+1) WHERE ID='$ID'");	
}	

if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Rank</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Rank</button></a>

<?php 

}
if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Ranks WHERE ID='$ID' ORDER BY Level");
	$row = mysqli_fetch_assoc($result);
	$name = $row['Name'];
	?>
		
	<form method="post" action="" name="rankedit" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Rank</th></tr></thead>
		
	<tr><td>
	<label for="rank_name" class="col-sm-1 control-label">Rank Name</label>
	<div class="col-sm-4">
	<input id="rank_name" type="text" name="rank_name" class="form-control" placeholder="Rank Name" value="<?php echo $name; ?>" required />
	</div>
	</td></tr>
    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="<?php echo $name;?>" name="old_rank" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/ranks"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>
		
	<?php 		
				
	}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){

?>


	<form method="post" action="" name="rankadd" class="form-horizontal" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Add New Rank</th></tr></thead>
		
	<tr><td>
	<label for="rank_name" class="col-sm-1 control-label">Rank Name</label>
	<div class="col-sm-4">
	<input id="rank_name" type="text" name="rank_name" class="form-control" placeholder="Rank Name" required />
	</div>
	</td></tr>
    <input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/ranks"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>

<h3>Current Ranks</h3>
<table class="table table-hover" data-sortable>
<thead>
<tr><th class="col-sm-1">Rank Level</th><th class="col-sm-7">Rank Name</th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<?php

	$result = mysqli_query($con,"SELECT * FROM Ranks ORDER BY Level");
	$numrows = mysqli_num_rows($result);
	while($row = mysqli_fetch_assoc($result)){
		$rankname = $row['Name'];
		$ranklevel = $row['Level'];
		$ID = $row['ID'];
		
		echo '<tr>';
		echo '<td>';
		if($ranklevel > 1){
			echo '<a alt="Up" title="Up" href="?up&ID='.$ID.'&rank='.$ranklevel.'"><span class="glyphicon glyphicon-chevron-up"></span></a> ';
		}
		else { echo '<span class="glyphicon glyphicon-chevron-up" style="opacity:0.1"></span> ';}
		if ($ranklevel <= $numrows - 1){
			echo '<a alt="Down" title="Down" href="?down&ID='.$ID.'&rank='.$ranklevel.'"><span class="glyphicon glyphicon-chevron-down"></span></a>';
		}
		else { echo '<span class="glyphicon glyphicon-chevron-down" style="opacity:0.1"></span> ';}
		echo '</td>';
		echo '<td>'.$rankname.'</td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}
		


?>


</table>


</div>


