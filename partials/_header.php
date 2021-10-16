
<!--begin::Header-->
					<div id="kt_header" class="header header-fixed">

						<!--begin::Container-->
						<div class="container-fluid">

							<!--begin::Header Menu Wrapper-->
							<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

								<!--begin::Logo-->
								<div class="header-logo mr-10 d-none d-lg-flex">
									<a href="index.php">
										<img alt="Logo" src="assets/media/logos/package.svg" class="h-40px" />
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

							<!--begin::Topbar-->
							<div class="topbar">
								<!--begin::User-->
								<div class="topbar-item mr-3">
									<div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
										<div class="symbol symbol-circle symbol-30 bg-white overflow-hidden">
											<div class="symbol-label">
												<img alt="Userland" src="assets/media/svg/avatars/<?=$_SESSION['operator']['avatar']?>.svg" class="h-75 align-self-end" />
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