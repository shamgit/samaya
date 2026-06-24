@include('layouts.header')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')

<style>
.table-scroll{
    overflow:visible !important;
}
</style>

<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">  
      <h1 class="page-title">Purchase Requisition</h1> 
  </div>
  
  <div class="d-flex gap-2 mb-3 purchase-req">
    <button id="btnCreate" class="btn btn-dark btn-sm px-3" onclick="showPage('create')">+ Create Requisition</button>
    <button id="btnHistory" class="btn btn-outline-secondary btn-sm px-3" onclick="showPage('list')">Requisition History</button>
  </div>
  
   <!-- ========== LIST PAGE ========== -->
   <div id="createPage" >
   <div class="detail-card">
   <div class="section-block">
    <div class="d-flex align-items-center gap-2 mb-2">
      <span class="req-id-label">Request ID:</span>
      <span class="req-id-value" id="newReqIdDisplay">
      <span class="placeholder-glow"><span class="placeholder col-4"></span></span>
    </span>
    <input type="hidden" id="newReqId" name="req_id"/>
    </div>
     
	</div>
	<div class="section-block">	
    
      <div class="row g-3 ">
        <div class="col-md-6 mb-3">
          <label class="form-label" >Department <span class="text-danger">*</span></label>
          <select class="form-input" id="f_dept">
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label" >Requested By <span class="text-danger">*</span>
          <input type="text" class="form-input" id="f_requestedBy" name="requested_by" placeholder="Enter name" />
        </div>
      </div>
      <div class="row g-3">
        <div class="col-md-6 mb-3">
          <label class="form-label" >Request Date</label>
          <div class="input-group date_picker">
            <input type="text" class="form-control" name="request_date" id="f_requestDate" placeholder="Select date" readonly />
            <span class="input-group-text bg-white">
              <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
            </span>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label ">Required Date <span class="text-danger">*</span>
          <div class="input-group date_picker">
            <input type="text" class="form-control" name="required_date" id="f_requiredDate" placeholder="Select date" readonly />
            <span class="input-group-text bg-white">
              <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
            </span>
          </div>
        </div>
      </div>  
	</div>
	
	

    <div class="section-block">
      <p class="form-label mb-3" >Product Details</p>
	  <div class="table-card" style="border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;">
		<div class="table-scroll">
			<table class="supplier-table product-table" id="productTable">
      
          <thead>
            <tr>
              <th style="width:22%;">Product Name  <span class="text-danger">*</span></th>
              <th style="width:18%;">Category</th>
              <th style="width:13%;">Color</th>
              <th style="width:12%;">Size  <span class="text-danger">*</span></th>
              <th style="width:12%;">Quantity <span class="text-danger">*</span></th>
              <th style="width:15%;">Unit</th>
              <th style="width:8%;"></th>
            </tr>
          </thead>
          <tbody id="productBody">

<tr>

    <!-- PRODUCT -->
    <td>
        <select name="product_id[]"
                class="form-control product-select"
                onchange="getProductDetails(this)">

            <option value="">Loading Products...</option>

        </select>
    </td>

    <!-- CATEGORY -->
    <td>
        <input type="text"
               name="category[]"
               class="form-control category"
               readonly>
    </td>

    <!-- COLOR -->
    <td>
        <input type="text"
               name="color[]"
               class="form-control color"
               readonly>
    </td>

    <!-- SIZE -->
    <td>
        <input type="text"
               name="size[]"
               class="form-control size"
               >
    </td>

    <!-- QUANTITY -->
    <td>
        <input type="number"
               name="quantity[]"
               class="form-control quantity"
               min="1">
    </td>

    <!-- UNIT -->
    <td>
        <input type="text"
               name="unit[]"
               class="form-control unit"
               readonly>
    </td>

    <!-- REMOVE -->
    <td class="text-center">
        <button type="button"
                class="remove-row"
                onclick="removeRow(this)">
            ×
        </button>
    </td>

</tr>

