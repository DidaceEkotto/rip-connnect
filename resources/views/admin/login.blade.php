@extends("layouts.admin.template_admin")
@php
    $title = "Espace de connexion :: " .env("APP_NAME");
    $title2 = "Espace de connexion";
@endphp
@push("body")
      <body class="login-page bg-body-secondary">
@endpush
@section("container")
    <div class="login-box">
    @php
        $setting = \App\Models\Setting::first();
    @endphp
      <div class="login-logo">
        @if($setting)
            <a href="{{ route('homePage') }}">
                <img src="{{ $setting->logo == null ? 'https://semantic-ui.com/images/avatar2/large/molly.png' : asset($setting->logo) }}" {{ $setting->logo == null ? 'width=150 height=150': '' }}>
            </a>
        @else
            <a href="{{ route('homePage') }}"><b>{{ $setting->name_entreprise }}</b></a>
        @endif
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Espace de connexion administration</p>

          @livewire("admin.auth.login")


        <!-- /.login-card-body -->
      </div>
    </div>

@endsection
