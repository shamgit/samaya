@include('layouts.header')
@include('layouts.sidebar')
<style>
 .error {
     color: red;
 }
  #dt-search-0 {
  display: none;
}
.dt-search{
	display: none;
}

.tab-wrapper{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.tab-btn{
    border:none;
    padding:10px 18px;
    border-radius:8px;
    background:#e9ecef;
    cursor:pointer;
    font-weight:600;
}

.tab-btn.active{
    background:#0d6efd;
    color:#fff;
}

.tab-content{
    display:none;
}

.tab-content.active{
    display:block;
}

</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
    <!-- ══════════ PAGE HEADER ══════════ -->
    <div class="page-header">
        <h1 class="page-title">Designations & Designation Access Menus</h1>
       
        <div class="header-actions">
          <button class="btn-add" data-bs-toggle="modal" data-bs-target="#masteradd">
            <i class="bi bi-plus-lg"></i>
            <span class="add-txt">Add Designation</span>
        </button>   
        <a href="{{ route('designation_add') }}"><button class="btn-add" >
            <i class="bi bi-plus-lg"></i>
           <span class="add-txt">Add Designation Access Menu</span>
        </button></a>
        </div>
    </div>

    <!-- ══════════ FILTER BAR ══════════ -->
    <div class="filter-bar">
        <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" class="search-input" id="searchInput" placeholder="Search"/>
        </div>
        <select class="filter-select" id="categoryFilter">
            <option value="">Designation: All</option>
            @foreach($designations as $designation)
            <option value="{{ $designation->designation_id }}">
                {{ $designation->name }}
            </option>
            @endforeach
        </select>
        <select class="filter-select" id="user_Filter">
            <option value="">Name: All</option>
            @foreach($users as $user)
            <option value="{{ $user->id }}">
                {{ $user->name }}
            </option>
            @endforeach
        </select>
        <select class="filter-select" id="sortFilter">
        <option value="recent">Sort By: Recent</option>
        <option value="name">Sort By: Name</option>
        <option value="sno">Sort By: S.No</option>
        </select>
    </div>

  <!-- ══════════ TAB BUTTONS ══════════ -->
<div class="tab-wrapper">

    <button class="tab-btn active" data-tab="designationTab">
        Designations
    </button>

    <button class="tab-btn" data-tab="designationAccessTab">
        Designation Access Menus
    </button>

</div>

<!-- ══════════ TAB 1 : DESIGNATION ══════════ -->
<div class="tab-content active" id="designationTab">

    <div class="table-card">

        <div class="table-scroll">

            <table class="supplier-table" id="Designation">

                <thead>

                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>

                </thead>

                <tbody class="text-center"></tbody>

            </table>

        </div>

    </div>

</div>

<!-- ══════════ TAB 2 : DESIGNATION ACCESS MENUS ══════════ -->
<div class="tab-content" id="designationAccessTab">

    <div class="table-card">

        <div class="table-scroll">

            <table class="supplier-table" id="DesignationTable">

                <thead>

                    <tr>
                        <th>S.No</th>
                        <th>Name</th>
                        <th>Role Name</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>

                </thead>

                <tbody class="text-center"></tbody>

            </table>

        </div>

    </div>

</div>

    </div><!-- /page-wrap -->
</main>

<!-- Add Masters -->
<div class="modal fade" id="masteradd" tabindex="-1" aria-labelledby="masteraddLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Designation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
        <form  method="POST" action="{{ route('store') }}">
        @csrf
        <div class="modal-body">
        <div class="section-block p-2"> 
            <div class="form-group">
                <label class="form-label">Designation Name <span class="text-danger">*</span></label>
                <input type="text" class="form-input" name="name" required placeholder="Designation Name"/>
            </div>
            <div class="text-end">
                <button class="btn-save">Add</button>
            </div>
            </div>
        </div>
        </form>
    </div>
</div>
</div>

<!-- Edit Designation Modal -->
<div class="modal fade" id="editDesignationModal" tabindex="-1" aria-labelledby="masteraddLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Designation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form  method="POST" action="{{ route('designations_update') }}">
		 @csrf
          <div id="edit_medium_form"></div>
        </form>
    </div>
  </div>
</div>
<!-- Edit Modal -->

@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
  $(document).on('click', '.edit_model_btn', function() {
        var table = $('#Designation').DataTable();
	    var rowData = table.row($(this).closest('tr')).data();
	    var designation_id = rowData.designation_id;
	    // console.log('Delete ID:', designation_id);

        $.ajax({
            url: 'edit/' + designation_id, 
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}" 
            },
            success: function(data) {
                $("#editDesignationModal").modal('show');
                $("#edit_medium_form").html(data);

            },
            error: function(xhr, status, error) {
                // Handle error (e.g., display a message to the user)
                console.error("AJAX Error: " + error);
            }
        });
    });
 });
