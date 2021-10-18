<div class="content d-flex flex-column flex-column-fluid d-print-none" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">HTTP SESSION
                                    <span class="d-block text-muted pt-2 font-size-sm">Session details.</span></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
                            ?>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-lg-3">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">HTTP REQUEST
                                    <span class="d-block text-muted pt-2 font-size-sm">REQUEST details.</span></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php
                                echo '<pre>' . print_r($_REQUEST, TRUE) . '</pre>';
                            ?>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-lg-3">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">HTTP GET
                                    <span class="d-block text-muted pt-2 font-size-sm">GET details.</span></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <?php
                                    echo '<pre>' . print_r($_GET, TRUE) . '</pre>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
                <div class="col-lg-3">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header flex-wrap border-0 pt-6 pb-0">
                            <div class="card-title">
                                <h3 class="card-label">HTTP POST
                                    <span class="d-block text-muted pt-2 font-size-sm">POST details.</span></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body">
                                <?php
                                    echo '<pre>' . print_r($_POST, TRUE) . '</pre>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
    </div>
</div>

