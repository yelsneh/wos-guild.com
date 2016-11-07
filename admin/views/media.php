<h1 class="page-header">Media Gallery</h1>
<p>Your media gallery can include images or videos, either uploaded or imported from elsewhere.</p>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	if($_POST['action']=='edit'){
		$ID = $_POST['ID'];
		$mediatype = $_POST['mediatype'];
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$caption = mysqli_real_escape_string($con, $_POST['caption']);
		$url = $_POST['url'];
		$youtube = $_POST['youtube'];
		$uploaded = $_POST['uploaded'];
		
			
		mysqli_query($con,"UPDATE Gallery SET name='$url', Title='$title', Caption='$caption', Type='$mediatype', Youtube='$youtube' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Gallery Item "'.$title.'" updated.</div>';
	
	}
	if($_POST['action']=='edituploaded'){
		$ID = $_POST['ID'];
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$caption = mysqli_real_escape_string($con, $_POST['caption']);
		$uploaded = $_POST['uploaded'];
		
			
		mysqli_query($con,"UPDATE Gallery SET Title='$title', Caption='$caption' WHERE ID='$ID'");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Gallery Item "'.$title.'" updated.</div>';
	
	}
	else if($_POST['action']=='add'){
		$mediatype = $_POST['mediatype'];
		$title = mysqli_real_escape_string($con, $_POST['title']);
		$caption = mysqli_real_escape_string($con, $_POST['caption']);
		$url = $_POST['url'];
		$youtube = $_POST['youtube'];
						
		mysqli_query($con,"INSERT INTO Gallery (name, Type, Title, Caption, Youtube, Uploaded) VALUES ('$url','$mediatype','$title','$caption','$youtube',0)");
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Gallery Item "'.$title.'" added.</div>';
	
	}
}

