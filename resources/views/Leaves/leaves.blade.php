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
.badge-danger {
    background-color: red;
}
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Leaves</h1>
    @if(Auth::user()->role_id != 1)
    <div class="header-actions">
      <a href="{{ route('leave_add') }}"><button class="btn-add" >
        <i class="bi bi-plus-lg"></i>
        <span class="add-txt">Add Leave</span>
      </button></a>
    </div>
    @endif
  </div>


  <!-- ══════════ FILTER BAR ══════════ -->
  <div class="filter-bar">
    <div class="search-wrap">
      <i class="bi bi-search search-icon"></i>
      <input type="text" class="search-input" id="searchInput" placeholder="Search"/>
    </div>
    <select class="filter-select" id="categoryFilter">
      <option value="">Leave Types: All</option>
        @foreach($leave_types as $leave_type)
          <option value="{{ $leave_type->leave_type_id }}">
              {{ $leave_type->name }}
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
      <table class="supplier-table" id="Leavestable">
        <thead>
          <tr>
            <th>Leave ID</th>
            <th>Employee </th>
            <th>Employee Code</th>
            <th>Leave Type</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Manager Approval</th>
            <th>Status</th>
            <th style="text-align:center;">Actions</th>
          </tr>
        </thead>
        
		   <tbody></tbody>
		
      </table>
    
  </div>

</div><!-- /page-wrap -->

</main>

@include('layouts.footer')

@include('layouts.scripts')

<script>
$(document).ready(function () {
    let table = $('#Leavestable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('leave_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.leave_type_id = $('#categoryFilter').val();

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
                data: 'employee_name',
                className: 'text-center fw-bold',
            },

            {
                data: 'employee_code',
                className: 'text-center'
            },

            {
                data: 'leave_type_name',
                className: 'text-center',

            },

            {
                data: 'from_date',
                className: 'text-center',
            },

            {
                data: 'to_date',
                className: 'text-center',
            },

            {
                data: 'manager_name',
                className: 'text-center',
            },

            {
                data: 'leave_status',
                className: 'text-center',

                render: function(data){

                    if(data == 1){

                        return `
                            <span class="badge-status badge-inactive">
                                Pending
                            </span>
                        `;
                    }

                    else if(data == 2){

                        return `
                            <span class="badge-status badge-active">
                                Approved
                            </span>
                        `;
                    }

                    else if(data == 3){

                        return `
                            <span class="badge-status badge-danger">
                                Rejected
                            </span>
                        `;
                    }

                    else{

                        return `
                            <span class="badge-status">
                                Unknown
                            </span>
                        `;
                    }
                }
            },

            {
                data: 'leave_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                   let deleteButton = '';

                    if (userRoleId != 4) {

                        deleteButton = `
                            <div class="action-menu-item delete deleteUserBtn"
                                data-id="${row.leave_id}">

                                <i class="bi bi-trash"></i> Delete

                            </div>
                        `;
                    }

                    return `
                        <div class="action-wrap">

                            <button class="btn-action"
                                    data-id="${row.leave_id }"
                                    onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu"
                                 data-menu="${row.leave_id }">

                                <div class="action-menu-item">

                                    <a href="/leave_edit/${btoa(row.leave_id)}">

                                        <i class="bi bi-pencil"></i> Edit

                                    </a>

                                </div>

                                <div class="action-menu-item">

                                    <a  href="/leave_view/${btoa(row.leave_id)}">

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

    // Search Filter
    $('#searchInput').keyup(function () {

        table.ajax.reload();

    });

    // Employee Filter
    $('#categoryFilter').change(function () {

        table.ajax.reload();

    });

    // Sort Filter
    $('#sortFilter').change(function () {

        table.ajax.reload();

    });

});

</script>
<script>

    let userRoleId = "{{ Auth::user()->role_id }}";

</script>
<script>

$(document).on('click', '.deleteUserBtn', function () {

    let leave_id = $(this).data('id');

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

                url: "{{ route('leave_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    leave_id: leave_id
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

                        $('#Leavestable').DataTable().ajax.reload();

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














