@include('layouts.header')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Purchase Order</h1>
   
  </div>

  <!-- ══════════ FILTER BAR ══════════ -->
  <div class="filter-bar">
    <div class="input-group date_picker" style="width:300px;">
        <span class="input-group-text bg-white">
          <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
        </span>
        <input type="text" id="dateRangePicker" class="form-control form-control-sm bg-white" placeholder="Select date range" readonly />
      </div>
    <select class="filter-select" id="statusFilter">
      <option value="">Status: All</option>
      <option value="Approval">Approved</option>
      <option value="Pending">Pending</option>
      <option value="Completed">Completed</option>
      <option value="Stitching">Denied</option>
    </select>
    <select class="filter-select" id="DepartmentFilter">
      <option value="">Department: All</option>
      <option value="Production">Production</option>
      <option value="Sampling">Sampling</option>
	  <option value="Cutting">Cutting</option>
    </select>
	<select class="filter-select" id="PriorityFilter">
      <option value="">Priority: All</option>
      <option value="Production">High</option>
      <option value="Medium">Medium</option>
	  <option value="Low">Low</option>
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
      <table class="supplier-table" id="supplierTable">
        <thead>
          <tr>
            <th>Requisition ID</th>
            <th>Department </th>
            <th>Requestor</th>
            <th>Date Required</th>
            <th>Priority</th>
            <th>Status </th>
            <th >Actions</th>
          </tr>
        </thead>
        
		    {{-- <tbody id="tableBody">
          <tr>
            <td>PR-2026-0012</td>
            <td>Production</td>
            <td>John Mathew</td>
            <td>30 Mer 2026</td>
            <td><span class="badge-status badge-completed">
                High
              </span></td>
            <td>
              <span class="badge-status badge-pending">
                Pending
              </span>
            </td>
            <td>
               <a href="{{ route('purchase-order.create') }}" class="btn btn-dark btn-sm px-3">+ Create PO</a>
            </td>
          </tr>
          <tr>
            <td>PR-2026-0013</td>
            <td>Sampling</td>
            <td>sathis</td>
            <td>01 Apr 2026</td>
            <td><span class="badge-status badge-info">
                Medium
              </span></td>
             <td>
              <span class="badge-status badge-pending">
                Pending
              </span>
            </td>
            <td>
               <a href="create-purchase-order.php"><button class="btn btn-dark btn-sm px-3">+ Create PO</button></a>
            </td>
          </tr>
          <tr>
            <td>PR-2026-0013</td>
            <td>Sampling</td>
            <td>sathis</td>
            <td>01 Apr 2026</td>
            <td><span class="badge-status badge-pending">
                Low
              </span></td>
            <td>
              <span class="badge-status badge-approved">
                Created
              </span>
            </td>
            <td >
              <div class="d-flex gap-2 align-items-center">
                <a href="purchase-order-edit.php"><div class="stat-icon"><i class="bi bi-pencil-fill text-dark"></i></div></a>
				<div class="stat-icon"><i class="bi bi-send-fill"></i></div>
				<div class="stat-icon"><i class="bi bi-printer-fill"></i></div>
              </div>
            </td>
          </tr>
        <tr>
            <td>PR-2026-0013</td>
            <td>Sampling</td>
            <td>sathis</td>
            <td>01 Apr 2026</td>
            <td><span class="badge-status badge-pending">
                Low
              </span></td>
            <td>
              <span class="badge-status badge-denied">
                Sent
              </span>
            </td>
            <td style="text-align:center;">
              <div class="d-flex gap-2 align-items-center">               
				<a href="purchase-order-view.php"><div class="stat-icon"><i class="bi bi-eye-fill text-dark"></i></div></a>
				<div class="stat-icon"><i class="bi bi-printer-fill"></i></div>
              </div>
            </td>
          </tr>
          
        
          
        
          
        </tbody> --}}

        <tbody id="tableBody">

@forelse($requisitions as $row)