</tbody>
        </table>
      </div>
	  </div>
      <button class="add-line-btn" onclick="addProductRow()">+ Add a line</button>
    </div>

    <div class="section-block">
      <div class="mb-3">
        <label class="form-label" >Priority</label>
        <div class="d-flex gap-2" id="priorityGroup">
          <button class="priority-btn active" onclick="setPriority(this)">High</button>
          <button class="priority-btn" onclick="setPriority(this)">Medium</button>
          <button class="priority-btn" onclick="setPriority(this)">Low</button>
        </div>
      </div>
      <div class="mb-3"> 
        <label class="form-label" >Remarks <span class="text-danger">*</span>
        <input type="text" class="form-input" id="f_remarks" placeholder="Enter remarks" />
      </div>
    </div>

    <div class="section-block text-end">
		<button class="btn-cancel">Cancel</button>
		<button class="btn-save">Submit Request</button>
	</div>
    </div>
  </div>
  

  <!-- ========== CREATE PAGE ========== -->
<!-- ========== REQUISITION HISTORY PAGE ========== -->

<div id="listPage" style="display:none;">

    <!-- FILTERS -->
    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">

        <!-- DATE FILTER -->
        <div class="input-group date_picker" style="width:250px;">

            <span class="input-group-text bg-white">

                <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                    <rect x="2" y="3" width="12" height="11" rx="2"
                          stroke="#6c757d" stroke-width="1.2"/>

                    <path d="M5 2v2M11 2v2M2 7h12"
                          stroke="#6c757d"
                          stroke-width="1.2"
                          stroke-linecap="round"/>
                </svg>

            </span>

            <input type="text"
                   id="dateRangePicker"
                   class="form-control form-control-sm bg-white"
                   placeholder="Select date range"
                   readonly />
        </div>

        <!-- STATUS FILTER -->
        <select class="filter-select"
                id="statusFilter"
                onchange="filterRows()">

            <option value="All">Status: All</option>
            <option value="Pending">Status: Pending</option>
            <option value="Approved">Status: Approved</option>
            <option value="Completed">Status: Completed</option>
            <option value="Denied">Status: Denied</option>

        </select>

        <!-- SORT FILTER -->
        <select class="filter-select"
                id="sortBy"
                onchange="sortRows()">

            <option value="recent" selected>
                Sort By: Recent
            </option>

            <option value="oldest">
                Sort By: Oldest
            </option>

            <option value="dept">
                Sort By: Department
            </option>

        </select>

    </div>
    <!-- TABLE -->
    <div class="table-card">

        <div class="table-scroll">

            <table class="supplier-table">

                <thead class="table-light">

                    <tr>

                        <th>Requisition ID</th>

                        <th>Department</th>

                        <th>Requestor</th>

                        <th>Date Required</th>

                        <th>Product Name</th>

                        <th>Status</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <!-- DYNAMIC DATA -->
                <tbody id="tableBody">

                    <tr>

                        <td colspan="7" class="text-center">
                            Loading...
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

    <!-- PAGINATION -->
    <div class="table-footer">

        <div class="rows-per-page">

            Row Per Page

            <select class="rows-select"
                    id="rowsPerPage"
                    onchange="renderTable()">

                <option value="5" selected>5</option>

                <option value="10">10</option>

                <option value="25">25</option>

                <option value="50">50</option>

            </select>

            Entries

        </div>

        <!-- PAGINATION BUTTONS -->
        <div class="pagination-wrap">

            <button class="page-btn"
                    id="prevItem"
                    onclick="changePage(-1);return false;"
                    disabled>

                <i class="bi bi-chevron-left"></i>

            </button>

            <button class="page-btn active" id="pageIndicator">

                1
            </button>

            <button class="page-btn"
                    id="nextItem"
                    onclick="changePage(1);return false;">

                <i class="bi bi-chevron-right"></i>

            </button>

        </div>

    </div>

</div>

  
  
</main>

@include('layouts.footer')

@include('layouts.scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(document).ready(function () {
    loadRequisitionTable();
});
// ── GLOBALS ───────────────────────────────────────────────────────

let cachedOptions = null;

let openMenu = null;

