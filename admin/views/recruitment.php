<h1 class="page-header">Recruitment</h1>
<div class="table-responsive">

<?php 

if(isset($_POST['submit'])){
		
	
	mysqli_query($con,"UPDATE Recruitment SET Open=0");
		

	foreach ($_POST as $key => $value){
		
		$fieldname = str_replace('_',' ',htmlspecialchars($key));
		
		$info = explode('-',$fieldname);
		$class = $info[0];
		$spec = $info[1];

		mysqli_query($con,"UPDATE Recruitment SET Open=1 WHERE Class='$class' AND Spec='$spec'");
		
	}
		echo '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">';
		echo '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Updated.</div>';
	
	}
?>
	<form method="post" action="" name="streamadd" class="form-horizontal form-settings" role="form">

	<table class="table table-hover">
	<thead><tr><th>Edit Recruitment</th></tr></thead>
<?php

	$recruiting = array();
	$result = mysqli_query($con,"SELECT * FROM Recruitment");
	while($row = mysqli_fetch_assoc($result)){
		
		$class = $row['Class'];
		$spec = $row['Spec'];
		$open = $row['Open'];
		
		$recruiting[$class][$spec] = $open;
		
	}
		
	foreach($recruiting as $key => $value){
		echo '<tr><td>';
		$class = $key;
		$classsnospace = str_replace(' ','_',$class);
		
		echo '<label class="col-sm-1 control-label">'.$class.'</label>';
		
		foreach($value as $spec => $open){
			$specnospace = str_replace(' ','_',$spec);	
		
			echo '<label class="checkbox-inline col-sm-1">';
			echo '<input type="checkbox" name="'.$classsnospace.'-'.$specnospace.'"';
			if($open==1){ echo 'checked';}
			echo ' /> '.$spec;
			echo '</label>';

		}
		
		echo '</td></tr>';
	}
		


?>
	<tfoot><tr><td><input type="submit" name="submit" value="Update" class="btn btn-md btn-primary"/></td></tr>
	
	</table>
	</form>



