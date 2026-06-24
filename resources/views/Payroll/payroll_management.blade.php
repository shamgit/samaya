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
      <h1 class="page-title">Payroll Management</h1>
	   <div class="header-actions">
		 <a href="{{ route('payroll_excel') }}"><button class="btn-export" >
			<span>Export</span>
			<i class="bi bi-chevron-down"></i>
		  </button></a>
		  <a href="{{ route('process_payroll') }}"><button class="btn-add" >
			<span class="add-txt">Process Payroll</span>
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
        <div class="stat-icon"><i class="bi bi-wallet-fill"></i></div>
		<div>
			<div class="stat-label">Total Payroll Amount</div>
			<div class="stat-value">₹{{$total_payroll_amount ?? ''}}</div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-green d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-pie-chart-fill"></i></div>
		<div>
			<div class="stat-label">Total Deductions</div>
			<div class="stat-value">₹{{$total_deductions ?? ''}}</div>
		</div>	
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-pink d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
		<div>
			<div class="stat-label">Payslips Generated</div>
			<div class="stat-value" >{{$payslips_generated_count ?? ''}}</div>
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
      <option value="">Department: All</option>
       @foreach($departments as $department)
          <option value="{{ $department->department_id }}">
              {{ $department->name }}
          </option>
        @endforeach
    </select>
    <select class="filter-select" id="statusFilter">
	  <option value="">Status: All</option>
      <option value="1">Status: Pending</option>
      <option value="2">Status: Processed</option>
     
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
      <table class="supplier-table" id="PayrollTable">
        <thead>
          <tr>
            <th>Employee Code</th>
            <th>Employee Name </th>
            <th>Department</th>
            <th>Basic Salary</th>
            <th>Allowances</th>
            <th>Deductions</th>
            <th>Net Salary</th>
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

    let table = $('#PayrollTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('payroll_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";

                d.department_id = $('#categoryFilter').val();

                d.payroll_status = $('#statusFilter').val();

                d.sort = $('#sortFilter').val();

                d.search = {
                    value: $('#searchInput').val()
                };
            }
        },

        columns: [

            {
                data: 'employee_code',
                className: 'text-center fw-bold'
            },

            {
                data: 'employee_name',
                className: 'text-center'
            },

            {
                data: 'department_name',
                className: 'text-center'
            },

            {
                data: 'basic_salary',
                className: 'text-center',

                render: function(data){

                    return '₹' + data;

                }
            },

            {
                data: 'net_allowance',
                className: 'text-center',

                render: function(data){

                    return '₹' + data;

                }
            },

            {
                data: 'net_deduction',
                className: 'text-center',

                render: function(data){

                    return '₹' + data;

                }
            },

            {
                data: 'net_salary',
                className: 'text-center fw-bold',

                render: function(data){

                    return '₹' + data;

                }
            },

            {
                data: 'payroll_status',
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
                            Processed
                        </span>
                    `;
                }
            },

            {
              data: 'payroll_id',
              orderable: false,
              searchable: false,
              className: 'text-center',

              render: function (data, type, row) {

                  let html = `<div class="d-flex justify-content-center gap-2">`;

                  if (row.payroll_status == 1) {
                      html += `
                          <a href="/process_payroll_edit/${btoa(row.payroll_id)}">
                              <div class="badge-status badge-payroll py-2 px-2">
                                  <i class="bi bi-gear-fill"></i> Process Payroll
                              </div>
                          </a>
                      `;
                  }

                  if (row.payroll_status == 2) {
                      html += `
                          <a href="/generate_payslip/${btoa(row.payroll_id)}">
                              <div class="badge-status badge-payroll py-2 px-2">
                                  <i class="bi bi-eye-fill"></i> Payslip
                              </div>
                          </a>
                      `;
                  }

                  html += `</div>`;

                  return html;
              }
          }
        ]
    });

    // ===============================
    // Search
    // ===============================

    $('#searchInput').keyup(function () {

        table.ajax.reload();

    });

    // ===============================
    // Department Filter
    // ===============================

    $('#categoryFilter').change(function () {

        table.ajax.reload();

    });

    // ===============================
    // Sort Filter
    // ===============================

    $('#sortFilter').change(function () {

        table.ajax.reload();

    });

    // ===============================
    // Status Filter
    // ===============================

    $('#statusFilter').change(function () {

        table.ajax.reload();

    });
});
</script>