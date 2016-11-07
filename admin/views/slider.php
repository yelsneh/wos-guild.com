<h1 class="page-header">Homepage Slider</h1>
<p>For best effect, use high resolution images for the homepage slider.</p>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$Header = mysqli_real_escape_string($con, $_POST['header']);
		$Content = mysqli_real_escape_string($con, $_POST['content']);
		$Link = $_POST['link'];
	
		$uploadsdir = "/images/slider/";
		$uploadto = $_SERVER['DOCUMENT_ROOT'].$uploadsdir;
		$slidersrc = $_POST['oldslider'];
	
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$slidermime = finfo_file($finfo, $_FILES['slider']['tmp_name']);

		if ((($slidermime == "image/gif") || ($slidermime == "image/jpeg") || ($slidermime == "image/pjpeg") || ($slidermime == "image/x-png") || ($slidermime == "image/png"))) {
			$slidername = basename($_FILES['slider']['name']);
			move_uploaded_file($_FILES['slider']['tmp_name'], $uploadto . $slidername);
			$slidersrc = $uploadsdir . $slidername;
		}
		mysqli_query($con,"UPDATE Slider SET Image='$slidersrc', Header='$Header', Content='$Content', Link='$Link' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Slide "'.$Header.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$Header = mysqli_real_escape_string($con, $_POST['header']);
		$Content = mysqli_real_escape_string($con, $_POST['content']);
		$Link = $_POST['link'];
	
		$uploadsdir = "/images/slider/";
		$uploadto = $_SERVER['DOCUMENT_ROOT'].$uploadsdir;
		$slidersrc = '';
	
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$slidermime = finfo_file($finfo, $_FILES['slider']['tmp_name']);

		if ((($slidermime == "image/gif") || ($slidermime == "image/jpeg") || ($slidermime == "image/pjpeg") || ($slidermime == "image/x-png") || ($slidermime == "image/png"))) {
			$slidername = basename($_FILES['slider']['name']);
			move_uploaded_file($_FILES['slider']['tmp_name'], $uploadto . $slidername);
			$slidersrc = $uploadsdir . $slidername;
		}
				
		mysqli_query($con,"INSERT INTO Slider (Image, Header, Content, Link) VALUES ('$slidersrc','$Header','$Content','$Link')");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Slide "'.$Header.'" added.</div>';
	
	}
}
if(isset($_POST['gallery'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$Header = mysqli_real_escape_string($con, $_POST['header']);
		$Content = mysqli_real_escape_string($con, $_POST['content']);
		$Link = $_POST['link'];
	
		$uploadsdir = "/images/slider/";
		$uploadto = $_SERVER['DOCUMENT_ROOT'].$uploadsdir;
		$slidersrc = $_POST['oldslider'];
		$gallerydir = "/images/upload/files/";
		$galleryto = $_SERVER['DOCUMENT_ROOT'].$gallerydir;
	
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$slidermime = finfo_file($finfo, $_FILES['slider']['tmp_name']);

		if ((($slidermime == "image/gif") || ($slidermime == "image/jpeg") || ($slidermime == "image/pjpeg") || ($slidermime == "image/x-png") || ($slidermime == "image/png"))) {
			$slidername = basename($_FILES['slider']['name']);
			move_uploaded_file($_FILES['slider']['tmp_name'], $uploadto . $slidername);
			$slidersrc = $uploadsdir . $slidername;
		}
		else{
			$slidername = substr($slidersrc,strlen($uploadsdir));
		}

		mysqli_query($con,"UPDATE Slider SET Image='$slidersrc', Header='$Header', Content='$Content', Link='$Link' WHERE ID='$ID'");
		$result = mysqli_query($con,"SELECT * FROM Gallery WHERE name='$slidername' OR name='$slidersrc'");
		$num_rows = mysqli_num_rows($result);
		if($num_rows==0){
			mysqli_query($con,"INSERT INTO Gallery (Type,name,Title,Caption,Uploaded,Slide) VALUES ('image','$slidersrc','$Header','$Content',0,1)");
		}
		else{
			mysqli_query($con,"UPDATE Gallery SET Title='$Header', Caption='$Content' WHERE name='$slidername' OR name='$slidersrc'");
		}
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Slide "'.$Header.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$Header = mysqli_real_escape_string($con, $_POST['header']);
		$Content = mysqli_real_escape_string($con, $_POST['content']);
		$Link = $_POST['link'];
	
		$uploadsdir = "/images/slider/";
		$uploadto = $_SERVER['DOCUMENT_ROOT'].$uploadsdir;
		$slidersrc='';
		$gallerydir = "/images/upload/files/";
		$galleryto = $_SERVER['DOCUMENT_ROOT'].$gallerydir;
	
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$slidermime = finfo_file($finfo, $_FILES['slider']['tmp_name']);

		if ((($slidermime == "image/gif") || ($slidermime == "image/jpeg") || ($slidermime == "image/pjpeg") || ($slidermime == "image/x-png") || ($slidermime == "image/png"))) {
			$slidername = basename($_FILES['slider']['name']);
			move_uploaded_file($_FILES['slider']['tmp_name'], $uploadto . $slidername);
			$slidersrc = $uploadsdir . $slidername;
		}
		else{
			$slidername = substr($slidersrc,strlen($uploadsdir));
		}					
		mysqli_query($con,"INSERT INTO Slider (Image, Header, Content, Link) VALUES ('$slidersrc','$Header','$Content','$Link')");
		
		$result = mysqli_query($con,"SELECT * FROM Gallery WHERE name='$slidername' OR name='$slidersrc'");
		$num_rows = mysqli_num_rows($result);
		if($num_rows==0){
			mysqli_query($con,"INSERT INTO Gallery (Type,name,Title,Caption,Uploaded,Slide) VALUES ('image','$slidersrc','$Header','$Content',0,1)");
		}
		else{
			mysqli_query($con,"UPDATE Gallery SET Title='$Header', Caption='$Content' WHERE name='$slidername' OR name='$slidersrc'");
		}
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Slide "'.$Header.'" added.</div>';
	
	}
}

if(isset($_GET['delete'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Slider WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$Header = $row['Header'];
	$Content = $row['Content'];
	$Link = $row['Link'];
	$Image = $row['Image'];

	mysqli_query($con,"DELETE FROM Slider WHERE ID='$ID'");
				
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Slide "'.$Header.'" deleted. <a href="?undo&header='.$Header.'&content='.$Content.'&image='.$Image.'&link='.$Link.'">Undo?</a></div>';
	
}	
if(isset($_GET['undo'])){
		$Header = mysqli_real_escape_string($con, $_GET['header']);
		$Content = mysqli_real_escape_string($con, $_GET['content']);
		$Link = $_GET['link'];
		$Image = $_GET['image'];
							
	mysqli_query($con,"INSERT INTO Slider (Header,Content,Image,Link) VALUES ('$Header','$Content','$Image','$Link')");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Slide "'.$Header.'" restored.</div>';
	
}				


if(!isset($_GET['new']) && !isset($_GET['edit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Slide</button></a>

<?php 

}
else if(isset($_POST['submit'])){

 ?>

<a href="?new"><button type="button" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> New Slide</button></a>

<?php 

}



if(isset($_GET['edit']) && !isset($_POST['submit']) && !isset($_POST['gallery'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Slider WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$Header = $row['Header'];
	$Content = $row['Content'];
	$Link = $row['Link'];
	$Image = $row['Image'];
?>

	<form method="post" action="" name="slideedit" class="form-horizontal form-settings" role="form" enctype="multipart/form-data">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Slide</th></tr></thead>
		
	<tr><td>
	<label for="header" class="col-sm-1 control-label">Title</label>
	<div class="col-sm-4">
	<input id="header" type="text" name="header" class="form-control" required value="<?php echo $Header;?>" />
	</div>
	</td></tr> 
	<tr><td>
	<label for="content" class="col-sm-1 control-label">Caption</label>
	<div class="col-sm-4">
	<input id="content" type="text" name="content" class="form-control" required value="<?php echo $Content;?>" />
	</div>
	</td></tr>
	<tr><td>
	<label for="link" class="col-sm-1 control-label">Link To</label>
	<div class="col-sm-4">
	<input id="link" type="text" name="link" class="form-control" required value="<?php echo $Link;?>" />
	</div>
	</td></tr>

	<tr><td>
	<label for="image" class="col-sm-1 control-label">Image</label>
	<div class="col-sm-3">
	<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px; height: 100px;"><img src="<?php echo $Image;?>"/></div>
    <div><span class="btn btn-default btn-file"><span class="fileinput-new">Browse</span><span class="fileinput-exists">Change</span><input type="file" name="slider" accept="image/*"></span>
    <a href="#" class="btn btn-default" data-dismiss="fileinput">Remove</a>
	</div></div></div>
    </td></tr>
    
    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="edit" name="action" /><input type="hidden" value="<?php echo $Image;?>" name="oldslider" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/slider"><button type="button" class="btn btn-default btn-md">Cancel</button></a> &nbsp; <input type="submit" name="gallery" value="Update + Add to Gallery" class="btn btn-md btn-success"/></td></tr>
	
	</table>
	</form>

<?php

}	


if(isset($_GET['new']) && !isset($_POST['submit']) && !isset($_POST['submit'])){
	
?>


	<form method="post" action="" name="slideadd" class="form-horizontal" role="form" enctype="multipart/form-data">
	
	<table class="table table-hover">
	<thead><tr><th>Add Slide</th></tr></thead>
		
	<tr><td>
	<label for="header" class="col-sm-1 control-label">Title</label>
	<div class="col-sm-4">
	<input id="header" type="text" name="header" class="form-control" placeholder="Title" required />
	</div>
	</td></tr>
	<tr><td>
	<label for="content" class="col-sm-1 control-label">Caption</label>
	<div class="col-sm-4">
	<input id="content" type="text" name="content" class="form-control" placeholder="Caption" required />
	</div>
	</td></tr>
	<tr><td>
	<label for="link" class="col-sm-1 control-label">Link To</label>
	<div class="col-sm-4">
	<input id="link" type="text" name="link" class="form-control" placeholder="http://" required />
	</div>
	</td></tr>
    
	<tr><td>
	<label for="image" class="col-sm-1 control-label">Image</label>
	<div class="col-sm-3">
	<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px; height: 100px;"></div>
    <div><span class="btn btn-default btn-file"><span class="fileinput-new">Browse</span><span class="fileinput-exists">Change</span><input type="file" name="slider" accept="image/*"></span>
    <a href="#" class="btn btn-default" data-dismiss="fileinput">Remove</a>
	</div></div></div>
    </td></tr>

    <input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/slider"><button type="button" class="btn btn-default btn-md">Cancel</button></a> &nbsp; <input type="submit" name="gallery" value="Submit + Add to Gallery" class="btn btn-md btn-success"/></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>
<h3></h3>
        <table role="presentation" class="table table-hover paginate-table" id="mediagallery">
        <tbody class="files">
<?php

	$result = mysqli_query($con,"SELECT * FROM Slider");
	$numrows = mysqli_num_rows($result);
	while($row = mysqli_fetch_assoc($result)){
		$ID = $row['ID'];
		$Header = $row['Header'];
		$Content = $row['Content'];
		$Link = $row['Link'];
		$Image = $row['Image'];

		
		echo '<tr>';
		echo '<td class="col-sm-1"><span class="preview">';
		echo '<a href="'.$Image.'" data-gallery><img src="'.$Image.'" /></a>';
		echo '</span></td>';
		echo '<td class="col-sm-4"><div class="col-sm-12"><strong>'.$Header.'</strong><br/>'.$Content.'</div></td>';
		echo '<td class="col-sm-5"><a href="'.$Link.'" target="_blank">'.$Link.'</a></td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}

?></tbody><tfoot></tfoot></table>
    </form>

<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>




</div>
