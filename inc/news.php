<div id="news">
<?php

	// rows per page

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'posts'");
	$row = mysqli_fetch_assoc($result);
	$postsperpage = $row['option_value'];
		
	$rowsPerPage = $postsperpage;
	
	// if $_GET
	
	if(isset($_GET['page'])){
		$pageNum= $_GET['page'];
	}
	else{
		$pageNum = 1;
	}
	
	// preceding rows
	
	$previousRows =($pageNum - 1) * $rowsPerPage;
	
	// the first, optional value of LIMIT is the start position


if(isset($_GET['post'])){
	$ID = $_GET['post'];
	require_once('admin/translations/en.php');
	require_once("admin/classes/Login.php");
	$login = new Login();
	if(isset($_GET['preview'])){				
		if ($login->isUserLoggedIn() == true) {
			$result = mysqli_query($con,"SELECT * FROM News WHERE id = $ID");
			$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE id = $ID");
		}
	}
	else {
		$result = mysqli_query($con,"SELECT * FROM News WHERE id = $ID AND date_posted < NOW() AND publish=1"); 
		$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE id = $ID AND date_posted < NOW() AND publish=1");
	}
}
else if(isset($_GET['tags'])){
	$inTag = $_GET['tags'];
	$inTag = str_replace('-',' ',$inTag);
    $result = mysqli_query($con,"SELECT * FROM News WHERE tags LIKE '%" . $inTag . "%' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC LIMIT $previousRows, $rowsPerPage");
	$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE tags LIKE '%" . $inTag . "%' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC");
}
else if(isset($_GET['author'])){
	$inAuthor = $_GET['author'];
    $result = mysqli_query($con,"SELECT * FROM News WHERE author = '" . $inAuthor . "' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC LIMIT $previousRows, $rowsPerPage");
	$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE author = '" . $inAuthor . "' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC");
}
else if(isset($_GET['year']) && !isset($_GET['month'])){
	$inYear = $_GET['year'];
    $result = mysqli_query($con,"SELECT * FROM News WHERE YEAR(date_posted) = '" . $inYear . "' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC LIMIT $previousRows, $rowsPerPage");
	$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE YEAR(date_posted) = '" . $inYear . "' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC");
}
else if(isset($_GET['year']) && isset($_GET['month'])){
	$inYear = $_GET['year'];
	$inMonth = $_GET['month'];
    $result = mysqli_query($con,"SELECT * FROM News WHERE YEAR(date_posted) = '" . $inYear . "' AND MONTH(date_posted) = '" . $inMonth . "' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC LIMIT $previousRows, $rowsPerPage");
	$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE YEAR(date_posted) = '" . $inYear . "' AND MONTH(date_posted) = '" . $inMonth . "' AND date_posted < NOW() AND publish=1 ORDER BY date_posted DESC");
}
else{
	$result = mysqli_query($con,"SELECT * FROM News WHERE date_posted < NOW() AND publish=1 ORDER BY date_posted DESC LIMIT $previousRows, $rowsPerPage");
	$query = mysqli_query($con,"SELECT COUNT(id) AS numrows FROM News WHERE date_posted < NOW() AND publish=1  ORDER BY date_posted DESC");
}	
	
	$countrow = mysqli_fetch_assoc($query);
	$numrows = $countrow['numrows'];
	
	// find the last page number
	
	$lastPage = ceil($numrows/$rowsPerPage);
			
	//then we print first and previous links
	
	if ($pageNum > 1){
	
	$page = $pageNum - 1;
	
	$nextlink = '';
	
		if($page == 1){
			if(isset($_GET['tags'])){
				$nextlink = '/news/tags/'.$_GET['tags'];
			}
			else if(isset($_GET['author'])){
				$nextlink = '/news/author/'.$_GET['author'];
			}
			else if(isset($_GET['year']) && !isset($_GET['month'])){
				$nextlink = '/news/archive/'.$_GET['year'];
			}
			else if(isset($_GET['year']) && isset($_GET['month'])){
				$nextlink = '/news/archive/'.$_GET['year'].'/'.$_GET['month'];
			}
			else{
				$nextlink = '/news';
			}
		}
		else {	
			if(isset($_GET['tags'])){
				$nextlink = '/news/tags/'.$_GET['tags'].'/page'.$page;
			}
			else if(isset($_GET['author'])){
				$nextlink = '/news/author/'.$_GET['author'].'/page'.$page;
			}
			else if(isset($_GET['year']) && !isset($_GET['month'])){
				$nextlink = '/news/archive/'.$_GET['year'].'/page'.$page;
			}
			else if(isset($_GET['year']) && isset($_GET['month'])){
				$nextlink = '/news/archive/'.$_GET['year'].'/'.$_GET['month'].'/page'.$page;
			}
			else{
				$nextlink = '/news/page'.$page;
			}
		}
	
	$next = "<a href=".$nextlink." class='btn btn-default' role='button'>Newer &raquo;</a>";
	}
	else {
		$next = '';
	}
	
		
	if ($pageNum < $lastPage)
	
	{
	
	$page = $pageNum + 1;
	
	$prevlink = '';

		if(isset($_GET['tags'])){
				$prevlink = '/news/tags/'.$_GET['tags'].'/page'.$page;
		}
		else if(isset($_GET['author'])){
				$prevlink = '/news/author/'.$_GET['author'].'/page'.$page;
		}
		else if(isset($_GET['year']) && !isset($_GET['month'])){
				$prevlink = '/news/archive/'.$_GET['year'].'/page'.$page;
		}
		else if(isset($_GET['year']) && isset($_GET['month'])){
				$prevlink = '/news/archive/'.$_GET['year'].'/'.$_GET['month'].'/page'.$page;
		}
		else{
				$prevlink = '/news/page'.$page;
		}
		
	$prev = "<a href=".$prevlink." class='btn btn-default' role='button'>&laquo; Older</a> ";
	
	}
	else {
		$prev = '';
	}	
	

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



	if(!isset($_GET['post'])){
		$postbreak = strpos($posttext,"[more]");
		if ($postbreak){		
		$posttext = substr($posttext,0,$postbreak);
		$posttext .= "</p><p><a href='/news/".$link."' class='btn btn-default' role='button'>Read More &raquo;</a></p>";
		}
		else{
			$posttext .= "</p>";
		}
	}
	else{
		$posttext .= "</p>";
	}
	  
    echo "<div class='blog-post'>";
	if(!isset($_GET['post'])){
    echo "<h2 class='blog-post-title'><a href='/news/".$link."'>" . $post['title'] . "</a></h2>";
	}
	else{
    echo "<h2 class='blog-post-title'>" . $post['title'] . "</h2>";
	}
    echo "<p class='blog-post-meta'>" . $postDate . " by <a href='/news/author/".$post['author']."'>" . $post['author'] . "</a></p>";
    echo "<p>" . $posttext;
	echo "<p>Tags: ";
	
	foreach ($postTags as $postTag){
		echo "<a href='/news/tags/".str_replace(" ","-",$postTag)."'>".$postTag."</a> ";
	}

	echo "</p>";
    echo "</div>";
}
	
	echo '<ul class="pager">
		<li class="previous">'.$prev.'</li>
		<li class="next">'.$next.'</li>
	</ul>';

?>
</div>