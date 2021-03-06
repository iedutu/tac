<?php
if(empty($_GET['id'])) {
    AppLogger::getLogger()->error('No cargo_truck id specified.');

    return;
}

try {
    DB_utils::clearNotifications($_SESSION['operator']['id'], AppStatuses::$NOTIFICATION_ENTITY_KIND_TRUCK, $_GET['id']);
} catch (ApplicationException $e) {
    Utils::handleApplicationException($e);
}

if(empty($truck = DB_utils::selectTruck(intval($_GET['id'])))) {
    Utils::updateNotifications();
    AppLogger::getLogger()->info('Unknown truck', ['id' => $_GET['id']]);

    return;
}

// Clear notifications
if(!empty($_GET['source'])) {
    if($_GET['source'] == 'notifications') {
        try {
            DB_utils::clearNotifications($_SESSION['operator']['id'], 2, $truck->getId());
            DB_utils::clearNotifications($_SESSION['operator']['id'], 3, $truck->getId());
        } catch (ApplicationException $e) {
            AppLogger::getLogger()->error($e->getMessage());
            AppLogger::getLogger()->error($e->getTraceAsString());
        }
    }
}

unset($_SESSION['current_truck']);

// Required for the fetching of notifications, dynamic updates
$_SESSION['entry-id'] = $_GET['id'];
$_SESSION['entry-kind'] = AppStatuses::$APP_TRUCK;
$_SESSION['originator-id'] = $truck->getOriginator();
$_SESSION['recipient-id'] = $truck->getRecipient();

/*
 * $editable['originator']
 * $editable['recipient]
 */
$editable = DB_utils::isEditable($truck->getOriginator(), $truck->getRecipient());

if($truck->getStatus() > AppStatuses::$TRUCK_MARKET) {
    $editable['originator'] = false;
}

if($truck->getStatus() > AppStatuses::$TRUCK_PARTIALLY_SOLVED) {
    $editable['recipient'] = false;
}

$status_code = '';

switch($truck->getStatus()) {
    case AppStatuses::$TRUCK_AVAILABLE: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Round-trip booked truck"';
        $status_code = '<span class="label label-lg label-secondary label-inline mr-2 font-weight-bolder" '.$tooltip.'>Available truck</span>';
        break;
    }
    case AppStatuses::$TRUCK_FREE: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="One-way booked truck"';
        $status_code = '<span class="label label-lg label-info label-inline mr-2 font-weight-bolder" '.$tooltip.'>Free truck</span>';
        break;
    }
    case AppStatuses::$TRUCK_MARKET: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Truck available on the market"';
        $status_code = '<span class="label label-lg label-dark label-inline mr-2 font-weight-bolder" '.$tooltip.'>Free on market</span>';
        break;
    }
    case AppStatuses::$TRUCK_PARTIALLY_SOLVED: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Partially loaded truck"';
        $status_code = '<span class="label label-lg label-warning label-inline mr-2 font-weight-bolder" '.$tooltip.'>Partially solved</span>';
        break;
    }
    case AppStatuses::$TRUCK_FULLY_SOLVED: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Fully loaded truck"';
        $status_code = '<span class="label label-lg label-success label-inline mr-2" '.$tooltip.'>Solved</span>';
        break;
    }
    case AppStatuses::$TRUCK_CANCELLED: {
        $tooltip = 'data-toggle="tooltip" data-placement="top" title="Cancelled truck"';
        $status_code = '<span class="label label-lg label-light label-inline mr-2" '.$tooltip.'>Cancelled</span>';
        break;
    }
    default: {

        break;
    }
}

if(DB_utils::countryMatch($truck->getOriginator())) {
    $_SESSION['role'] = 'originator';
}
else {
    if(DB_utils::countryMatch($truck->getRecipient())) {
        $_SESSION['role'] = 'recipient';
    }
    else {
        $_SESSION['role'] = 'outsider';
    }
}

$originator = DB_utils::selectUserById($truck->getOriginator());
$recipient = DB_utils::selectUserById($truck->getRecipient());
$statusChangedBy = DB_utils::selectUserById($truck->getStatusChangedBy());

// Read the changes which happened so far
$audit = Audit::readTruck($truck->getId());
// Clean-up the changes
Audit::clearTruck($truck->getId());

$class_text_new = 'text-primary';
$class_text_default = '';

if($editable['originator']) {
    $_SESSION['originator'] = true;
}
else {
    unset($_SESSION['originator']);
}
?>

