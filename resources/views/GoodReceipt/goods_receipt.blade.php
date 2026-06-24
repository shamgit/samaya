@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Goods Receipt</h1>
    <div class="header-actions">
      <button class="btn-export" >
        <span>Export</span>
        <i class="bi bi-chevron-down"></i>
      </button>
     
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
      <option value="Received">Status: Received</option>
      <option value="Pending">Status: Pending</option>
      
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
            <th>PO Number</th>
            <th>Supplier</th>
            <th>Product</th>			
            <th>Qty Expected</th>
            <th>Delivery Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        
  <tbody id="purchaseOrderTableBody">
  <tr>
  <td>PO-2026-0045</td>
  <td>ABC Garments</td>
  <td>Mul Fabric</td>
  <td>100 KG</td>
  <td>30 Mar 2026</td>
  <td>
  <span class="badge-status badge-info">
  Received
  </span>
  </td>

  <td>
  <a href="{{ route('goods_receipt_view') }}"><span class="badge-status badge-active"><i class="bi bi-eye"></i> 
  Receive Goods
  </span></a>
  </td>            
  </tr>
  <tr>
  <td>PO-2026-0046</td>
  <td>JR Garments</td>
  <td>Fabric</td>
  <td>10 KG</td>
  <td>30 Mar 2026</td>
  <td>
  <span class="badge-status badge-pending">
  Pending
  </span>
  </td>

  <td>
  -
  </td>            
  </tr>
  </tbody>
		
      </table>
      
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


</main>

@include('layouts.footer')

@include('layouts.scripts')  

<script>
 $(document).ready(function () {

    loadPurchaseOrders();

});

function loadPurchaseOrders()
{
    $.ajax({
        url: '/goods-receipt-list',
        type: 'GET',
        dataType: 'json',
        success: function(response)
        {
            let rows = '';

            $.each(response, function(index, item)
            {
                let statusBadge = '';

                if(item.aproval_status == 'received')
                {
                    statusBadge =
                    `<span class="badge-status badge-info">
                        Received
                    </span>`;
                }
                else
                {
                    statusBadge =
                    `<span class="badge-status badge-pending">
                        Pending
                    </span>`;
                }

                let actionBtn = '';

                if(item.aproval_status == 'received')
                {
                    actionBtn = `
                    <a href="/goods-receipt-view/${item.id}">
                        <span class="badge-status badge-active">
                            <i class="bi bi-eye"></i>
                            Receive Goods
                        </span>
                    </a>`;
                }
                else
                {
                    actionBtn = '-';
                }

                rows += `
                <tr>
                    <td>${item.po_no}</td>
                    <td>${item.supplier_name}</td>
                    <td>${item.product_name}</td>
                    <td>${item.qty}</td>
                    <td>${item.delivery_date}</td>
                    <td>${statusBadge}</td>
                    <td> <a href="{{ route('goods_receipt_view') }}"><span class="badge-status badge-active"><i class="bi bi-eye"></i> 
  Receive Goods
  </span></a></td>
                </tr>`;
            });

            $('#purchaseOrderTableBody').html(rows);
        }
    });
}
</script>  