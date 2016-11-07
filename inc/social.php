<div id="social">
<?php
$result = mysqli_query($con,"SELECT option_value FROM Options WHERE option_key='social'");

while($row = mysqli_fetch_assoc($result))
{
  
$social = explode(",",$row['option_value']);

foreach ($social as $site)
  {
		$siteinfo = explode("|",$site);
		$socialsite = $siteinfo[0];
		$socialaddress = $siteinfo[1];
		if($socialaddress!=''){
		echo '<a href="'.$socialaddress.'" title="Follow us on '.$socialsite.'" alt="Follow us on '.$socialsite.'" target="_blank">';
		echo '<img src="/images/icons/'.strtolower($socialsite).'.png"/>';
		echo '</a>';
		}
  } 

}

?>
</div>