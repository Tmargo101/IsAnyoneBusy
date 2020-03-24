<?php
    include_once "functions.class.php";
    include_once "CONSTANTS.php";
    Functions::html_header();
?>
<div class="w-100 p-3 h-100 d-inline-block">
    <?php echo Functions::isAnyoneBusy(); ?>
</div>

