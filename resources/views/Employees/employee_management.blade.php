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
    <h1 class="page-title">Employee Management</h1>
    <div class="header-actions">
      <a href="{{ route('employee_excel') }}"><button class="btn-export" >
        <span>Export</span>
        <i class="bi bi-chevron-down"></i>
      </button></a>
      @if(Auth::user()->role_id != 4)
      <a href="{{ route('employee_add') }}"><button class="btn-add" >
        <i class="bi bi-plus-lg"></i>
        <span class="add-txt">Add Employee</span>
      </button></a>
      @endif
    </div>
  </div>

  <!-- ══════════ FILTER BAR ══════════ -->
  <div class="filter-bar">
    <div class="search-wrap">
      <i class="bi bi-search search-icon"></i>
      <input type="text" class="search-input" id="searchInput" placeholder="Search"/>
    </div>
    <select class="filter-select" id="categoryFilter">
      <option value="">Department: All</option>
        @foreach($departments as $department)
          <option value="{{ $department->department_id }}">
              {{ $department->name }}
          </option>
        @endforeach
    </select>
    <select class="filter-select" id="statusFilter">
	  <option value="">Status: All</option>
      <option value="1">Status: Active</option>
      <option value="0">Status: Inactive</option>
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
      <table class="supplier-table" id="employeetable">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Name </th>
            <th>Department</th>
            <th>Designation</th>
            <th>Joining Date</th>
            <th>Contact</th>
            <th>Status</th>
            <th style="text-align:center;">Actions</th>
          </tr>
        </thead>
        
        <tbody>
      
        </tbody>
        
      </table>

  </div>

</div><!-- /page-wrap -->

</main>
@include('layouts.footer')

@include('layouts.scripts')

<script>
$(document).ready(function () {

    let table = $('#employeetable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('employee_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.department_id = $('#categoryFilter').val();

                d.status = $('#statusFilter').val();

                d.sort = $('#sortFilter').val();

                d.search = {
                    value: $('#searchInput').val()
                };
            }
        },

        columns: [
            {
                data: 'employee_code',
                className: 'text-center'
            },

            {
                data: 'employee_name',
                className: 'text-center fw-bold'
            },

            {
                data: 'department_name',
                className: 'text-center',

            },

            {
                data: 'name',
                className: 'text-center'
            },

              {
                data: 'joining_date',
                className: 'text-center'
            },


            {
                data: 'phone',
                className: 'text-center'
            },

            {
                data: 'status',
                className: 'text-center',

                render: function(data){

                    if(data == 1){

                        return `
                           <span class="badge-status badge-active">
                                Active
                            </span>
                        `;
                    }

                    return `
                        <span class="badge-status badge-inactive">
                            Inactive
                        </span>
                    `;
                }
            },

            {
                data: 'employee_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                    let deleteButton = '';

                    if (userRoleId != 4) {

                        deleteButton = `
                            <div class="action-menu-item delete deleteUserBtn"
                                data-id="${row.employee_id}">

                                <i class="bi bi-trash"></i> Delete

                            </div>
                        `;
                    }

                    return `
                        <div class="action-wrap">

                            <button class="btn-action"
                                    data-id="${row.employee_id}"
                                    onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu" data-menu="${row.employee_id}">

                                <div class="action-menu-item">

                                    <a href="/employee_edit/${btoa(row.employee_id)}">

                                        <i class="bi bi-pencil"></i> Edit

                                    </a>

                                </div>

                                <div class="action-menu-item">

                                    <a href="/employee_view/${btoa(row.employee_id)}">

                                        <i class="bi bi-eye"></i> View

                                    </a>

                                </div>

                                ${deleteButton}

                            </div>

                        </div>
                    `;
                }
            }
        ]
    });

    // Search
    $('#searchInput').keyup(function () {

        table.ajax.reload();

    });

    // Role Filter
    $('#categoryFilter').change(function () {

        table.ajax.reload();

    });

    // Sort Filter
    $('#sortFilter').change(function () {

        table.ajax.reload();

    });

     
    $('#statusFilter').change(function () {

        table.ajax.reload();

    });

});
</script>
<script>

    let userRoleId = "{{ Auth::user()->role_id }}";

</script>
<script>

$(document).on('click', '.deleteUserBtn', function () {

    let employee_id = $(this).data('id');

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

                url: "{{ route('employee_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    employee_id: employee_id
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

                        $('#employeetable').DataTable().ajax.reload();

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