<tr>
    <td>{{ $row->requisition_id ?? '-' }}</td>

    <td>{{ $row->department_name ?? '-' }}</td>

    <td>{{ $row->requested ?? '-' }}</td>

    <td>
        {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}
    </td>

    <td>
        <span class="badge-status badge-completed">
            {{ $row->priority ?? 'Low' }}
        </span>
    </td>

    <td>
        @if($row->po_status == 'Pending')
            <span class="badge-status badge-pending">
                Pending
            </span>

        @elseif($row->po_status == 'Created')
            <span class="badge-status badge-completed">
                Created
            </span>

        @elseif($row->po_status == 'sent')
            <span class="badge-status badge-denied">
                Sent
            </span>

        @else
            <span class="badge-status badge-info">
                {{ $row->status }}
            </span>
        @endif
    </td>

    <td>

        @if($row->po_status == 'Pending')

          <a href="{{ route('purchase-order.create', ['id' => $row->id]) }}"
          class="btn btn-dark btn-sm px-3">
          + Create PO
          </a>

        @elseif($row->po_status == 'Created')

        <div class="d-flex gap-2 align-items-center">
            <a href="{{ route('purchase-order-edit', ['id' => $row->id]) }}">
                <div class="stat-icon"><i class="bi bi-pencil-fill text-dark"></i></div>
            </a>
          <div class="stat-icon send-po" data-id="{{ !empty($row->po_id) ? $row->po_id : '' }}">
               <i class="bi bi-send-fill"></i>
            </div>
            <div class="stat-icon"><i class="bi bi-printer-fill"></i></div>
        </div>

        @elseif($row->po_status == 'sent')

            <div class="d-flex gap-2 align-items-center">

                <a href="{{ route('purchase-order.view', ['id' => !empty($row->po_id) ? $row->po_id : '']) }}">
                    <div class="stat-icon">
                        <i class="bi bi-eye-fill text-dark"></i>
                    </div>
                </a>

                <div class="stat-icon">
                    <i class="bi bi-printer-fill"></i>
                </div>

            </div>

        @endif

    </td>

</tr>

@empty

<tr>
    <td colspan="7" class="text-center">
        No Data Found
    </td>
</tr>

@endforelse

</tbody>
		
      </table>
      <!-- Empty state -->
      <div class="empty-state" id="emptyState">
        <i class="bi bi-inbox"></i>
        <p>No suppliers found matching your filters.</p>
      </div>
    </div>

    <!-- ══════════ FOOTER / PAGINATION ══════════ -->
    <div class="table-footer">
      <div class="rows-per-page">
        Row Per Page
        <select class="rows-select" id="rowsSelect">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
        Entries
      </div>
      <div class="pagination-wrap" id="paginationWrap"><button class="page-btn" onclick="goPage(0)" disabled="">
                <i class="bi bi-chevron-left"></i>
              </button><button class="page-btn active" onclick="goPage(1)">1</button><button class="page-btn " onclick="goPage(2)">2</button><button class="page-btn" onclick="goPage(2)">
             <i class="bi bi-chevron-right"></i>
           </button></div>
    </div>
  </div>

</div><!-- /page-wrap -->

<!-- ══════════ ADD/EDIT MODAL ══════════ -->
<div class="modal-overlay" id="supplierModal">
  <div class="modal-box">
    <div class="modal-header">
      <span class="modal-title" id="modalTitle">Add Supplier</span>
      <button class="modal-close" id="modalClose"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="editId"/>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Supplier Name *</label>
          <input type="text" class="form-input" id="fName" placeholder="e.g. ABC Garments"/>
        </div>
        <div class="form-group">
          <label class="form-label">Contact Person *</label>
          <input type="text" class="form-input" id="fContact" placeholder="e.g. John Mathew"/>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Phone *</label>
          <input type="text" class="form-input" id="fPhone" placeholder="e.g. 98568 83347"/>
        </div>
        <div class="form-group">
          <label class="form-label">Category *</label>
          <select class="form-input" id="fCategory">
            <option value="">Select Category</option>
            <option>Fabric</option><option>Trims</option>
            <option>Dyeing</option><option>Stitching</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Payment Terms</label>
          <select class="form-input" id="fTerms">
            <option>Net 30</option><option>Net 15</option>
            <option>Net 45</option><option>Net 60</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select class="form-input" id="fStatus">
            <option>Active</option><option>Inactive</option>
          </select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn-cancel" id="cancelModal">Cancel</button>
      <button class="btn-save" id="saveSupplier">Save Supplier</button>
    </div>
  </div>
</div>
</main>

