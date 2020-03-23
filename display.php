<?php
    include_once "functions.class.php";
    include_once "CONSTANTS.php";
    Functions::html_header();
?>
<div style="height:100%">
    <?php echo Functions::isAnyoneBusy(); ?>
</div>

