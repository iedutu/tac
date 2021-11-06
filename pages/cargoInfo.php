<?php
if(!isset($_GET['id'])) {
    Utils::log('No cargo_request id specified.');

    return;
}

$cargo = DB_utils::selectRequest(intval($_GET['id']));
if(is_null($cargo)) {
    Utils::log('No cargo_request found for id='.$_GET['id']);

    return;
}

// Required for the fetching of notifications, dynamic updates
$_SESSION['entry-id'] = $_GET['id'];
$_SESSION['entry-kind'] = 1;
$_SESSION['originator-id'] = $cargo->getOriginator();
$_SESSION['recipient-id'] = $cargo->getRecipient();

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
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="New cargo"';
        $status_code = '<span class="label label-lg label-danger label-inline mr-2 font-weight-bolder" '.$tooltip.'>New</span>';
        break;
    }
    case 2: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Accepted cargo"';
        $status_code = '<span class="label label-lg label-success label-inline mr-2 font-weight-bolder" '.$tooltip.'>Accepted</span>';
        break;
    }
    case 3: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Closed cargo"';
        $status_code = '<span class="label label-lg label-success label-inline mr-2" '.$tooltip.'>Closed</span>';
        break;
    }
    case 4: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Cancelled cargo"';
        $status_code = '<span class="label label-lg label-light label-inline mr-2" '.$tooltip.'>Cancelled</span>';
        break;
    }
    case 5: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Expired cargo"';
        $status_code = '<span class="label label-lg label-light label-inline mr-2" '.$tooltip.'>Expired</span>';
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
if(empty($cargo->getAcceptedBy())) {
    $acceptor = null;
}
else {
    $acceptor = DB_utils::selectUserById($cargo->getAcceptedBy());
}

