<!-- Start JS -->
<script src="{{ asset('assets/manager-admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/detect.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/fastclick.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/waves.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('assets/manager-admin/js/jquery.scrollTo.min.js') }}"></script>

<script src="{{ asset('assets/manager-admin/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
{{-- <script src="{{ asset('assets/manager-admin/pages/dashborad.js') }}"></script> --}}


<!-- End JS -->

<script src="{{ asset('assets/helper.js') }}" type="text/javascript"></script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@include('sweetalert::alert')
{{-- @include('Others.sweetalert-js'); --}}

@stack('datatableJS')

<script src="{{ asset('assets/manager-admin/js/app.js') }}"></script>

@stack('script')


