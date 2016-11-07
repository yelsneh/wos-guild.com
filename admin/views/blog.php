<h1 class="page-header">Blog</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$Title = mysqli_real_escape_string($con, htmlspecialchars($_POST['title']));
		$Author = htmlspecialchars($_POST['author']);
		$Date = $_POST['date'];
		$Time = $_POST['time'];
		$DateTime = $Date.' '.$Time;
		$Post = mysqli_real_escape_string($con, $_POST['post']);
		$Tags = htmlspecialchars($_POST['tags']);
		$Publish = $_POST['publish'];
		if ($Publish != 1) {$Publish=0;}	
				
		mysqli_query($con,"UPDATE News SET title='$Title', date_posted='$DateTime', author='$Author', post='$Post', tags='$Tags', publish='$Publish' WHERE id='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Post "'.$Title.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$Title = mysqli_real_escape_string($con, htmlspecialchars($_POST['title']));
		$Author = htmlspecialchars($_POST['author']);
		$Post = mysqli_real_escape_string($con, $_POST['post']);
		$Tags = htmlspecialchars($_POST['tags']);
		$Date = $_POST['date'];
		$Time = $_POST['time'];
		$DateTime = $Date.' '.$Time;
		$Publish = $_POST['publish'];
		if ($Publish != 1) {$Publish=0;}
						
		mysqli_query($con,"INSERT INTO News (title,author,date_posted,post,tags,publish) VALUES ('$Title','$Author','$DateTime','$Post','$Tags','$Publish')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Post "'.$Title.'" added.</div>';
	
	}
}

