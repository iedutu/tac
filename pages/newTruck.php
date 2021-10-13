<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">New available truck details</h3>
            </div>
            <form class="form" id="kt_rohel_truck_form" action="/api/insertTruck.php" method="post">
                <input type="hidden" name="_submitted" id="_submitted" value="yes"/>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Truck recipient</label>
                            <select class="form-control" id="recipient" name="recipient">
                                <?php DB_utils::selectActiveUsers(); ?>
                            </select>
                            <span class="form-text text-muted">Please select your colleague</span>
                        </div>
                        <div class="col-lg-4">
                            <label>City of origin:</label>
                            <input type="text" id="from_city" name="from_city" class="form-control" placeholder="City name"/>
                            <span class="form-text text-muted">Please enter the truck origin</span>
                        </div>
                        <div class="col-lg-4">
                            <label>Address of origin:</label>
                            <input type="text" id="to_city" name="from_address" class="form-control" placeholder="Street address"/>
                            <span class="form-text text-muted">Leave empty if not applicable</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Cargo type:</label>
                            <select class="form-control" id="cargo_type" name="cargo_type">
                                <option value="FTL">FTL</option>
                                <option value="LTL">LTL</option>
                                <option value="Groupage">Groupage</option>
                            </select>
                            <span class="form-text text-muted">Please select the cargo loading details</span>
                        </div>
                        <div class="col-lg-4">
                            <label>Contract type:</label>
                            <select class="form-control" id="contract_type" name="contract_type">
                                <option value="Round-trip">Round-trip</option>
                                <option value="One-way">One-way</option>
                            </select>
                            <span class="form-text text-muted">Please select the type of the order</span>
                        </div>
                        <div class="col-lg-4">
                            <label>ADR:</label>
                            <input type="text" id="adr" name="adr" class="form-control" placeholder="Leave empty if no ADR"/>
                            <span class="form-text text-muted">Please enter ADR description</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>License plate:</label>
                            <input type="text" id="plate_number" name="plate_number" class="form-control" placeholder="License plate (ex. B-144-FFR)."/>
                            <span class="form-text text-muted">Please enter the truck license plate.</span>
                        </div>
                        <div class="col-lg-4">
                            <label>Loading date:</label>
                            <div class="input-group date mb-2">
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_truck_loading" name="rohel_truck_loading"/>
                                <div class="input-group-append">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label>Unloading date:</label>
                            <div class="input-group date mb-2">
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_truck_unloading" name="rohel_truck_unloading"/>
                                <div class="input-group-append">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>Ameta:</label>
                            <input type="text" id="ameta" name="ameta" class="form-control" placeholder="Ameta"/>
                            <span class="form-text text-muted">Please enter the ameta code</span>
                        </div>
                        <div class="col-lg-4">
                            <label>Freight:</label>
                            <input type="text" id="freight" name="freight" class="form-control" placeholder="Price in Euros"/>
                            <span class="form-text text-muted">Please enter the cost of the transport</span>
                        </div>
                        <div class="col-lg-4">
                            <label>Details:</label>
                            <input type="text" id="details" name="details" class="form-control" placeholder="Truck details"/>
                            <span class="form-text text-muted">Please enter any relevant details about the truck</span>
                        </div>
                    </div>
                    <div class="h5">
                        <label>Add all truck stops in the below form. If there are no additional stops, simply fill in one row as the final destination.</label>
                    </div>
                    <div id="kt_repeater_truck">
                        <div class="form-group row" id="kt_repeater_truck">
                            <div data-repeater-list="stops" class="col-lg-12">
                                <div data-repeater-item class="form-group row align-items-center">
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="to_city" placeholder="City name"/>
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="to_address" placeholder="Address"/>
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="loading_meters" placeholder="Loading meters"/>
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="weight" placeholder="Weight"/>
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="text" class="form-control" name="volume" placeholder="Volume"/>
                                        <div class="d-md-none mb-2"></div>
                                    </div>
                                    <div class="col-lg-2">
                                        <a href="javascript:;" data-repeater-delete="" class="btn font-weight-bold btn-danger btn-icon">
                                            <i class="la la-remove"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">
                                <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                    <i class="la la-plus"></i>Add
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-8">
                            <button type="submit" class="btn btn-primary mr-2" id="kt_new_cargo_submit_btn">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
