<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="display-4">Help
                        <span class="d-block text-muted pt-2 font-size-sm">This page explains the functionality of this application.</span>
                    </h3>
                </div>
                <div class="card-toolbar d-print-none">
                    <!--begin::Button-->
                    <button type="button" class="btn btn-light-primary font-weight-bolder" aria-expanded="false" onclick="javascript:window.print()">
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
                <h3 class="display-5">Cargo Section</h3>
                <p>New orders will be inserted in this section as <strong>New Cargo</strong>. Please make sure to fill all the mandatory fields, otherwise the order cannot be submitted. All new orders will show in the <em>Matching</em> section as <strong>NEEDED</strong> trucks.</p>
                <p>After submitting a new order, the Originator can edit its data, including the Recipient’s name. The Recipient(s) will be notified by e-mail about all changes.
                    The new order data can be modified by anyone from the Originator’s office, including removing/cancellation. Changing an order is done on the order page, by simply clicking on the item in need to be modified (<strong>bold text</strong> values), changing it and pressing ENTER.
                    A removed/cancelled order will automatically disappear from the list. Recipient will be notified by e-mail about the cancellation.</p>
                <p>Further comments that must be made over the new order can be added in the Notes box on the right side of the screen. New messages will be highlighted by the app, one time.</p>
                <p>By accepting an order, the Recipient must assign both a truck (license plates) and an Ameta number. The order will receive the status ACCEPTED in this section and SOLVED in Matching section. The Originator will be notified by e-mail about the acceptance.
                    An order can be accepted by anyone from the Recipient’s office.</p>
                <p>The summary page will show all orders, new and accepted. The accepted orders will be seen in the list one more calendar day after the acceptance date.</p>
                <br /><br />
                <h3 class="display-5">Trucks Section</h3>
                <p>Export trucks will be inserted in this section as <strong>New Truck</strong>. Please make sure to fill all the fields, otherwise the entry cannot be submitted. All new trucks will show in the <em>Matching</em> section as <strong>AVAILABLE</strong> if booked round-trip, or <strong>FREE</strong> if booked one way.</p>
                <p>After submitting a new truck, the Originator can edit its data, including the Recipient’s name. Changing a truck is done on the truck details page, by simply clicking on the item in need to be modified (<strong>bold text</strong> values), changing it and pressing ENTER. The Recipient(s) will be notified by e-mail about all changes.
                    The new truck data can be modified by anyone from the Originator’s office, including removing/cancellation. A removed/cancelled truck will automatically disappear from the list. Recipient will be notified by e-mail about the cancellation.</p>
                <p>The new trucks will receive the status <strong>PARTIAL</strong>, if partially loaded or <strong>SOLVED</strong> if fully loaded. A partially loaded truck can receive later the status <strong>SOLVED</strong> if fully loaded. These statuses can be issued by anyone in the Recipient’s office.</p>
                <p>The summary page will show all trucks, New, Partial and Solved. The solved trucks will be seen in the list one more calendar day after the date being solved.</p>
                <br /><br />
                <h3 class="display-5">Matching section</h3>
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
            </div>
        </div>
        <!--end::Card-->
    </div>
</div>