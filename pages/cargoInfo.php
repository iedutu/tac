<?php
if(!isset($_GET['id'])) {
    error_log('No cargo_request id specified.');

    return;
}

$cargo = DB_utils::selectRequest(intval($_GET['id']));

// Required for the fetching of notifications, dynamic updates
$_SESSION['entry-id'] = $_GET['id'];
$_SESSION['email-recipient'] = $cargo->getRecipient();

if(is_null($cargo)) {
    error_log('No cargo_request found for id='.$_GET['id']);

    return;
}

/*
 * $editable['originator']
 * $editable['recipient]
 */
$editable = DB_utils::isEditable($cargo->getOriginator(), $cargo->getRecipient());
if($cargo->getStatus() > 0) {
    $editable['originator'] = false;
}

$status_code = '';

switch($cargo->getStatus()) {
    case 0: {
        $status_code = '<span class="label label-lg label-info label-inline mr-2 font-weight-bolder">NEW</span>';
        break;
    }
    case 1: {
        $status_code = '<span class="label label-lg label-success label-inline mr-2 font-weight-bolder">ACCEPTED</span>';
        break;
    }
    case 2: {
        $status_code = '<span class="label label-lg label-warning label-inline mr-2">CLOSED</span>';
        break;
    }
    case 3: {
        $status_code = '<span class="label label-lg label-danger label-inline mr-2">CANCELLED</span>';
        break;
    }
    case 4: {
        $status_code = '<span class="label label-lg label-dark label-inline mr-2">EXPIRED</span>';
        break;
    }
    default: {

        break;
    }
}
?>
<input type="hidden" id="kt_operator" value="<?=$_SESSION['operator']?>" />
<input type="hidden" id="kt_today" value="<?=date(Utils::$DATE_FORMAT)?>" />

