<div id="achievements">
<?php

	$imagepath = 'http://media.blizzard.com/wow/icons/56/';
	$linkpath = 'http://www.wowhead.com/achievement=';

	$allachieves = array();
	
	$achievejson1 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cache/guildachievements.json');
	$achievedata1 = json_decode($achievejson1, true);
	
	if(count($achievedata1)>0){
		foreach ($achievedata1 as $x) {
			$id = $x['id'];
			$name = $x['name'];
			$icon = $x['icon'];
			$time = $x['time'];
			array_push($allachieves, array('id'=>$id, 'name'=>$name, 'icon'=>$icon, 'time'=>$time));
		}
	}

	$achievejson2 = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/cache/guildpersonalachievements.json');
	$achievedata2 = json_decode($achievejson2, true);

	if(count($achievedata2)>0){
		foreach ($achievedata2 as $y) {
			$id = $y['id'];
			$name = $y['name'];
			$icon = $y['icon'];
			$time = $y['time'];
			array_push($allachieves, array('id'=>$id, 'name'=>$name, 'icon'=>$icon, 'time'=>$time));
		}
	}
	
	
	usort($allachieves, function($a, $b) { //Sort the array using a user defined function
		return $a['time'] > $b['time'] ? -1 : 1; //Compare the scores
	});
	

	$max = min(6,count($allachieves));
			
	for($i=0; $i<$max; $i++){

		$name = $allachieves[$i]['name'];
		$time = $allachieves[$i]['time'];
		$icon = $allachieves[$i]['icon'];
		$id = $allachieves[$i]['id'];
		
		date_default_timezone_set(TIME_ZONE);
		$datetime = date("M. j, Y, g:ia", substr($time,0,10));
		
		echo '<div class="media"><a class="pull-left" href="'.$linkpath.$id.'" target="_blank" alt="'.$name.'" title="'.$name.'">';
		$url=$imagepath.$icon.'.jpg';
		$headers = get_headers($url, 1);
		if ($headers[0] == 'HTTP/1.0 404 Not Found') {
		$noimage = '/images/noimage-sm.gif';
		echo '<img class="media-object" src="'.$noimage.'" alt="'.$name.'" title="'.$name.'">';
		}
		else{
		echo '<img class="media-object" src="'.$url.'" alt="'.$name.'" title="'.$name.'">';
		}
		echo '</a><div class="media-body">'.$datetime.'<p class="media-heading">'.$name.'</p>';
		echo '</div></div>';		
									
	}
	
?>
</div>