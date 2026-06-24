@include('layouts.header')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Purchase Order Tracking</h1>
   
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
	  <option value="Sent">Sent</option>
      <option value="Accepted">Accepted</option>
      <option value="In Delivery">In Delivery</option>
      <option value="Completed">Completed</option>
    </select>
    <select class="filter-select" id="DepartmentFilter">
      <option value="">Department: All</option>
      <option value="ABC Garments">ABC Garments</option>
      <option value="SJ Garments">SJ Garments</option>
	  <option value="FAB Garments">FAB Garments</option>
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
            <th>PO Number</th>
            <th>Supplier </th>
            <th>Material</th>
            <th>Dispatch Date</th>
            <th>Delivery Date</th>
            <th>Status </th>
            <th>Actions</th>
          </tr>
        </thead>
        
		<tbody id="tableBody">
          <tr>
            <td>PO-2026-0012</td>
            <td>ABC Garments</td>
            <td>Cotton Fabric</td>
            <td>1 Mar 2026</td>
			<td>30 Mar 2026</td>
            <td><span class="badge-status badge-denied">
                Sent
              </span></td>           
            <td>
               <a href="{{ route('purchase_order_tracking_view') }}"><div class="stat-icon"><i class="bi bi-eye-fill"></i></div></a>
            </td>
          </tr>
		  <tr>
            <td>PO-2026-0012</td>
            <td>SJ Garments</td>
            <td>Zipper</td>
            <td>1 Mar 2026</td>
			<td>30 Mar 2026</td>
            <td><span class="badge-status badge-approved">
                Accepted
              </span></td>           
            <td>
               <a href="{{ route('purchase_order_tracking_view') }}"><div class="stat-icon"><i class="bi bi-eye-fill"></i></div></a>
            </td>
          </tr>
		  <tr>
            <td>PO-2026-0012</td>
            <td>FAB Garments</td>
            <td>Dyned Fabric</td>
            <td>1 Mar 2026</td>
			<td>30 Mar 2026</td>
            <td><span class="badge-status badge-info">
                In Delivery
              </span></td>           
            <td>
               <a href="{{ route('purchase_order_tracking_view') }}"><div class="stat-icon"><i class="bi bi-eye-fill"></i></div></a>
            </td>
          </tr>
		   <tr>
            <td>PO-2026-0012</td>
            <td>FAB Garments</td>
            <td>Dyned Fabric</td>
            <td>1 Mar 2026</td>
			<td>30 Mar 2026</td>
            <td><span class="badge-status badge-completed">
                Completed
              </span></td>           
            <td>
               <a href="{{ route('purchase_order_tracking_view') }}"><div class="stat-icon"><i class="bi bi-eye-fill"></i></div></a>
            </td>
          </tr>
         
          
        
        
          
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