if(isset($_GET['enable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE News SET publish=1 WHERE ID='$ID'");	
}

if(isset($_GET['disable'])){
	$ID = $_GET['ID'];
	
	mysqli_query($con,"UPDATE News SET publish=0 WHERE ID='$ID'");	
}


if(isset($_GET['delete']) && !isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM News WHERE id='$ID'");
	$row = mysqli_fetch_assoc($result);
	$Title = $row['title'];
				
	echo '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Are you sure you want to delete "'.$Title.'"? ';
	echo '<a href="?delete&confirm&ID='.$ID.'">Yes, delete it.</a> <a href="/admin/blog">No, go back.</a></div>';
	
}
if(isset($_GET['delete']) && isset($_GET['confirm'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM News WHERE id='$ID'");
	$row = mysqli_fetch_assoc($result);
	$Title = $row['title'];
				
	mysqli_query($con,"DELETE FROM News WHERE id='$ID'");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Post "'.$Title.'" deleted.</div>';
	
}		

if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Post</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Post</button></a>

<?php 

}

if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM News WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$Title = $row['title'];
	$DateTime = $row['date_posted'];
	$Author = $row['author'];
	$Post = $row['post'];
	$Tags = $row['tags'];
	$Published = $row['publish'];
	$Date= date('Y-m-d', strtotime($DateTime));
	$Time= date('H:i', strtotime($DateTime));	

	?>
		
	<form method="post" action="" name="postedit" role="form" class="form-horizontal" enctype="application/x-www-form-urlencoded">
	
	<table class="table">
	<thead><tr><th>Edit Post</th></tr></thead>
    
    <tr><td>
	<label for="title" class="col-sm-1 control-label">Title</label>
    <div class="col-sm-11">
	<input id="title" type="text" name="title" class="form-control" placeholder="Title" value="<?php echo $Title; ?>" required />
    </div>
	</td></tr>    

	<tr><td>
	<label for="author" class="col-sm-1 control-label">Author</label>
    <div class="col-sm-11">
	<input id="author" type="text" name="author" class="form-control" placeholder="Author" value="<?php echo $Author; ?>" required />
	</div>
	</td></tr>   

	<tr><td>
	<label for="post" class="col-sm-1 control-label">Content</label>
    <div class="col-sm-11">
	<textarea name="post" class="form-control" rows="10" id="edit" rows="40" required style="margin-top: 30px;"><?php echo $Post; ?></textarea>
    </div>
	</td></tr>   

	<tr><td>
	<label for="tags" class="col-sm-1 control-label">Tags</label>
    <div class="col-sm-11">
	<input id="tags" type="text" name="tags" class="form-control" style="width:100%;" data-role="tagsinput" value="<?php echo $Tags; ?>" />
	</div>
	</td></tr>   

    <tr><td>
	<label for="date" class="col-sm-1 control-label">Date</label>
    <div class="col-sm-2">
    <input id="date" type="date" name="date" class="form-control" value="<?php echo $Date;?>" required />
	</div>
	</td>
    </tr>
    <tr><td>
	<label for="time" class="col-sm-1 control-label">Time</label>
    <div class="col-sm-2">
    <input id="time" type="time" name="time" class="form-control" value="<?php echo $Time;?>" required />
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="publish" <?php if($Published==1){ echo 'checked';} ?> value="1" /> Publish
    </label>
	</div>
    </td></tr>  

    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td>
    <input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/blog"><button type="button" class="btn btn-default btn-md">Cancel</button></a>
    
    
    </div></td></tr>
	</form>  	
	</table>
		
	<?php 		
				
	}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){

?>


	<form method="post" action="" name="postnew" role="form" class="form-horizontal" enctype="application/x-www-form-urlencoded">
	
	<table class="table">
	<thead><tr><th>New Post</th></tr></thead>

	<tr><td>
	<label for="title" class="col-sm-1 control-label">Title</label>
    <div class="col-sm-11">
	<input id="title" type="text" name="title" class="form-control" placeholder="Title" required />
    </div>
	</td></tr>    

	<tr><td>
	<label for="author" class="col-sm-1 control-label">Author</label>
    <div class="col-sm-11">
	<input id="author" type="text" name="author" class="form-control" placeholder="Author" required />
    </div>
	</td></tr>   

	<tr><td>
	<label for="post" class="col-sm-1 control-label">Content</label>
    <div class="col-sm-11">
	<textarea name="post" class="form-control editable" id="edit" rows="40" required style="margin-top: 30px;"></textarea>
    
    </div>
	</td></tr>   

	<tr><td>
	<label for="tags" class="col-sm-1 control-label">Tags</label>
    <div class="col-sm-11">
	<input id="tags" type="text" name="tags" class="form-control" placeholder="One,Two,Three" data-role="tagsinput" />
    </div>
	</td></tr>
    
    <tr><td>
	<label for="date" class="col-sm-1 control-label">Date</label>
    <div class="col-sm-2">
    <input id="date" type="date" name="date" class="form-control" value="<?php echo date('Y-m-d');?>" required />
	</div>
    </td></tr>
    <tr><td>
	<label for="time" class="col-sm-1 control-label">Time</label>
    <div class="col-sm-2">
    <input id="time" type="time" name="time" class="form-control" value="<?php echo date('H:i');?>" required />
	<label class="checkbox-inline col-sm-12">
	<input type="checkbox" name="publish" checked value="1" /> Publish
    </label>
    </div>
	</td></tr>          
    <input type="hidden" value="add" name="action" />
               
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/blog"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>

<h3>Current Posts</h3>
<table class="table table-hover paginate-table" data-sortable>
<thead>
<tr><th class="col-sm-1">Post Date</th><th class="col-sm-3">Title</th><th class="col-sm-2">Author</th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1"></th><th class="col-sm-1" data-sortable="false"></th><th class="col-sm-1" data-sortable="false"></th></tr>
</thead>
<tbody>
<?php

	$result = mysqli_query($con,"SELECT * FROM News ORDER BY date_posted DESC");
	while($row = mysqli_fetch_assoc($result)){
		$ID = $row['id'];
		$Title = $row['title'];
		$DatePosted = $row['date_posted'];
		$Author = $row['author'];
		$Publish = $row['publish'];
		
		if($Publish==1){$status='<a alt="Unpublish" title="Unpublish" href="?disable&ID='.$ID.'"><span class="glyphicon glyphicon-ban-circle"></span></a>';}
		else {$status='<a alt="Publish" title="Publish" href="?enable&ID='.$ID.'"><span class="glyphicon glyphicon-ok-circle"></span></a>';}


		$Date = date('Y-m-d', strtotime($DatePosted));
		$Link = strtolower(str_replace(' ','-',$Title));
		
		echo '<tr>';
		echo '<td>'.$Date.'</td><td>'.$Title.'</td><td>'.$Author.'</td>';
		echo '<td><a alt="Preview" title="Preview" href="javascript:void(0);" onClick="window.open(\'/index.php?preview&p=news&post='.$ID.'\',\'_blank\', \'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=200, width=1200, height=800\');"><span class="glyphicon glyphicon-eye-open"></span></a></td><td>'.$status.'</td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}
		


?>

</tbody>
</table>


</div>


