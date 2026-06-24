@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Issued Material Record</h1>
    <div class="header-actions">
      <button class="btn-export" >
        <span>Export</span>
        <i class="bi bi-chevron-down"></i>
      </button>
      <a href="{{ route('issue_material_add') }}"><button class="btn-add" >
        <i class="bi bi-plus-lg"></i>
        <span class="add-txt">Issue Product</span>
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
      <option value="">Product: All</option>
      <option value="Mul Coton Fabric">Mul Coton Fabric</option>
      <option value="Color Dye">Color Dye</option>
      <option value="Yarns">Yarns</option>
      <option value="Denim">Denim</option>
	  <option value="Steel Button">Steel Button</option>
    </select>
    <select class="filter-select" id="statusFilter">
	  <option value="">Department: All</option>
      <option value="Cutting Unit">Cutting Unit</option>
      <option value="Dyeing Unit">Dyeing Unit</option>
	  <option value="Low Stack">Stitching Unit</option>
      
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
            <th>Issued ID</th>
            <th>Product Name</th>
            <th>Quantity</th>			
            <th>Department</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        
		<tbody>
          <tr>
            <td>IP-0099</td>
            <td>Mul cotton Fabric</td>
            <td>100 KG</td>
            <td>Cutting Unit</td>
            <td>30 Mar 2026</td>
            <td>
              <span class="badge-status badge-active">
                Issued
              </span>
            </td>
            <td>
              <a href="{{ route('issue_material_view') }}"><div class="stat-icon"><i class="bi bi-eye-fill"></i></div></a>
            </td> 
          </tr>
        
          <tr>
            <td>IP-0099</td>
            <td>Mul cotton Fabric</td>
            <td>100 KG</td>
            <td>Cutting Unit</td>
            <td>30 Mar 2026</td>
            <td>
              <span class="badge-status badge-pending">
                Pending
              </span>
            </td>
            <td>
              <a href="{{ route('issue_material_edit') }}"><div class="stat-icon"><i class="bi bi-eye-fill"></i></div></a>
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