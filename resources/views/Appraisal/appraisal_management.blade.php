@include('layouts.header')
@include('layouts.sidebar')
<style>
.stat-value 
{
    font-size: 25px;
}
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
      <h1 class="page-title">Appraisal Management</h1>
	   <div class="header-actions">
		  <button class="btn-export" >
			<span>Export</span>
			<i class="bi bi-chevron-down"></i>
		  </button>
		  <a href="{{ route('appraisal_evaluation_form') }}"><button class="btn-add" >
			<span class="add-txt">Start Appraisal</span>
		  </button></a>
		</div>
  </div>

  <!-- STAT CARDS -->
  <div class="row g-3">
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-purple d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
		<div>
			<div class="stat-label">Total Employees<br/>Reviewed</div>
			<div class="stat-value">{{$employee_count ?? ''}}</div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-blue d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-wallet-fill"></i></div>
		<div>
			<div class="stat-label">Excellent<br/>Performance</div>
			<div class="stat-value"></div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-green d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-pie-chart-fill"></i></div>
		<div>
			<div class="stat-label">Salary Increment<br/>Recommended</div>
			<div class="stat-value"></div>
		</div>	
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-pink d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
		<div>
			<div class="stat-label">Panding<br/>Review</div>
			<div class="stat-value">{{$panding_count ?? ''}}</div>
		</div>	
      </div>
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
      <option value="">Employee Name: All</option>
       @foreach($employees as $employee)
          <option value="{{ $employee->employee_id }}">
              {{ $employee->employee_name }}
          </option>
        @endforeach
    </select>
    <select class="filter-select" id="DepartmentFilter">
      <option value="">Department: All</option>
       @foreach($departments as $department)
          <option value="{{ $department->department_id }}">
              {{ $department->name }}
          </option>
        @endforeach
    </select>
    <select class="filter-select" id="statusFilter">
	  <option value="">Status: All</option>
      <option value="2">Status: Completed</option>
      <option value="1">Status: Pending</option>
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
      <table class="supplier-table" id="AppraisalTable">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Employee Name </th>
            <th>Department</th>
            <th>Review Period</th>
            <th>Perf.Score</th>
            <th>Increment</th>
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

    let table = $('#AppraisalTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('appraisal_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.employee_id = $('#categoryFilter').val();

                d.department_id = $('#DepartmentFilter').val();

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
                className: 'text-center'
            },

            {
                data: 'review_period',
                className: 'text-center'
            },

            {
                data: 'rating_scale',
                className: 'text-center'
            },


            {
                data: 'salary_increment_recommendation',
                className: 'text-center'
            },

            {
                data: 'status',
                className: 'text-center',

                render: function(data){

                    if(data == 1){

                        return `
                           <span class="badge-status badge-completed">
                                Pending
                            </span>
                        `;
                    }

                    return `
                        <span class="badge-status badge-active">
                            Completed
                        </span>
                    `;
                }
            },

            {
              data: 'appraisal_id',
              orderable: false,
              searchable: false,
              className: 'text-center',

            render: function(data, type, row) {

                let html = '';

                if (row.status == 2) {

                    html += `
                        <a href="/appraisal_evaluation_view/${btoa(row.appraisal_id)}"
                        class="badge-status badge-payroll me-1">
                            <i class="bi bi-eye-fill"></i> View
                        </a>
                    `;
                }

                if (userRoleId != 4) {

                    if (row.status == 1) {

                        html += `
                            <a href="/appraisal_evaluation_edit/${btoa(row.appraisal_id)}"
                            class="badge-status badge-payroll">
                                <i class="bi bi-pencil-fill"></i> Edit
                            </a>
                        `;
                    }
                }

                return html;
            }
          }
        ]
    });

    // Search
    $('#searchInput').keyup(function () {

        table.ajax.reload();

    });


    $('#categoryFilter').change(function () {

        table.ajax.reload();

    });

    $('#DepartmentFilter').change(function () {

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
