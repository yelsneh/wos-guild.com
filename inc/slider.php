<div class="banner">
	<ul>
<?php 
$result = mysqli_query($con,"SELECT * FROM Slider LIMIT 5");

while($row = mysqli_fetch_assoc($result)) {
	$image = $row['Image'];
	$header = html_entity_decode($row['Header']);
	$content = html_entity_decode($row['Content']);
	$link = $row['Link'];
	
	echo '<li style="background-image: url('.$image.');"><h1>'.$header.'</h1><p>'.$content.'</p><a class="btn" href="'.$link.'">Read More</a></li>';
	
}

?>
	</ul>
</div>
        
<script>
			$('.banner li').css('background-size', 'auto auto');
			
			$('.banner').unslider({
				speed: 1000,
				delay: 10000,
				keys: true, 
				fluid: true,
				dots: false
			});
</script>