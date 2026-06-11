 <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        @php
            $date = date('Y');
            $now_date = 2026;
        @endphp
        <strong>
          Copyright &copy; {{ $date == $now_date ? '2026' : '2026 -'. $date}} &nbsp;
          <a href="javascript:void(0);" class="text-decoration-none">{{ $setting->name_entreprise }}</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
