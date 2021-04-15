<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <base href="">
    <meta charset="utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/themes/layout/header/base/light.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/header/menu/light.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/brand/dark.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/themes/layout/aside/dark.css?v=7.0.3') }}" rel="stylesheet" type="text/css" />

</head>

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-row-fluid" id="kt_wrapper">
        <div class="content d-flex flex-column flex-column-fluid mt-20" id="kt_content">
            <div class="container-fluid" style="margin-top: -50px">
                <div class="d-flex flex-column-fluid">
                    <div class="container">
                        <div class="card card-custom overflow-hidden">
                            <div class="card-body p-0">
                                <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                                    <div class="col-md-9">
                                        <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                            <h1 class="display-4 font-weight-boldest mb-10">FATURA</h1>
                                            <div class="d-flex flex-column align-items-md-end px-0">
                                                <a href="#" class="mb-5">
                                                    <img src="{{ asset('assets/media/logos/logo-dark.png') }}" style="width: 75%" alt="" />
                                                </a>
                                                <span class="d-flex flex-column align-items-md-end opacity-70">
                                                    <span>Nail Bey, Vali Fahri Bey Cd.</span>
                                                    <span>No:37, 23000 Elâzığ</span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-bottom w-100"></div>
                                        <div class="d-flex justify-content-between pt-6">
                                            <div class="d-flex flex-column flex-root">
                                                <span class="font-weight-bolder mb-2">FATURA TARİHİ</span>
                                                <span class="opacity-70">{{ date('d.m.Y', strtotime($reservation->end_date)) }}</span>
                                            </div>
                                            <div class="d-flex flex-column flex-root">
                                                <span class="font-weight-bolder mb-2">FATURA NUMARASI</span>
                                                <span class="opacity-70">GS 000014</span>
                                            </div>
                                            <div class="d-flex flex-column flex-root">
                                                <span class="font-weight-bolder mb-2">MÜŞTERİ</span>
                                                <span class="opacity-70">{{ $reservation->customer_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-n15">
                                <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="pl-0 font-weight-bold text-muted text-uppercase">HİZMET</th>
                                                    <th class="text-right pt-7"></th>
                                                    <th class="text-right pt-7"></th>
                                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">TUTAR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($safeActivities->where('direction', 1)->all() as $safeActivity)
                                                    <tr class="font-weight-boldest">
                                                        <td class="pl-0 pt-7">{{ $safeActivity->extra ? $safeActivity->extra->name : 'Oda Ücreti' }}</td>
                                                        <td class="text-right pt-7"></td>
                                                        <td class="text-right pt-7"></td>
                                                        <td class="text-danger pr-0 pt-7 text-right">{{ number_format($safeActivity->price, 2) }} TL</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end: Invoice body-->
                                <!-- begin: Invoice footer-->
                                <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                                    <div class="col-md-9">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th class="text-right pt-7"></th>
                                                    <th class="text-right pt-7"></th>
                                                    <th class="text-right pt-7"></th>
                                                    <th class="text-right pr-0 font-weight-bold text-muted text-uppercase">TOPLAM TUTAR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="font-weight-bolder">
                                                    <td class="pl-0 pt-7"></td>
                                                    <td class="text-right pt-7"></td>
                                                    <td class="text-right pt-7"></td>
                                                    <td class="text-danger font-size-h1 pr-0 font-weight-boldest text-right">{{ $safeActivities->where('direction', 1)->sum('price') }} TL</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>var HOST_URL = "https://keenthemes.com/metronic/tools/preview";</script>
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
@stack('before-scripts')

<script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.3') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.3') }}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=7.0.3') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('assets/js/pages/widgets.js?v=7.0.3') }}"></script>
<!--end::Page Scripts-->

@stack('after-scripts')

<script src="{{ asset('assets/js/bootstrap-datepicker.tr.js') }}"></script>
<script src="{{ asset('assets/js/pages/crud/forms/widgets/input-mask.js?v=7.0.3') }}"></script>
<script>
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'tr'
    });
</script>

@if (trim($__env->yieldContent('page-script')))
    @yield('page-script')
@endif

</body>
<!--end::Body-->
</html>