<div class="row">
    <div class="col-lg-8">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Cargo request details
                        <?php
                        if($editable['originator']) {
                            echo '<span class="d-block text-muted pt-2 font-size-sm">If you need to change an item, simply click on its value and press ENTER after changing it.</span></h3>';
                        }
                        else {
                            if($editable['recipient']) {
                                echo '<span class="d-block text-muted pt-2 font-size-sm">Please fill in the license plate and ameta to acknowledge the request.</span></h3>';
                            }
                            else {
                                echo '<span class="d-block text-muted pt-2 font-size-sm">This entry cannot be modified.</span></h3>';
                            }
                        }
                        ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td>
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td align="right">Cargo originator</td>
                                    <td>
                                        <p style="display: inline"><?=$cargo->getOriginator()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Origin city</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="from_city" class="editable-text">'.$cargo->getFromCity().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="from_city">'.$cargo->getFromCity().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Origin address</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="from_address" class="editable-text">'.$cargo->getFromAddress().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="from_address">'.$cargo->getFromAddress().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Status</td>
                                    <td id="kt_cargo_status_code">
                                        <?=$status_code?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Accepted by</td>
                                    <td id="kt_cargo_accepted_by">
                                        <p style="display: inline" id="recipient"><?=empty($cargo->getAcceptedBy())?'N/A':$cargo->getAcceptedBy()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Client</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="client" class="editable-text">'.$cargo->getClient().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="client">'.$cargo->getClient().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Loading date</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="loading_date" class="editable-date">'.date(Utils::$DATE_FORMAT, $cargo->getLoadingDate()).'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="loading_date">'.date(Utils::$DATE_FORMAT, $cargo->getLoadingDate()).'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Delivery instructions</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="instructions" class="editable-select">'.$cargo->getInstructions().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="instructions">'.$cargo->getInstructions().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Gross weight</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="weight" class="editable-text">'.$cargo->getWeight().'</b> kg';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="weight">'.$cargo->getWeight().' kg</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Loading meters</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="loading_meters" class="editable-text">'.number_format($cargo->getLoadingMeters(), 2).'</b> m';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="loading_meters">'.number_format($cargo->getLoadingMeters(), 2).' m</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">License plate</td>
                                    <td>
                                        <?php
                                        if($editable['recipient']) {
                                            if($cargo->getStatus() == 0) {
                                                echo '<b style="display: inline" id="plate_number" class="editable-acknowledge-text text-danger" /b>';
                                            }
                                            else {
                                                if($cargo->getStatus() == 1) {
                                                    echo '<b style="display: inline" id="plate_number" class="editable-text">' . $cargo->getPlateNumber() . '</b>';
                                                }
                                                else {
                                                    echo '<p style="display: inline" id="plate_number">'.$cargo->getPlateNumber().'</p>';
                                                }
                                            }
                                        }
                                        else {
                                            echo '<p style="display: inline" id="plate_number">'.$cargo->getPlateNumber().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td align="right">Cargo recipient</td>
                                    <td>
                                        <p style="display: inline"><?=$cargo->getRecipient()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Destination city</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="to_city" class="editable-text">'.$cargo->getToCity().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="to_city">'.$cargo->getToCity().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Destination address</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="to_address" class="editable-text">'.$cargo->getToAddress().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="to_address">'.$cargo->getToAddress().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Order type</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="order_type" class="editable-select">'.$cargo->getOrderType().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="order_type">'.$cargo->getOrderType().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Accepted at</td>
                                    <td id="kt_cargo_accepted_at">
                                        <p style="display: inline" id="recipient"><?=($cargo->getAcceptance()>0)?date(Utils::$DATE_FORMAT, $cargo->getAcceptance()):'N/A'?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Description</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="description" class="editable-text">'.$cargo->getDescription().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="description">'.$cargo->getDescription().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Unloading date</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            // TODO: See if you can add validators for date format here (add a form, add the JS to validate the fields)
                                            echo '<b style="display: inline" id="loading_date" class="editable-date">'.date(Utils::$DATE_FORMAT, $cargo->getUnloadingDate()).'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="unloading_date">'.date(Utils::$DATE_FORMAT, $cargo->getUnloadingDate()).'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">ADR</td>
                                    <td>
                                        <?php
                                        $_adr = 'N/A';
                                        if(!empty($cargo->getAdr())) {
                                            $_adr = $cargo->getAdr();
                                        }

                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="adr" class="editable-text">'.$_adr.'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="adr">'.$_adr.'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Volume</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="volume" class="editable-text">'.$cargo->getVolume().'</b> mc';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="volume">'.$cargo->getVolume().' mc</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Freight</td>
                                    <td>
                                        <p style="display: inline" id="freight"><?=$cargo->getFreight()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">Ameta</td>
                                    <td>
                                        <?php
                                        if($editable['recipient']) {
                                            if($cargo->getStatus() == 0) {
                                                if(empty($cargo->getAmeta())) {
                                                    echo '<b style="display: inline" id="ameta" class="editable-text text-danger"/>';
                                                }
                                                else {
                                                    echo '<b style="display: inline" id="ameta" class="editable-text text-danger">' . $cargo->getAmeta() . '</b>';
                                                }
                                            }
                                            else {
                                                if($cargo->getStatus() == 1) {
                                                    if(empty($cargo->getAmeta())) {
                                                        echo '<b style="display: inline" id="ameta" class="editable-text" /b>';
                                                    }
                                                    else {
                                                        echo '<b style="display: inline" id="ameta" class="editable-text">' . $cargo->getAmeta() . '</b>';
                                                    }
                                                }
                                                else {
                                                    echo '<p style="display: inline" id="ameta">'.$cargo->getAmeta().'</p>';
                                                }
                                            }
                                        }
                                        else {
                                            echo '<p style="display: inline" id="ameta">'.$cargo->getAmeta().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <!--
            <div class="card-footer">
                <?php
                    if($editable['originator']) {
                ?>
                        <form class="form" id="kt_rohel_cancel_form" action="/api/cancelCargo.php" method="post">
                    <input type="hidden" name="_submitted" value="true">
                    <input type="hidden" name="id" value="<?=$cargo->getId()?>">
                    <div class="row">
                        <div class="col-lg-8">
                            <?php
                            // NEW cargo only can be cancelled
                            if($cargo->getStatus() == 0) {
                                echo '<button type="submit" class="btn btn-primary btn-danger btn-lg" data-toggle="tooltip" title="Click to cancel!">Remove/Cancel cargo</button>';
                            }
                            else {
                                echo '
                                            <span class="d-inline-block" data-toggle="tooltip" title="Only status NEW cargo can be cancelled.">
                                                <button type="submit" class="btn btn-primary btn-danger btn-lg" style="pointer-events: none;" disabled>Remove/Cancel cargo</button>
                                            </span>
                                                    ';
                            }
                            ?>
                        </div>
                    </div>
                </form>
                <?php
                    }
                    else {
                        if($editable['recipient']) {
                ?>
                        <form class="form" id="kt_rohel_accept_form" action="/api/acceptCargo.php" method="post">
                            <input type="hidden" name="_submitted" value="true">
                            <input type="hidden" name="id" value="<?=$cargo->getId()?>">
                            <div class="row">
                                <div class="col-lg-8">
                                    <?php
                                    // NEW cargo only can be cancelled
                                    if($cargo->getStatus() == 0) {
                                        echo '<button type="submit" class="btn btn-primary btn-lg" data-toggle="tooltip" title="Click to acknowledge the request!">Acknowledge request</button>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                <?php
                        }
                    }
                ?>
            </div>
            -->
        </div>
        <!--end::Card-->
    </div>
    <div class="col-lg-4">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Notes
                        <span class="d-block text-muted pt-2 font-size-sm">Please add below if needed.</span></h3>
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable"></div>
                <!--end: Datatable-->

                <!--begin: New note form-->
                <form class="form" id="kt_rohel_cargo_note_form" action="/api/insertCargoNote.php" method="post">
                    <input type="hidden" name="_submitted" id="_submitted" value="yes"/>
                    <input type="hidden" name="page" id="page" value="<?=$_GET['page']?>"/>
                    <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>"/>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text-area" id="note" name="note" class="form-control" placeholder="Text details"/>
                                <span class="form-text text-muted">Please add your note</span>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary mr-2" id="kt_new_cargo_note_submit_btn">Add note</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end: New note form-->
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>
