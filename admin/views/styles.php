<h1 class="page-header">Site Styles</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){

	$uploadsdir = "/images/site/";
	$uploadto = $_SERVER['DOCUMENT_ROOT'].$uploadsdir;
	$logosrc = $_POST['oldlogo'];
	$iconsrc = $_POST['oldicon'];

	
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $logomime = finfo_file($finfo, $_FILES['logo']['tmp_name']);
    $iconmime = finfo_file($finfo, $_FILES['icon']['tmp_name']);

    if ((($logomime == "image/gif") || ($logomime == "image/jpeg") || ($logomime == "image/pjpeg") || ($logomime == "image/x-png") || ($logomime == "image/png"))) {
        $logoname = basename($_FILES['logo']['name']);
		move_uploaded_file($_FILES['logo']['tmp_name'], $uploadto . $logoname);
		$logosrc = $uploadsdir . $logoname;
    }

    if ((($iconmime == "image/gif") || ($iconmime == "image/jpeg") || ($iconmime == "image/pjpeg") || ($iconmime == "image/x-png") || ($iconmime == "image/png"))) {
        $iconname = basename($_FILES['icon']['name']);
		move_uploaded_file($_FILES['icon']['tmp_name'], $uploadto . $iconname);
		$iconsrc = $uploadsdir . $iconname;
    }

	
	$colors = array();
	$classcolors = array();
	$fonts = array();
	
	foreach ($_POST as $key => $value){
		
		$fieldname = htmlspecialchars($key);
		$fieldvalue = htmlspecialchars($value);
		
		$classcolorfield = strpos($fieldname, 'class_');
		if($classcolorfield!==false){
			$classcolorname = substr($fieldname,6);
			$classcolordata = $classcolorname.':'.$fieldvalue;
			array_push($classcolors,	$classcolordata);
		}

		$fontfield = strpos($fieldname, 'font_');
		if($fontfield!==false){
			$fontname = substr($fieldname,5);
			$fontdata = $fontname.':'.$fieldvalue;
			array_push($fonts,	$fontdata);
		}

		$colorfield = strpos($fieldname, 'color_');
		if($colorfield!==false){
			$colorname = substr($fieldname,6);
			$colordata = $colorname.':'.$fieldvalue;
			array_push($colors,	$colordata);
		}	
		
		if($fieldname=='fontsize') {$fontsize=$fieldvalue;}
		
	}

	$colorrow = implode(",",$colors);
	mysqli_query($con,"UPDATE Options SET option_value='$colorrow' WHERE option_key='colors'");

	$fontrow = implode(",",$fonts);
	mysqli_query($con,"UPDATE Options SET option_value='$fontrow' WHERE option_key='fonts'");
	
	$classcolorrow = implode(",",$classcolors);
	mysqli_query($con,"UPDATE Options SET option_value='$classcolorrow' WHERE option_key='classes'");



	mysqli_query($con,"UPDATE Options SET option_value='$fontsize' WHERE option_key='fontsize'");
	mysqli_query($con,"UPDATE Options SET option_value='$logosrc' WHERE option_key='logo'");
	mysqli_query($con,"UPDATE Options SET option_value='$iconsrc' WHERE option_key='favicon'");
    echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Updated.</div>';

}
?>


<form method="post" action="" name="stylesform" class="form-horizontal form-settings" role="form" enctype="multipart/form-data">


<table class="table table-hover">
<thead><tr><th>Site Assets</th></tr></thead>
<?php

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key IN ('logo','favicon')");
while($row = mysqli_fetch_assoc($result)){
$optionkey = $row['option_key'];
$optionvalue = $row['option_value'];

/// ADD UPLOADER
	if(	$optionkey == 'logo'){	
		echo '<tr><td>';
		echo '<label for="logo" class="col-sm-1 control-label">Logo</label>';
		echo '<div class="col-sm-3">';
		echo '
<div class="fileinput fileinput-new" data-provides="fileinput">
  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 300px; height: 100px;"><img src="'.$optionvalue.'" /></div>
  <div>
    <span class="btn btn-default btn-file"><span class="fileinput-new">Change</span><span class="fileinput-exists">Change</span><input type="file" name="logo" accept="image/*"></span>
    <a href="#" class="btn btn-default" onClick="removelogo();" data-dismiss="fileinput">Remove</a><input type="hidden" value="'.$optionvalue.'" name="oldlogo" />
  </div>
</div>';

		echo '</div>';
		echo '</td></tr>';
		
		




	}
	else if(	$optionkey == 'favicon'){	
		echo '<tr><td>';
		echo '<label for="favicon" class="col-sm-1 control-label">Icon</label>';
		echo '<div class="col-sm-3">';
		echo '		
<div class="fileinput fileinput-new" data-provides="fileinput">
  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 32px; height: 32px; margin-top:4px;"><img src="'.$optionvalue.'" /></div>
    <span class="btn btn-default btn-file"><span class="fileinput-new">Change</span><span class="fileinput-exists">Change</span><input type="file" name="icon" accept="image/*"></span>
    <a href="#" class="btn btn-default" onClick="removeicon();" data-dismiss="fileinput">Remove</a><input type="hidden" value="'.$optionvalue.'" name="oldicon" />
</div>';

		echo '</div>';
		echo '<div class="col-sm-7"><span class="label label-info">Note</span> Your favicon image should be a .png, .jpg, or .gif that is 16x16, 32x32, or 64x64 pixels.</div>';
		echo '</td></tr>';
	}
////////////

}
?>

