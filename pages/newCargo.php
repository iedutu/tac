<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <h3 class="card-title">New cargo</h3>
            </div>
            <form class="form" id="kt_rohel_cargo_form" action="/api/insertCargo.php" method="post">
                <input type="hidden" name="_submitted" id="_submitted" value="yes"/>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="recipient">Cargo recipient <span class="text-danger">*</span></label>
                            <select class="form-control" id="recipient" name="recipient">
                                <?php DB_utils::selectActiveUsers(); ?>
                            </select>
                            <span class="form-text text-muted">Please select your colleague</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="from_city">Origin city: <span class="text-danger">*</span></label>
                            <input type="text" id="from_city" name="from_city" class="form-control" placeholder="City name"/>
                            <span class="form-text text-muted">Please enter the cargo origin</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="to_city">Destination city: <span class="text-danger">*</span></label>
                            <input type="text" id="to_city" name="to_city" class="form-control" placeholder="City name"/>
                            <span class="form-text text-muted">Please enter the cargo destination</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="order_type">Order type: <span class="text-danger">*</span></label>
                            <select class="form-control" id="order_type" name="order_type">
                                <option value="Bid">Bid</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Forecast">Forecast</option>
                            </select>
                            <span class="form-text text-muted">Please select the type of the order</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="from_address">Origin: <span class="text-danger">*</span></label>
                            <input type="text" id="from_address" name="from_address" class="form-control" placeholder="Company name & address"/>
                            <span class="form-text text-muted">Please enter the cargo origin</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="to_address">Destination: <span class="text-danger">*</span></label>
                            <input type="text" id="to_address" name="to_address" class="form-control" placeholder="Company name & address"/>
                            <span class="form-text text-muted">Please enter the cargo destination</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="rohel_cargo_expiration">Expiration date: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_cargo_expiration" name="rohel_cargo_expiration"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="rohel_cargo_loading">Loading date: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_cargo_loading" name="rohel_cargo_loading"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="rohel_cargo_unloading">Unloading date: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend">
                                               <span class="input-group-text">
                                               <i class="la la-calendar"></i>
                                               </span>
                                </div>
                                <input type="text" class="form-control" placeholder="Click to select a date." id="rohel_cargo_unloading" name="rohel_cargo_unloading"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="weight">Gross weight: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend"><span class="input-group-text">kg</span></div>
                                <input type="text" id="weight" name="weight" class="form-control" placeholder="Cargo weight"/>
                            </div>
                            <span class="form-text text-muted">Please enter the cargo gross weight</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="volume">Volume: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend"><span class="input-group-text">m&sup3</span></div>
                                <input type="text" id="volume" name="volume" class="form-control" placeholder="Cargo volume"/>
                            </div>
                            <span class="form-text text-muted">Please enter the volume</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="loading">Loading meters: <span class="text-danger">*</span></label>
                            <div class="input-group date mb-2">
                                <div class="input-group-prepend"><span class="input-group-text">m</span></div>
                                <input type="text" id="loading" name="loading" class="form-control" placeholder="LDM"/>
                            </div>
                            <span class="form-text text-muted">Please enter the loading meters</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="collies">Collies:</label>
                            <input type="text" id="collies" name="collies" class="form-control" placeholder="Collies"/>
                            <span class="form-text text-muted">Please enter the number of collies</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label" for="freight">Freight:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">&euro;</span></div>
                                    <input type="text" id="freight" name="freight" class="form-control" placeholder="Price in Euros"/>
                                </div>
                                <span class="form-text text-muted">Please enter the cost of the transport</span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="adr">ADR:</label>
                            <input type="text" id="adr" name="adr" class="form-control" placeholder="Leave empty if no ADR"/>
                            <span class="form-text text-muted">Please enter ADR description</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="client">Client: <span class="text-danger">*</span></label>
                            <input type="text" id="client" name="client" class="form-control" placeholder="Client name only"/>
                            <span class="form-text text-muted">Please enter the name of the client</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="description">Description of goods :</label>
                            <input type="text" id="description" name="description" class="form-control" placeholder=""/>
                            <span class="form-text text-muted">Please enter the goods description</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="instructions">Delivery instructions: <span class="text-danger">*</span></label>
                            <select class="form-control" id="instructions" name="instructions">
                                <option value="Client">Client</option>
                                <option value="Local">Local</option>
                                <option value="Depo">Depo</option>
                            </select>
                            <span class="form-text text-muted">Please choose the delivery instructions</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="form-control-label" for="dimensions">Cargo dimensions:</label>
                            <input type="text" id="dimensions" name="dimensions" class="form-control" placeholder="L x W x H"/>
                            <span class="form-text text-muted">Please enter the cargo dimensions</span>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-control-label" for="package">Package :</label>
                            <input type="text" id="package" name="package" class="form-control" placeholder="Packaging"/>
                            <span class="form-text text-muted">Please enter the packaging data</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-4"></div>
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