let allData = [];

let filtered = [];

let currentPage = 1;

function showPage(page) {
  document.getElementById('listPage').style.display   = page === 'list'   ? '' : 'none';
  document.getElementById('createPage').style.display = page === 'create' ? '' : 'none';
  document.getElementById('btnCreate').className  = page === 'create' ? 'btn btn-dark btn-sm px-3' : 'btn btn-outline-secondary btn-sm px-3';
  document.getElementById('btnHistory').className = page === 'list'   ? 'btn btn-dark btn-sm px-3' : 'btn btn-outline-secondary btn-sm px-3';
  if (page === 'create') {
    const nextNum = allData.length + 12;
    document.getElementById('f_dept').value = '';
    document.getElementById('f_requestedBy').value = '';
    document.getElementById('f_remarks').value = '';
    document.querySelectorAll('.priority-btn').forEach((b,i) => b.classList.toggle('active', i===0));
  }
}

function filterRows() {
  const sf = document.getElementById('statusFilter').value;
  filtered = allData.filter(r => {
    const statusOk = sf === 'All' || sf === 'Active' || r.status === sf;
    const fromOk = !window._fromDate || r.dateSort >= window._fromDate;
    const toOk   = !window._toDate   || r.dateSort <= window._toDate;
    return statusOk && fromOk && toOk;
  });
  sortRows();
}

function sortRows() {
  const sort = document.getElementById('sortBy').value;
  if (sort === 'recent') filtered.sort((a,b) => b.dateSort - a.dateSort);
  else if (sort === 'oldest') filtered.sort((a,b) => a.dateSort - b.dateSort);
  else filtered.sort((a,b) => a.dept.localeCompare(b.dept));
  currentPage = 1;
  renderTable();
}



function changePage(dir) {
  const perPage = parseInt(document.getElementById('rowsPerPage').value);
  const totalPages = Math.max(1, Math.ceil(filtered.length / perPage));
  currentPage = Math.max(1, Math.min(totalPages, currentPage + dir));
  renderTable();
}
// ── DOM READY ─────────────────────────────────────────────────────
$(document).ready(function () {
  
    loadDepartments();
    loadProducts($('.product-select')); // populate first row

    flatpickr("#f_requestDate",  { dateFormat: "d M Y", defaultDate: "today" });
    flatpickr("#f_requiredDate", { dateFormat: "d M Y" });

    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["2026-03-01", "2026-04-30"],
        onChange(selectedDates) {
            if (selectedDates.length === 2) {
                const fmt = d => parseInt(
                    d.getFullYear() * 10000 + (d.getMonth() + 1) * 100 + d.getDate()
                );
                window._fromDate = fmt(selectedDates[0]);
                window._toDate   = fmt(selectedDates[1]);
            } else {
                window._fromDate = null;
                window._toDate   = null;
            }
            filterRows();
        }
    });

    window._fromDate = 20260301;
    window._toDate   = 20260430;
    renderTable();
});

// ── DEPARTMENTS ───────────────────────────────────────────────────
function loadDepartments()
{
    $.ajax({
        url: "{{ route('departments.list') }}",
        type: "GET",
        success: function (res) {
            let html = '<option value="">Select Department</option>';
            $.each(res, function (i, item) {
                html += `<option value="${item.department_id}">${item.name}</option>`;
            }); 
            $('#f_dept').html(html);
        },
        error: function (xhr) {
            console.error('Departments failed:', xhr.responseText);
        }
    });
}

// ── LOAD PRODUCTS (runs ONCE, then uses cache) ────────────────────
// ── LOAD PRODUCTS (runs ONCE, then uses cache) ────────────────────
function loadProducts(target)
{
    // If cache exists, inject directly — no AJAX
    if (cachedOptions) {
        $(target).html(cachedOptions);
        return;
    }

    $(target).html('<option value="">Loading...</option>');

    $.ajax({
        url: "{{ route('products.list') }}",
        type: "GET",
        dataType: "json",

        success: function (response) {
            let products = response.data || [];

            if (products.length === 0) {
                $(target).html('<option value="">No products found</option>');
                return;
            }

            let html = '<option value="">Select Product</option>';
            $.each(products, function (i, p) {
                html += `<option value="${p.id}">${p.product_name}</option>`;
            });

            cachedOptions = html; // save cache
            $(target).html(cachedOptions); // inject ONLY into target
        },

        error: function (xhr) {
            console.error('Product load error:', xhr.status, xhr.responseText);
            $(target).html('<option value="">Failed to load</option>');
        }
    });
}

