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
                            <label class="form-control-label" for="recipient">Truck recipient <span class="text-danger">*</span></label>
                            <select class="form-control" id="recipient" name="recipient">
                                <?php DB_utils::selectActiveUsers(); ?>
                            </select>
                            <span class="form-text text-muted">Please select your colleague</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="from_city">City of origin: <span class="text-danger">*</span></label>
                            <input type="text" id="from_city" name="from_city" class="form-control" placeholder="City name"/>
                            <span class="form-text text-muted">Please enter the truck origin</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="from_address">Address of origin:</label>
                            <input type="text" id="from_address" name="from_address" class="form-control" placeholder="Street address"/>
                            <span class="form-text text-muted">Leave empty if not applicable</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="cargo_type">Cargo type: <span class="text-danger">*</span></label>
                            <select class="form-control" id="cargo_type" name="cargo_type">
                                <option value="FTL">FTL</option>
                                <option value="LTL">LTL</option>
                                <option value="Groupage">Groupage</option>
                            </select>
                            <span class="form-text text-muted">Please select the cargo loading details</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="contract_type">Contract type: <span class="text-danger">*</span></label>
                            <select class="form-control" id="contract_type" name="contract_type">
                                <option value="Round-trip">Round-trip</option>
                                <option value="One-way">One-way</option>
                            </select>
                            <span class="form-text text-muted">Please select the type of the contract</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="adr">ADR:</label>
                            <input type="text" id="adr" name="adr" class="form-control" placeholder="Leave empty if no ADR"/>
                            <span class="form-text text-muted">Please enter ADR description</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="plate_number">License plate: <span class="text-danger">*</span></label>
                            <input type="text" id="plate_number" name="plate_number" class="form-control" placeholder="License plate (ex. B-144-FFR)."/>
                            <span class="form-text text-muted">Please enter the truck license plate.</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="rohel_truck_loading">Loading date: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_truck_loading" name="rohel_truck_loading"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="rohel_truck_unloading">Unloading date: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_truck_unloading" name="rohel_truck_unloading"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="ameta">Ameta: <span class="text-danger">*</span></label>
                            <input type="text" id="ameta" name="ameta" class="form-control" placeholder="Ameta"/>
                            <span class="form-text text-muted">Please enter the ameta code</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="freight">Freight: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&euro;</span></div>
                                    <input type="text" id="freight" name="freight" class="form-control" placeholder="Price in Euros"/>
                                </div>
                                <span class="form-text text-muted">Please enter the cost of the transport</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="details">Driver details: <span class="text-danger">*</span></label>
                            <input type="text" id="details" name="details" class="form-control" placeholder="<Name>, <Mobile number>"/>
                            <span class="form-text text-muted">Please enter the driver details.</span>
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
                                        <div class="input-group date mb-2">
                                            <input type="text" class="form-control" name="to_city" placeholder="City name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group date mb-2">
                                            <input type="text" class="form-control" name="to_address" placeholder="Address"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group date mb-2">
                                            <div class="input-group-prepend"><span class="input-group-text">m</span></div>
                                            <input type="text" id="loading" name="loading" class="form-control" placeholder="LDM"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group date mb-2">
                                            <div class="input-group-prepend"><span class="input-group-text">kg</span></div>
                                            <input type="text" id="weight" name="weight" class="form-control" placeholder="Weight"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group date mb-2">
                                            <div class="input-group-prepend"><span class="input-group-text">m&sup3</span></div>
                                            <input type="text" id="volume" name="volume" class="form-control" placeholder="Volume"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="input-group date mb-2">
                                            <a href="javascript:;" data-repeater-delete="" class="btn font-weight-bold btn-danger btn-icon">
                                                <i class="la la-remove"></i>
                                            </a>
                                        </div>
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
