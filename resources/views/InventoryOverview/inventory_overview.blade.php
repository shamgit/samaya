
@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">   
      <h1 class="page-title">Inventory Overview</h1>
	   <div class="dropdown-wrapper">
		  <button class="alert-badge" onclick="document.getElementById('alertPanel').classList.toggle('show')"> <span class="text-danger">5</span> Low Stock Alerts <i class="bi bi-three-dots-vertical"></i></button>
		  <div class="dropdown-panel" id="alertPanel">
			<div class="alert-dropdown">
			  <div class="alert-item">
				<span class="icon"><i class="bi bi-exclamation-triangle"></i></span>
				<div><p class="title">Zipper (Black, 8 inch)</p><p class="qty-alert">50 pcs left</p></div>
			  </div>
			  <div class="alert-item">
				<span class="icon"><i class="bi bi-exclamation-triangle"></i></span>
				<div><p class="title">Thread (White)</p><p class="qty-alert">20 cones left</p></div>
			  </div>
			  <div class="alert-item">
				<span class="icon"><i class="bi bi-exclamation-triangle"></i></span>
				<div><p class="title">Mul Fabric (#678465)</p><p class="qty-alert">100 meters left</p></div>
			  </div>
			  <a href="purchase-requisition.php"><button class="btn-purchase">Create Purchase Request</button></a>
			</div>
		  </div>
		</div>
  </div>

  <!-- STAT CARDS -->
  <div class="row g-3">
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-purple d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
		<div>
			<div class="stat-label">Product Items</div>
    <div class="stat-value">
        {{ $totalProducts }}
    </div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-blue d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-box-fill"></i></div>
		<div>
			<div class="stat-label">Fabric Stock</div>
			<div class="stat-value">800<span>meters</span></div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-green d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-box-fill"></i></div>
		<div>
			<div class="stat-label">Low Stock Items</div>
      <div class="stat-value">
      {{ $lowStockCount }}
      <span>Items</span>
      </div>
		</div>	
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-pink d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-inboxes-fill"></i></div>
		<div>
			<div class="stat-label">Warehouse</div>
			<div class="stat-value" >5<span>Active</span></div>
		</div>	
      </div>
    </div>
  </div>

</div>

    <div class="row g-3">
    <div class="col-12 col-md-4 mb-4">
    <div class="warehouse-card">
      <h6>Main Warehouse – Chennai</h6>
    <div class="subtitle">Primary Hub</div>
    <div class="stock-row"><span class="name">Fabric</span><div class="bar-wrap"><div class="bar bar-blue" style="width:90%"></div></div><span class="qty">5000 m</span></div>
    <div class="stock-row"><span class="name">Trims</span><div class="bar-wrap"><div class="bar bar-orange" style="width:40%"></div></div><span class="qty">2000 pcs</span></div>
    <div class="stock-row"><span class="name">Dyeing</span><div class="bar-wrap"><div class="bar bar-teal" style="width:24%"></div></div><span class="qty">1,200 kg</span></div>
    <div class="stock-row"><span class="name">Stitching</span><div class="bar-wrap"><div class="bar bar-red" style="width:55%"></div></div><span class="qty">2,800 pcs</span></div>
    </div>
    </div>
    <div class="col-12 col-md-4 mb-4">
    <div class="warehouse-card">
    <h6>Fabric Store – Unit 1</h6>
    <div class="subtitle">Secondary Fabric</div>
    <div class="stock-row"><span class="name">Fabric</span><div class="bar-wrap"><div class="bar bar-blue" style="width:65%"></div></div><span class="qty">3,500 m</span></div>
    <div class="stock-row"><span class="name">Trims</span><div class="bar-wrap"><div class="bar bar-orange" style="width:0%"></div></div><span class="qty">–</span></div>
    <div class="stock-row"><span class="name">Dyeing</span><div class="bar-wrap"><div class="bar bar-teal" style="width:0%"></div></div><span class="qty">–</span></div>
    <div class="stock-row"><span class="name">Stitching</span><div class="bar-wrap"><div class="bar bar-red" style="width:22%"></div></div><span class="qty">1,200 pcs</span></div>
    </div>
    </div>
    <div class="col-12 col-md-4 mb-4">
    <div class="warehouse-card">
       <h6>Accessories Store</h6>
    <div class="subtitle">Trims &amp; Accessories</div>
    <div class="stock-row"><span class="name">Fabric</span><div class="bar-wrap"><div class="bar bar-blue" style="width:0%"></div></div><span class="qty">–</span></div>
    <div class="stock-row"><span class="name">Trims</span><div class="bar-wrap"><div class="bar bar-orange" style="width:50%"></div></div><span class="qty">800 pcs</span></div>
    <div class="stock-row"><span class="name">Dyeing</span><div class="bar-wrap"><div class="bar bar-teal" style="width:0%"></div></div><span class="qty">–</span></div>
    <div class="stock-row"><span class="name">Stitching</span><div class="bar-wrap"><div class="bar bar-red" style="width:12%"></div></div><span class="qty">600 pcs</span></div>
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
          <option value="">Category: All</option>

          @foreach($categories as $category)
              <option value="{{ $category->category_name }}">
                  {{ $category->category_name }}
              </option>
          @endforeach
      </select>
      <select class="filter-select" id="statusFilter">
      <option value="">Stock Status: All</option>
        <option value="In Stock">Stock Status: In Stock</option>
        <option value="Low Stock">Stock Status: Low Stock</option>
      <option value="Out of Stock">Stock Status: Out of Stock</option>
        
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
        <table class="supplier-table">
            <thead>
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Qty Available</th>
                    <th>Unit</th>
                    <th>Warehouse</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody id="productTableBody">
                <!-- AJAX data will be loaded here -->
            </tbody>
        </table>
    </div>

    <!-- Footer / Pagination -->
    <div class="table-footer">

        <div class="rows-per-page">
            Row Per Page
            <select class="rows-select" id="rowsSelect">
                <option value="5" selected>5</option>
                <option value="10" >10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            Entries
        </div>

        <div class="pagination-wrap" id="paginationWrap">
            <!-- Page numbers will be generated by JavaScript -->
        </div>

    </div>

</div>

</div><!-- /page-wrap -->

</main>

@include('layouts.footer')

@include('layouts.scripts')  

<script>
  document.addEventListener('click', function(e) {
    const panel = document.getElementById('alertPanel');
    if (!e.target.closest('.dropdown-wrapper')) panel.classList.remove('show');
  });


    loadProducts();

    function loadProducts() {

        $.ajax({
            url: '/inventory-list',
            type: 'GET',
            dataType: 'json',
            success: function (response) {

                let rows = '';

                $.each(response, function (index, item) {

                    let status = '';

                    if (item.quantity > 100) {
                        status = '<span class="badge-status badge-approved">In Stock</span>';
                    } else if (item.quantity > 0) {
                        status = '<span class="badge-status badge-info">Low Stock</span>';
                    } else {
                        status = '<span class="badge-status badge-completed">Out of Stock</span>';
                    }

                    rows += `
                        <tr>
                            <td>${item.product_code}</td>
                            <td>${item.product_name}</td>
                            <td>${item.category_name}</td>
                            <td>${item.product_color}</td>
                            <td>${item.size ?? '-'}</td>
                            <td>${item.quantity}</td>
                            <td>${item.unit}</td>
                            <td>${item.warehouse_location}</td>
                            <td>${status}</td>
                        </tr>
                    `;
                });

                $('#productTableBody').html(rows);
            }
        });

    }

});
</script>
<script>

