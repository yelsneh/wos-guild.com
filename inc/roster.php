<div id="roster">
<?php 
$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'realm'");
$row = mysqli_fetch_assoc($result);
$realm = $row['option_value'];
$realm = str_replace(' ','-', $realm);
$realm = str_replace("'","", $realm);
$apikeystring = "&locale=en_US&apikey=ywputdcsx5wqttm3vvye5ecerszhuebc";

$apihost = 'https://us.api.battle.net/wow/character/'.$realm.'/';
$linkpath = 'http://us.battle.net/wow/en/character/'.$realm.'/';
$imagepath = 'http://us.battle.net/static-render/us/';
$specimgpath = 'http://media.blizzard.com/wow/icons/36/';

$last_mod = filemtime($_SERVER['DOCUMENT_ROOT'].'/cache/rosterlist.json');
$age = time() - $last_mod;

	$result = mysqli_query($con,"SELECT * FROM Ranks ORDER BY Level");
	$ranks = array();
	while($row = mysqli_fetch_assoc($result)){
		$RankName = $row['Name'];
		array_push($ranks, $RankName);
		${$RankName} = array();
		${$RankName.'results'} = array();
		
	}
	
	
if($age > 21600){

	
	$rosterresults = array();

	$result = mysqli_query($con,"SELECT * FROM Roster");
	while($row = mysqli_fetch_assoc($result)){
		$membername = html_entity_decode($row['Name']);
		$membername = html_entity_decode($membername);
		$memberrank = $row['Rank'];

		foreach ($ranks as $rank=>$r){
			if($memberrank==$r){array_push(${$r},$membername);}	
		}
	}
	foreach ($ranks as $rank=>$r){

	if(count(${$r})>0){
		foreach (${$r} as $j) {
			$fetch = $apihost.strtolower($j).'?fields=talents&'.$apikeystring;
			$json = file_get_contents($fetch);
			$exist = strpos($json, 'name');
			if($exist) {
				$data = json_decode($json, true);
				$name = $data['name'];
				$level = $data['level'];
				$class = $data['class'];
				$thumbnail = $data['thumbnail'];
				$points = $data['achievementPoints'];
				
				//get active spec
				$spec_count = isset($data['talents']) ? count($data['talents']) : 0;
				$active_set = null;
				
				if ($spec_count > 0)
				{
				 foreach ($data['talents'] as $set)
				 {
				 if (isset($set['selected']) && ($set['selected'] == true))
				 {
				 $active_set = $set;
				 }
				 }
				}
				
				if ($active_set != null)
				{
				 $specname = $active_set['spec']['name'];
				 $specrole = $active_set['spec']['role'];
				 $specicon = $active_set['spec']['icon'];
				}
						
				${$r.'results'}[] = array('name'=> $name, 'level'=> $level, 'class'=> $class, 'thumbnail'=> $thumbnail, 'points'=> $points, 'specname'=> $specname, 		'specrole'=> $specrole, 'specicon'=> $specicon);
			}
			$rosterresults[$r] = ${$r.'results'};
		}
	}
	}


	
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cache/rosterlist.json', json_encode($rosterresults));
}


	$rosterjson = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cache/rosterlist.json');
	$rosterdata = json_decode($rosterjson, true);
	
	foreach ($ranks as $rank=>$r){
	${$r.'data'} = $rosterdata[$r];

	if(count(${$r.'data'})>0){
			
		echo '<h3>'.ucfirst($r).'</h3>';
		echo '<div class="row">';
		foreach (${$r.'data'} as $j) {
			$name = $j['name'];
			$level = $j['level'];
			$class = $j['class'];
			$thumbnail = $j['thumbnail'];
			$points = $j['points'];
			$spec = $j['specname'];
			$role = $j['specrole'];
			$icon = $j['specicon'];
						
			echo '<div class="col-sm-2 roster-class'.$class.'">';
			echo '<a href="'.$linkpath.$name.'/advanced" target="_blank" class="thumbnail">';
			echo '<img src="'.$imagepath.$thumbnail.'" alt="'.$name.'" title="'.$name.'"></a>';
			echo '<span class="roster-name">'.$name.'</span><br/>';
			echo '<span class="spec"><img src="'.$specimgpath.$icon.'.jpg" alt="'.$role.' - '.$spec.'" title="'.$role.' - '.$spec.'"/></span><br/>';
			echo '<span class="label label-warning">'.$points.'</span>';
			echo '</div>';

		}
		echo '</div>';
	}
	}
	
?>
</div>