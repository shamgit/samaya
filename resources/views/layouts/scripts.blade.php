<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
 <script src="{{ asset('assets/js/datatables.min.js') }}"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
 <script src="{{ asset('assets/js/moment.min.js')}}"></script>
 
<script>
	@if(session('toast_error'))
		Swal.fire({
			icon: 'error',
			title: 'Downgrade Restricted',
			text: "{{ session('toast_error') }}",
			confirmButtonColor: '#d33'
		});
	@endif

	@if(session('toast_success'))
		Swal.fire({
			icon: 'success',
			title: 'Downgrade Successful',
			text: "{{ session('toast_success') }}",
			confirmButtonColor: '#3085d6'
		});
	@endif
</script>