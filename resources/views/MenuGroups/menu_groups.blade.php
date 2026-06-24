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
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
    <div class="page-header">
      <h1 class="page-title">Menu Groups</h1>
      <div class="header-actions">
        
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#masteradd">
          <i class="bi bi-plus-lg"></i>
          <span class="add-txt">Add Menu Group</span>
        </button>
      </div>
    </div>

  <!-- Add Masters -->
  <div class="modal fade" id="masteradd" tabindex="-1" aria-labelledby="masteraddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Menu Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <form id="createMenuGroupForm" method="POST" action="{{ route('menu_group_store') }}">
            @csrf
            <div class="modal-body">
            <div class="section-block p-2"> 
                <div class="form-group">
                  <label class="form-label">Menu Group Name *</label>
                  <input type="text" class="form-input" name="menu_group_name" required placeholder="Menu Group Name"/>
                </div>
                <div class="form-group">
                  <label class="form-label">Menu Group Icon *</label>
                  <input type="text" class="form-input" name="menu_group_icon" required placeholder="Menu Group Icon"/>
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

    <!-- ══════════ FILTER BAR ══════════ -->
    <div class="filter-bar">
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" class="search-input" id="searchInput" placeholder="Search"/>
      </div>
      <select class="filter-select" id="categoryFilter">
        <option value="">Menu Group: All</option>
        @foreach($menu_groups as $menu_group)
          <option value="{{ $menu_group->menu_group_id }}">
              {{ $menu_group->menu_group_name }}
          </option>
        @endforeach
      </select>
    
      <select class="filter-select" id="sortFilter">
        <option value="recent">Sort By: Recent</option>
        <option value="name">Sort By: Name</option>
        <option value="sno">Sort By: S.No</option>
      </select>
    </div>

    <!-- ══════════ TABLE CARD ══════════ -->
    <div class="table-card">
      <div class="table-scroll">
        <table class="supplier-table" id="MenuGroupTable">
          <thead>
            <tr>
              <th>Menu Group ID</th>
              <th>Menu Group Name</th>
              <th>Created By</th>
              <th>Ctreate At</th>
              <th>Updated By</th>
              <th>Updated At</th>
              <th style="text-align:center;">Actions</th>
            </tr>
          </thead>
          
          <tbody class="text-center">    
          </tbody>
      
        </table>
    </div>
  </div>
</main>

<!-- Edit Role Modal -->
<div class="modal fade" id="editMenuGroupModal" tabindex="-1" aria-labelledby="masteraddLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Menu Group</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form  method="POST" action="{{ route('menu_group_updated') }}">
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
$(document).ready(function () {

    let table = $('#MenuGroupTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('menu_group_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";
                d.menu_group_id = $('#categoryFilter').val();
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
                data: 'menu_group_name',
                className: 'text-center fw-bold'
            },

            {
                data: 'created_by',
                className: 'text-center',

                render: function(data){

                    return data ?? 'Admin';
                }
            },

            {
                data: 'created_at',
                className: 'text-center',

                render: function(data){

                    return moment(data).format('DD MMM YYYY');
                }
            },

            {
                data: 'updated_by',
                className: 'text-center',

                render: function(data){

                    return data ?? '-';
                }
            },

            {
                data: 'updated_at',
                className: 'text-center',

                render: function(data){

                    return moment(data).format('DD MMM YYYY');
                }
            },

            {
                data: 'menu_group_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data) {

                    return `
                      <div class="d-flex gap-2">
                        <a class="edit_model_btn" data-bs-toggle="modal" data-bs-target="#editRoleModal">
                          <div class="alert alert-secondary py-1 px-2 mb-0" >
                            <i class="bi bi-pencil"></i>
                          </div>
                        </a>
                        <div class="alert alert-danger py-1 px-2 mb-0 deleteRoleBtn" role="alert"  data-id="${data}" style="cursor:pointer;">
                          <i class="bi bi-trash"></i>
                        </div>
                      </div>
                      
                     
                        
                    `;
                }
            }
        ]
    });

    $('#categoryFilter').change(function () {

        table.ajax.reload();
    });

    $('#sortFilter').change(function () {

        table.ajax.reload();
    });

     $('#searchInput').keyup(function () {

        table.ajax.reload();

    });

});

</script>


<script>
$(document).ready(function() {
  $(document).on('click', '.edit_model_btn', function() {
        var table = $('#MenuGroupTable').DataTable();
	    var rowData = table.row($(this).closest('tr')).data();
	    var menu_group_id = rowData.menu_group_id;
	    // console.log('Delete ID:', menu_group_id);

        $.ajax({
            url: 'menu_group_edit/' + menu_group_id, 
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}" 
            },
            success: function(data) {
                $("#editMenuGroupModal").modal('show');
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



$(document).on('click', '.deleteRoleBtn', function () {

    let menu_group_id = $(this).data('id');

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

                url: "{{ route('menu_group_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    menu_group_id: menu_group_id
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

                        $('#MenuGroupTable').DataTable().ajax.reload();

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
 $(document).ready(function () {      
   $('#createMenuGroupForm').validate({
       rules: {
           menu_group_name: {
               required: true
           },
            menu_group_icon: {
               required: true
           }
       },
       messages: {
           menu_group_name: "Please enter a menu group name"
       },
        messages: {
           menu_group_icon: "Please enter a menu group icon"
       }
   });
});
</script>


