<h1 class="page-header">Achievement Tracking</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
	
	$socials = array();

	foreach ($_POST as $key => $value){
		
		$fieldname = mysqli_real_escape_string($con, $key);
		$fieldvalue = mysqli_real_escape_string($con, $value);

		if($fieldname == 'currenttierraids'){
			$currenttierraids = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$currenttierraids' WHERE option_key='current_tier_raid'");
		}
		else if($fieldname == 'trackachieves'){
			$trackachieves = $fieldvalue;
			mysqli_query($con,"UPDATE Options SET option_value='$trackachieves' WHERE option_key='all_achieve_ids'");
		}
		
	}

    echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Updated.</div>';

}
?>


<form method="post" action="" name="settingsform" class="form-horizontal form-settings" role="form" enctype="multipart/form-data">

<table class="table table-hover">
<thead><tr><th>Current Tier</th></tr></thead>

<?php

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'current_tier_raid'");
while($row = mysqli_fetch_assoc($result)){
$optionkey = $row['option_key'];
$optionvalue = $row['option_value'];


		echo '<tr><td>';
		echo '<div class="col-sm-12">This populates the Progression widget. Enter raid name and kill achievement IDs for the current tier in the following format: Highmaul(XXXX,XXXX,XXXX,XXXX)|Blackrock Foundry(XXXX,XXXX,XXXX,XXXX) </div>';
		echo '</td></tr>';
		echo '<tr><td>';
		echo '<label for="currenttierraids" class="col-sm-2 control-label">Current Tier Raid(s)</label>';
		echo '<div class="col-sm-10">';
		echo '<input id="currenttierraids" type="text" name="currenttierraids" class="form-control" placeholder="Current Tier Raid(s)" value="'.$optionvalue.'" />';
		echo '</div>';
		echo '</td></tr>';

}


?>
</table>





<table class="table table-hover">
<thead><tr><th>Previous Tiers and Other Achievements</th></tr></thead>
<?php

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'all_achieve_ids'");
while($row = mysqli_fetch_assoc($result)){
$optionkey = $row['option_key'];
$optionvalue = $row['option_value'];


		echo '<tr><td>';
		echo '<div class="col-sm-12">Enter achievement IDs for previous tiers, metas, or any other achievements you would like to track, separated by a comma. E.g., XXXX,XXXX,XXXX. Note that order does not matter as these will appear sorted by date. </div>';
		echo '</td></tr>';
		echo '<tr><td>';
		echo '<label for="trackachieves" class="col-sm-2 control-label">Achievement IDs</label>';
		echo '<div class="col-sm-10">';
		echo '<textarea name="trackachieves" class="form-control" rows="10" id="trackachieves" rows="40" >'.$optionvalue.'</textarea>';
		echo '</div>';
		echo '</td></tr>';

}


?>
<tr><td><span class="label label-info">Note</span> Guild Achievements are tracked automatically. Only raid kill and other personal achievements need to be entered above. Leaving these empty will grab all recent achievements.</td></tr>
</table>

<?php

//$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'current_tier_ids'");
//while($row = mysqli_fetch_assoc($result)){
//$optionkey = $row['option_key'];
//$optionvalue = $row['option_value'];


		//echo '<div class="col-sm-10">';
		//echo '<input id="currenttierkills" type="text" name="currenttierkills" class="form-control" value="'.$optionvalue.'" />';
		//echo '</div>';

//}


?>

<input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/>
</form>
</div>

