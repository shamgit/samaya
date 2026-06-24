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
		<a href="{{ route('attendance_management') }}" class="back-title">
		    <h1 class="page-title"><i class="bi bi-chevron-left"></i>Absence Tracking</h1>
		</a>
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
    <select class="filter-select" name="leave_status" id="statusFilter">
	  <option value="" >Status: All</option>
      <option value="1">Status: Pending</option>
      <option value="2">Status: Approved</option>
      <option value="3">Status: Rejected</option>
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
      <table class="supplier-table" id="AbsenceTracking">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Employee </th>
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
  </div>


</div><!-- /page-wrap -->

</main>

@include('layouts.footer')

@include('layouts.scripts')

<script>
$(document).ready(function () {
    let table = $('#AbsenceTracking').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('absence_tracking_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.leave_type_id = $('#categoryFilter').val();

                d.leave_status = $('#statusFilter').val();

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
                className: 'text-center fw-bold',
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

                    return `
                        <div class="action-wrap">
                                <div class="action-menu-item">

                                    <a  href="/absence_tracking_view/${btoa(row.leave_id)}">

                                        <i class="bi bi-eye"></i> View

                                    </a>

                                </div>
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

     $('#statusFilter').change(function () {

        table.ajax.reload();

    });


    // Sort Filter
    $('#sortFilter').change(function () {

        table.ajax.reload();

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