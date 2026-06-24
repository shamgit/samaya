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
        <h1 class="page-title">Admin Users</h1>
        <div class="header-actions">
        <a href="{{ route('user_add') }}"><button class="btn-add" >
            <i class="bi bi-plus-lg"></i>
            <span class="add-txt">Add Admin User</span>
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
            <option value="">Role: All</option>
            @foreach($roles as $role)
            <option value="{{ $role->role_id }}">
                {{ $role->role_name }}
            </option>
            @endforeach
        </select>
        <select class="filter-select" id="statusFilter">
        <option value="">Status: All</option>
        <option value="status"hidden>Status</option>
        <option value="1">Status: Active</option>
        <option value="2">Status: Inactive</option>
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
        <table class="supplier-table" id="usersTable">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role Name</th>
                    <th>Status</th>
                    <th style="text-align:center;">Actions</th>
                </tr>
            </thead>

            <tbody class="text-center"></tbody>

        </table>
        </div>
    </div>

    </div><!-- /page-wrap -->
</main>

@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$(document).ready(function () {

    let table = $('#usersTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('users_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.role_id = $('#categoryFilter').val();

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
                data: 'email',
                className: 'text-center'
            },

            {
                data: 'phone',
                className: 'text-center',

                render: function(data){

                    return data ?? '-';
                }
            },

            {
                data: 'role_name',
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
                data: 'id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                    return `
                        <div class="action-wrap">

                            <button class="btn-action"
                                    data-id="${row.id}"
                                    onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu" data-menu="${row.id}">

                                <div class="action-menu-item">

                                     <a href="/user_edit/${btoa(row.id)}">

                                        <i class="bi bi-pencil"></i> Edit

                                    </a>

                                </div>

                                <div class="action-menu-item" data-menu="${row.id}">

                                    <a href="/user_view/${btoa(row.id)}">

                                        <i class="bi bi-eye"></i> View

                                    </a>

                                </div>

                                <div class="action-menu-item delete deleteUserBtn"  data-id="${row.id}">

                                    <i class="bi bi-trash"></i> Delete

                                </div>

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

$(document).on('click', '.deleteUserBtn', function () {

    let user_id = $(this).data('id');

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

                url: "{{ route('users_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    user_id: user_id
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

                        $('#usersTable').DataTable().ajax.reload();

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