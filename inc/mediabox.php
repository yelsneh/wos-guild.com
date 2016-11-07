<div id="links">
<?php 
$result = mysqli_query($con,"SELECT * FROM Gallery ORDER BY ID DESC LIMIT 6 ");

while($row = mysqli_fetch_assoc($result)) {
	$type = $row['Type'];
	$content = $row['name'];
	$title = html_entity_decode($row['Title']);
	$caption = html_entity_decode($row['Caption']);
	$uploaded = $row['Uploaded'];
	$slide = $row['Slide'];
	
	if(strpos($type,'image')!==false && $uploaded==1){
		echo '<a href="/images/upload/files/'.$content.'" title="'.$title.'" data-gallery><img src="/images/upload/files/'.$content.'" alt="'.$title.'"></a>';
	}
	else if(strpos($type,'image')!==false && $uploaded==0){
		echo '<a href="'.$content.'" title="'.$title.'" data-gallery><img src="'.$content.'" alt="'.$title.'"></a>';
	}
}

?>
</div>



<div id="streams-small">
<?php 


$last_mod = filemtime('cache/streamlist.json');
$age = time() - $last_mod;

if($age > 180){
	
	$streamresults = array();	
	$streams = array();
	$result = mysqli_query($con,"SELECT * FROM Streams") or die("Some error occurred during connection " . mysqli_error($con)); 
	while($rows = mysqli_fetch_array($result)){
		array_push($streams, $rows['Name']);
	}
	
		//Determines if a user's justin.tv stream is online, then displays it if it is
		//To add more streams add the justin.tv channel id to the $streams array
		if (isset($_GET['firstchannel'])){
			$firstkey = array_search($firstchannel,$streams);
			array_splice($streams,$firstkey,1);
		}
		shuffle($streams);
		foreach ($streams as $i) {
			$chan = "https://api.twitch.tv/kraken/streams/".strtolower($i);
			$json = file_get_contents($chan);
			$exist = strpos($json, 'name');
			if($exist) {
				$data = json_decode($json, TRUE);
				$image = $data['stream']['preview']['medium'];
				$game = $data['stream']['game'];												
				$streamresults[] = array('name'=> $i, 'image'=> $image, 'game'=> $game);
			}
		}

	file_put_contents('cache/streamlist.json', json_encode($streamresults));
}


	$streamjson = file_get_contents('cache/streamlist.json');
	$streamdata = json_decode($streamjson, true);
	foreach ($streamdata as $i) {
		$name = $i['name'];
		$image = $i['image'];
		$game = $i['game'];
	
		echo "<div> ";
		echo '<a href="/media/'.$name.'#streams"><img src='.$image.' alt="'.$i.' is playing '.$game.'" title="'.$name.' playing '.$game.'"></a>';
		echo "</div>";
	}
?>
</div>