let tableData = [];
let filteredData = [];
let currentPage = 1;
let rowsPerPage = parseInt($('#rowsSelect').val());

$(document).ready(function () {

    loadProducts();

    $('#rowsSelect').change(function () {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        renderTable();
        renderPagination();
    });

    $('#searchInput').on('keyup', applyFilters);

    $('#categoryFilter').on('change', applyFilters);

    $('#statusFilter').on('change', applyFilters);

    $('#sortFilter').on('change', applyFilters);

});

function loadProducts() {

    $.ajax({
        url: '/inventory-list',
        type: 'GET',
        dataType: 'json',
        success: function (response) {

            tableData = response;
            filteredData = [...tableData];

            renderTable();
            renderPagination();
        }
    });

}

function applyFilters() {

    let search = $('#searchInput').val().toLowerCase();
    let category = $('#categoryFilter').val();
    let status = $('#statusFilter').val();
    let sort = $('#sortFilter').val();

    filteredData = tableData.filter(function(item){

        let stockStatus = '';

        if (item.quantity > 100) {
            stockStatus = 'In Stock';
        } else if (item.quantity > 0) {
            stockStatus = 'Low Stock';
        } else {
            stockStatus = 'Out of Stock';
        }

        let searchMatch =
            item.product_code.toLowerCase().includes(search) ||
            item.product_name.toLowerCase().includes(search);

        let categoryMatch =
            category === '' ||
            item.category_name === category;

        let statusMatch =
            status === '' ||
            stockStatus === status;

        return searchMatch && categoryMatch && statusMatch;

    });

    // Sort
    if (sort === 'name') {

        filteredData.sort(function(a, b) {
            return a.product_name.localeCompare(b.product_name);
        });

    }
    else if (sort === 'sno') {

        filteredData.sort(function(a, b) {
            return a.product_code.localeCompare(b.product_code);
        });

    }

    currentPage = 1;

    renderTable();
    renderPagination();
}

