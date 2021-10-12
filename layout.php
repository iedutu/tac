
<!--begin::Main-->

<?php include 'partials/_header-mobile.php'; ?>
<?php include 'partials/_aside.php'; ?>

<div class="d-flex flex-column flex-root">

    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">

        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <?php include 'partials/_header.php'; ?>
            <?php // include 'partials/_subheader.php'; ?>

            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin:Alert box-->
                        <?php include "pages/internal/displayAlert.php"; ?>
                        <!--end:Alert box-->

                        <?php include "pages/internal/includeContent.php"; ?>
                    </div>
                </div>
            </div>
            <!--end::Content-->

            <?php
                if($_SESSION['debug']) {
                    echo '<!--begin::Debug-->';
                    include "pages/internal/displayDebug.php";
                    echo '<!--begin::Debug-->';
                }
            ?>

            <?php include 'partials/_footer.php'; ?>
        </div>

        <!--end::Wrapper-->
    </div>

    <!--end::Page-->
</div>

<!--end::Main-->