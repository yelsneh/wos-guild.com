<div id="archive">
<ul class="list-unstyled">

<?php
$result = mysqli_query($con,"SELECT date_posted FROM News GROUP BY YEAR(date_posted) DESC, MONTH(date_posted) DESC");

  $dateArray = array();
  while ($row = mysqli_fetch_assoc($result))
  {
	$date = $row['date_posted'];
	$newdate = explode(" ",$date);
	$monthYear = date("F Y", strtotime($newdate[0]));
	$month = date("m", strtotime($newdate[0]));
	$year = date("Y", strtotime($newdate[0]));
	$postDates = array(
		"year" => $year,
		"month" => $month,
		"monthYear" => $monthYear		
	);
	
	array_push($dateArray, $postDates);
  }

  foreach($dateArray as $postDate){
	  echo "<li><a href='/news/archive/".$postDate['year']."/".$postDate['month']."'>".$postDate['monthYear']."</a></li>";
  }


?>
</ul>
</div>