function renderTable() {

    let start = (currentPage - 1) * rowsPerPage;
    let end = start + rowsPerPage;

    let pageData = filteredData.slice(start, end);

    let rows = '';

    $.each(pageData, function(index, item) {

        let status = '';

        if (item.quantity > 100) {

            status = '<span class="badge-status badge-approved">In Stock</span>';

        } else if (item.quantity > 0) {

            status = '<span class="badge-status badge-info">Low Stock</span>';

        } else {

            status = '<span class="badge-status badge-completed">Out of Stock</span>';

        }

        rows += `
        <tr>
            <td>${item.product_code}</td>
            <td>${item.product_name}</td>
            <td>${item.category_name}</td>
            <td>${item.product_color}</td>
            <td>${item.size ?? '-'}</td>
            <td>${item.quantity}</td>
            <td>${item.unit}</td>
            <td>${item.warehouse_location}</td>
            <td>${status}</td>
        </tr>
        `;

    });

    $('#productTableBody').html(rows);

}

function renderPagination() {

    let totalPages = Math.ceil(filteredData.length / rowsPerPage);

    let html = '';

    // Previous button
    html += `
        <button class="page-btn"
            onclick="goPage(${currentPage - 1})"
            ${currentPage == 1 ? 'disabled' : ''}>
            <i class="bi bi-chevron-left"></i>
        </button>
    `;

    // Page numbers
    for (let i = 1; i <= totalPages; i++) {

        html += `
            <button class="page-btn ${currentPage == i ? 'active' : ''}"
                onclick="goPage(${i})">
                ${i}
            </button>
        `;

    }

    // Next button
    html += `
        <button class="page-btn"
            onclick="goPage(${currentPage + 1})"
            ${currentPage == totalPages ? 'disabled' : ''}>
            <i class="bi bi-chevron-right"></i>
        </button>
    `;

    $('#paginationWrap').html(html);

}

function goPage(page) {

    let totalPages = Math.ceil(filteredData.length / rowsPerPage);

    if (page < 1 || page > totalPages) {
        return;
    }

    currentPage = page;

    renderTable();
    renderPagination();

}
</script>