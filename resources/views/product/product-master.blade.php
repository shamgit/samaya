@include('layouts.header')
@include('layouts.sidebar')

<style>
.action-wrap{
    position:relative;
}

.action-menu{
    position:absolute;
    top:35px;
    right:0;
    background:#fff;
    min-width:150px;
    border-radius:8px;
    box-shadow:0 2px 10px rgba(0,0,0,0.15);
    display:none;
    z-index:9999;
}

.action-menu.show-menu{
    display:block;
}

.action-menu-item{
    padding:10px 15px;
    cursor:pointer;
    border-bottom:1px solid #eee;
}

.action-menu-item:last-child{
    border-bottom:none;
}

.action-menu-item:hover{
    background:#f5f5f5;
}

.action-menu-item a{
    text-decoration:none;
    color:#333;
    display:block;
}
.table-scroll{
    overflow: visible !important;
    max-height: unset !important;
    height: auto !important;
}

.table-card{
    overflow: visible !important;
}

.supplier-table{
    width: 100%;
    overflow: visible !important;
}
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Product Master</h1>
    <div class="header-actions">
      <button class="btn-export" >
        <span>Export</span>
        <i class="bi bi-chevron-down"></i>
      </button>
      <a href="{{ route('products-master-add') }}"><button class="btn-add" >
        <i class="bi bi-plus-lg"></i>
        <span class="add-txt">Add Product</span>
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
      <option value="">Category: All</option>
      <option value="Fabric">Fabric</option>
      <option value="Trims">Trims</option>
      <option value="Dyeing">Dyeing</option>
      <option value="Stitching">Stitching</option>
    </select>
    <select class="filter-select" id="statusFilter">
	  <option value="">Status: All</option>
      <option value="Active">Status: Active</option>
      <option value="Inactive">Status: Inactive</option>
	  <option value="Low Stack">Status: Low Stack</option>
      
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
      <table class="supplier-table" >
        <thead>
          <tr>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Category</th>			
            <th>Unit</th>
            <th>Supplier</th>
            <th>Reorder</th>
			<th>Warehouse</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>

      <tbody id="productTableBody"></tbody>
		
      </table>
      
    </div>

    <!-- ══════════ FOOTER / PAGINATION ══════════ -->
  <div class="table-footer">

    <div class="rows-per-page">

        Row Per Page

        <select class="rows-select" id="rowsSelect">

            <option value="10">10</option>

            <option value="25">25</option>

            <option value="50">50</option>

        </select>

        Entries

    </div>

    <div class="pagination-wrap" id="paginationWrap"></div>

</div>
  </div>

</div><!-- /page-wrap -->


</main>
@include('layouts.footer')
@include('layouts.scripts')
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
<script>

$(document).ready(function () {

    loadProducts(1);

    // Search
    $('#searchInput').keyup(function () {

        loadProducts(1);

    });

    // Category Filter
    $('#categoryFilter').change(function () {

        loadProducts(1);

    });

    // Status Filter
    $('#statusFilter').change(function () {

        loadProducts(1);

    });

    // Sort
    $('#sortFilter').change(function () {

        loadProducts(1);

    });

    // Row Per Page
    $('#rowsSelect').change(function () {

        loadProducts(1);

    });

    // Export
    $('.btn-export').click(function () {

        exportTable();

    });

});


