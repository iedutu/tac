
<!--begin::Header-->
<div id="kt_header" class="header header-fixed">

    <!--begin::Container-->
    <div class="container-fluid">

        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

            <!--begin::Logo-->
            <div class="header-logo mr-10 d-none d-lg-flex">
                <a href="/">
                    <img alt="Logo" src="/assets/media/logos/package.svg" class="h-40px" />
                </a>
            </div>
            <!--end::Logo-->

            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">

                <!--begin::Header Nav-->
                <ul class="menu-nav">
                    <li class="menu-item <?=(Utils::isCargo())?'menu-item-active':''?>" aria-haspopup="true">
                        <a href="/?page=cargo" class="menu-link">
                            <span class="menu-text">Cargo</span>
                        </a>
                    </li>
                    <li class="menu-item <?=(Utils::isTruck())?'menu-item-active':''?>" aria-haspopup="true">
                        <a href="/?page=trucks" class="menu-link">
                            <span class="menu-text">Trucks</span>
                        </a>
                    </li>
                    <li class="menu-item <?=(Utils::isMatch())?'menu-item-active':''?>" aria-haspopup="true">
                        <a href="/?page=matches" class="menu-link">
                            <span class="menu-text">Matching</span>
                        </a>
                    </li>
                </ul>

                <!--end::Header Nav-->
            </div>

            <!--end::Header Menu-->
        </div>

        <!--end::Header Menu Wrapper-->
        <?php
        $_SESSION['operator']['notification-count'] = DB_utils::notificationsCount();
        ?>
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::Help-->
            <div class="topbar-item mr-1">
                <div class="btn btn-icon btn-hover-transparent-white btn-clean btn-lg" id="kt_quick_panel_toggle">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/keen/releases/2021-04-21-040700/theme/demo6/dist/../src/media/svg/icons/Code/Question-circle.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                            <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                </div>
            </div>
            <!--end::Help-->
            <!--begin::User-->
            <div class="topbar-item mr-3">
                <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2 <?=$_SESSION['operator']['notification-count']>0?'pulse pulse-danger':''?>" <?=$_SESSION['operator']['notification-count']>0?'data-toggle="tooltip" data-placement="bottom" title="You have '.$_SESSION['operator']['notification-count'].' new notifications!"':''?> id="kt_quick_user_toggle">
                    <div class="symbol symbol-circle symbol-30 bg-white overflow-hidden">
                        <div class="symbol-label">
                            <img alt="Userland" src="assets/media/svg/avatars/<?=$_SESSION['operator']['avatar']?>.svg" class="h-75 align-self-end" />
                            <?=$_SESSION['operator']['notification-count']>0?'<span id="kt_user_icon_ring" class="pulse-ring"></span>':''?>
                        </div>
                    </div>

                </div>
            </div>

            <!--end::User-->
        </div>

        <!--end::Topbar-->
    </div>

    <!--end::Container-->
</div>

<!--end::Header-->