<div id="blueimp-gallery-carousel" class="blueimp-gallery blueimp-gallery-carousel blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>


<script src="/js/blueimp-gallery.min.js"></script>
<script type="text/javascript">

blueimp.Gallery([   
<?php 
$result = mysqli_query($con,"SELECT * FROM Gallery ORDER BY ID DESC");
$num_rows = mysqli_num_rows($result);
$i = 1;
while($row = mysqli_fetch_assoc($result)) {
	$type = $row['Type'];
	$content = $row['name'];
	$title = html_entity_decode($row['Title']);
	$caption = html_entity_decode($row['Caption']);
	$youtube = $row['Youtube'];
	$uploaded = $row['Uploaded'];
	$slide = $row['Slide'];
	
	if($type=='youtube'){
		echo '{
			title: "'.$title.': '.$caption.'",
			type: "text/html",
	        href: "'.$content.'",
			youtube: "'.$youtube.'",
			poster: "http://img.youtube.com/vi/'.$youtube.'/0.jpg"
		}';
		if($i<$num_rows){echo ',';}
	}
	else if(strpos($type,'image')!==false && $uploaded==1){
		echo '{
		title: "'.$title.': '.$caption.'",
        href: "/images/upload/files/'.$content.'",
        type: "image/jpeg",
        thumbnail: "'.$content.'"
    	}';
		if($i<$num_rows){echo ',';}
	}
	else if(strpos($type,'image')!==false && $uploaded==0){
		echo '{
			title: "'.$title.': '.$caption.'",
        href: "'.$content.'",
        type: "image/jpeg",
        thumbnail: "'.$content.'"
    	}';
		if($i<$num_rows){echo ',';}
	}
	else if(strpos($type,'video')!==false && $uploaded==1){
		echo '{
			title: "'.$title.': '.$caption.'",
        href: "/images/upload/files/'.$content.'",
        type: "video/*",
        thumbnail: "'.$content.'"
    	}';
		if($i<$num_rows){echo ',';}
	}
	else if(strpos($type,'video')!==false && $uploaded==0){
		echo '{
			title: "'.$title.': '.$caption.'",
        href: "'.$content.'",
        type: "video/*",
        thumbnail: "'.$content.'"
    	}';
		if($i<$num_rows){echo ',';}
	}
	$i++;	 
}
?>
],
	{
		container: '#blueimp-gallery-carousel',
		carousel: true,
		enableKeyboardNavigation: true
	}
);

</script>

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



<div id="streams">
<h3>Streams</h3><a name="streams"></a>
<?php 


	$streams = array();
	$result = mysqli_query($con,"SELECT * FROM Streams");
	while($rows = mysqli_fetch_array($result)){
		array_push($streams, $rows['Name']);
	}

	//Determines if a user's justin.tv stream is online, then displays it if it is
	//To add more streams add the justin.tv channel id to the $streams array
	if (isset($_GET['firstchannel'])){$firstchannel = $_GET['firstchannel'];}
	$chan = "";
	if (isset($_GET['firstchannel'])){
		$firstkey = array_search($firstchannel,$streams);
		array_splice($streams,$firstkey,1);
	}
	shuffle($streams);
	if (isset($_GET['firstchannel'])){array_unshift($streams,$firstchannel);}
	$offline = array();
	$row = 0;
	foreach ($streams as $i) {
		$chan = "https://api.twitch.tv/kraken/streams/".strtolower($i);
		$json = file_get_contents($chan);
		$exist = strpos($json, 'name');
        	if($exist) {
                    echo "<div class='streamer stream".$row."'><span><a href='http://www.twitch.tv/".$i."' target='_blank'>".$i."</a></span> ";
                    if ($row!=0){
						echo "<a href='/media/".$i."'>Make Primary</a>";
					}
					echo "<br/>";
                    if ($row==0){
                    	echo '<object type="application/x-shockwave-flash" class="stream-main" id="live_embed_player_flash"
							data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='.$i.'">
							<param  name="flashvars" value="hostname=www.twitch.tv&channel='.$i.'&auto_play=true&start_volume=25" />
							</object>';
						
						//echo '<iframe frameborder="0" scrolling="no" id="chat_embed" src="http://twitch.tv/chat/embed?channel='.$i.'&amp;popout_chat=true">
						//	</iframe>';
                    }
                    else {
                    	echo '<object type="application/x-shockwave-flash" class="stream" id="live_embed_player_flash"
							data="http://www.twitch.tv/widgets/live_embed_player.swf?channel='.$i.'">
							<param  name="flashvars" value="hostname=www.twitch.tv&channel='.$i.'&auto_play=true&start_volume=0" />
							</object>';
					}
                    echo "</div>";
                    $row++;

                }
                else {array_push($offline,$i);}		
	} 
	if ($row == 0){
		echo "<p>Sorry, no one is currently streaming.</p>";
	}
		echo "<div style='clear:both'><h5>Offline Streamers:</h5><ul class='streamerlist'>";
		foreach ($offline as $j) {
		echo "<li><a href='http://www.twitch.tv/".$j."' target='_blank'>".$j."</a></li>";
		}
		echo "</ul></div>";
?>
</div>