</table>
<h3></h3>
<input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/>
<h3></h3>
<table class="table">
<thead><tr><th colspan="3">Site Styles</th></tr></thead>
<tr>
<td class="col-sm-4" style="vertical-align:top !important;"><h4>Site Colors</h4>
<table class="table table-hover">
<?php

$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key = 'colors'");
$row = mysqli_fetch_assoc($result);
$colorslist = $row['option_value'];

		$colors = explode(',',$colorslist);
		
		foreach($colors as $color){
			$colorinfo = explode(':',$color);
			$colorname = ucfirst($colorinfo[0]);
			$colorhex = $colorinfo[1];
		
			echo '<tr><td class="col-sm-6"><label for="color_'.$colorname.'" class="control-label">'.str_replace("_"," ",$colorname).'</label></td>';
			echo '<td><div class="col-sm-12 input-group color-picker">';
			echo '<input id="color_'.$colorname.'" type="text" name="color_'.$colorname.'" value="'.$colorhex.'" class="form-control color-picker" required/>';
			echo '<span class="input-group-addon"><i></i></span>';
			echo '</div></td></tr>';
		}
?>
</table>
</td>
<td class="col-sm-4" style="vertical-align:top !important;"><h4>Fonts</h4>
<table class="table table-hover">

<?php

$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key = 'fonts'");
$row = mysqli_fetch_assoc($result);
$fontslist = $row['option_value'];

		$fonts = explode(',',$fontslist);
		
		foreach($fonts as $font){
			$fontinfo = explode(':',$font);
			$fontname = ucfirst($fontinfo[0]);
			$fontdata = $fontinfo[1];
		
			echo '<tr><td class="col-sm-6"><label for="font_'.$fontname.'" class="control-label">'.str_replace("_"," ",$fontname).'</label></td>';
			echo '<td><select id="font_'.$fontname.'" name="font_'.$fontname.'" class="form-control">
					
					<option value="Open Sans" ';
						if($fontdata=='Open Sans'){echo 'selected';}
						echo '>Open Sans</option>
					<option value="Droid Serif" ';
						if($fontdata=='Droid Serif'){echo 'selected';}
						echo '>Droid Serif</option>
					<option value="Roboto" ';
						if($fontdata=='Roboto'){echo 'selected';}
						echo '>Roboto</option>
					<option value="Lato" ';
						if($fontdata=='Lato'){echo 'selected';}
						echo '>Lato</option>
					<option value="Oswald" ';
						if($fontdata=='Oswald'){echo 'selected';}
						echo '>Oswald</option>
					<option value="Lobster" ';
						if($fontdata=='Lobster'){echo 'selected';}
						echo '>Lobster</option>
					<option value="Bitter" ';
						if($fontdata=='Bitter'){echo 'selected';}
						echo '>Bitter</option>
					<option value="Shadows Into Light" ';
						if($fontdata=='Shadows Into Light'){echo 'selected';}
						echo '>Shadows Into Light</option>
					<option value="Righteous" ';
						if($fontdata=='Righteous'){echo 'selected';}
						echo '>Righteous</option>					
					<option value="Francois One" ';
						if($fontdata=='Francois One'){echo 'selected';}
						echo '>Francois One</option>						
					<option value="Vast Shadow" ';
						if($fontdata=='Vast Shadow'){echo 'selected';}
						echo '>Vast Shadow</option>						
					<option value="Vollkorn" ';
						if($fontdata=='Vollkorn'){echo 'selected';}
						echo '>Vollkorn</option>						
					<option value="Voltaire" ';
						if($fontdata=='Voltaire'){echo 'selected';}
						echo '>Voltaire</option>						
					<option value="Source Sans Pro" ';
						if($fontdata=='Source Sans Pro'){echo 'selected';}
						echo '>Source Sans Pro</option>						
							
				</select>			
			</td></tr>';
		}
		
		
$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key = 'fontsize'");
$row = mysqli_fetch_assoc($result);
$fontsize = $row['option_value'];
	
echo '<tr><td class="col-sm-6"><label for="fontsize" class="control-label">Body Font Size</label></td>';
echo '<td><div class="input-group"><input id="fontsize" type="number" min="10" max="18" name="fontsize" value="'.$fontsize.'" class="form-control"/><div class="input-group-addon">px</div></div></td></tr>';

?>
</table>
</td>
<td class="col-sm-4" style="vertical-align:top !important;"><h4>Class Colors</h4>
<table class="table table-hover">
<?php

$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key = 'classes'");
$row = mysqli_fetch_assoc($result);
$colorslist = $row['option_value'];

		$colors = explode(',',$colorslist);
		
		foreach($colors as $color){
			$colorinfo = explode(':',$color);
			$colorname = ucfirst($colorinfo[0]);
			$colorhex = $colorinfo[1];
		
			echo '<tr><td class="col-sm-6"><label for="class_'.$colorname.'" class="control-label">'.str_replace("_"," ",$colorname).'</label></td>';
			echo '<td><div class="col-sm-12 input-group color-picker">';
			echo '<input id="class_'.$colorname.'" type="text" name="class_'.$colorname.'" value="'.$colorhex.'" class="form-control color-picker" required/>';
			echo '<span class="input-group-addon"><i></i></span>';
			echo '</div></td></tr>';
		}
?>
</table>
</td>

</tr>
</table>


<input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/>
</form>
</div>

<script type="text/javascript">
var thisform = 	document.forms['stylesform'];

function removelogo(){
	thisform.oldlogo.value = '';
}
function removeicon(){
	thisform.oldicon.value = '';
}
</script>