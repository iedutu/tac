
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