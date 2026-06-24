@include('layouts.header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')
<style>
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
      <h1 class="page-title">Time Tracking</h1>
	   <div class="header-actions">
		 <a href="{{ route('time_entry_excel') }}"><button class="btn-export" >
			<span>Export</span>
			<i class="bi bi-chevron-down"></i>
		  </button></a>
		  <a href="{{ route('time_entry_add') }}"><button class="btn-add" >
			<i class="bi bi-plus-lg"></i><span class="add-txt">Add Time Entry</span>
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
      <option value="">Employee: All</option>
         @foreach($employees as $employee)
            <option value="{{ $employee->employee_id }}">
                {{ $employee->employee_name }}
            </option>
        @endforeach
    </select>
    <div class="input-group date_picker" style="width:150px;">
				<input type="text" class="form-control"  name="form_date" id="f_requestDate" placeholder="Select date" readonly />
				<span class="input-group-text bg-white">
				  <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
				</span>
		</div>
    <select class="filter-select" id="sortFilter">
      <option value="recent">Sort By: Recent</option>
      <option value="name">Sort By: Name</option>
      <option value="sno">Sort By: S.No</option>
    </select>
  </div>

  
   <!-- ══════════ TABLE CARD ══════════ -->
  <div class="table-card">
    <div class="table-scroll">
      <table class="supplier-table" id="TimeEntrytable">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Employee </th>
            <th>Project / Task</th>
            <th>Work Hours</th>
            <th>Date</th>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 

<script>


$(document).ready(function () {

    // Flatpickr
    flatpickr("#f_requestDate", {

        dateFormat: "d M Y",

        defaultDate: "all"
    });

    // DataTable
    let table = $('#TimeEntrytable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('time_entry_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.employee_id = $('#categoryFilter').val();

                d.sort = $('#sortFilter').val();

                // Date Filter
                d.form_date = $('#f_requestDate').val();

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
                data: 'project_task',
                className: 'text-center',

                render: function(data){

                    return data ?? '-';
                }
            },

            {
                data: 'total_work_hours',
                className: 'text-center'
            },

            {
                data: 'form_date',
                className: 'text-center'
            },

            {
                data: 'time_tracking_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data, type, row) {

                   let deleteButton = '';

                    if (userRoleId != 4) {

                        deleteButton = `
                            <div class="action-menu-item delete deleteUserBtn"
                                data-id="${row.time_tracking_id}">

                                <i class="bi bi-trash"></i> Delete

                            </div>
                        `;
                    }

                    return `
                        <div class="action-wrap">

                            <button class="btn-action"
                                    data-id="${row.time_tracking_id}"
                                    onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu"
                                 data-menu="${row.time_tracking_id}">

                                <div class="action-menu-item">

                                    <a href="/time_entry_edit/${btoa(row.time_tracking_id)}">

                                        <i class="bi bi-pencil"></i> Edit

                                    </a>

                                </div>

                                <div class="action-menu-item">

                                    <a  href="/time_entry_view/${btoa(row.time_tracking_id)}">

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

    // Date Filter
    $('#f_requestDate').change(function () {

        table.ajax.reload();

    });

});

</script>
<script>

    let userRoleId = "{{ Auth::user()->role_id }}";

</script>

<script>

$(document).on('click', '.deleteUserBtn', function () {

    let time_tracking_id = $(this).data('id');

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

                url: "{{ route('time_tracking_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    time_tracking_id: time_tracking_id
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

                        $('#TimeEntrytable').DataTable().ajax.reload();

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

flatpickr("#dateRangePicker", {
  mode: "range", dateFormat: "d M Y",
  defaultDate: ["2026-03-01","2026-04-30"],
  onChange(selectedDates) {
    if (selectedDates.length === 2) {
      const fmt = d => parseInt(d.getFullYear()*10000+(d.getMonth()+1)*100+d.getDate());
      window._fromDate = fmt(selectedDates[0]);
      window._toDate   = fmt(selectedDates[1]);
    } else { window._fromDate = null; window._toDate = null; }
    filterRows();
  }
});
flatpickr("#f_requestDate", { dateFormat: "d M Y", defaultDate: "all" });
flatpickr("#f_requiredDate", { dateFormat: "d M Y" });

window._fromDate = 20260301;
window._toDate   = 20260430;
filterRows();


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