<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Truck details
                        <?php
                        if($editable['originator'] || $editable['recipient']) {
                            echo '<span class="d-block text-muted pt-2 font-size-sm">If you need to change an item, simply click on its value and press ENTER after changing it.</span></h3>';
                        }
                        else {
                            echo '<span class="d-block text-muted pt-2 font-size-sm">This entry can no longer be modified, as it is either ACCEPTED by the recipient or marked as loaded.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></h3>';
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
                <div class="row">
                    <div class="col-lg-4">
                        <table class="table table-borderless" id="kt_truck_details">
                            <tbody>
                            <tr>
                                <td class="text-right">Truck originator</td>
                                <td>
                                    <p style="display: inline"><?=$originator->getUsername()?></p>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Truck recipient</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="recipient_id" class="editable-select-3 '.($audit->getRecipient()?$class_text_new:$class_text_default).'">'.$recipient->getUsername().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="recipient_id" class="'.($audit->getRecipient()?$class_text_new:$class_text_default).'">'.$recipient->getUsername().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Origin city</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="from_city" class="editable-text '.($audit->getFromCity()?$class_text_new:$class_text_default).'">'.$truck->getFromCity().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="from_city" class="'.($audit->getFromCity()?$class_text_new:$class_text_default).'">'.$truck->getFromCity().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Loading date</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="loading_date" class="editable-date '.($audit->getLoadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()).'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="loading_date" class="'.($audit->getLoadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $truck->getLoadingDate()).'</p>';
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
                                        echo '<b style="display: inline" id="unloading_date" class="editable-date '.($audit->getUnloadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $truck->getUnloadingDate()).'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="unloading_date" class="'.($audit->getUnloadingDate()?$class_text_new:$class_text_default).'">'.date(Utils::$PHP_DATE_FORMAT, $truck->getUnloadingDate()).'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Unloading zone</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="unloading_zone" class="editable-text '.($audit->getUnloadingZone()?$class_text_new:$class_text_default).'">'.$truck->getUnloadingZone().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="unloading_zone" class="'.($audit->getUnloadingZone()?$class_text_new:$class_text_default).'">'.(empty($truck->getUnloadingZone())?"N/A":$truck->getUnloadingZone()).'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Status</td>
                                <td id="kt_truck_status_code">
                                    <?=$status_code?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Status last updated by</td>
                                <td>
                                    <?=empty($statusChangedBy)?'N/A':$statusChangedBy->getName()?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">License plate</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="plate_number" class="editable-text '.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">'.$truck->getPlateNumber().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="plate_number" class="'.($audit->getPlateNumber()?$class_text_new:$class_text_default).'">'.$truck->getPlateNumber().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Ameta</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="ameta" class="editable-text '.($audit->getAmeta()?$class_text_new:$class_text_default).'">'.$truck->getAmeta().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="ameta" class="'.($audit->getAmeta()?$class_text_new:$class_text_default).'">'.$truck->getAmeta().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Contract type</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="contract_type" class="editable-select '.($audit->getContractType()?$class_text_new:$class_text_default).'">'.$truck->getContractType().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="contract_type" class="'.($audit->getContractType()?$class_text_new:$class_text_default).'">'.$truck->getContractType().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">ADR</td>
                                <td>
                                    <?php
                                    $_adr = 'N/A';
                                    if(!empty($truck->getAdr())) {
                                        $_adr = $truck->getAdr();
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
                                <td class="text-right">Freight</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="freight" class="editable-text '.($audit->getFreight()?$class_text_new:$class_text_default).'">'.$truck->getFreight().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="freight" class="'.($audit->getFreight()?$class_text_new:$class_text_default).'">'.$truck->getFreight().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Driver details</td>
                                <td>
                                    <?php
                                    if($editable['originator']) {
                                        echo '<b style="display: inline" id="details" class="editable-text '.($audit->getDetails()?$class_text_new:$class_text_default).'">'.$truck->getDetails().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="details" class="'.($audit->getDetails()?$class_text_new:$class_text_default).'">'.$truck->getDetails().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Client</td>
                                <td>
                                    <?php
                                    if($editable['originator'] || $editable['recipient']) {
                                        echo '<b style="display: inline" id="client" class="editable-text '.($audit->getClient()?$class_text_new:$class_text_default).'">'.$truck->getClient().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="client" class="'.($audit->getClient()?$class_text_new:$class_text_default).'">'.$truck->getClient().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Retour loading from</td>
                                <td>
                                    <?php
                                    if($editable['originator'] || $editable['recipient']) {
                                        echo '<b style="display: inline" id="retour_loading_from" class="editable-text '.($audit->getRetourLoadingFrom()?$class_text_new:$class_text_default).'">'.$truck->getRetourLoadingFrom().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="retour_loading_from" class="'.($audit->getRetourLoadingFrom()?$class_text_new:$class_text_default).'">'.$truck->getRetourLoadingFrom().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Retour loading date</td>
                                <td>
                                    <?php
                                    if($editable['originator'] || $editable['recipient']) {
                                        echo '<b style="display: inline" id="retour_loading_date" class="editable-date '.($audit->getRetourLoadingDate()?$class_text_new:$class_text_default).'">'.(empty($truck->getRetourLoadingDate())?null:date(Utils::$PHP_DATE_FORMAT, $truck->getRetourLoadingDate())).'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="retour_loading_date" class="'.($audit->getRetourLoadingDate()?$class_text_new:$class_text_default).'">'.empty($truck->getRetourLoadingDate())?"N/A":date(Utils::$PHP_DATE_FORMAT, $truck->getRetourLoadingDate()).'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Retour un-loading from</td>
                                <td>
                                    <?php
                                    if($editable['originator'] || $editable['recipient']) {
                                        echo '<b style="display: inline" id="retour_unloading_from" class="editable-text '.($audit->getRetourUnloadingFrom()?$class_text_new:$class_text_default).'">'.$truck->getRetourUnloadingFrom().'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="retour_unloading_from" class="'.($audit->getRetourUnloadingFrom()?$class_text_new:$class_text_default).'">'.$truck->getRetourUnloadingFrom().'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">Retour un-loading date</td>
                                <td>
                                    <?php
                                    if($editable['originator'] || $editable['recipient']) {
                                        echo '<b style="display: inline" id="retour_unloading_date" class="editable-date '.($audit->getRetourUnloadingDate()?$class_text_new:$class_text_default).'">'.(empty($truck->getRetourUnloadingDate())?null:date(Utils::$PHP_DATE_FORMAT, $truck->getRetourUnloadingDate())).'</b>';
                                    }
                                    else {
                                        echo '<p style="display: inline" id="retour_unloading_date" class="'.($audit->getRetourUnloadingDate()?$class_text_new:$class_text_default).'">'.empty($truck->getRetourUnloadingDate())?"N/A":date(Utils::$PHP_DATE_FORMAT, $truck->getRetourUnloadingDate()).'</p>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-8">
                        <?php
                        if($editable['originator']) {
                            ?>
                            <!--begin: Selected Rows Group Action Form-->
                            <div class="mt-10 mb-5 collapse" id="kt_datatable_group_action_form">
                                <div class="d-flex align-items-center">
                                    <div class="font-weight-bold text-danger mr-3">Selected
                                        <span id="kt_datatable_selected_records">0</span> records:</div>
                                    <button class="btn btn-sm btn-danger mr-2" type="button" id="kt_datatable_delete_btn">Delete</button>
                                </div>
                            </div>
                            <!--end: Selected Rows Group Action Form-->
                            <!--begin: Datatable-->
                            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_cargo_truck_stops"></div>
                            <!--end: Datatable-->
                            <br><br>
                            <!--begin: Additional stop-->
                            <div class="row">
                                <form class="form" id="kt_rohel_truck_stop_form" action="/api/insertTruckStop.php" method="post">
                                    <input type="hidden" name="_submitted" value="true" />
                                    <input type="hidden" name="recipient" value="<?=$recipient->getUsername()?>" />
                                    <input type="hidden" name="originator" value="<?=$originator->getUsername()?>" />
                                    <div id="kt_new_stop">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="stop_id" name="stop_id" value ="<?=sizeof($truck->getStop())+1?>" placeholder="Stop #"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="city" name="city" placeholder="City name"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="cmr" name="cmr" placeholder="CMRs"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="loading_meters" name="loading_meters" placeholder="LDM"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="volume" name="volume" placeholder="Volume"/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-4">
                                                <button type="submit" class="btn btn-primary mr-2" id="kt_new_stop_submit_btn">Add new stop</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end: Additional stop-->
                            <?php
                        }
                        else {
                            ?>
                            <!--begin: Datatable-->
                            <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_cargo_truck_stops_read_only"></div>
                            <!--end: Datatable-->
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
            if($editable['originator']) {
                ?>
                <div class="card-footer d-print-none">
                    <div class="row">
                        <div class="col-lg-8">
                            <form class="form" id="kt_rohel_cancel_form" action="/api/cancelTruck.php" method="post">
                                <input type="hidden" name="_submitted" value="true">
                                <input type="hidden" name="id" value="<?=$truck->getId()?>">
                                <div>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <button type="submit" class="btn btn-primary btn-danger btn-lg" data-toggle="tooltip" title="Click to cancel!">Remove/Cancel truck</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
            else {
                if($editable['recipient']) {
                    echo '
            <div class="card-footer d-print-none">
                <div class="col-lg-8">
                    <div class="row">
                                            ';
                    if($truck->getStatus() < 4) {
                        echo '
                            <form class="form" id="kt_rohel_solved_form" action="/api/partiallySolveTruck.php" method="post">
                                                    <input type="hidden" name="_submitted" value="true">
                                                    <input type="hidden" name="id" value="'.$truck->getId().'">
                                                    <button type="submit" class="btn btn-success btn-lg" data-toggle="tooltip" title="Click to confirm the truck was partially loaded">Partial load</button>
                                                </form>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    ';
                    }
                    if($truck->getStatus() < 5) {
                        echo '
                            <form class="form" id="kt_rohel_solved_form" action="/api/solveTruck.php" method="post">
                                                    <input type="hidden" name="_submitted" value="true">
                                                    <input type="hidden" name="id" value="' . $truck->getId() . '">
                                                    <button type="submit" class="btn btn-primary btn-lg" data-toggle="tooltip" title="Click to confirm the truck was fully loaded">Full load</button>
                                                </form>
                                ';
                    }
                    echo '
                    </div>
                </div>
            </div>
                                ';
                }
            }
            ?>
            <!--end::Card-->
        </div>
    </div>
</div>

<?php Utils::updateNotifications() ?>