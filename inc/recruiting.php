<div id="recruitment">
<?php

$result = mysqli_query($con,"SELECT * FROM Recruitment");

$spec = 0;
$sameclass = '';	
while($row = mysqli_fetch_assoc($result)) {
	$class = str_replace(' ','',strtolower($row['Class']));
	if($row['Open'] == 1){$open = "Currently Recruiting";}
	else {$open = "Not Recruiting";}
	
	if($sameclass == $class){		
		$spec++;
		echo "<div class='spec spec-".$class." spec-".$spec." recruiting-".$row['Open']."' title='".$row['Spec']." - ".$open."'></div>";
		if($class == 'druid' && $spec == 3){echo "</div>";}
		else if($class != 'druid' && $spec == 2){echo "</div>";}
	}
	else {
		$sameclass = $class;
		$spec = 0;
		
		echo "<div class='class'><div class='class-title class-".$class."'>".$row['Class']."</div>";
		if ($class != 'druid'){
		echo "<div class='spec spec-".$class." spec-".$spec." recruiting-".$row['Open']." push' title='".$row['Spec']." - ".$open."'></div>";
		}
		else{
		echo "<div class='spec spec-".$class." spec-".$spec." recruiting-".$row['Open']."' title='".$row['Spec']." - ".$open."'></div>";
		}
	}
	
	

}

?>
</div>