// ── GET PRODUCT DETAILS ON SELECT ────────────────────────────────
function getProductDetails(element)
{
    const productId = $(element).val();
    const row       = $(element).closest('tr');

    row.find('.category').val('');
    row.find('.color').val('');
    row.find('.size').val('');
    row.find('.unit').val('');

    if (!productId) return;

    $.ajax({
        url: "{{ url('/product-details') }}/" + productId,
        type: "GET",
        dataType: "json",

        success: function (response) {

            console.log('FULL RESPONSE:', response); // CHECK THIS IN CONSOLE
            console.log('category_name:', response.category_name);
            console.log('product_color:', response.product_color);
            console.log('size:', response.size);
            console.log('unit_of_measure:', response.unit_of_measure);

            row.find('.category').val(response.category_name || '');
            row.find('.color').val(response.product_color    || '');
            row.find('.unit').val(response.unit_of_measure   || '');
        },

        error: function (xhr) {
            console.error('Detail error:', xhr.status, xhr.responseText);
        }
    });
}

// ── ADD NEW PRODUCT ROW ───────────────────────────────────────────
function addProductRow()
{
    const newRow = $(`
        <tr>
            <td>
                <select name="product_id[]"
                        class="form-control product-select"
                        onchange="getProductDetails(this)">
                    <option value="">Select Product</option>
                </select>
            </td>
            <td><input type="text"   name="category[]" class="form-control category" readonly></td>
            <td><input type="text"   name="color[]"    class="form-control color"    readonly></td>
            <td><input type="text"   name="size[]"     class="form-control size" ></td>
            <td><input type="number" name="quantity[]" class="form-control quantity" placeholder="0" min="1"></td>
            <td><input type="text"   name="unit[]"     class="form-control unit"     readonly></td>
            <td class="text-center">
                <button type="button" class="remove-row" onclick="removeRow(this)">×</button>
            </td>
        </tr>
    `).appendTo('#productBody');

    // Pass ONLY the new row's select — never touches existing rows
    loadProducts(newRow.find('.product-select'));
}

$(document).ready(function () {

    loadDepartments();
    loadProducts($('.product-select')); // ← pass target, populates first row only

    flatpickr("#f_requestDate",  { dateFormat: "d M Y", defaultDate: "today" });
    flatpickr("#f_requiredDate", { dateFormat: "d M Y" });

    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: ["2026-03-01", "2026-04-30"],
        onChange(selectedDates) {
            if (selectedDates.length === 2) {
                const fmt = d => parseInt(
                    d.getFullYear() * 10000 + (d.getMonth() + 1) * 100 + d.getDate()
                );
                window._fromDate = fmt(selectedDates[0]);
                window._toDate   = fmt(selectedDates[1]);
            } else {
                window._fromDate = null;
                window._toDate   = null;
            }
            filterRows();
        }
    });

    window._fromDate = 20260301;
    window._toDate   = 20260430;
    renderTable();
});

function setPriority(btn)
{
    $('#priorityGroup .priority-btn').removeClass('active');
    $(btn).addClass('active');
}

$(document).ready(function () {

    // FETCH REQUISITION ID ON PAGE LOAD
    fetchRequisitionId();

    function fetchRequisitionId() {
        $.ajax({
            url: '{{ route("requisition.generate-id") }}',
            type: 'GET',
            success: function (response) {
                if (response.requisition_id) {

                    // SHOW IN SPAN
                    $('#newReqIdDisplay').text(response.requisition_id);

                    // SET IN HIDDEN INPUT FOR FORM SUBMIT
                    $('#newReqId').val(response.requisition_id);
                }
            },
            error: function (xhr) {
                console.error('Failed to fetch requisition ID:', xhr.responseText);
                $('#newReqIdDisplay').text('Error generating ID');
            }
        });
    }

});

