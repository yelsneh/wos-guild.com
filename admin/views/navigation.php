<h1 class="page-header">Navigation</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$name = htmlentities($_POST['nav_name']);
		$page = htmlentities($_POST['pages']);
		$link = htmlentities($_POST['link']);
		$visible = $_POST['visible'];
		
		if($page!="0"){$navlink=$page;}
		else{$navlink=$link;}
		
	
		mysqli_query($con,"UPDATE Navigation SET Name='$name', Link='$navlink', Visible='$visible' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Link "'.$name.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$name = htmlentities($_POST['nav_name']);
		$page = htmlentities($_POST['pages']);
		$link = htmlentities($_POST['link']);
		$visible = $_POST['visible'];
		
		if($page!="0"){$navlink=$page;}
		else{$navlink=$link;}

		$result = mysqli_query($con,"SELECT * FROM Navigation");
		$numrows = mysqli_num_rows($result);
		$rank = $numrows+1;

						
		mysqli_query($con,"INSERT INTO Navigation (Name, Rank, Link, Visible) VALUES ('$name','$rank','$navlink','$visible')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Link "'.$name.'" added.</div>';
	
	}
}

if(isset($_GET['delete'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Navigation WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$rank = $row['Rank'];
	$name = $row['Name'];
	$link = $row['Link'];

	mysqli_query($con,"DELETE FROM Navigation WHERE ID='$ID'");

	$result = mysqli_query($con,"SELECT * FROM Navigation WHERE Rank > $rank");
	while($row = mysqli_fetch_assoc($result)){
		$editID = $row['ID'];
		$editRank = $row['Rank'];
		mysqli_query($con,"UPDATE Navigation SET Rank=($editRank-1) WHERE ID=$editID");	
	}

	$result = mysqli_query($con,"SELECT * FROM Navigation");
	$numrows = mysqli_num_rows($result);
	$newrank = $numrows+1;
				
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Link "'.$name.'" deleted. <a href="?undo&Rank='.$newrank.'&Name='.$name.'&Link='.$link.'">Undo?</a></div>';
	
}	
if(isset($_GET['undo'])){
	$rank = $_GET['Rank'];
	$name = $_GET['Name'];
	$link = htmlentities($_GET['Link']);
							
	mysqli_query($con,"INSERT INTO Navigation (Rank, Name, Link,Visible) VALUES ('$rank', '$name','$link',1)");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Link "'.$name.'" restored.</div>';
	
}				


if(isset($_GET['enable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE Navigation SET Visible=1 WHERE ID='$ID'");	
}

if(isset($_GET['disable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE Navigation SET Visible=0 WHERE ID='$ID'");	
}

if(isset($_GET['up'])){
	$ID = $_GET['ID'];
	$rank = $_GET['rank'];
	
	mysqli_query($con,"UPDATE Navigation SET Rank=$rank WHERE Rank=($rank-1)");	
	mysqli_query($con,"UPDATE Navigation SET Rank=($rank-1) WHERE ID='$ID'");	
}

if(isset($_GET['down'])){
	$ID = $_GET['ID'];
	$rank = $_GET['rank'];
	
	mysqli_query($con,"UPDATE Navigation SET Rank=$rank WHERE Rank=($rank+1)");	
	mysqli_query($con,"UPDATE Navigation SET Rank=($rank+1) WHERE ID='$ID'");	
}


if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Link</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Link</button></a>

<?php 

}
if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Navigation WHERE ID='$ID' ORDER BY Rank");
	$row = mysqli_fetch_assoc($result);
	$navname = $row['Name'];
	$navlink = $row['Link'];
	$visible = $row['Visible'];
	
	$result = mysqli_query($con,"SELECT * FROM Pages");
	$pages = array();
	while($row = mysqli_fetch_assoc($result)){
		$Page = $row['Page'];
		array_push($pages, $Page);		
	}
	
	$link='';
	?>
		
	<form method="post" action="" name="linkedit" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Link</th></tr></thead>
		
	<tr><td>
	<label for="nav_name" class="col-sm-1 control-label">Link Title</label>
	<div class="col-sm-4">
	<input id="nav_name" type="text" name="nav_name" class="form-control" placeholder="Link Title" value="<?php echo $navname; ?>" required />
	</div>
	</td></tr>
	<tr><td>
	<label for="pages" class="col-sm-1 control-label">Link Location</label>
	<div class="col-sm-4">    
   		<?php 
		
		if($navlink=='/forums' || $navlink=='/latest-achievements' || $navlink=='/roster' || $navlink=='/media' || $navlink=='/news'){
			echo '<input id="pages" type="text" name="pages" class="form-control" value="'.$navlink.'" readonly />';
		} 
		else if(in_array(substr($navlink,1), $pages)){
				echo '<input id="pages" type="text" name="pages" class="form-control" value="'.$navlink.'" readonly />';
		}
		else {
		?>
       
            <select class="form-control" name="pages" id="pages" onChange="disableLink();">
            <option value="0" >Select existing page...</option>
            <?php
            
            foreach($pages as $p){
                echo '<option value="/'.$p.'">'.ucfirst(str_replace('-',' ',$p)).'</option>';
            }
        
            ?>
            </select><p><span class="help-block">- OR -</span></p>
            <input id="link" type="text" name="link" class="form-control" value="<?php echo $navlink;?>" <?php if($link!=''){echo "disabled";} ?> />
            
        <?php } ?>
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="visible" <?php if($visible==1){ echo 'checked';} ?> value="1" /> Show in navigation?
    </label>
    </div>
	</td></tr>
    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/navigation"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
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


	<form method="post" action="" name="linkadd" class="form-horizontal" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Add New Link</th></tr></thead>
		
	<tr><td>
	<label for="nav_name" class="col-sm-1 control-label">Link Title</label>
	<div class="col-sm-4">
	<input id="nav_name" type="text" name="nav_name" class="form-control" placeholder="Link Name" required />
	</div>
	</td></tr>
	<tr><td>
	<label for="pages" class="col-sm-1 control-label">Link Location</label>
	<div class="col-sm-4">    
    <select class="form-control" name="pages" id="pages" onChange="disableLink();">
		<option value="0" >Select existing page...</option>
    <?php
	
	foreach($pages as $p){
		echo '<option value="/'.$p.'" >'.ucfirst(str_replace('-',' ',$p)).'</option>';
	}

	?>
		<option value="/forums" >Forums</option>
		<option value="/latest-achievements" >Achievements</option>
		<option value="/media" >Media</option>
		<option value="/roster" >Roster</option>
		<option value="/news" >News</option>
	</select><p><span class="help-block">- OR -</span></p>
	<input id="link" type="text" name="link" class="form-control" placeholder="New Location: URL or Site Path" />
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="visible" checked value="1" /> Show in navigation?
    </label>
	</div>
	</td></tr>
    <input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/navigation"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>

<h3>Current Navigation</h3>
<table class="table table-hover" data-sortable>
<thead>
<tr><th class="col-sm-1">Order</th><th class="col-sm-2">Title</th><th class="col-sm-4">Location</th><th class="col-sm-1" ></th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<?php

	$result = mysqli_query($con,"SELECT * FROM Navigation ORDER BY Rank");
	$numrows = mysqli_num_rows($result);
	while($row = mysqli_fetch_assoc($result)){
		$navname = $row['Name'];
		$navrank = $row['Rank'];
		$navlink = $row['Link'];
		$ID = $row['ID'];

		$visible = $row['Visible'];
		
		if($visible==1){$status='<a alt="Disable" title="Disable" href="?disable&ID='.$ID.'"><span class="glyphicon glyphicon-ban-circle"></span></a>';}
		else {$status='<a alt="Enable" title="Enable" href="?enable&ID='.$ID.'"><span class="glyphicon glyphicon-ok-circle"></span></a>';}


		echo '<tr>';
		echo '<td>';
		if($navrank > 1){
			echo '<a alt="Up" title="Up" href="?up&ID='.$ID.'&rank='.$navrank.'"><span class="glyphicon glyphicon-chevron-up"></span></a> ';
		}
		else { echo '<span class="glyphicon glyphicon-chevron-up" style="opacity:0.1"></span> ';}
		if ($navrank <= $numrows - 1){
			echo '<a alt="Down" title="Down" href="?down&ID='.$ID.'&rank='.$navrank.'"><span class="glyphicon glyphicon-chevron-down"></span></a>';
		}
		else { echo '<span class="glyphicon glyphicon-chevron-down" style="opacity:0.1"></span> ';}
		echo '</td>';
		echo '<td>'.$navname.'</td>';
		echo '<td>'.$navlink.'</td>';
		echo '<td>'.$status.'</td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}

?>


</table>


</div>

<script>
function disableLink(){
  	var myselect = document.getElementById("pages");
 	var val = myselect.options[myselect.selectedIndex].value;
  
  	if (val!=0){
		document.getElementById('link').value = toLowerCase(val);
		document.getElementById('link').disabled = true;
	}
	else {
		document.getElementById('link').disabled = false;
		document.getElementById('link').value=""
	}
	
}
</script>


