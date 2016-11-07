<div id="tags">
<?php
$result = mysqli_query($con,"SELECT tags FROM News");

$AllTags = array();

while($row = mysqli_fetch_assoc($result))
{
  
$Tags = explode(",",$row['tags']);

foreach ($Tags as $Tag)
  {
array_push($AllTags, trim($Tag));
  } 

}

$NewTags = array_count_values($AllTags);

$UniqueTags = array_unique($AllTags);

foreach ($UniqueTags as $NewTag)
{
echo "<a href='/news/tags/".str_replace(" ","-",$NewTag)."' style='font-size:1.".$NewTags[$NewTag].$NewTags[$NewTag].$NewTags[$NewTag]."em;' >".$NewTag."</a> ";
}

?>
</div>