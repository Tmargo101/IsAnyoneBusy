<?php
    include_once "functions.class.php";
    include_once "CONSTANTS.php";

    Functions::html_header();

    if (isset($_POST['button'])){
        switch ($_POST['button']) {
            case "setToBusy":
                Functions::setToBusy($_POST['id']);
                break;
            case "setToFree":
                Functions::setToFree($_POST['id']);
                break;
            case "setToSleep":
                Functions::setToSleep($_POST['id']);
                break;
        }
    }
    ?>

<div class='Title'>
    <div class="container col-md-4 my-5 text-black">
        <?php $APPLICATION_NAME = APPLICATION_NAME; echo "<h1>{$APPLICATION_NAME}</h1>";?>
    </div>
</div>
<div class="container mb-5">
    <div class="row">
<?php echo Functions::isAnyoneBusy('small');?>
    </div>
</div>

<h1>Status Board</h1>

<?php Functions::buildTable();?>
<?php //echo Functions::reference();?>

<?php Functions::html_footer();?>

