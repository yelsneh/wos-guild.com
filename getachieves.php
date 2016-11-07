<?php 
require_once("admin/config/db.php");
require_once("inc/connect.php");


$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'realm'");
$row = mysqli_fetch_assoc($result);
$realm = $row['option_value'];
$realm = str_replace(' ','-', $realm);
$realm = str_replace("'","", $realm);
$apikeystring = "&locale=en_US&apikey=ywputdcsx5wqttm3vvye5ecerszhuebc";

$tierresult = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'current_tier_raid'");
$tierrow = mysqli_fetch_assoc($tierresult);
$tierinfo = $tierrow['option_value'];
$tierinfos = explode('|',$tierinfo);
$tierraids = array();
$tierraidids = array();
foreach ($tierinfos as $tierraid){
	$tierraidinfo = explode('(',$tierraid);
	$tierraidname = $tierraidinfo[0];
	array_push($tierraids,$tierraidname);
			
	$tierraiddata = explode(')',$tierraidinfo[1]);
	$tierraididlist = explode(',',$tierraiddata[0]);
	foreach($tierraididlist as $tierraidid){
		array_push($tierraidids,$tierraidid);		
	}
}

$achieveresult = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'all_achieve_ids'");
$achieverow = mysqli_fetch_assoc($achieveresult);
$achieveinfo = $achieverow['option_value'];
$achieveinfos = explode(',',$achieveinfo);
$achieveinfoids = array();
foreach ($achieveinfos as $achieveinfoid){
	array_push($achieveinfoids,$achieveinfoid);
}

$guildapihost = 'https://us.api.battle.net/wow/guild/'.$realm.'/';
$achieveapihost = 'https://us.api.battle.net/wow/achievement/';
$imagepath = 'http://media.blizzard.com/wow/icons/56/';
$linkpath = 'http://www.wowhead.com/achievement=';

$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'guild'");
$row = mysqli_fetch_assoc($result);
$guild = $row['option_value'];
$guild = str_replace(' ','%20', $guild);



	$fetch = $guildapihost.$guild.'?fields=achievements&'.$apikeystring;
	$json = file_get_contents($fetch);
	$data = json_decode($json, true);
	$achieveidlist = $data['achievements']['achievementsCompleted'];
	$achievetimelist = $data['achievements']['achievementsCompletedTimestamp'];
	
	$max = count($achieveidlist)-1;
	$min = count($achieveidlist)-20;
	
	
	for($i=$max; $i>$min; $i--){
		$fetchname = $achieveapihost.$achieveidlist[$i].'?'.$apikeystring;
		$jsonname = file_get_contents($fetchname);
		$dataname = json_decode($jsonname, true);
		$achievename = $dataname['title'];
		$achieveicon = $dataname['icon'];
		
		$achieveresults[] = array('id'=> $achieveidlist[$i], 'name' => $achievename, 'icon' => $achieveicon, 'time'=> $achievetimelist[$i]);
	}
	
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cache/guildachievements.json', json_encode($achieveresults));




$progressionapihost = 'https://us.api.battle.net/wow/character/'.$realm.'/';

	$raiders = array();

	$result = mysqli_query($con,"SELECT * FROM Roster");
	while($row = mysqli_fetch_assoc($result)){
		$membername = html_entity_decode($row['Name']);
		$membername = html_entity_decode($membername);
		$memberrank = $row['Rank'];
	
		array_push($raiders,$membername);		
	}
	
	$commonlist = array();

	$killsjson = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cache/guildpersonalachievements.json');
	$killsdata = json_decode($killsjson, true);
	if(!$killsdata){
		$killsdata=array();
	}

	$numraiders = 0;
	shuffle($raiders);
	$achievenumtotrack = count($achieveinfoids) + count($tierraidids);

	foreach ($raiders as $j) {

		$bossachievefetch = $progressionapihost.strtolower($j).'?fields=achievements&'.$apikeystring;
		$json = file_get_contents($bossachievefetch);
		$exist = strpos($json, 'name');	
		
		if($exist) {
			$numraiders++;
			$data = json_decode($json, true);
			$achieveidlist = $data['achievements']['achievementsCompleted'];
			$achievetimelist = $data['achievements']['achievementsCompletedTimestamp'];
			
			
			if($achievenumtotrack<1){			
				$max = count($achieveidlist)-1;
				$min = count($achieveidlist)-500;
				
				
				for($i=$max; $i>$min; $i--){
					if (!array_key_exists($achieveidlist[$i], $commonlist)){
						$commonlist[$achieveidlist[$i]] = array('id'=>$achieveidlist[$i], 'timestamp'=>$achievetimelist[$i], 'people'=>1);
					}
					else{
						$commonlist[$achieveidlist[$i]] = array('id'=>$achieveidlist[$i], 'timestamp'=>$achievetimelist[$i], 'people'=>$commonlist[$achieveidlist[$i]]['people']+1);
					}
				}
			}else{
				$listlength = count($achieveidlist);
				for($i=0; $i<$listlength; $i++){
					if (in_array($achieveidlist[$i], $achieveinfoids) || in_array($achieveidlist[$i], $tierraidids)) {
						if (!array_key_exists($achieveidlist[$i], $commonlist)){
							$commonlist[$achieveidlist[$i]] = array('id'=>$achieveidlist[$i], 'timestamp'=>$achievetimelist[$i], 'people'=>1);
						}
						else{
							$commonlist[$achieveidlist[$i]] = array('id'=>$achieveidlist[$i], 'timestamp'=>$achievetimelist[$i], 'people'=>$commonlist[$achieveidlist[$i]]['people']+1);
						}
					}
				}
				
			}
		}
	}
	
	$bosskills=array();

	foreach($commonlist as $achieve){	
		$achieveid = $achieve['id'];
		$achievetime = $achieve['timestamp'];
		$people = $achieve['people'];
	
		if($people >= ($numraiders*.50)){
			$fetchname = $achieveapihost.$achieveid.'?'.$apikeystring;
			$jsonname = file_get_contents($fetchname);
			$dataname = json_decode($jsonname, true);
			$achievename = $dataname['title'];
			$achieveicon = $dataname['icon'];
		
			if (!array_key_exists($achieveid, $killsdata)){
				$killsdata[$achieveid] = array('id'=> $achieveid, 'name' => $achievename, 'icon' => $achieveicon, 'time'=> $achievetime);
			}
			if (in_array($achieveid, $tierraidids)) {
				array_push($bosskills,$achieveid);
			}
			
		}
	}
	
	$bosskillslist = implode(',',$bosskills);
	mysqli_query($con,"UPDATE Options SET option_value='$bosskillslist' WHERE option_key='current_tier_ids'");


	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/cache/guildpersonalachievements.json', json_encode($killsdata));


?>
