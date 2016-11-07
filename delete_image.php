<?php
    // Get src.
    $src = $_POST["src"];

    // Check if file exists.
    if (file_exists(getcwd().$src)) {
      // Delete file.
      unlink(getcwd().$src);
    }
?>