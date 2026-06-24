@include('layouts.header')
@include('layouts.sidebar')

<style>
.password-wrap{
    position: relative;
}

.password-wrap .form-input{
    padding-right: 45px;
}

.password-toggle{
    position: absolute;
    right: 15px;
    top: 43px;
    border: none;
    background: transparent;
    cursor: pointer;
    padding: 0;
    color: #6c757d;
    font-size: 18px;
}

.password-toggle:hover{
    color: #111;
}
.error-text{
    color:#dc3545;
    font-size:13px;
    margin-top:5px;
    display:block;
}

.is-invalid{
    border:1px solid #dc3545 !important;
}
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('users') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Add Admin User</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Basic Info ── -->
    <div class="section-block">
      <div class="section-header">
    
      </div>
      <form id="userForm" method="POST" action="{{ route('users_store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-row">

            <div class="form-group">

                <label class="form-label">Name  <span class="text-danger">*</span></label>

                <input
                    type="text"
                    class="form-input"
                    id="name"
                    name="name"
                    placeholder="Enter  Name" 
                >

                <span class="error-text" id="name_error"></span>

            </div>

            <div class="form-group">

                <label class="form-label">Email  <span class="text-danger">*</span></label>

                <input
                    type="email"
                    class="form-input"
                    id="email"
                    name="email"
                    autocomplete="off"
                    placeholder="Enter Email" 
                >

                <span class="error-text" id="email_error"></span>

            </div>

        </div>

        <div class="form-row">

            <div class="form-group">

                <label class="form-label">Phone  <span class="text-danger">*</span></label>

                <input
                    type="text"
                    class="form-input"
                    id="phone"
                    name="phone"
                    placeholder="Enter Phone Number" 
                >

                <span class="error-text" id="phone_error"></span>

            </div>

            <div class="form-group password-wrap">

                <label class="form-label">Password  <span class="text-danger">*</span></label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-input"
                    autocomplete="new-password" 
                    placeholder="Password"
                >

                <button
                    type="button"
                    class="password-toggle"
                    id="pwdToggle"
                >
                    <i class="bi bi-eye-slash" id="pwdIcon"></i>
                </button>

                <span class="error-text" id="password_error"></span>

            </div>

        </div>

        <div class="form-row">

            <div class="form-group">

                <label class="form-label">Role  <span class="text-danger">*</span></label>

                <select class="form-input" id="role_id" name="role_id">

                    <option value="">Select Role</option>

                    @foreach($roles as $role)

                        <option value="{{ $role->role_id }}">
                            {{ $role->role_name }}
                        </option>

                    @endforeach

                </select>

                <span class="error-text" id="role_error"></span>

            </div>

            <div class="form-group">

                <label class="form-label">Status  <span class="text-danger">*</span></label>

                <select class="form-input" id="status" name="status">

                    <option value="">Select Status</option>

                    <option value="1">Active</option>

                    <option value="2">Inactive</option>

                </select>

                <span class="error-text" id="status_error"></span>

            </div>

        </div>
        <div class="form-row">			
			<div class="form-group">
			  <label class="form-label">Profile Image  <span class="text-danger">*</span></label>
			  <div class="input-group date_picker file_btn">
				<input type="text" class="form-control" placeholder="Profile Image" id="fileName"  readonly="">
				<input type="file" class="d-none"  name="profile" id="fileInput">
				<button class="btn btn-primary" type="button" onclick="document.getElementById('fileInput').click()">
				  Profile Image
				</button>
			  </div>
               <div class="mt-2"><img id="previewImage" src="{{asset('assets/img/images.jpg')}}" style="width:80px;height:80px;border-radius:6px;object-fit:cover;border:1px solid #ddd;"></div>
			</div>
		</div>

      

        <div class="section-block text-end">

            <a type="button"
                    class="btn-cancel"
                    onclick="window.location='{{ route('users') }}'">

                Cancel

            </a>


            <button
                type="submit"
                class="btn-save"
            >
                Save
            </button>

        </div>

    </form>
   
    

  </div><!-- /detail-card -->
  
  
</main>

@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$(document).ready(function () {

    // Password Toggle
    $('#pwdToggle').click(function () {

        let password = $('#password');

        let icon = $('#pwdIcon');

        if(password.attr('type') === 'password'){

            password.attr('type', 'text');

            icon.removeClass('bi-eye-slash');

            icon.addClass('bi-eye');

        } else {

            password.attr('type', 'password');

            icon.removeClass('bi-eye');

            icon.addClass('bi-eye-slash');
        }
    });

    // File Name Show
    $('#fileInput').change(function () {

        if (this.files && this.files[0]) {

            $('#fileName').val(this.files[0].name);

            let reader = new FileReader();

            reader.onload = function (e) {

                $('#previewImage').attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
    });

    // Validation
    $('#userForm').validate({

        rules: {

            name: {
                required: true
            },

            email: {
                required: true,
                email: true
            },

            phone: {
                required: true,
                minlength: 10,
                maxlength: 10,
                digits: true
            },

            password: {
                required: true,
                minlength: 8
            },

            role_id: {
                required: true
            },

            status: {
                required: true
            },

            profile: {
                required: true
            }
        },

        messages: {

            name: {
                required: "Please enter user name"
            },

            email: {
                required: "Please enter email",
                email: "Please enter valid email"
            },

            phone: {
                required: "Please enter phone number",
                minlength: "Phone must be 10 digits",
                maxlength: "Phone must be 10 digits",
                digits: "Only numbers allowed"
            },

            password: {
                required: "Please enter password",
                minlength: "Minimum 8 characters required"
            },

            role_id: {
                required: "Please select role"
            },

            status: {
                required: "Please select status"
            },

            profile: {
                required: ""
            }
        },

        errorElement: 'span',

        errorClass: 'error-text',

        highlight: function(element){

            $(element).addClass('is-invalid');
        },

        unhighlight: function(element){

            $(element).removeClass('is-invalid');
        },

        submitHandler: function(form){

            form.submit();
        }

    });

});

</script>
