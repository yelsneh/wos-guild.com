<div id="latest">
<?php

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'posts'");
	$row = mysqli_fetch_assoc($result);
	$postsperpage = $row['option_value'];
	
	
$result = mysqli_query($con,"SELECT * FROM News WHERE date_posted < NOW() AND publish=1 ORDER BY date_posted DESC LIMIT $postsperpage");
		
		
    $postArray = array();
    while($row = mysqli_fetch_assoc($result))
    {
    	$myPost = array(
		    "id" => $row['id'],
			"title" => $row['title'], 
			"post" => $row['post'], 
			"tags" => $row['tags'], 
			"author" => $row['author'], 
			"date" => $row['date_posted']
		);
        array_push($postArray, $myPost);
    }
			
foreach ($postArray as $post)
{
	$find = array("/ ",",","'");
	$replace = "";
	$link = str_replace($find,$replace,$post['title']);
	$link = str_replace(" ","-",$link);	
	$link = $post['id'].'-'.$link;
	
	$postTags = array();
	$Tags = explode(",",$post['tags']);
	foreach ($Tags as $Tag)
	  {array_push($postTags, trim($Tag));} 
	  
	$date = $post['date'];
	$newdate = explode(" ",$date);
	$postDate = date("F j, Y", strtotime($newdate[0]));

	$posttext = str_replace("\r\n\r\n","</p><p>",$post['post']);	

	$html = str_get_html($posttext);
	
	// Find all images 
	foreach($html->find('img') as $image){
		$imagesrc = $image->src;
		$newimage = '<a href="'.$imagesrc.'" data-gallery>'.$image.'</a>';
		$posttext = str_replace($image,$newimage,$posttext);
	}

	
	$postbreak = strpos($posttext,"[more]");
	if ($postbreak){		
		$posttext = substr($posttext,0,$postbreak);
		$posttext .= "</p><p><a href='/news/".$link."' class='btn btn-default' role='button'>Read More &raquo;</a></p>";

	}
	else{
			$posttext .= "</p>";
		}

	  
    echo "<div class='blog-post'>";
    echo "<h2 class='blog-post-title'><a href='/news/".$link."'>" . $post['title'] . "</a></h2>";
    echo "<p class='blog-post-meta'>" . $postDate . " by <a href='/news/author/".$post['author']."'>" . $post['author'] . "</a></p>";
    echo "<p>" . $posttext;
	echo "<p>Tags: ";
	
	foreach ($postTags as $postTag){
		echo "<a href='/news/tags/".str_replace(" ","-",$postTag)."'>".$postTag."</a> ";
	}

	echo "</p>";
    echo "</div>";
}
?>
</div>