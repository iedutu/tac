<?php
switch($_SESSION['app']) {
    case 'cargo':
    {
        $title = 'Cargo';
        $subtitle = 'Cargo list';
        $text = '
                        <p>The summary page will show all orders, new and accepted. The accepted orders will be seen in the list one more calendar day after the acceptance date.</p>
            ';
        break;
    }
    case 'newCargo':
    {
        $title = 'Cargo';
        $subtitle = 'New item creation';
        $text = '
                        <p>New orders will be inserted in this section as <strong>New Cargo</strong>. Please make sure to fill all the mandatory fields, otherwise the order cannot be submitted. All new orders will show in the <em>Matching</em> section as <strong>NEEDED</strong> trucks.</p>
            ';
        break;
    }
    case 'cargoInfo':
    {
        $title = 'Cargo';
        $subtitle = 'Cargo details';
        $text = '
                        <p>After submitting a new order, the Originator can edit its data, including the Recipient’s name. The Recipient(s) will be notified by e-mail about all changes.
                        The new order data can be modified by anyone from the Originator’s office, including removing/cancellation. Changing details is done by simply clicking on the item in need to be modified (<strong>bold text</strong> values), changing it and pressing ENTER.
                        A removed/cancelled order will automatically disappear from the list. Recipient will be notified by e-mail about the cancellation.</p>
                        <p>Further comments that must be made over the new order can be added in the Notes box on the right side of the screen. New messages will be highlighted by the app, one time.</p>
                        <p>By accepting an order, the Recipient must assign both a truck (license plates) and an Ameta number. The order will receive the status <strong>ACCEPTED</strong> in this section and <strong>SOLVED</strong> in <em>Matching</em> section. The Originator will be notified by e-mail about the acceptance.
                        An order can be accepted by anyone from the Recipient’s office.</p>
            ';
        break;
    }
    case 'trucks':
    {
        $title = 'Trucks';
        $subtitle = 'Truck list';
        $text = '
                <p>The summary page will show all trucks, New, Partial and Solved. The solved trucks will be seen in the list one more calendar day after the date being solved.</p>
        ';

        break;
    }
    case 'newTruck':
    {
        $title = 'Trucks';
        $subtitle = 'New item creation';
        $text = '
                <p>Export trucks will be inserted in this section as <strong>New Truck</strong>. Please make sure to fill all the fields, otherwise the entry cannot be submitted. All new trucks will show in the <em>Matching</em> section as <strong>AVAILABLE</strong> if booked round-trip, or <strong>FREE</strong> if booked one way.</p>
        ';

        break;
    }
    case 'truckInfo':
    {
        $title = 'Trucks';
        $subtitle = 'Truck details';
        $text = '
                <p>After submitting a new truck, the Originator can edit its data, including the Recipient’s name. Changing details is done by simply clicking on the item in need to be modified (<strong>bold text</strong> values), changing it and pressing ENTER. The Recipient(s) will be notified by e-mail about all changes.
                    The new truck data can be modified by anyone from the Originator’s office, including removing/cancellation. A removed/cancelled truck will automatically disappear from the list. Recipient will be notified by e-mail about the cancellation.</p>
                <p>The new trucks will receive the status <strong>PARTIAL</strong>, if partially loaded or <strong>SOLVED</strong> if fully loaded. A partially loaded truck can receive later the status <strong>SOLVED</strong> if fully loaded. These statuses can be issued by anyone in the Recipient’s office.</p>
        ';

        break;
    }
    case 'matches': {
        $title = 'Matches';
        $subtitle = 'Cargo & truck matching page';
        $text = '
                <p>In this section there is the list of trucks: requested trucks (equivalent with the new orders) and the stock of available/free trucks (trucks sent to the partner’s country). If a truck has more than one delivery and the originator has filled correctly all the delivery locations, the truck will appear in the list as many times as per the number of the deliveries.</p>
                <p><em>Example 1</em>: A truck is booked from Romania to Greece, round trip, two deliveries: in Salonic (7 ldm, 10 tons) and in Athens (6.5 ldm, 10 tons). In the <em>Matching</em> summary there will be two lines displayed for the same truck: one with status <strong>Available</strong> in Salonic (for 7 ldm) and one with status <strong>Available</strong> in Athens (for 6.5 ldm).</p>
                <p><em>Example 2</em>: A truck is booked from Greece to Romania, one way, two deliveries: in Bucharest (2 ldm, 2 tons) and in Bacau (11 ldm, 20 tons). In the <em>Matching</em> summary there will be two lines displayed for the same truck: one with status <strong>Free</strong> in Bucharest (for 2 ldm) and one with status <strong>Free</strong> in Bacau (for 11 ldm).</p>
                <ul class="list-unstyled">
                    <li>In this section there are two operations to be done:</li>
                    <ul>
                        <li>To assign trucks to new orders. By selecting <strong>NEEDED</strong> button, you will be directed to the new order page, where you can fill the truck and Ameta number. The New order will receive the status <strong>ACCEPTED</strong> in <em>Cargo</em> section and the <strong>NEEDED</strong> status will become <strong>SOLVED</strong> in <em>Matching</em> section.</li>
                        <li>To close all the available/free trucks in stock by loading them. By selecting <strong>FREE</strong> or <strong>AVAILABLE</strong> button, you will be directed to the new truck page, where you can select either Partial load or Full load buttons, depending on your plans. The status of the available/free trucks will change in both sections – <em>Trucks</em> and <em>Matching</em> – to <strong>Partial</strong>, meaning partially loaded or <strong>Closed</strong>, meaning fully loaded.</li>
                    </ul>
                </ul>
        ';

        break;
    }
    case 'reports': {
        $title = 'Data reports';
        $subtitle = 'Downloadable Excel reports';
        $text = '
                <p>Please select the dates you want for your report, then download the report. Please see your Downloads folder used by your browser for the file.</p>
        ';

        break;
    }
    default: {
        $title = 'No data';
        $subtitle = '';
        $text = 'No help available for this page.';

        break;
    }
}
?>

<!--begin::Quick Panel-->
<div id="kt_quick_panel" class="offcanvas offcanvas-right pt-5 pb-10">
    <!--begin::Header-->
    <div class="offcanvas-header offcanvas-header-navs d-flex align-items-center justify-content-between mb-5">
        <div class="text-success font-weight-bold font-size-h5 px-5">
            Help page
        </div>
        <div class="offcanvas-close mt-n1 pr-5">
            <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_panel_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="offcanvas-content px-10">
        <div class="tab-content">
            <div class="tab-pane fade show pt-3 pr-5 mr-n5 active" id="kt_quick_panel_logs" role="tabpanel">
                <div class="mb-15">
                    <h5 class="font-weight-bold mb-5"><?=$title?>
                        <span class="d-block text-muted pt-2 font-size-sm"><?=$subtitle?></span>
                    </h5>
                    <div>
                        <?=$text?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--end::Content-->
</div>

<!--end::Quick Panel-->