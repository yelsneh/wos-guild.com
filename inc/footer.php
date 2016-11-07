<?php

	$result = mysqli_query($con,"SELECT * FROM Options WHERE option_key LIKE 'footer'");
	$row = mysqli_fetch_assoc($result);
	$footer = $row['option_value'];
?>
    <a href="#" class="scrollToTop"></a>
     <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo $footer;?></p>
      </footer>