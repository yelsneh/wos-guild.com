<div id="bosskills">
<?php

$tierresult = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'current_tier_raid'");
$tierrow = mysqli_fetch_assoc($tierresult);
$tierinfo = $tierrow['option_value'];
$tierinfos = explode('|',$tierinfo);
$tierraids = array();
foreach ($tierinfos as $tierraid){
	$tierraidinfo = explode('(',$tierraid);
	$tierraidname = $tierraidinfo[0];
			
	$tierraidids = array();
	$tierraiddata = explode(')',$tierraidinfo[1]);
	$tierraididlist = explode(',',$tierraiddata[0]);
	foreach($tierraididlist as $tierraidid){
		array_push($tierraidids,$tierraidid);		
	}
	
	$tierraids[] = array('name'=>$tierraidname, 'ids'=>implode(',',$tierraidids), 'bosscount'=>count($tierraidids));
}

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'current_tier_ids'");
while($row = mysqli_fetch_assoc($result)){
$optionkey = $row['option_key'];
$optionvalue = $row['option_value'];
$killedbosses = explode(',',$optionvalue);
}

foreach($tierraids as $raid){
	$raidname = $raid['name'];
	$bossids = $raid['ids'];
	$bosscount = $raid['bosscount'];
	
	echo '<div style="text-align:center">';
	echo '<h4 style="border:0;">'.$raidname . '</h4>';
	
	$killed = 0;
	$bosslist = explode(',',$bossids);
	foreach($bosslist as $boss){
		if(in_array($boss,$killedbosses)){
			$killed++;
		}
	}
	
	echo '<h3 style="margin-top:0;border:0;">'.$killed .'/'.$bosscount.'</h3>';
	echo '</div>';
}


?>
</div>