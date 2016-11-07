<?php 

// Connect DB
require_once("admin/config/db.php");
require_once("inc/connect.php");
require_once('inc/simple_html_dom.php');
require_once('inc/lessc.inc.php');

//Include Header Scripts
include("inc/head.php");


if(isset($_GET['p'])){

//Include Header Section
include("inc/header.php");

	$page = $_GET['p'];

	if($page != 'forums' && $page != 'archives' && $page != 'tags'){
	
		$pagetitle = ucwords(str_replace('-',' ',$page));
		echo '<div class="container">';
		echo '<h1></h1>';
		echo '<div class="row">';
		$leftquery = mysqli_query($con,"SELECT COUNT(id) AS numleftrows FROM Widgets WHERE ShowWidget=1 AND Side LIKE 'left'");
		$countleft = mysqli_fetch_assoc($leftquery);
		$numleftrows = $countleft['numleftrows'];
				
		$rightquery = mysqli_query($con,"SELECT COUNT(id) AS numrightrows FROM Widgets WHERE ShowWidget=1 AND Side LIKE 'right'");
		$countright = mysqli_fetch_assoc($rightquery);
		$numrightrows = $countright['numrightrows'];


		if ($numleftrows > 0){
		echo '<div class="col-sm-3">';
		include('inc/leftbar.php');
		echo '</div>';
        } 
		if ($numleftrows == 0 && $numrightrows == 0){ 
        	echo '<div class="col-sm-12">';
		}
		elseif (($numleftrows == 0 && $numrightrows > 0) || ($numleftrows > 0 && $numrightrows == 0)){ 
        	echo '<div class="col-sm-9">';
		}
		else{
        	echo '<div class="col-sm-6">';
		}
		echo '<h2>'.$pagetitle.'</h2>';

	
		$filename = "inc/".$page.".php";
		if(file_exists($filename)){
			include("inc/$page.php");
		}
		else{
			require_once('admin/translations/en.php');
			require_once("admin/classes/Login.php");
			$login = new Login();
			if(isset($_GET['preview'])){				
				if ($login->isUserLoggedIn() == true) {
					$result = mysqli_query($con,"SELECT Content FROM Pages WHERE Page='$page'");
				}
			}
			else{
			$result = mysqli_query($con,"SELECT Content FROM Pages WHERE Page='$page' AND publish=1") or die("Some error occurred during connection " . mysqli_error($con)); 
			}
			$row = mysqli_fetch_assoc($result);
			if ($row) { 
				echo $row['Content'];
			} 
			else { 
				include("inc/404.php"); 
			}
		}
		
		echo '</div>';
		
				
		if ($numrightrows > 0){
		echo '<div class="col-sm-3">';
		include('inc/rightbar.php');
		echo '</div>';
		}
		echo '</div>';
	}
}
else {
include("inc/slider.php");
//Include Header Section
include("inc/header.php");

echo '<div class="container">';
include("inc/main.php");
}

//Include Footer Section
include("inc/footer.php");

echo '</div>';


	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'colors'");
	$row = mysqli_fetch_assoc($result);
	$colorlist = explode(',',$row['option_value']);
	$colorarray = array();
	foreach($colorlist as $colors){
		$color = explode(':',$colors);
		array_push($colorarray, $color[1]);
	}
		
	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'fonts'");
	$row = mysqli_fetch_assoc($result);
	$fontlist = explode(',',$row['option_value']);
	$fontarray = array();
	foreach($fontlist as $fonts){
		$font = explode(':',$fonts);
		array_push($fontarray, $font[1]);
	}	
	
	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'fontsize'");
	$row = mysqli_fetch_assoc($result);
	$fontsize = $row['option_value'];

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'lineheight'");
	$row = mysqli_fetch_assoc($result);
	$lineheight = $row['option_value'];
	
	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key = 'classes'");
	$row = mysqli_fetch_assoc($result);
	$classcolorlist = explode(',',$row['option_value']);
	$classcolorarray = array();
	foreach($classcolorlist as $classcolors){
		$classcolor = explode(':',$classcolors);
		array_push($classcolorarray, $classcolor[1]);
	}
	

$inputFile = "css/styles.less";
$outputFile = "cache/theme.css";

$less = new lessc;

$less->setVariables(array(
	"bodybg" => $colorarray[0],
	"bodyfont" => $colorarray[1],
	"links" => $colorarray[2],
	"linkshover" => $colorarray[3],
	"border" => $colorarray[4],
	"navbg" => $colorarray[5],
	"navlink" => $colorarray[6],
	"navbghover" => $colorarray[7],
	"navbgactive" => $colorarray[8],
	"navlinkhover" => $colorarray[9],
	"navlinkactive" => $colorarray[10],
	"banner" => $colorarray[11],
	"bannerbg" => $colorarray[12],
	"buttonbg" => $colorarray[13],
	"buttonlink" => $colorarray[14],
	"buttonlinkhover" => $colorarray[15],
	"buttonbghover" => $colorarray[16],
	"buttonborderhover" => $colorarray[17],
	"boxbg" => $colorarray[18],
	"boxborder" => $colorarray[19],
	"boxfont" => $colorarray[20],
	"font-family-body" => $fontarray[0],
	"font-family-header" => $fontarray[1],
	"font-size-base" => $fontsize."px",
	"line-height-base" => $lineheight,
	"deathknight" => $classcolorarray[0],
	"druid" => $classcolorarray[1],
	"hunter" => $classcolorarray[2],
	"mage" => $classcolorarray[3],
	"monk" => $classcolorarray[4],
	"paladin" => $classcolorarray[5],
	"priest" => $classcolorarray[6],
	"rogue" => $classcolorarray[7],
	"shaman" => $classcolorarray[8],
	"warlock" => $classcolorarray[9],
	"warrior" => $classcolorarray[10]
));

try {
    $less->compileFile($inputFile,$outputFile);
} catch (Exception $ex) {
    echo "lessphp fatal error: ".$ex->getMessage();
}


//Include Footer Scripts
include("inc/foot.php");

?>

