<?php
    $dataHeight = 375;
    $dataMobileHeight = 300;

    switch($_SESSION['app']) {
        case 'cargo':
        {
            $title = 'Cargo';
            $subtitle = 'Cargo list';
            $dataHeight = 375;
            $dataMobileHeight = 300;
            $text = '
                        <p>The summary page will show all orders, new and accepted. The accepted orders will be seen in the list one more calendar day after the acceptance date.</p>
            ';
            break;
        }
        case 'newCargo':
        {
            $title = 'Cargo';
            $subtitle = 'New item creation';
            $dataHeight = 375;
            $dataMobileHeight = 300;
            $text = '
                        <p>New orders will be inserted in this section as <strong>New Cargo</strong>. Please make sure to fill all the mandatory fields, otherwise the order cannot be submitted. All new orders will show in the <em>Matching</em> section as <strong>NEEDED</strong> trucks.</p>
            ';
            break;
        }
        case 'cargoInfo':
        {
            $title = 'Cargo';
            $subtitle = 'Cargo details';
            $dataHeight = 375;
            $dataMobileHeight = 300;
            $text = '
                        <p>After submitting a new order, the Originator can edit its data, including the Recipient’s name. The Recipient(s) will be notified by e-mail about all changes.
                        The new order data can be modified by anyone from the Originator’s office, including removing/cancellation. Changing an order is done on the order page, by simply clicking on the item in need to be modified (<strong>bold text</strong> values), changing it and pressing ENTER.
                        A removed/cancelled order will automatically disappear from the list. Recipient will be notified by e-mail about the cancellation.</p>
                        <p>Further comments that must be made over the new order can be added in the Notes box on the right side of the screen. New messages will be highlighted by the app, one time.</p>
                        <p>By accepting an order, the Recipient must assign both a truck (license plates) and an Ameta number. The order will receive the status ACCEPTED in this section and SOLVED in Matching section. The Originator will be notified by e-mail about the acceptance.
                        An order can be accepted by anyone from the Recipient’s office.</p>
            ';
            break;
        }
        case 'truck':
        case 'newTruck':
        case 'truckInfo': {
            $title = 'Truck';
            $subtitle = 'Truck sub';
            $text = 'Truck text';

            break;
        }
        case 'matches': {
            $title = 'Matches';
            $subtitle = 'Matches sub';
            $text = 'Matches text';

            break;
        }
        default: {
            $title = 'Error';
            $subtitle = 'Error sub';
            $text = 'Error text';

            break;
        }
    }
?>
<!--begin::Chat Panel-->
<div class="offcanvas offcanvas-right pt-5 pb-10" id="kt_chat_modal" role="dialog" data-backdrop="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header align-items-center px-4 py-3">
                    <div class="text-left flex-grow-1">
                        &nbsp;
                    </div>
                    <div class="text-center flex-grow-1">
                        <div class="text-dark-75 font-weight-bold font-size-h5"><?=$title?></div>
                        <div>
                            <span class="font-weight-bold text-muted font-size-sm"><?=$subtitle?></span>
                        </div>
                    </div>
                    <div class="text-right flex-grow-1">
                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-dismiss="modal">
                            <i class="ki ki-close icon-1x"></i>
                        </button>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Body-->
                <div class="card-body">
                    <!--begin::Scroll-->
                    <div class="scroll scroll-pull" data-height="<?=$dataHeight?>" data-mobile-height="<?=$dataMobileHeight?>">
                        <?=$text?>
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Body-->

                <!--begin::Footer-->
                <div class="card-footer align-items-center">
                    <!--begin::Compose-->
                    <div class="text-success font-weight-bold font-size-h5">Help page</div>
                    <!--begin::Compose-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
<!--end::Chat Panel-->