<?php
if(!isset($_GET['id'])) {
    error_log('No cargo_request id specified.');

    return;
}

$cargo = DB_utils::selectRequest(intval($_GET['id']));
if(is_null($cargo)) {
    error_log('No cargo_request found for id='.$_GET['id']);

    return;
}

// Required for the fetching of notifications, dynamic updates
$_SESSION['entry-id'] = $_GET['id'];
$_SESSION['email-recipient'] = $cargo->getRecipient();

/*
 * $editable['originator']
 * $editable['recipient]
 */
$editable = DB_utils::isEditable($cargo->getOriginator(), $cargo->getRecipient());
if($cargo->getStatus() > 1) {
    $editable['originator'] = false;
}

$status_code = '';

switch($cargo->getStatus()) {
    case 1: {
        $status_code = '<span class="label label-lg label-info label-inline mr-2 font-weight-bolder">NEW</span>';
        break;
    }
    case 2: {
        $status_code = '<span class="label label-lg label-success label-inline mr-2 font-weight-bolder">ACCEPTED</span>';
        break;
    }
    case 3: {
        $status_code = '<span class="label label-lg label-warning label-inline mr-2">CLOSED</span>';
        break;
    }
    case 4: {
        $status_code = '<span class="label label-lg label-danger label-inline mr-2">CANCELLED</span>';
        break;
    }
    case 5: {
        $status_code = '<span class="label label-lg label-dark label-inline mr-2">EXPIRED</span>';
        break;
    }
    default: {

        break;
    }
}

if(DB_utils::countryMatch($cargo->getOriginator())) {
    $_SESSION['role'] = 'originator';
}
else {
    if(DB_utils::countryMatch($cargo->getRecipient())) {
        $_SESSION['role'] = 'recipient';
    }
    else {
        $_SESSION['role'] = 'outsider';
    }
}

$originator = DB_utils::selectUserById($cargo->getOriginator());
$recipient = DB_utils::selectUserById($cargo->getRecipient());

$audit = Audit::readCargo($cargo->getId(), $_SESSION['role']);
$class_text_new = 'text-primary';
$class_text_default = '';

