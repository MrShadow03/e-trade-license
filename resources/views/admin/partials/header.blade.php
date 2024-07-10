<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    @section('title')
        <!--begin::Page Title-->
    @show
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <link rel="shortcut icon" href="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}">

    

    <!--begin::Fonts(mandatory for all pages)-->
    @include('admin.partials.fonts')
    <!--end::Fonts-->

    @section('exclusive_styles')
    @show


    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    @include('partials.global_stylesheets_bundle')
    <!--end::Global Stylesheets Bundle-->
    <!--Begin::Header Scripts -->
    @include('admin.partials.header_scripts')
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"  class="app-default">
    
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;

        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }

            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }

            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }            
    </script>

    <!--begin::Page loading-->
	<div class="page-loader">
		<span class="spinner-border text-primary" role="status">
			<span class="visually-hidden">Loading...</span>
		</span>
	</div>
	<!--end::Page loading-->
