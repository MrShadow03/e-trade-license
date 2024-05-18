<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toastr-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "500",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "messageClass": "font-bn",
    };
</script>
  
@if(Session::has('error'))
    <script>
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif
@if(Session::has('success'))
    <script>
        toastr.success("{{ Session::get('success') }}");
    </script>
@endif
@if(Session::has('info'))
    <script>
        toastr.info("{{ Session::get('info') }}");
    </script>
@endif
@if(Session::has('warning'))
    <script>
        toastr.warning("{{ Session::get('warning') }}");
    </script>
@endif
<!--end::Global Javascript Bundle-->

{{-- <!--begin::Toast-->
@if(Session::has('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index:99999;">
    <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-light-danger">
            <i class="ki-duotone ki-information-3 fs-1 text-danger me-3">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <strong class="fs-6 me-auto font-bn text-danger">
                কিছু ভুল হয়েছে
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body font-bn">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

@if(Session::has('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index:99999;">
    <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-light-success">
            <i class="ki-duotone ki-shield-tick fs-1 text-success me-3">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <strong class="fs-6 me-auto font-bn text-success">
                সফল হয়েছে
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body font-bn">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(Session::has('info'))
<div class="position-fixed top-0 end-0 p-3" style="z-index:99999;">
    <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-light-info">
            <i class="ki-duotone ki-information-4 fs-1 text-info me-3">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <strong class="fs-6 me-auto font-bn text-info">
                তথ্য
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body font-bn">
            {{ session('info') }}
        </div>
    </div>
</div>
@endif

@if(Session::has('warning'))
<div class="position-fixed top-0 end-0 p-3" style="z-index:99999;">
    <div id="kt_docs_toast_toggle" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-light-warning">
            <i class="ki-duotone ki-information fs-1 text-warning me-3">
                <span class="path1"></span>
                <span class="path2"></span>
                <span class="path3"></span>
            </i>
            <strong class="fs-6 me-auto font-bn text-warning">
                সতর্কতা
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body font-bn">
            {{ session('warning') }}
        </div>
    </div>
</div>
@endif
<!--end::Toast--> --}}

{{-- <script>
    const toastElement = document.getElementById('kt_docs_toast_toggle');
    const options = {
        autohide: false,
        delay: 5000,
    };
    const toast = new bootstrap.Toast(toastElement, options);
    toast.show();
</script> --}}