$(document).on('click', '.btn-save', function (e) {

    e.preventDefault();

    let priority = $('#priorityGroup .priority-btn.active').text().trim();

    let formData = {
        requisition_id: $('#newReqId').val(),
        department_id: $('#f_dept').val(),
        requested_by: $('#f_requestedBy').val(),
        request_date: $('#f_requestDate').val(),
        required_date: $('#f_requiredDate').val(),
        priority: priority,
        remarks: $('#f_remarks').val(),
        product_id: [],
        category: [],
        color: [],
        size: [],
        quantity: [],
        unit: [],
        _token: '{{ csrf_token() }}'
    };

    $('#productBody tr').each(function () {

        formData.product_id.push(
            $(this).find('.product-select').val()
        );

        formData.category.push(
            $(this).find('.category').val()
        );

        formData.color.push(
            $(this).find('.color').val()
        );

        formData.size.push(
            $(this).find('.size').val()
        );

        formData.quantity.push(
            $(this).find('.quantity').val()
        );

        formData.unit.push(
            $(this).find('.unit').val()
        );
    });

    $.ajax({
        url: "{{ route('purchase-requisition.store') }}",
        type: "POST",
        data: formData,

        success: function (response) {

            if (response.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });

            }
        },

        error: function (xhr) {

            if (xhr.status === 422) {

                let errors = xhr.responseJSON.errors;
                let errorMsg = '';

                $.each(errors, function (key, value) {
                    errorMsg += value[0] + '\n';
                });

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: errorMsg
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Save Failed'
                });

            }
        }
    });

});

{
    const perPage = parseInt($('#rowsPerPage').val());

    const totalPages = Math.ceil(filtered.length / perPage);

    $('#pageIndicator').text(currentPage);

    $('#prevItem').prop('disabled', currentPage === 1);

    $('#nextItem').prop('disabled', currentPage >= totalPages);
}

// PAGE SHOW
function showPage(page)
{
    $('#listPage').hide();

    $('#createPage').hide();

    if(page === 'list') {

        $('#listPage').show();

        $('#btnHistory')
            .removeClass('btn-outline-secondary')
            .addClass('btn-dark');

        $('#btnCreate')
            .removeClass('btn-dark')
            .addClass('btn-outline-secondary');

        loadRequisitionTable();

    } else {

        $('#createPage').show();

        $('#btnCreate')
            .removeClass('btn-outline-secondary')
            .addClass('btn-dark');

        $('#btnHistory')
            .removeClass('btn-dark')
            .addClass('btn-outline-secondary');
    }
}
// LOAD HISTORY TABLE
function loadRequisitionTable()
{
    $('#tableBody').html(`
        <tr>
            <td colspan="7" class="text-center">
                Loading...
            </td>
        </tr>
    `);

    $.ajax({

        url: "{{ route('purchase-requisition.list') }}",

        type: "GET",

        dataType: "json",

        success: function(response)
        {
            console.log(response);

            allData = [];

            if(response.length === 0){

                $('#tableBody').html(`
                    <tr>
                        <td colspan="7" class="text-center">
                            No Data Found
                        </td>
                    </tr>
                `);

                return;
            }

            $.each(response, function(index, item){

                let productNames = '';

                // PRODUCT NAMES
                if(item.details && item.details.length > 0){

                    productNames = item.details.map(function(d){

                        if(d.product){

                            return d.product.product_name;
                        }

                        return 'N/A';

                    }).join(', ');
                }

                  allData.push({

                    id : item.requisition_id || '',

                    dept : item.department
                        ? item.department.name
                        : item.department_id,

                    req : item.requested || '',

                    date : item.required_date || '',

                    product : productNames || 'N/A',

                    status : item.status || 'Pending'
                });
            });

            filtered = allData;

            renderTable();
        },

        error: function(xhr)
        {
            console.log(xhr.responseText);

            $('#tableBody').html(`
                <tr>
                    <td colspan="7" class="text-danger text-center">
                        Failed To Load Data
                    </td>
                </tr>
            `);
        }
    });
}