// Load Products
function loadProducts(page = 1)
{
    $.ajax({

        url: "{{ route('products.list') }}",

        type: "GET",

        data: {

            page: page,

            rows: $('#rowsSelect').val(),

            search: $('#searchInput').val(),

            category: $('#categoryFilter').val(),

            status: $('#statusFilter').val(),

            sort: $('#sortFilter').val()

        },

        success: function(response) {

            let html = '';

            if(response.data.length == 0)
            {
                html += `

                <tr>

                    <td colspan="9" class="text-center">

                        No Data Found

                    </td>

                </tr>

                `;
            }

            $.each(response.data, function(index, product){

                let statusBadge = '';

                if(product.status == 'Active')
                {
                    statusBadge = 'badge-active';
                }
                else if(product.status == 'Inactive')
                {
                    statusBadge = 'badge-inactive';
                }
                else
                {
                    statusBadge = 'badge-info';
                }

                html += `

                <tr>

                    <td>${product.product_code ?? ''}</td>

                    <td>${product.product_name ?? ''}</td>

                    <td>${product.category_name ?? ''}</td>

                    <td>${product.unit_of_measure ?? ''}</td>

                    <td>${product.supplier_name ?? ''}</td>

                    <td>${product.reorder_level ?? ''}</td>

                    <td>${product.warehouse_location ?? ''}</td>

                    <td>

                        <span class="badge-status ${statusBadge}">

                            ${product.status ?? ''}

                        </span>

                    </td>

                    <td style="text-align:center; position:relative;">

                        <div class="action-wrap">

                            <button type="button"
                                class="btn-action"
                                data-id="${product.id}"
                                onclick="toggleMenu(this, event)">

                                <i class="bi bi-three-dots-vertical"></i>

                            </button>

                            <div class="action-menu"
                                data-menu="${product.id}">

                                <div class="action-menu-item" data-menu="${product.id}">

                                    <a href="/product-edit/${btoa(product.id)}">

                                        <i class="bi bi-pencil"></i>

                                        Edit

                                    </a>

                                </div>

                               <div class="action-menu-item" data-menu="${product.id}">
                                    <a href="/product-view/${btoa(product.id)}">
                                        <i class="bi bi-eye"></i>
                                        View
                                    </a>
                                </div>

                                <div class="action-menu-item delete"
                                    onclick="deleteProduct(${product.id})">

                                    <i class="bi bi-trash"></i>

                                    Delete

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

                `;
            });

            $('#productTableBody').html(html);

            // Pagination
            let pagination = '';

            pagination += `

            <button class="page-btn"
                ${response.current_page == 1 ? 'disabled' : ''}
                onclick="loadProducts(${response.current_page - 1})">

                <i class="bi bi-chevron-left"></i>

            </button>

            `;

            for(let i = 1; i <= response.last_page; i++)
            {
                pagination += `

                <button
                    class="page-btn ${response.current_page == i ? 'active' : ''}"
                    onclick="loadProducts(${i})">

                    ${i}

                </button>

                `;
            }

            pagination += `

            <button class="page-btn"
                ${response.current_page == response.last_page ? 'disabled' : ''}
                onclick="loadProducts(${response.current_page + 1})">

                <i class="bi bi-chevron-right"></i>

            </button>

            `;

            $('#paginationWrap').html(pagination);

        }

    });
}


// Toggle Action Menu
function toggleMenu(btn, e)
{
    e.stopPropagation();

    closeAllMenus();

    const id = btn.dataset.id;

    const menu = document.querySelector(
        `.action-menu[data-menu="${id}"]`
    );

    if(menu)
    {
        menu.classList.toggle('show-menu');
    }
}


// Close Menu
function closeAllMenus()
{
    document.querySelectorAll('.action-menu')
        .forEach(menu => {

            menu.classList.remove('show-menu');

        });
}

document.addEventListener('click', function () {

    closeAllMenus();

});


// Delete Product
function deleteProduct(id)
{
    Swal.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#3085d6',

        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {

        if(result.isConfirmed)
        {
            $.ajax({

                url: '/product-delete/' + id,

                type: 'DELETE',

                data: {

                    _token: '{{ csrf_token() }}'

                },

                success: function(response) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Deleted!',

                        text: response.message,

                        timer: 2000,

                        showConfirmButton: false

                    });

                    loadProducts(1);

                },

                error: function(xhr) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Delete Failed'

                    });

                }

            });
        }

    });
}


// Export CSV
function exportTable()
{
    let csv = [];

    let rows = document.querySelectorAll('.supplier-table tr');

    rows.forEach(function(row){

        let cols = row.querySelectorAll('td, th');

        let rowData = [];

        cols.forEach(function(col, index){

            if(index != cols.length - 1)
            {
                rowData.push(col.innerText);
            }

        });

        csv.push(rowData.join(','));

    });

    downloadCSV(csv.join('\n'), 'products.csv');
}


// Download CSV
function downloadCSV(csv, filename)
{
    let csvFile = new Blob([csv], {
        type: "text/csv"
    });

    let downloadLink = document.createElement("a");

    downloadLink.download = filename;

    downloadLink.href = window.URL.createObjectURL(csvFile);

    downloadLink.style.display = "none";

    document.body.appendChild(downloadLink);

    downloadLink.click();
}

function deleteProduct(id)
{
    Swal.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#3085d6',

        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {

        if(result.isConfirmed)
        {
            $.ajax({

                url: '/product-delete/' + id,

                type: 'DELETE',

                data: {

                    _token: '{{ csrf_token() }}'

                },

                success: function(response) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Deleted!',

                        text: response.message,

                        timer: 2000,

                        showConfirmButton: false

                    });

                    // Reload Product List
                    loadProducts(1);

                },

                error: function(xhr) {

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Delete Failed'

                    });

                    console.log(xhr.responseText);

                }

            });
        }

    });
}
</script>