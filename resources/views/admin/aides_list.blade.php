@extends("layouts.admin.template_admin")
@php
    $setting = \App\Models\Setting::first();
    $title = "Aides :: ". $setting->name_entreprise;
    $title2 = "Aides ";
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
                                    <a href="{{ route('admin.aides.create') }}"
                                        class="btn btn-primary d-none d-sm-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 5l0 14"></path>
                                            <path d="M5 12l14 0"></path>
                                        </svg>
                                        Ajouter une aide
                                    </a>
                                </div>
                            </div>
                            <p style="clear: both !important;"></p>
                            <br><br>

                            <div class="col-md-12 col-lg-12">
                                @if ($aides->count() > 0)
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
                                                    @foreach ($aides as $aide)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex py-1 align-items-center">
                                                                    <img src="{{ asset($aide->image) }}"
                                                                        style="width:50px !important;height:50px !important;">
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p>{{ $aide->titre }}</p>
                                                            </td>
                                                            <td>
                                                                <p style="color: {{ $aide->status == "0" ? "green" : "red" }}">{{ $aide->status == "0" ? "Inactif" : "Actif" }} </p>
                                                            </td>
                                                            <td>
                                                                <a
                                                                    href="{{ route('admin.aides.edite', ['id' => $aide->id]) }}">Modifier / Supprimer</a>&nbsp;

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="card">
                                        <div class="card-body">
                                            Pas d'aide pour le moment
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

@endpush
