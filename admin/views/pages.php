<h1 class="page-header">Pages</h1>
<div class="table-responsive">

<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);


if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$OldLink = '/'.$_POST['old_link'];
		$Name = str_replace(' ','-',strtolower($_POST['page_name']));
		$Content = mysqli_real_escape_string($con, $_POST['page_content']);
		$Publish = $_POST['publish'];
		if ($Publish != 1) {$Publish=0;}
		
		$Link = '/'.strtolower($Name);
							
		mysqli_query($con,"UPDATE Pages SET Page='$Name', Content='$Content', publish='$Publish' WHERE PageID='$ID'");
		mysqli_query($con,"UPDATE Navigation SET Link='$Link' WHERE Link='$OldLink'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Page "'.$Name.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$Name = str_replace(' ','-',strtolower($_POST['page_name']));
		$Content = mysqli_real_escape_string($con, $_POST['page_content']);
		$Publish = $_POST['publish'];
		if ($Publish != 1) {$Publish=0;}
				
		mysqli_query($con,"INSERT INTO Pages (Page,Content,publish) VALUES ('$Name','$Content','$Publish')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Page "'.$Name.'" added.</div>';
	
	}
}

if(isset($_GET['enable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE Pages SET publish=1 WHERE PageID='$ID'");	
}

if(isset($_GET['disable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE Pages SET publish=0 WHERE PageID='$ID'");	
}


if(isset($_GET['delete']) && !isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Pages WHERE PageID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = str_replace('-',' ',$row['Page']);
				
	echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Are you sure you want to delete page "'.$name.'"? ';
	echo '<a href="?delete&confirm&ID='.$ID.'">Yes, delete it.</a> <a href="/admin/pages">No, go back.</a></div>';
	
}
if(isset($_GET['delete']) && isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Pages WHERE PageID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$name = str_replace('-',' ',$row['Page']);
				
	mysqli_query($con,"DELETE FROM Pages WHERE PageID='$ID'");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Page "'.$name.'" deleted.</div>';
	
}		

if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Page</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Page</button></a>

<?php 

}

if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Pages WHERE PageID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$Name = str_replace('-',' ',$row['Page']);
	$Link = $row['Page'];
	$Content = $row['Content'];
	$Published = $row['publish'];

	?>
		
	<form method="post" action="" name="pageedit" role="form" class="form-horizontal" enctype="multipart/form-data">
	
	<table class="table">
	<thead><tr><th>Edit Page</th></tr></thead>
    
    <tr><td>
	<label for="page_name" class="col-sm-1 control-label">Name</label>
    <div class="col-sm-11">
	<input id="page_name" type="text" name="page_name" class="form-control" placeholder="Page Name" value="<?php echo $Name; ?>" required />
    </div>
	</td></tr>    

	<tr><td>
	<label for="page_content" class="col-sm-1 control-label">Content</label>
    <div class="col-sm-11">
	<textarea name="page_content" class="form-control" rows="10" required id="edit" style="margin-top: 30px;"><?php echo $Content; ?></textarea>

    
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="publish" <?php if($Published==1){ echo 'checked';} ?> value="1" /> Publish
    </label>
	</div>
	</td></tr>  
                    
    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="<?php echo $Link;?>" name="old_link" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/pages"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>
		
	<?php 		
				
	}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){

?>


	<form method="post" action="" name="pagenew" role="form" class="form-horizontal" enctype="multipart/form-data">
	
	<table class="table">
	<thead><tr><th>New Page</th></tr></thead>

	<tr><td>
	<label for="page_name" class="col-sm-1 control-label">Name</label>
    <div class="col-sm-11">
	<input id="page_name" type="text" name="page_name" class="form-control" placeholder="Page Name" required />
    </div>
	</td></tr>    

	<tr><td>
	<label for="page_content" class="col-sm-1 control-label">Content</label>
    <div class="col-sm-11">
	<textarea name="page_content" class="form-control" rows="10" required id="edit" style="margin-top: 30px;"></textarea>
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="publish" checked value="1" /> Publish
    </label>
    </div>
	</td></tr> 
        
    <input type="hidden" value="add" name="action" />
               
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/pages"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>

<h3>Current Pages</h3>
<table class="table table-hover" data-sortable>
<thead>
<tr><th class="col-sm-6">Name</th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1"></th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<?php

	$result = mysqli_query($con,"SELECT * FROM Pages");
	while($row = mysqli_fetch_assoc($result)){
		$ID = $row['PageID'];
		$Name = $row['Page'];
		$Content = $row['Content'];
		$Publish = $row['publish'];
		
		if($Publish==1){$status='<a alt="Unpublish" title="Unpublish" href="?disable&ID='.$ID.'"><span class="glyphicon glyphicon-ban-circle"></span></a>';}
		else {$status='<a alt="Publish" title="Publish" href="?enable&ID='.$ID.'"><span class="glyphicon glyphicon-ok-circle"></span></a>';}
		
		$path = str_replace(' ','-',$Name);
		echo '<tr>';
		echo '<td>'.$Name.'</td>';
		echo '<td><a alt="Preview" title="Preview" href="javascript:void(0);" onClick="window.open(\'/?preview&p='.$path.'\',\'_blank\', \'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=200, width=1200, height=800\');"><span class="glyphicon glyphicon-eye-open"></span></a></td><td>'.$status.'</td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}
		


?>


</table>


</div>

