@include('layouts.header')

@include('layouts.sidebar')

<!-- ════════════════════════════════
     MAIN CONTENT
═════════════════════════════════ -->
<main class="main-content">

    <!-- ══════════ PAGE HEADER ══════════ -->
    <div class="page-header">

        <a href="{{ route('designations') }}" class="back-title">

            <h1 class="page-title">
                <i class="bi bi-chevron-left"></i>
                Add Designation Access Menu
            </h1>

        </a>

    </div>

    <!-- ══════════ DETAIL CARD ══════════ -->
    <div class="detail-card">

        <div class="section-block">

            <form id="DesignationForm"
                  method="POST"
                  action="{{ route('designation_store') }}"
                  enctype="multipart/form-data">

                @csrf

                <!-- Row -->
                <div class="form-row">
                    
                  <!-- User -->
                    <div class="form-group">

                        <label class="form-label">Name  <span class="text-danger">*</span></label>

                        <select
                            class="form-input"
                            id="user_id"
                            name="user_id" required 
                        >

                            <option value="">
                                Select Name
                            </option>

                            @foreach($users as $user)

                                <option value="{{ $user->id }}">

                                    {{ $user->name }}

                                </option>

                            @endforeach

                        </select>

                     

                    </div>

                      <div class="form-group">

                        <label class="form-label"> Role  <span class="text-danger">*</span></label>

                        <select
                            class="form-input"
                            id="role_id"
                            name="role_id" required 
                        >

                            <option value="">
                                Select Role
                            </option>

                            @foreach($roles as $role)
                                <option value="{{ $role->role_id }}">

                                    {{ $role->role_name }}

                                </option>

                            @endforeach

                        </select>

                      
                    </div>
                    
                    <!-- Designation Name -->
                    <!-- <div class="form-group">

                        <label class="form-label">
                            Designation Name *
                        </label>

                        <input
                            type="text"
                            class="form-input"
                            name="name"
                            placeholder="Enter Designation Name" required
                        >

                      

                    </div> -->

                    <!-- Description -->
                    

                </div>

                <!-- Row -->
                <div class="form-row">

                   <!-- Access Menus -->
                    <div class="form-group">

                        <label class="form-label"> Access Menus <span class="text-danger">*</span></label>

                        <select
                            class="form-input"
                            id="access_menus"
                            name="access_menus[]"
                            multiple 
                        >

                            @foreach($menus as $menu)

                                <option value="{{ $menu->menu_id }}">

                                    {{ $menu->menu_name }}

                                </option>

                            @endforeach

                        </select>

                       
                    </div>


                    <!-- Role -->
                  

                    <div class="form-group">

                        <label class="form-label">
                            Description
                        </label>

                        <input
                            type="text"
                            class="form-input"
                            id="description"
                            name="description"
                            placeholder="Enter Description"
                        >

                      

                    </div>

                </div>

                <!-- Buttons -->
                <div class="section-block text-end">

                    <a
                        type="button"
                        class="btn-cancel"
                        onclick="window.location='{{ route('designations') }}'"
                    >

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

        </div>

    </div>

</main>

@include('layouts.footer')

@include('layouts.scripts')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {

    $('#access_menus').select2({

        placeholder: 'Select Access Menus',

        width: '100%'
    });

});
</script>
<script>

$("#user_id").change(function () {

    let user_id = $(this).val();

    $.ajax({

        url: "{{ route('get_user_details') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            user_id: user_id,

        },

        success: function (response) {

            console.log(response);

            if (response.status == true) {

                // DESIGNATION NAME
                $("#name").val(
                    response.designations?.name ?? ''
                );

                // ROLE SELECT
                $("#role_id").val(
                    response.role_id ?? ''
                );
            }
        }

    });

});

</script>