</script>

<script>

$(document).ready(function () {

    // ═══════════════════════════════════════
    // DESIGNATION TABLE
    // ═══════════════════════════════════════

    let designationTable = $('#Designation').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('designation_list') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.designation_id = $('#categoryFilter').val();

                d.status = $('#statusFilter').val();

                d.sort = $('#sortFilter').val();

                d.search = {
                    value: $('#searchInput').val()
                };
            }
        },

        columns: [

            {
                data: null,

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row, meta) {

                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },

            {
                data: 'name',

                className: 'text-center fw-bold'
            },

            {
                data: 'designation_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                    return `
                       <div class="d-flex gap-2 justify-content-center">
                        <a class="edit_model_btn text-right" data-bs-toggle="modal" data-bs-target="#editRoleModal">
                          <div class="alert alert-secondary py-1 px-2 mb-0" >
                            <i class="bi bi-pencil"></i>
                          </div>
                        </a>
                      </div>
                    `;
                }
            }
        ]
    });




    // ═══════════════════════════════════════
    // DESIGNATION ACCESS MENU TABLE
    // ═══════════════════════════════════════

    let designationAccessTable = $('#DesignationTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('designation_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.user_id = $('#user_Filter').val();

                d.status = $('#statusFilter').val();

                d.sort = $('#sortFilter').val();

                d.search = {
                    value: $('#searchInput').val()
                };
            }
        },

        columns: [

            {
                data: null,

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row, meta) {

                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },

            {
                data: 'user_name',

                className: 'text-center fw-bold'
            },

            {
                data: 'role_name',

                className: 'text-center'
            },

            {
                data: 'designation_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                    return `
                        <div class="action-wrap">

                            <button class="btn-action"
                                    data-id="${row.designation_id}"
                                    onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu"
                                 data-menu="${row.designation_id}">

                                <div class="action-menu-item">

                                    <a href="/designation_edit/${btoa(row.designation_id)}">

                                        <i class="bi bi-pencil"></i> Edit

                                    </a>

                                </div>

                                <div class="action-menu-item delete deleteUserBtn"
                                     data-id="${row.designation_id}">

                                    <i class="bi bi-trash"></i> Delete

                                </div>

                            </div>

                        </div>
                    `;
                }
            }
        ]
    });




    // ═══════════════════════════════════════
    // COMMON FILTERS
    // ═══════════════════════════════════════

    $('#searchInput').keyup(function () {

        designationTable.ajax.reload();

        designationAccessTable.ajax.reload();

    });

    $('#categoryFilter').change(function () {

        designationTable.ajax.reload();

        designationAccessTable.ajax.reload();

    });

    $('#user_Filter').change(function () {

        designationTable.ajax.reload();

        designationAccessTable.ajax.reload();

    });

    $('#sortFilter').change(function () {

        designationTable.ajax.reload();

        designationAccessTable.ajax.reload();

    });
    

    $('#statusFilter').change(function () {

        designationTable.ajax.reload();

        designationAccessTable.ajax.reload();

    });

});

</script>

<script>

$(document).on('click', '.deleteUserBtn', function () {

    let designation_id = $(this).data('id');

    Swal.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('designation_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    designation_id: designation_id
                },

                success: function (response) {

                    if (response.status == true) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Deleted!',

                            text: response.message,

                            timer: 2000,

                            showConfirmButton: false

                        });

                        $('#DesignationTable').DataTable().ajax.reload();

                    } else {

                        Swal.fire({

                            icon: 'error',

                            title: 'Oops...',

                            text: response.message
                        });
                    }
                },

                error: function () {

                    Swal.fire({

                        icon: 'error',

                        title: 'Server Error',

                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });

});

</script>

<script>

/* ══════════════════════════════
   ACTION MENU
══════════════════════════════ */
function toggleMenu(btn, e) {
  e.stopPropagation();
  const id   = btn.dataset.id;
  const menu = document.querySelector(`.action-menu[data-menu="${id}"]`);
  const isOpen = menu.classList.contains('open');
  closeAllMenus();
  if (!isOpen) {
    menu.classList.add('open');
    btn.classList.add('open');
    openMenu = id;
  }
}
function closeAllMenus() {
  document.querySelectorAll('.action-menu.open').forEach(m => m.classList.remove('open'));
  document.querySelectorAll('.btn-action.open').forEach(b => b.classList.remove('open'));
  openMenu = null;
}
document.addEventListener('click', closeAllMenus);


</script>
<script>

$(document).ready(function () {

    $(".tab-btn").click(function () {

        $(".tab-btn").removeClass("active");

        $(this).addClass("active");

        $(".tab-content").removeClass("active");

        $("#" + $(this).data("tab")).addClass("active");

    });

});

</script>