// Read the changes which happened so far
$audit = Audit::readCargo($cargo->getId(), $_SESSION['role']);
// Clean-up the changes
Audit::clearCargo($cargo->getId(), $_SESSION['role']);

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
                        <h3 class="card-label">Order details
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
                    <div class="card-toolbar d-print-none">
                        <!--begin::Button-->
                        <button type="button" class="btn btn-light-primary font-weight-bolder" aria-expanded="false" onclick="window.print()">
												<span class="svg-icon svg-icon-md">
													<!--begin::Svg Icon | path:assets/media/svg/icons/Design/PenAndRuller.svg-->
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
															<rect x="0" y="0" width="24" height="24" />
															<path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
															<path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
														</g>
													</svg>
                                                    <!--end::Svg Icon-->
												</span>Print</button>
                        <!--end::Button-->
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
                                            <p style="display: inline" id="recipient" class="<?=($audit->getAcceptedBy()?$class_text_new:$class_text_default)?>"><?=empty($cargo->getAcceptedBy())?'N/A':$acceptor->getName()?></p>
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
                                        <td class="text-right">Dimensions</td>
                                        <td>
                                            <?php
                                            if($editable['originator']) {
                                                echo '<b style="display: inline" id="dimensions" class="editable-text '.($audit->getDimensions()?$class_text_new:$class_text_default).'">'.$cargo->getDimensions().'</b>';
                                            }
                                            else {
                                                echo '<p style="display: inline" id="dimensions" class="'.($audit->getDimensions()?$class_text_new:$class_text_default).'">'.$cargo->getDimensions().'</p>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Package</td>
                                        <td>
                                            <?php
                                            if($editable['originator']) {
                                                echo '<b style="display: inline" id="package" class="editable-text '.($audit->getPackage()?$class_text_new:$class_text_default).'">'.$cargo->getPackage().'</b>';
                                            }
                                            else {
                                                echo '<p style="display: inline" id="package" class="'.($audit->getPackage()?$class_text_new:$class_text_default).'">'.$cargo->getPackage().'</p>';
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
                                            <?php
                                            if($editable['originator']) {
                                                echo '<b style="display: inline" id="recipient_id" name="recipient_id" class="editable-select-3 '.($audit->getRecipient()?$class_text_new:$class_text_default).'">'.$recipient->getUsername().'</b>';
                                            }
                                            else {
                                                echo '<p style="display: inline" class="'.($audit->getRecipient()?$class_text_new:$class_text_default).'">'.$recipient->getUsername().'</p>';
                                            }
                                            ?>
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
                                                echo '<b style="display: inline" id="volume" class="editable-text '.($audit->getVolume()?$class_text_new:$class_text_default).'">'.$cargo->getVolume().'</b> m&sup3';
                                            }
                                            else {
                                                echo '<p style="display: inline" id="volume" class="'.($audit->getVolume()?$class_text_new:$class_text_default).'">'.$cargo->getVolume().' m&sup3</p>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Freight</td>
                                        <td>
                                            <?php
                                            if($editable['originator']) {
                                                echo '&euro; <b style="display: inline" id="freight" class="editable-text '.($audit->getFreight()?$class_text_new:$class_text_default).'">'.number_format($cargo->getFreight(), 2).'</b>';
                                            }
                                            else {
                                                echo '&euro; <p style="display: inline" id="freight" class="'.($audit->getFreight()?$class_text_new:$class_text_default).'">'.number_format($cargo->getFreight(), 2).'</p>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">License plate</td>
                                        <td>
                                            <?php
                                            if($editable['recipient']) {
                                                if($cargo->getStatus() == 1) {
                                                    echo '<b style="display: inline" id="plate_number" class="editable-acknowledge-text text-danger"></b>';
                                                }
                                                else {
                                                    if($cargo->getStatus() == 2) {
                                                        echo '<b style="display: inline" id="plate_number" class="editable-text '.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">' . $cargo->getPlateNumber() . '</b>';
                                                    }
                                                    else {
                                                        echo '<p style="display: inline" id="plate_number" class="'.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">'.$cargo->getPlateNumber().'</p>';
                                                    }
                                                }
                                            }
                                            else {
                                                if($cargo->getOriginator() == $_SESSION['operator']['id']) {
                                                    echo '<p style="display: inline" id="plate_number" class="'.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">'.$cargo->getPlateNumber().'</p>';
                                                }
                                                else {
                                                    echo '<p style="display: inline" id="plate_number">' . $cargo->getPlateNumber() . '</p>';
                                                }
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">Ameta</td>
                                        <td>
                                            <?php
                                            if($editable['recipient']) {
                                                if($cargo->getStatus() == 1) {
                                                    if(empty($cargo->getAmeta())) {
                                                        echo '<b style="display: inline" id="ameta" class="editable-text text-danger"/>';
                                                    }
                                                    else {
                                                        echo '<b style="display: inline" id="ameta" class="editable-text text-danger">' . $cargo->getAmeta() . '</b>';
                                                    }
                                                }
                                                else {
                                                    if($cargo->getStatus() == 2) {
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
                <?php
                if($editable['originator']) {
                    ?>
                    <div class="card-footer d-print-none">
                        <form class="form" id="kt_rohel_cancel_form" action="/api/cancelCargo.php" method="post">
                            <input type="hidden" name="_submitted" value="true">
                            <input type="hidden" name="id" value="<?=$cargo->getId()?>">
                            <div class="row">
                                <div class="col-lg-8">
                                    <?php
                                    // NEW cargo only can be cancelled
                                    if($cargo->getStatus() == 1) {
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
                    </div>
                    <?php
                }
                else {
                    if($editable['recipient']) {
                        ?>
                        <div class="card-footer d-print-none">
                            <form class="form" id="kt_rohel_accept_form" action="/api/acknowledgeCargo.php" method="post">
                                <input type="hidden" name="_submitted" value="true">
                                <input type="hidden" name="id" value="<?=$cargo->getId()?>">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <?php
                                        // NEW cargo only can be cancelled
                                        if($cargo->getStatus() == 1) {
                                            echo '<button type="submit" class="btn btn-primary btn-lg" data-toggle="tooltip" title="Click to acknowledge the request!">Acknowledge request</button>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <!--end::Card-->
        </div>
        <div class="col-lg-4">
            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Notes
                            <span class="d-block text-muted pt-2 font-size-sm d-print-none">Please add below if needed.</span></h3>
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_notes"></div>
                    <!--end: Datatable-->

                    <!--begin: New note form-->
                    <form class="form" id="kt_rohel_cargo_note_form" action="/api/insertCargoNote.php" method="post">
                        <input type="hidden" name="_submitted" id="_submitted" value="yes"/>
                        <input type="hidden" name="page" id="page" value="<?=$_GET['page']?>"/>
                        <input type="hidden" name="id" id="id" value="<?=$_GET['id']?>"/>
                        <input type="hidden" name="recipient" id="recipient" value="<?=$cargo->getRecipient()?>"/>
                        <div class="card-body d-print-none">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <label for="note">Add your note below:</label>
                                    <input type="text" id="note" name="note" class="form-control" placeholder="Text details"/>
                                </div>
                                &nbsp;
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

<?php Utils::updateNotifications() ?>