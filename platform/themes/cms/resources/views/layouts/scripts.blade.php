<script src="{{ asset('public/templates/tabler/js/tabler.min.js') }}" defer></script>
<script src="{{ asset('public/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
<script src="{{ asset('public/libs/parsley/parsley.min.js') }}"></script>

{{-- datatable --}}
<script src="{{ asset('libs/datatables/jquery.dataTables.min.js') }}"></script>

<script src="{{ asset('libs/datatables/plugins/bs5/js/dataTables.bootstrap5.min.js') }}"></script>

<script src="{{ asset('libs/datatables/plugins/buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('libs/datatables/plugins/buttons/js/buttons.bootstrap5.min.js') }}"></script>

<script src="{{ asset('libs/datatables/plugins/responsive/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('libs/datatables/plugins/responsive/js/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('public/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('public/libs/select2/js/i18n/' . trans()->getLocale() . '.js') }}"></script>


@stack('libs-js')

@vite(core_public_asset('base', 'js/i18n.js'))
<script src="{{ vite_asset(core_public_asset('base', 'js/select2.js')) }}"></script>
<script src="{{ vite_asset(core_public_asset('base', 'js/init.js')) }}"></script>
<script src="{{ vite_asset(core_public_asset('base', 'js/lib-ajax.js')) }}"></script>
<script src="{{ vite_asset(core_public_asset('base', 'js/modal-form.js')) }}"></script>
<script src="{{ vite_asset(core_public_asset('base', 'js/modal.js')) }}"></script>
<script src="{{ vite_asset(core_public_asset('base', 'js/alert.js')) }}"></script>
<script src="{{ vite_asset(core_public_asset('datatable', 'js/datatable.js')) }}"></script>

<script type="text/javascript" src="{{ vite_theme_asset('cms', 'assets/js/cms.js') }}"></script>

@stack('js')