// RENDER TABLE
function renderTable()
{
    let tbody = $('#tableBody');

    tbody.html('');

    if(filtered.length === 0){

        tbody.html(`
            <tr>
                <td colspan="7" class="text-center">
                    No Data Found
                </td>
            </tr>
        `);

        return;
    }

    $.each(filtered, function(index, row){

        let statusClass = row.status
            ? row.status.toLowerCase()
            : 'pending';

        tbody.append(`

            <tr>

                <td>${row.id}</td>

                <td>${row.dept}</td>

                <td>${row.req}</td>

                <td>${row.date}</td>

                <td>${row.product}</td>
                
                <td>
                    ${
                        row.status === 'Pending'
                        ? `<span class="badge-status badge-pending">Pending</span>`

                        : row.status === 'Approved'
                        ? `<span class="badge-status badge-approved">Approved</span>`

                        : row.status === 'Denied'
                        ? `<span class="badge-status badge-denied">Denied</span>`

                        : row.status === 'Completed'
                        ? `<span class="badge-status badge-completed">Completed</span>`

                        : `<span class="badge-status badge-pending">Pending</span>`
                    }
                </td>

                <td>

                    <div class="action-wrap">

                        <button class="btn-action"
                                data-id="${row.id}"
                                onclick="toggleMenu(this, event)">

                            <i class="bi bi-three-dots-vertical"></i>

                        </button>

                        <div class="action-menu"
                             data-menu="${row.id}">

                            <div class="action-menu-item">

                                <a href="/purchase-requisition-view/${row.id}">

                                    <i class="bi bi-eye"></i>

                                    View

                                </a>

                            </div>

                            <div class="action-menu-item delete"
                                 onclick="deleteRequisition('${row.id}')">

                                <i class="bi bi-trash"></i>

                                Delete

                            </div>

                        </div>

                    </div>

                </td>

            </tr>

        `);

    });
}

// FILTER
function filterRows()
{
    let status = $('#statusFilter').val();

    if(status === 'All'){

        filtered = allData;

    } else {

        filtered = allData.filter(function(item){

            return item.status === status;
        });
    }

    renderTable();
}


// SORT
function sortRows()
{
    let sort = $('#sortBy').val();

    if(sort === 'recent'){

        filtered.reverse();
    }

    if(sort === 'dept'){

        filtered.sort(function(a,b){

            return a.dept.localeCompare(b.dept);
        });
    }

    renderTable();
}
{
    let sort = $('#sortBy').val();

    if(sort === 'recent'){

        filtered.reverse();

    } else if(sort === 'dept'){

        filtered.sort((a,b) =>
            a.dept.localeCompare(b.dept)
        );
    }

    renderTable();
}

function toggleMenu(button, event)
{
    event.stopPropagation();

    $('.action-menu').hide();

    let menu = $(button)
        .closest('.action-wrap')
        .find('.action-menu');

    let rect = button.getBoundingClientRect();

    menu.css({

        display : 'block',

        position : 'fixed',

        top : (rect.bottom + 5) + 'px',

        left : (rect.left - 120) + 'px',

        zIndex : 99999

    });
}

$(document).click(function () {

    $('.action-menu').hide();

});


function deleteRequest(id)
{
    Swal.fire({

        title: 'Delete Request?',

        text: "This record will be permanently deleted.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Yes, Delete'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('purchase-requisition.delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    requisition_id: id
                },

                success: function(response)
                {
                    Swal.fire({

                        icon: 'success',

                        title: 'Deleted',

                        text: response.message,

                        timer: 1500,

                        showConfirmButton: false

                    });

                    loadApprovalTable();
                },

                error: function(xhr)
                {
                    console.log(xhr.responseText);

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Delete failed'

                    });
                }

            });

        }

    });
}
</script>


