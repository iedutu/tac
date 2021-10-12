<?php
$width = 12;
if(isset($_SESSION['alert']['width'])) {
    $width = $_SESSION['alert']['width'];
}
?>

<div class="col-lg-<?=$width?>">
    <?php
    if(isset($_SESSION['alert'])) {
        if($_SESSION['alert']['type'] == 'success') {
            echo '
    <div class="alert alert-custom alert-success" role="alert">
        <div class="alert-icon">
            <i class="flaticon-warning"></i>
        </div>
        <div class="alert-text">'.$_SESSION['alert']['message'].'</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
                ';
        }
        else {
            echo '
    <div class="alert alert-custom alert-danger" role="alert">
        <div class="alert-icon">
            <i class="flaticon-questions-circular-button"></i>
        </div>
        <div class="alert-text">'.$_SESSION['alert']['message'].'</div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
                ';
        }

        unset($_SESSION['alert']);
    }
    ?>
</div>