?>
<input type="hidden" id="kt_operator" value="<?=$_SESSION['operator']['name']?>" />
<input type="hidden" id="kt_today" value="<?=date(Utils::$PHP_DATE_FORMAT)?>" />

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
                                    <td class="text-right">Cargo originator</td>
                                    <td>
                                        <p style="display: inline"><?=$originator->getUsername()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Origin city</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="from_city" class="editable-text '.($audit->getFromCity()?$class_text_new:$class_text_default).'">'.$cargo->getFromCity().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="from_city" class="'.($audit->getFromCity()?$class_text_new:$class_text_default).'">'.$cargo->getFromCity().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Origin address</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="from_address" class="editable-text '.($audit->getFromAddress()?$class_text_new:$class_text_default).'">'.$cargo->getFromAddress().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="from_address" class="'.($audit->getFromAddress()?$class_text_new:$class_text_default).'">'.$cargo->getFromAddress().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Status</td>
                                    <td id="kt_cargo_status_code">
                                        <?=$status_code?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Accepted by</td>
                                    <td id="kt_cargo_accepted_by">
                                        <p style="display: inline" id="recipient" class="<?=($audit->getAcceptedBy()?$class_text_new:$class_text_default)?>"><?=empty($cargo->getAcceptedBy())?'N/A':$cargo->getAcceptedBy()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Client</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="client" class="editable-text '.($audit->getClient()?$class_text_new:$class_text_default).'">'.$cargo->getClient().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="client" class="'.($audit->getClient()?$class_text_new:$class_text_default).'">'.$cargo->getClient().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Loading date</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="loading_date" class="editable-date '.($audit->getLoadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()).'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="loading_date" class="'.($audit->getLoadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $cargo->getLoadingDate()).'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Delivery instructions</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="instructions" class="editable-select-1 '.($audit->getInstructions()?$class_text_new:$class_text_default).'">'.$cargo->getInstructions().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="instructions" class="'.($audit->getInstructions()?$class_text_new:$class_text_default).'">'.$cargo->getInstructions().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Gross weight</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="weight" class="editable-text '.($audit->getWeight()?$class_text_new:$class_text_default).'">'.$cargo->getWeight().'</b> kg';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="weight" class="'.($audit->getWeight()?$class_text_new:$class_text_default).'">'.$cargo->getWeight().' kg</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Loading meters</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="loading_meters" class="editable-text '.($audit->getLoadingMeters()?$class_text_new:$class_text_default).'">'.number_format($cargo->getLoadingMeters(), 2).'</b> m';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="loading_meters" class="'.($audit->getLoadingMeters()?$class_text_new:$class_text_default).'">'.number_format($cargo->getLoadingMeters(), 2).' m</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">License plate</td>
                                    <td>
                                        <?php
                                        if($editable['recipient']) {
                                            if($cargo->getStatus() == 0) {
                                                echo '<b style="display: inline" id="plate_number" class="editable-acknowledge-text text-danger" /b>';
                                            }
                                            else {
                                                if($cargo->getStatus() == 1) {
                                                    echo '<b style="display: inline" id="plate_number" class="editable-text '.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">' . $cargo->getPlateNumber() . '</b>';
                                                }
                                                else {
                                                    echo '<p style="display: inline" id="plate_number" class="'.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">'.$cargo->getPlateNumber().'</p>';
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
                                    <td class="text-right">Cargo recipient</td>
                                    <td>
                                        <p style="display: inline"><?=$recipient->getUsername()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Destination city</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="to_city" class="editable-text '.($audit->getToCity()?$class_text_new:$class_text_default).'">'.$cargo->getToCity().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="to_city" class="'.($audit->getToCity()?$class_text_new:$class_text_default).'">'.$cargo->getToCity().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Destination address</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="to_address" class="editable-text '.($audit->getToAddress()?$class_text_new:$class_text_default).'">'.$cargo->getToAddress().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="to_address" class="'.($audit->getToAddress()?$class_text_new:$class_text_default).'">'.$cargo->getToAddress().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Order type</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="order_type" class="editable-select-2 '.($audit->getOrderType()?$class_text_new:$class_text_default).'">'.$cargo->getOrderType().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="order_type" class="'.($audit->getOrderType()?$class_text_new:$class_text_default).'">'.$cargo->getOrderType().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Accepted at</td>
                                    <td id="kt_cargo_accepted_at">
                                        <p style="display: inline" id="recipient" class="<?=$audit->getAcceptance()?$class_text_new:$class_text_default?>"><?=($cargo->getAcceptance()>0)?date(Utils::$PHP_DATE_FORMAT, $cargo->getAcceptance()):'N/A'?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Description</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="description" class="editable-text '.($audit->getDescription()?$class_text_new:$class_text_default).'">'.$cargo->getDescription().'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="description" class="'.($audit->getDescription()?$class_text_new:$class_text_default).'">'.$cargo->getDescription().'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Unloading date</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            // TODO: See if you can add validators for date format here (add a form, add the JS to validate the fields)
                                            echo '<b style="display: inline" id="loading_date" class="editable-date '.($audit->getUnloadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $cargo->getUnloadingDate()).'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="unloading_date" class="'.($audit->getUnloadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $cargo->getUnloadingDate()).'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">ADR</td>
                                    <td>
                                        <?php
                                        $_adr = 'N/A';
                                        if(!empty($cargo->getAdr())) {
                                            $_adr = $cargo->getAdr();
                                        }

                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="adr" class="editable-text '.($audit->getAdr()?$class_text_new:$class_text_default).'">'.$_adr.'</b>';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="adr" class="'.($audit->getAdr()?$class_text_new:$class_text_default).'">'.$_adr.'</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Volume</td>
                                    <td>
                                        <?php
                                        if($editable['originator']) {
                                            echo '<b style="display: inline" id="volume" class="editable-text '.($audit->getVolume()?$class_text_new:$class_text_default).'">'.$cargo->getVolume().'</b> mc';
                                        }
                                        else {
                                            echo '<p style="display: inline" id="volume" class="'.($audit->getVolume()?$class_text_new:$class_text_default).'">'.$cargo->getVolume().' mc</p>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Freight</td>
                                    <td>
                                        <p style="display: inline" id="freight" class="<?=$audit->getFreight()?$class_text_new:$class_text_default?>"><?=$cargo->getFreight()?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right">Ameta</td>
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
                                                        echo '<b style="display: inline" id="ameta" class="editable-text '.($audit->getAmeta()?$class_text_new:$class_text_default).'">' . $cargo->getAmeta() . '</b>';
                                                    }
                                                }
                                                else {
                                                    echo '<p style="display: inline" id="ameta" class="'.($audit->getAmeta()?$class_text_new:$class_text_default).'">'.$cargo->getAmeta().'</p>';
                                                }
                                            }
                                        }
                                        else {
                                            echo '<p style="display: inline" id="ameta" class="'.($audit->getAmeta()?$class_text_new:$class_text_default).'">'.$cargo->getAmeta().'</p>';
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
