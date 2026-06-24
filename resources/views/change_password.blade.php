@include('layouts.header')
@include('layouts.sidebar')
<style>
.form-group {
	margin-bottom: 1rem;
	position: relative;
}
.form-label {
	display: block;
	margin-bottom: 0.5rem;
	font-weight: 500;
}
#pwdIcon {
	position: absolute;
	right: 10px;
	bottom: 5px;
	cursor: pointer;
	font-size: 1.2rem;
	color: #6c757d;
}
#pwdIcon:hover {
	color: #000;
}
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('dashboard') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
     Change Password</h1>
    </a>
    
  </div>
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Basic Info ── -->
    <div class="section-block">
      <div class="section-header">
       <span class="section-title">Change Password</span>

        {{-- Success/Error Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      </div>
     <form action="{{ route('update_password', $user_details->id) }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $user_details->id }}">

        <div class="form-row">
            <div class="form-group">
               <label class="form-label">Old Password </label>	
               <input type="password" id="password" name="old_password" value="{{ $user_details->plain_password }}" placeholder="Old Password"  class="form-input" readonly>  
               <i class="bi bi-eye-slash" id="pwdIcon"></i>           
            </div>
            <div class="form-group">
                <label class="form-label">New Password</label>			
                <input type="password" name="new_password" placeholder="New Password (min 8 characters)"  class="form-input" required>           
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
              <label class="form-label">Confirm New Password </label>				
              <input type="password" name="confirm_password" placeholder="Confirm New Password"  class="form-input" required>
            </div>
        </div>
        <div class="section-block text-end">
           <a type="button" class="btn-cancel" onclick="window.location='{{ route('dashboard') }}'">Cancel</a>		
           <button type="submit" class="btn-save">Save</button>
        </div>
    </form>
  </div><!-- /detail-card -->
</main>

@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
	const pwdInput = document.getElementById('password');
	const pwdIcon = document.getElementById('pwdIcon');

	pwdIcon.addEventListener('click', function () {
		// Toggle the type attribute
		const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
		pwdInput.setAttribute('type', type);
		// Toggle the icon class
		this.classList.toggle('bi-eye');
		this.classList.toggle('bi-eye-slash');
	});
</script>