if(isset($_GET['delete'])){
	$ID = $_GET['ID'];
	
	$result = mysqli_query($con,"SELECT * FROM Gallery WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$mediatype = $row['Type'];
	$title = $row['Title'];
	$caption = $row['Caption'];
	$url = $row['name'];
	$youtube = $row['Youtube'];
	$uploaded = $row['uploaded'];
	$slide = $row['slide'];

	mysqli_query($con,"DELETE FROM Gallery WHERE ID='$ID'");
				
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Gallery Item "'.$title.'" deleted. <a href="?undo&mediatype='.$mediatype.'&url='.$url.'&title='.$title.'&caption='.$caption.'&youtube='.$youtube.'&uploaded='.$uploaded.'&slide='.$slide.'">Undo?</a></div>';
	
}	
if(isset($_GET['undo'])){
		$mediatype = $_GET['mediatype'];
		$title = mysqli_real_escape_string($con, $_GET['title']);
		$caption = mysqli_real_escape_string($con, $_GET['caption']);
		$url = $_GET['url'];
		$youtube = $_GET['youtube'];
		$uploaded = $_GET['uploaded'];
		$slide = $_GET['slide'];
							
	mysqli_query($con,"INSERT INTO Gallery (name, Type, Title, Caption, Youtube, Uploaded) VALUES ('$url','$mediatype','$title','$caption','$youtube',$uploaded)");
	echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>';
	echo '<span class="sr-only">Close</span></button>Gallery Item "'.$title.'" restored.</div>';
	
}				


if(isset($_GET['edit']) && !isset($_POST['submit'])){
	$ID = $_GET['ID'];
	$result = mysqli_query($con,"SELECT * FROM Gallery WHERE ID='$ID'");
	$row = mysqli_fetch_assoc($result);
	$mediatype = $row['Type'];
	$title = $row['Title'];
	$caption = $row['Caption'];
	$url = $row['name'];
	$youtube = $row['Youtube'];
		$slide = $row['Slide'];
		$uploaded = $row['Uploaded'];
		if($uploaded==1 && strpos($url,'/images/')===false){
			$url = '/images/upload/files/'.$url;
		}
		if($slide==1 && strpos($url,'/images/')===false){
			$url = '/images/slider/'.$url;
		}
?>

	<form method="post" action="" name="gallery" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Gallery Item</th></tr></thead>
		
	<tr><td>
	<label for="title" class="col-sm-1 control-label">Title</label>
	<div class="col-sm-4">
	<input id="title" type="text" name="title" class="form-control" required value="<?php echo $title;?>" />
	</div>
	</td></tr> 
	<tr><td>
	<label for="caption" class="col-sm-1 control-label">Caption</label>
	<div class="col-sm-4">
	<input id="caption" type="text" name="caption" class="form-control" required value="<?php echo $caption;?>" />
	</div>
	</td></tr>
	<tr><td>
	<label for="url" class="col-sm-1 control-label">URL</label>
	<div class="col-sm-4">
	<input id="url" type="text" name="url" class="form-control" required value="<?php echo $url;?>" />
	</div>
	</td></tr>
    <tr><td>
	<label for="mediatype" class="col-sm-1 control-label">Type</label>
	<div class="col-sm-4">    
    <select class="form-control" name="mediatype" onChange="youtube()" id="mediatype">
		<option value="image" <?php if($mediatype=='image'){ echo 'selected';} ?>>Image</option>
		<option value="youtube"  <?php if($mediatype=='youtube'){ echo 'selected';} ?>>Youtube</option>
	</select>
	</div>
	</td></tr>
	<tr><td>
	<label for="youtube" class="col-sm-1 control-label">Youtube ID</label>
	<div class="col-sm-4">
	<input id="youtube" type="text" name="youtube" class="form-control" id="youtube" value="<?php echo $youtube;?>" />
	</div>
	</td></tr>

    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="<?php echo $uploaded;?>" name="uploaded" /><input type="hidden" value="edit" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/media"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php

}

if(isset($_GET['edituploaded']) && !isset($_POST['submit'])){
	$name = $_GET['name'];
	$result = mysqli_query($con,"SELECT * FROM Gallery WHERE name='$name'");
	$row = mysqli_fetch_assoc($result);
	$ID = $row['ID'];
	$title = $row['Title'];
	$caption = $row['Caption'];
		$slide = $row['Slide'];
		$uploaded = $row['Uploaded'];
		if($uploaded==1 && strpos($url,'/images/')===false){
			$url = '/images/upload/files/'.$url;
		}
		if($slide==1 && strpos($url,'/images/')===false){
			$url = '/images/slider/'.$url;
		}

?>		
	<form method="post" action="" name="gallery" class="form-horizontal form-settings" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Edit Gallery Item</th></tr></thead>
		
	<tr><td>
	<label for="title" class="col-sm-1 control-label">Title</label>
	<div class="col-sm-4">
	<input id="title" type="text" name="title" class="form-control" required value="<?php echo $title;?>" />
	</div>
	</td></tr> 
	<tr><td>
	<label for="caption" class="col-sm-1 control-label">Caption</label>
	<div class="col-sm-4">
	<input id="caption" type="text" name="caption" class="form-control" required value="<?php echo $caption;?>" />
	</div>
	</td></tr>
    <input type="hidden" value="<?php echo $ID;?>" name="ID" /><input type="hidden" value="<?php echo $name;?>" name="name" /><input type="hidden" value="<?php echo $uploaded;?>" name="uploaded" /><input type="hidden" value="edituploaded" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/> <a href="/admin/media"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>
		
<?php 		
}
	
	
	


if(isset($_GET['new']) && !isset($_POST['submit'])){
	
?>


	<form method="post" action="" name="gallery" class="form-horizontal" role="form">
	
	<table class="table table-hover">
	<thead><tr><th>Add Gallery Item</th></tr></thead>
		
	<tr><td>
	<label for="title" class="col-sm-1 control-label">Title</label>
	<div class="col-sm-4">
	<input id="title" type="text" name="title" class="form-control" placeholder="Title" required />
	</div>
	</td></tr>
	<tr><td>
	<label for="caption" class="col-sm-1 control-label">Caption</label>
	<div class="col-sm-4">
	<input id="caption" type="text" name="caption" class="form-control" placeholder="Caption" required />
	</div>
	</td></tr>
	<tr><td>
	<label for="url" class="col-sm-1 control-label">URL</label>
	<div class="col-sm-4">
	<input id="url" type="text" name="url" class="form-control" placeholder="http://" required />
	</div>
	</td></tr>
    <tr><td>
	<label for="mediatype" class="col-sm-1 control-label">Type</label>
	<div class="col-sm-4">    
    <select class="form-control" name="mediatype" onChange="youtube()" id="mediatype">
		<option value="image" >Image</option>
		<option value="youtube" >Youtube</option>
	</select>
	</div>
	</td></tr>
	<tr><td>
	<label for="youtube" class="col-sm-1 control-label">Youtube ID</label>
	<div class="col-sm-4">
	<input id="youtube" type="text" name="youtube" class="form-control" placeholder="VIDEO ID" id="youtube" />
	</div>
	</td></tr>
    <input type="hidden" value="add" name="action" />
	<tfoot><tr><td><input type="submit" name="submit" value="Submit" class="btn btn-md btn-primary"/> <a href="/admin/media"><button type="button" class="btn btn-default btn-md">Cancel</button></a></td></tr>
	
	</table>
	</form>

<?php 

}

 ?>


    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="" method="POST" enctype="multipart/form-data">
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value=""></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <a href="?new"><button type="button" class="btn btn-info btn-md"><span class="glyphicon glyphicon-import"></span> Import web files...</button></a>
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Upload files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-hover paginate-table" id="mediagallery">
        <tbody class="files"></tbody><tfoot><?php

	$result = mysqli_query($con,"SELECT * FROM Gallery WHERE Uploaded=0");
	$numrows = mysqli_num_rows($result);
	while($row = mysqli_fetch_assoc($result)){
		$ID = $row['ID'];
		$mediatype = $row['Type'];
		$title = html_entity_decode($row['Title']);
		$caption = html_entity_decode($row['Caption']);
		$url = $row['name'];
		$youtube = $row['Youtube'];
		$slide = $row['Slide'];
		$uploaded = $row['Uploaded'];
		if($uploaded==1 && strpos($url,'/images/')===false){
			$url = '/images/upload/files/'.$url;
		}
		if($slide==1 && strpos($url,'/images/')===false){
			$url = '/images/slider/'.$url;
		}
		
		echo '<tr>';
		echo '<td class="col-sm-1"><span class="preview">';
		if($mediatype=='youtube'){
			echo '<a href="http://img.youtube.com/vi/'.$youtube.'/default.jpg" data-gallery><img src="http://img.youtube.com/vi/'.$youtube.'/default.jpg" /></a>';
		}
		else {
			echo '<a href="'.$url.'" data-gallery><img src="'.$url.'" /></a>';
		}
		echo '</span></td>';
		echo '<td class="col-sm-9"><div class="col-sm-12"><strong>'.$title.'</strong><br/>'.$caption.'</div></td>';
		echo '<td><a alt="Edit" title="Edit" href="?edit&ID='.$ID.'"><span class="glyphicon glyphicon-edit"></span></a></td>';
		echo '<td><a alt="Delete" title="Delete" href="?delete&ID='.$ID.'"><span class="glyphicon glyphicon-trash"></span></a></td>';
		echo '</tr>';
	}

?></tfoot></table>
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

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="col-sm-1">
            <span class="preview"></span>
        </td>
        <td class="col-sm-9">
			<label class="title">
				<span>Title:</span><br>
				<input name="Title[]" class="form-control" type="text" required>
			</label>
			<label class="caption">
				<span>Caption:</span><br>
				<input name="Caption[]" class="form-control" type="text" required>
			</label>
        <strong class="error text-danger"></strong>
        </td>
        <td colspan="2">
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
             {% if (!i && !o.options.autoUpload) { %}
              <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td class="col-sm-1">
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td class="col-sm-9">
			<div class="col-sm-6">
				<p><strong>{%=file.title||''%}</strong>
				<br/>{%=file.description||''%}</p>
			</div>
			<div class="col-sm-6">
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
                {% if (!file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a><br/>
				<span class="size">{%=o.formatFileSize(file.size)%}</span>
                {% } %}
			</div>
        </td>
        <td><a alt="Edit" title="Edit" href="?edituploaded&name={%=file.name%}"><span class="glyphicon glyphicon-edit"></span></a></td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn-delete delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                </button>
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>


</div>

<script type="text/javascript">

function youtube(){
  	var myselect = document.getElementById('mediatyoe');
 	var val = myselect.options[myselect.selectedIndex].value;
  
	if(val=='youtube'){
		document.getElementById('youtube').required='true';
	}
}
</script>