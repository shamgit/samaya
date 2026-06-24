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
      <h1 class="page-title">Attendance Management</h1>
	   <div class="header-actions">
		   <a href="{{ route('attendance_excel') }}"><button class="btn-export" >
			<span>Export</span>
			<i class="bi bi-chevron-down"></i>
		  </button></a>
		  <a href="{{ route('mark_daily_attendance') }}"><button class="btn-add" >
			<span class="add-txt">Mark Daily Attendance</span>
		  </button></a>
		  <a href="{{ route('absence_tracking') }}"><button class="btn-add" >
			<span class="add-txt">Absence Tracking</span>
		  </button></a>
		</div>
  </div>

  <!-- STAT CARDS -->
  <div class="row g-3">
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-purple d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
		<div>
			<div class="stat-label">Total Employees</div>
			<div class="stat-value">{{$employee_count ?? ''}}</div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-blue d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
		<div>
			<div class="stat-label">Present Today</div>
			<div class="stat-value">{{$present_count ?? ''}}</div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-green d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-clipboard-check-fill"></i></div>
		<div>
			<div class="stat-label">On Leave</div>
			<div class="stat-value">{{$leave_count ?? ''}}</div>
		</div>	
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-pink d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-x-circle-fill"></i></div>
		<div>
			<div class="stat-label">Absent</div>
			<div class="stat-value" >{{$absent_count ?? ''}}</div>
		</div>	
      </div>
    </div>
  </div>
  
  
   
</div>

 
  <!-- ══════════ FILTER BAR ══════════ -->
   <div class="filter-bar">
    <div class="search-wrap">
      <i class="bi bi-search search-icon"></i>
      <input type="text" class="search-input" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Search"/>
    </div>
    <select class="filter-select" id="categoryFilter">
      <option value="">Department: All</option>
         @foreach($departments as $department)
          <option value="{{ $department->department_id }}">
              {{ $department->name }}
          </option>
        @endforeach
    </select>
    @if(Auth::user()->role_id != 4)
      <select class="filter-select" id="statusFilter">
      <option value="">Status: All</option>
        @foreach($attendance_status as $attendance_statu)
            <option value="{{ $attendance_statu->attendance_statu_id }}">
                {{ $attendance_statu->attendance_status_name }}
            </option>
        @endforeach
      </select>
    @endif
    <select class="filter-select" id="sortFilter">
      <option value="recent">Sort By: Recent</option>
      <option value="name">Sort By: Name</option>
      <option value="sno">Sort By: S.No</option>
    </select>
  </div>

  
   <!-- ══════════ TABLE CARD ══════════ -->
  <div class="table-card">
    <div class="table-scroll">
      <table class="supplier-table" id="attendanceTable">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Employee Name </th>
            <th>Department</th>
            <th>Attendance Date
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
            <th style="text-align:center;">Actions</th>
          </tr>
        </thead>
        
		    <tbody></tbody>
		
      </table>

  </div>
  </div>


</div><!-- /page-wrap -->

</main>

@include('layouts.footer')

@include('layouts.scripts')


<script>

$(document).ready(function () {

    let table = $('#attendanceTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('attendance_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.department_id = $('#categoryFilter').val();

                d.attendance_statu_id = $('#statusFilter').val();

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
                className: 'text-center'
            },

            {
                data: 'attendance_date',

                className: 'text-center',

                render: function(data){

                    if(data){

                        return moment(data).format('DD MMM YYYY');

                    }

                    return '-';
                }
            },
            {
              data: 'check_in',

              className: 'text-center',

              render: function(data){

                  if(data){

                      return moment(data, "HH:mm:ss")
                          .format("hh:mm A");

                  }

                  return '-';
              }
          },

          {
              data: 'check_out',

              className: 'text-center',

              render: function(data){

                  if(data){

                      return moment(data, "HH:mm:ss")
                          .format("hh:mm A");

                  }

                  return '-';
              }
          },

            {
                data: 'name',

                className: 'text-center',

                render: function(data){

                if(data == 'Present'){

                      return `
                          <span class="badge-status badge-active">
                              Present
                          </span>
                      `;

                  }
                 if (data == 'Late') {

                    return `
                        <span class="badge-status badge-denied">
                          Late
                        </span>
                      `;
                  }  
                  if (data == 'Absent') {

                      return `
                          <span class="badge-status badge-inactive">
                              Absent
                          </span>
                      `;

                  } 

                  if (data == 'Half Day') {  

                   return `
                      <span class="badge-status badge-info">
                        Half Day
                      </span>
                       `;

                     } 
                }
            },

            {
                data: 'attendance_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                  let deleteButton = '';

                    if (userRoleId != 4) {

                        deleteButton = `
                            <div class="action-menu-item delete deleteUserBtn"
                                data-id="${row.attendance_id}">

                                <i class="bi bi-trash"></i> Delete

                            </div>
                        `;
                    }

                    return `
                        <div class="action-wrap">

                            <button class="btn-action"
                                    data-id="${row.attendance_id}"
                                    onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu" data-menu="${row.attendance_id }">

                                <div class="action-menu-item">

                                     <a href="/mark_daily_attendance_edit/${btoa(row.attendance_id)}">

                                        <i class="bi bi-pencil"></i> Edit

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

    let attendance_id = $(this).data('id');

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

                url: "{{ route('attendance_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    attendance_id: attendance_id
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

                        $('#attendanceTable').DataTable().ajax.reload();

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