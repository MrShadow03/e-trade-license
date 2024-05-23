<div class="app-navbar flex-shrink-0">
    <!--begin::Theme mode-->
    <div class="app-navbar-item ms-1 ms-md-3">

        <!--begin::Menu toggle-->
        <a href="#" class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <i class="fal fa-sun-bright theme-light-show fs-4 fs-lg-1"></i>
            <i class="fal fa-moon theme-dark-show fs-4 fs-lg-1"></i>
        </a>
        <!--begin::Menu toggle-->

        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="fal fa-sun-bright fs-4"></i> 
                    </span>
                    <span class="menu-title">
                        Light
                    </span>
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="fal fa-moon fs-4"></i>
                    </span>
                    <span class="menu-title">
                        Dark
                    </span>
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3 my-0">
                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                    <span class="menu-icon" data-kt-element="icon">
                        <i class="fal fa-computer-speaker fs-4"></i>
                    </span>
                    <span class="menu-title">
                        System
                    </span>
                </a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->

    </div>
    <!--end::Theme mode-->

    <div class="app-navbar-item ms-1 ms-md-3 font-bn" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">
            <img class="object-fit-cover" src="{{ asset('storage').'/'.auth()->user()->image }}" alt="user" />
        </div>

        <!--begin::User account menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <img class="object-fit-cover" alt="Logo" src="{{ asset('storage').'/'.auth()->user()->image }}" />
                    </div>
                    <!--end::Avatar-->

                    <!--begin::Username-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5 font-hind-siliguri">
                            {{ auth()->user()->name }}
                        </div>
                        <span class="fw-semibold text-success fs-6">{{ ucfirst(auth()->user()->designation ?? '') }}</span>
                        <a href="#" class="fw-semibold text-muted fs-7">{{ auth()->user()->email ?? '' }}</a>
                    </div>
                    <!--end::Username-->
                </div>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="{{ route('user.profile.edit') }}" class="menu-link px-5">আমার প্রোফাইল</a>
            </div>
            <!--end::Menu item-->

            {{-- <!--begin::Menu separator-->
            <div class="separator my-2"></div>
            <!--end::Menu separator--> --}}


            {{-- <!--begin::Menu item-->
            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                <a href="#" class="menu-link px-5">
                    <span class="menu-title position-relative">
                        Language

                        <span
                            class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                            English <img class="w-15px h-15px rounded-1 ms-2"
                                src="../assets/media/flags/united-states.svg" alt="" />
                        </span>
                    </span>
                </a>

                <!--begin::Menu sub-->
                <div class="menu-sub menu-sub-dropdown w-175px py-4">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="../account/settings.html" class="menu-link d-flex px-5 active">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="../assets/media/flags/united-states.svg"
                                    alt="" />
                            </span>
                            English
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="../account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="../assets/media/flags/spain.svg" alt="" />
                            </span>
                            Spanish
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="../account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="../assets/media/flags/germany.svg" alt="" />
                            </span>
                            German
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="../account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="../assets/media/flags/japan.svg" alt="" />
                            </span>
                            Japanese
                        </a>
                    </div>
                    <!--end::Menu item-->

                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="../account/settings.html" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img class="rounded-1" src="../assets/media/flags/france.svg" alt="" />
                            </span>
                            French
                        </a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu sub-->
            </div>
            <!--end::Menu item--> --}}

            {{-- <!--begin::Menu item-->
            <div class="menu-item px-5 my-1">
                <a href="#" class="menu-link px-5">
                    Account Settings
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-5">
                <a href="#" class="menu-link px-5">
                    Sign Out
                </a>
            </div>
            <!--end::Menu item--> --}}
        </div>
        <!--end::User account menu-->
        <!--end::Menu wrapper-->
    </div>
</div>