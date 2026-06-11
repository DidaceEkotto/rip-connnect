@extends("layouts.admin.template_admin")
@php
    $setting = \App\Models\Setting::first();
    $title = " Ajouter une aide :: ". $setting->name_entreprise;
    $title2 = " Ajouter une aide";
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
            @livewire("admin.aides-create")
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

@endpush
