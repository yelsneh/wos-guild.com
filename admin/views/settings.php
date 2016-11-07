<h1 class="page-header">Site Settings</h1>
<div class="table-responsive">

<?php 

if($_POST['action']=='clearcache'){

// Specify the target directory and add forward slash
$path = $_SERVER['DOCUMENT_ROOT']."/cache/";
// Loop over all of the files in the folder
foreach(glob($path ."*.*") as $file) {
    unlink($file); // Delete each file through the loop
}

echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Cache cleared.</div>';

}

if($_POST['action']=='clearachieve'){

// Specify the target directory and add forward slash
$path = $_SERVER['DOCUMENT_ROOT']."/cache/";
// Loop over all of the files in the folder
foreach(glob($path ."*achievements.*") as $file) {
    unlink($file); // Delete each file through the loop
}

echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Achievement cache cleared.</div>';

}


if($_POST['action']=='clearroster'){

// Specify the target directory and add forward slash
$path = $_SERVER['DOCUMENT_ROOT']."/cache/";
unlink($path."rosterlist.json"); // Delete each file through the loop

echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Roster cache cleared.</div>';

}


if(isset($_POST['submit'])){
	
	$socials = array();

	foreach ($_POST as $key => $value){
		
		$fieldname = htmlspecialchars($key);
		$fieldvalue = htmlspecialchars($value);
		
		
		$socialfield = strpos($fieldname, 'social_');


		if($socialfield!==false){
			$socialname = substr($fieldname,7);
			$socialdata = $socialname.'|'.$fieldvalue;
			array_push($socials, $socialdata);
		}		
		else if($fieldname == 'guild_name'){
			$guild = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$guild' WHERE option_key='guild'");
		}
		else if($fieldname == 'guild_realm'){
			$realm = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$realm' WHERE option_key='realm'");
		}
		else if($fieldname == 'title_text'){
			$titlebar = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$titlebar' WHERE option_key='titlebar'");
		}
		else if($fieldname == 'footer_text'){
			$footer = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$footer' WHERE option_key='footer'");
		}
		else if($fieldname == 'num_posts'){
			$posts = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$posts' WHERE option_key='posts'");
		}
		
	}

	$socialrow = implode(",",$socials);
	mysqli_query($con,"UPDATE Options SET option_value='$socialrow' WHERE option_key='social'");
    echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Updated.</div>';

}
?>


<form method="post" action="" name="settingsform" class="form-horizontal form-settings" role="form" enctype="multipart/form-data">

<table class="table table-hover">
<thead><tr><th>Guild Information</th></tr></thead>

<?php

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key IN ('guild','realm')");
while($row = mysqli_fetch_assoc($result)){
$optionkey = $row['option_key'];
$optionvalue = $row['option_value'];


	if(	$optionkey == 'guild'){
		echo '<tr><td>';
		echo '<label for="guild_name" class="col-sm-1 control-label">Guild Name</label>';
		echo '<div class="col-sm-4">';
		echo '<input id="guild_name" type="text" name="guild_name" class="form-control" placeholder="Guild Name" value="'.$optionvalue.'" required />';
		echo '</div>';
		echo '<div class="col-sm-7"><span class="label label-info">Note</span> To change the name of the site, edit <b>SITE_NAME</b> in your admin/config/db.php file. </div>';
		echo '</td></tr>';
	}
	else if(	$optionkey == 'realm'){
		echo '<tr><td>';
		echo '<label for="guild_realm" class="col-sm-1 control-label">Guild Realm</label>';
		echo '<div class="col-sm-4">';
		echo '<input id="guild_realm" type="text" name="guild_realm" class="form-control" placeholder="Guild Realm" value="'.$optionvalue.'" required />';
		echo '</div>';
		echo '</td></tr>';
	}
}


?>
</table>

<table class="table table-hover">
<thead><tr><th>Social Pages</th></tr></thead>
<?php

$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key = 'social'");
$row = mysqli_fetch_assoc($result);
$social = $row['option_value'];

		$sites = explode(',',$social);
		
		foreach($sites as $site){
			$siteinfo = explode('|',$site);
			$sitename = ucfirst($siteinfo[0]);
			$siteurl = $siteinfo[1];
		
			echo '<tr><td>';
			echo '<label for="social_'.$sitename.'" class="col-sm-1 control-label">'.$sitename.'</label>';
			echo '<div class="col-sm-4">';
			echo '<input id="social_'.$sitename.'" type="url" name="social_'.$sitename.'" class="form-control" placeholder="'.$sitename.' URL" value="'.$siteurl.'" />';
			echo '</div>';
			echo '</td></tr>';
		}
?>

</table>


<table class="table table-hover">
<thead><tr><th>Site Options</th></tr></thead>
<?php

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key IN ('footer','titlebar','posts')");
while($row = mysqli_fetch_assoc($result)){
$optionkey = $row['option_key'];
$optionvalue = $row['option_value'];

	if(	$optionkey == 'footer'){	
		echo '<tr><td>';
		echo '<label for="footer_text" class="col-sm-1 control-label">Footer Text</label>';
		echo '<div class="col-sm-4">';
		echo '<input id="footer_text" type="text" name="footer_text" class="form-control" placeholder="Footer Text" value="'.$optionvalue.'" required />';
		echo '</div>';
		echo '</td></tr>';
	}
	else if(	$optionkey == 'titlebar'){	
		echo '<tr><td>';
		echo '<label for="title_text" class="col-sm-1 control-label">Title Text</label>';
		echo '<div class="col-sm-4">';
		echo '<input id="title_text" type="text" name="title_text" class="form-control" placeholder="Title Text" value="'.$optionvalue.'" required />';
		echo '</div>';
		echo '</td></tr>';
	}
	else if(	$optionkey == 'posts'){	
		echo '<tr><td>';
		echo '<label for="num_posts" class="col-sm-1 control-label">Posts/page</label>';
		echo '<div class="col-sm-4">';
		echo '<input id="num_posts" type="number" min="1" max="10" class="form-control" name="num_posts" value="'.$optionvalue.'" />';
		echo '</div>';
		echo '</td></tr>';
	}


}
?>
</table>


<input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/>
</form>
</div>

<form method="post" action="" name="rostercacheform" class="form-horizontal form-settings" role="form">
<input type="hidden" name="action" value="clearroster" />
<p style="margin:20px 0 0 0"><input type="submit" class="btn btn-md btn-warning" value="Clear Roster Cache"></p>
</form>
<form method="post" action="" name="achievecacheform" class="form-horizontal form-settings" role="form">
<input type="hidden" name="action" value="clearachieve" />
<p style="margin:20px 0 0 0"><input type="submit" class="btn btn-md btn-warning" value="Clear Achieve Cache"></p>
</form>
<form method="post" action="" name="cacheform" class="form-horizontal form-settings" role="form">
<input type="hidden" name="action" value="clearcache" />
<p style="margin:20px 0 0 0"><input type="submit" class="btn btn-md btn-warning" value="Clear Site Cache"></p>
</form>
