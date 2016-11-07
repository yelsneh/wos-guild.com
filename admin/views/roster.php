<h1 class="page-header">Roster</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$rank = $_POST['member_rank'];
		$name = htmlentities($_POST['member_name']);
				
		mysqli_query($con,"UPDATE Roster SET Rank='$rank', Name='$name' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$name.' updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$rank = $_POST['member_rank'];
		$name = htmlentities($_POST['member_name']);
				
		mysqli_query($con,"INSERT INTO Roster (Rank, Name) VALUES ('$rank', '$name')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$name.' added.</div>';
	
	}
}
if(isset($_GET['delete'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Roster WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$memberrank = $row['Rank'];
	$membername = $row['Name'];
				
	mysqli_query($con,"DELETE FROM Roster WHERE ID='$ID'");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>'.$membername.' deleted. <a href="?undo&Rank='.$memberrank.'&Name='.$membername.'">Undo?</a></div>';
	
}	
if(isset($_GET['undo'])){
	$Rank = $_GET['Rank'];
	$Name = htmlentities($_GET['Name']);
					
	mysqli_query($con,"INSERT INTO Roster (Rank, Name) VALUES ('$Rank', '$Name')");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>'.$Name.' restored.</div>';
	
}		

if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Member</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Member</button></a>

<?php 

}

if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Roster WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$membername = $row['Name'];
	$memberrank = $row['Rank'];
	
	
	$result = mysqli_query($con,"SELECT * FROM Ranks");
	$ranks = array();
	while($row = mysqli_fetch_assoc($result)){
		$RankName = $row['Name'];
		array_push($ranks, $RankName);		
	}
	
	
	?>
		
	<form method="post" action="" name="memberedit" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Member</th></tr></thead>
		
	<tr><td>
	<label for="member_rank" class="sr-only">Rank</label>
	<div class="col-sm-1">
	<select class="form-control" name="member_rank">    
    <?php
	
	foreach($ranks as $rank){
		echo '<option value="'.$rank.'" ';
		if($memberrank==$rank){ echo "selected";}
		echo ' >'.$rank.'</option>';
	}

	?>
	</select>
	</div>
	<label for="member_name" class="sr-only">Member Name</label>
	<div class="col-sm-4">
	<input id="member_name" type="text" name="member_name" class="form-control" placeholder="Member Name" value="<?php echo $membername; ?>" required />
	</div>
	</td></tr>
	<input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/roster"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>
		
	<?php 		
				
	}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){


	$result = mysqli_query($con,"SELECT * FROM Ranks");
	$ranks = array();
	while($row = mysqli_fetch_assoc($result)){
		$RankName = $row['Name'];
		array_push($ranks, $RankName);		
	}
	
	
?>


	<form method="post" action="" name="memberadd" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Add New Member</th></tr></thead>
		
	<tr><td>
	<label for="member_rank" class="sr-only">Rank</label>
	<div class="col-sm-1">
	<select class="form-control" name="member_rank">
    <?php
	
	foreach($ranks as $rank){
		echo '<option value="'.$rank.'" >'.$rank.'</option>';
	}

	?>
	</select>
	</div>
	<label for="member_name" class="sr-only">Member Name</label>
	<div class="col-sm-4">
	<input id="member_name" type="text" name="member_name" class="form-control" placeholder="Member Name" required />
	</div>
	</td></tr>
	<input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/roster"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}



 ?>

<h3>Current Roster</h3>
<table class="table table-hover paginate-table" data-sortable>
<thead>
<tr><th class="col-sm-1">Rank</th><th class="col-sm-7">Name</th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<tbody>
<?php

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'realm'");
	$row = mysqli_fetch_assoc($result);
	$realm = $row['option_value'];
	$realm = str_replace(' ','-', $realm);
	$realm = str_replace("'","", $realm);

	$armory = 'http://us.battle.net/wow/en/character/'.$realm.'/';

	$result = mysqli_query($con,"SELECT * FROM Roster ORDER BY Rank");
	while($row = mysqli_fetch_assoc($result)){
		$membername = $row['Name'];
		$memberrank = $row['Rank'];
		$memberID = $row['ID'];
		echo '<tr>';
		echo '<td>'.$memberrank.'</td><td><a href="'.$armory.$membername.'/advanced" target="_blank">'.$membername.'</a></td>';
		echo '<td><a href="?edit&ID='.$memberID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a href="?delete&ID='.$memberID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}
		
	

?>

</tbody>
</table>


</div>