@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
<script>
$(document).on('click', '.send-po', function () {

    let poId = $(this).data('id');

    Swal.fire({
        title: 'Send Purchase Order?',
        text: 'This PO will be sent to the supplier.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Send',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#111827',
        reverseButtons: true,
        backdrop: true,
        allowOutsideClick: false,
        customClass: {
            popup: 'rounded-4 shadow-lg'
        }
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }

        Swal.fire({
            title: 'Sending...',
            html: 'Please wait while we send the PO.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/purchase-order/send/' + poId,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },

            success: function (response) {

                if (response.status) {

                    Swal.fire({
                        icon: 'success',
                        title: 'PO Sent Successfully',
                        text: response.message,
                        confirmButtonColor: '#16a34a',
                        timer: 2500,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message,
                        confirmButtonColor: '#dc2626'
                    });
                }
            },

            error: function () {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonColor: '#dc2626'
                });
            }
        });

    });

});

let currentPage = 1;
let rowsPerPage = parseInt($('#rowsSelect').val()) || 5;

function getFilteredRows() {

    let status = $('#statusFilter').val().toLowerCase();
    let department = $('#DepartmentFilter').val().toLowerCase();
    let priority = $('#PriorityFilter').val().toLowerCase();

    let filteredRows = [];

    $('#tableBody tr').each(function () {

        let row = $(this);

        let rowDepartment = row.find('td:eq(1)').text().trim().toLowerCase();
        let rowPriority   = row.find('td:eq(4)').text().trim().toLowerCase();
        let rowStatus     = row.find('td:eq(5)').text().trim().toLowerCase();

        let show = true;

        if (status && !rowStatus.includes(status)) {
            show = false;
        }

        if (department && !rowDepartment.includes(department)) {
            show = false;
        }

        if (priority && !rowPriority.includes(priority)) {
            show = false;
        }

        if (show) {
            filteredRows.push(row);
        }
    });

    return filteredRows;
}

function filterRows() {

    let rows = getFilteredRows();

    $('#tableBody tr').hide();

    let totalRows = rows.length;

    rowsPerPage = parseInt($('#rowsSelect').val()) || 5;

    let totalPages = Math.ceil(totalRows / rowsPerPage);

    if (currentPage > totalPages) {
        currentPage = 1;
    }

    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    rows.slice(start, end).forEach(function (row) {
        row.show();
    });

    buildPagination(totalPages);

    if (totalRows === 0) {
        $('#emptyState').show();
    } else {
        $('#emptyState').hide();
    }

    $('#pageInfo').html(
        `Showing ${totalRows > 0 ? start + 1 : 0} to ${Math.min(end, totalRows)} of ${totalRows} entries`
    );
}

function buildPagination(totalPages) {

    let html = '';

    html += `
        <button class="page-btn"
            ${currentPage == 1 ? 'disabled' : ''}
            onclick="goPage(${currentPage - 1})">
            <i class="bi bi-chevron-left"></i>
        </button>
    `;

    for (let i = 1; i <= totalPages; i++) {

        html += `
            <button
                class="page-btn ${currentPage === i ? 'active' : ''}"
                onclick="goPage(${i})">
                ${i}
            </button>
        `;
    }

    html += `
        <button class="page-btn"
            ${currentPage == totalPages || totalPages == 0 ? 'disabled' : ''}
            onclick="goPage(${currentPage + 1})">
            <i class="bi bi-chevron-right"></i>
        </button>
    `;

    $('#paginationWrap').html(html);
}

function goPage(page) {

    currentPage = page;

    filterRows();
}

$('#statusFilter').on('change', function () {
    currentPage = 1;
    filterRows();
});

$('#DepartmentFilter').on('change', function () {
    currentPage = 1;
    filterRows();
});

$('#PriorityFilter').on('change', function () {
    currentPage = 1;
    filterRows();
});

$('#rowsSelect').on('change', function () {
    currentPage = 1;
    rowsPerPage = parseInt($(this).val());
    filterRows();
});

$(document).ready(function () {

    $('#emptyState').hide();

    filterRows();
});

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
flatpickr("#f_requestDate", { dateFormat: "d M Y", defaultDate: "today" });
flatpickr("#f_requiredDate", { dateFormat: "d M Y" });

window._fromDate = 20260301;
window._toDate   = 20260430;
filterRows();

</script>
