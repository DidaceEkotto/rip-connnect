@extends("layouts.admin.template_admin")
@php
    $setting = \App\Models\Setting::first();
    $title = "Nos services :: ". $setting->name_entreprise;
    $title2 = "Nos services ";
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
            <div class="">
                        <div class="row row-deck row-cards">

                            <div class="">
                                <div class="btn-list">
                                    <a href="{{ route('admin.services.ajouter') }}"
                                        class="btn btn-primary d-none d-sm-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        Ajouter un service
                                    </a>
                                </div>
                            </div>
                            <p style="clear: both !important;"></p>
                            <br><br>

                            <div class="col-md-12 col-lg-12">
                                @if ($services->count() > 0)
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-vcenter card-table">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Titre</th>
                                                        <th>Status</th>
                                                        <th>Modifier</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($services as $service)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex py-1 align-items-center">
                                                                    <img src="{{ asset($service->image) }}"
                                                                        style="width:50px !important;height:50px !important;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p>{{ $service->titre }}</p>
                                                            </td>
                                                            <td>
                                                                <p style="color: {{ $service->status == "0" ? "green" : "red" }}">{{ $service->status == "0" ? "Inactif" : "Actif" }} </p>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('admin.services.modifier', ['id' => $service->id]) }}">Modifier / Supprimer</a>&nbsp;

                                                            </td>
                                                            {{-- <td>
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                    data-bs-target="#modal-edite"
                                                                    wire:click='showUpdate({{ $organisme->id }})'>Modifier</a>
                                                            </td>
                                                            <td>
                                                                @if ($organisme->status == '0')
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                        data-bs-target="#modal-small-{{ $organisme->id }}"
                                                                        style="color:green">Activer</a>
                                                                    <div wire:ignore.self class="modal modal-blur fade"
                                                                        data-bs-backdrop="static"
                                                                        id="modal-small-{{ $organisme->id }}" tabindex="-1"
                                                                        role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="modal-title">Est-vous sûr?
                                                                                    </div>
                                                                                    <div>
                                                                                        Voulez-vous vraiment activer
                                                                                        l'organisation
                                                                                        : {{ $organisme->name }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-link link-secondary me-auto"
                                                                                        data-bs-dismiss="modal">Fermer</button>
                                                                                    <button
                                                                                        wire:click='showOrganisme({{ $organisme->id }})'
                                                                                        class="btn btn-success"
                                                                                        data-bs-dismiss="modal">Oui
                                                                                        activer</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                        data-bs-target="#modal-small-{{ $organisme->id }}"
                                                                        style="color:red !important;">Désactiver</a>
                                                                    <div wire:ignore.self class="modal modal-blur fade"
                                                                        data-bs-backdrop="static"
                                                                        id="modal-small-{{ $organisme->id }}"
                                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                                        <div class="modal-dialog modal-sm modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <div class="modal-title">Est-vous sûr?
                                                                                    </div>
                                                                                    <div>
                                                                                        Voulez-vous vraiment désactiver
                                                                                        l'organisme:
                                                                                        {{ $organisme->name }}
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-link link-secondary me-auto"
                                                                                        data-bs-dismiss="modal">Fermer</button>
                                                                                    <button
                                                                                        wire:click='hideOrganisme({{ $organisme->id }})'
                                                                                        class="btn btn-danger"
                                                                                        data-bs-dismiss="modal">Oui
                                                                                        désactiver</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif

                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-body">
                                            Pas de service pour le moment
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
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
