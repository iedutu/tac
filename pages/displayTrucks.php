<!--begin::Card-->
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">Avalailable trucks
                <span class="d-block text-muted pt-2 font-size-sm">Please note all records will be kept for up to 5 calendar days from acceptance.</span></h3>
        </div>
        <div class="card-toolbar d-print-none">
            <!--begin::Button-->
            <a href="/?page=reports&data=trucks" class="btn btn-light-primary font-weight-bolder <?=($_SESSION['operator']['reports']==0)?'disabled':''?>">
											<span class="svg-icon svg-icon-md">
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g id="Stockholm-icons-/-Files-/-Download" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z" id="Path-57" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                        <rect id="Rectangle" fill="#000000" opacity="0.3" transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) " x="11" y="1" width="2" height="14" rx="1"></rect>
                                                        <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z" id="Path-102" fill="#000000" fill-rule="nonzero" transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "></path>
                                                    </g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>Download</a>
            <!--end::Button-->
            &nbsp;&nbsp;
            <!--begin::Button-->
            <a href="/?page=newTruck" class="btn btn-primary font-weight-bolder <?=($_SESSION['operator']['insert']==0)?'disabled':''?>">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g id="Stockholm-icons-/-Navigation-/-Plus" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect id="Rectangle-185" fill="#000000" x="4" y="11" width="16" height="2" rx="1"></rect>
                                                        <rect id="Rectangle-185-Copy" fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"></rect>
                                                    </g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>New truck</a>
            <!--end::Button-->
        </div>
    </div>
    <div class="card-body">
        <!--begin::Search Form-->
        <div class="mb-7">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Search..." id="kt_datatable_search_query" />
                                <span><i class="flaticon2-search-1 text-muted"></i></span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <select class="form-control" id="kt_datatable_search_status">
                                    <option value="">Status</option>
                                    <option value="<?=AppStatuses::$TRUCK_AVAILABLE?>">Available</option>
                                    <option value="<?=AppStatuses::$TRUCK_FREE?>">Free</option>
                                    <option value="<?=AppStatuses::$TRUCK_NEW?>">New</option>
                                    <option value="<?=AppStatuses::$TRUCK_PARTIALLY_SOLVED?>">Partially loaded</option>
                                    <option value="<?=AppStatuses::$TRUCK_FULLY_SOLVED?>">Fully loaded</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <select class="form-control" id="kt_datatable_search_from">
                                    <option value="">Origin office</option>
                                    <?php DB_utils::selectOffices(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <select class="form-control" id="kt_datatable_search_to">
                                    <option value="">Destination office</option>
                                    <?php DB_utils::selectOffices(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <!-- <label class="mr-3 mb-0 d-none d-md-block">From:</label> -->
                                <select class="form-control" id="kt_datatable_search_country_from">
                                    <option value="">Origin country</option>
                                    <option value="1">Romania</option>
                                    <option value="2">Greece</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex align-items-center">
                                <!-- <label class="mr-3 mb-0 d-none d-md-block">To:</label> -->
                                <select class="form-control" id="kt_datatable_search_country_to">
                                    <option value="">Destination country</option>
                                    <option value="1">Romania</option>
                                    <option value="2">Greece</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end: Search Form-->
        <!--begin: Datatable-->
        <div class="datatable datatable-bordered datatable-head-custom" id="kt_datatable_truck_list"></div>
        <!--end: Datatable-->
    </div>
</div>
<!--end::Card-->
