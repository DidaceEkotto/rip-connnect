@extends("layouts.admin.template_admin")
@php
    $setting = \App\Models\Setting::first();
    $title = $service->titre ." - modifier :: ". $setting->name_entreprise;
    $title2 = $service->titre ." - modifier ";
@endphp
@push("body")
      <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
@endpush
@section('container')
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        @include('layouts.admin.include.header_sidebar',['setting'=>$setting,'title'=>$title2])

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6">
                <h3 class="mb-0">{{ $title2 }}</h3>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{ $title2 }}</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            @livewire("admin.edite-services",["service"=>$service,'title'=>$title2, 'page'=>request()->fullUrl()])
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
    @include('layouts.admin.include.footer',['setting'=>$setting])

    </div>
@endsection
@push("scripts")
        <!--end::App Wrapper-->
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>

    <script>
      const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
      const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
      };
      document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

        // Disable OverlayScrollbars on mobile devices to prevent touch interference
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: Default.scrollbarTheme,
              autoHide: Default.scrollbarAutoHide,
              clickScroll: Default.scrollbarClickScroll,
            },
          });
        }
      });
    </script>
    <!--end::OverlayScrollbars Configure--><!--begin::Color Mode Toggle (#6010)-->


    <!-- OPTIONAL SCRIPTS -->

    <!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>

    <script>
      // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
      // IT'S ALL JUST JUNK FOR DEMO
      // ++++++++++++++++++++++++++++++++++++++++++

      const visitors_chart_options = {
        series: [
          {
            name: 'High - 2023',
            data: [100, 120, 170, 167, 180, 177, 160],
          },
          {
            name: 'Low - 2023',
            data: [60, 80, 70, 67, 80, 77, 100],
          },
        ],
        chart: {
          height: 200,
          type: 'line',
          toolbar: {
            show: false,
          },
        },
        colors: ['#0d6efd', '#adb5bd'],
        stroke: {
          curve: 'smooth',
        },
        grid: {
          borderColor: '#e7e7e7',
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5,
          },
        },
        legend: {
          show: false,
        },
        markers: {
          size: 1,
        },
        xaxis: {
          categories: ['22th', '23th', '24th', '25th', '26th', '27th', '28th'],
        },
      };

      const visitors_chart = new ApexCharts(
        document.querySelector('#visitors-chart'),
        visitors_chart_options,
      );
      visitors_chart.render();

      const sales_chart_options = {
        series: [
          {
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
          },
          {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
          },
          {
            name: 'Free Cash Flow',
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
          },
        ],
        chart: {
          type: 'bar',
          height: 200,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded',
          },
        },
        legend: {
          show: false,
        },
        colors: ['#0d6efd', '#20c997', '#ffc107'],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent'],
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        fill: {
          opacity: 1,
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return '$ ' + val + ' thousands';
            },
          },
        },
      };

      const sales_chart = new ApexCharts(
        document.querySelector('#sales-chart'),
        sales_chart_options,
      );
      sales_chart.render();
    </script>
@endpush
