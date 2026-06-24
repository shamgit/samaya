<!-- SIDEBAR OVERLAY -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<style>

.nav-item-parent.active {
    background: #c8f575;
    border-radius: 6px;
}

.nav-item-parent.active .nav-label,
.nav-item-parent.active i {
    color: #000;
    font-weight: 600;
}
.nav-submenu-inner {
  max-height: 280px;       
  overflow-y: auto;
  padding-right: 6px;      
}

/* Custom scrollbar (optional) */
.nav-submenu-inner::-webkit-scrollbar {
  width: 5px;
}
.nav-submenu-inner::-webkit-scrollbar-track {
  background: #e9e9e9;
  border-radius: 10px;
}
.nav-submenu-inner::-webkit-scrollbar-thumb {
  background: #b3b3b3;
  border-radius: 10px;
}
.nav-submenu-inner::-webkit-scrollbar-thumb:hover {
  background: #8c8c8c;
}

</style>
<!-- ════════════════════════════════
     SIDEBAR
════════════════════════════════ -->
<aside class="sidebar" id="sidebar">
  <div class="d-flex align-items-center justify-content-between px-1 pb-2 mb-1 d-lg-none">
    <div class="brand">
      <img src="{{ asset('assets/img/logo.png')}}" style="width:120px;">
    </div>
    <button class="icon-btn" id="closeSidebarBtn" style="border:none;background:var(--bg);">
      <i class="bi bi-x-lg"></i>
    </button>
  </div>

<div class="nav-divider d-lg-none"></div>
@if(isset($menu_groups) && count($menu_groups))

    @foreach($menu_groups as $menu_group)

        @php
            $isGroupActive = $menu_group->menus->contains(function ($menu) {
                return request()->routeIs($menu->menu_link);
            });
        @endphp

        <div class="nav-item-wrap">

            <div class="nav-item-parent {{ $isGroupActive ? 'active open' : '' }}"
                  id="parent-{{ $menu_group->menu_group_id }}">

                  <div class="nav-label">
                      <i class="{{ $menu_group->menu_group_icon }}"></i>
                      {{ $menu_group->menu_group_name }}
                  </div>

                  <i class="bi bi-chevron-down nav-arrow"></i>

            </div>

            <div class="nav-submenu {{ $isGroupActive ? 'open' : '' }}"
                 id="submenu-{{ $menu_group->menu_group_id }}">

                <div class="nav-submenu-inner">

                    @foreach($menu_group->menus as $menu)

                        <a href="{{ route($menu->menu_link) }}" 
                           class="nav-sub-item {{ request()->routeIs($menu->menu_link) ? 'active' : '' }}">

                            <span class="nav-sub-dot"></span>

                            {{ $menu->menu_name }}

                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    @endforeach

@endif



  <!-- Procurement (with submenu) -->
  <!-- <div class="nav-item-wrap">
    <div class="nav-item-parent" id="procurementParent">
      <div class="nav-label"><i class="bi bi-bag-fill"></i> Procurement</div>
      <i class="bi bi-chevron-down nav-arrow"></i>
    </div>
    <div class="nav-submenu" id="procurementSubmenu">
      <div class="nav-submenu-inner">
        <a href="supplier.php" class="nav-sub-item active" >
          <span class="nav-sub-dot"></span> Suppliers
        </a>
        <a href="purchase-requisition.php" class="nav-sub-item" >
          <span class="nav-sub-dot"></span> Purchase Requisition
        </a>
        <a href="purchase-request-approval.php" class="nav-sub-item" >
          <span class="nav-sub-dot"></span> Purchase Request Approval
        </a>
        <a href="purchase-order.php" class="nav-sub-item" >
          <span class="nav-sub-dot"></span> Purchase Order
        </a>
        <a href="purchase-order-approval.php" class="nav-sub-item" >
          <span class="nav-sub-dot"></span> Purchase Order Approval
        </a>
        <a href="purchase-order-tracking.php" class="nav-sub-item" >
          <span class="nav-sub-dot"></span> Purchase Order Tracking
        </a>
      </div>
    </div>
  </div> -->

  <!-- Material Management (with submenu) -->
  <!-- <div class="nav-item-wrap">
    <div class="nav-item-parent" id="materialParent">
      <div class="nav-label"><i class="bi bi-gear-fill"></i> Material Management</div>
      <i class="bi bi-chevron-down nav-arrow"></i>
    </div>
    <div class="nav-submenu" id="materialSubmenu">
      <div class="nav-submenu-inner">
        <a href="product-master.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Product Master</a>
        <a href="goods-receipt.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Goods Receipt</a>
        <a href="inventory-overview.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Inventory Overview</a>
        <a href="issue-material.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Issue Material</a>
      </div>
    </div>
  </div> -->

  <!-- HR & Finance (with submenu) -->
  <!-- <div class="nav-item-wrap">
    <div class="nav-item-parent" id="hrParent">
      <div class="nav-label"><i class="bi bi-bar-chart-fill"></i> HR &amp; Finance</div>
      <i class="bi bi-chevron-down nav-arrow"></i>
    </div>
    <div class="nav-submenu" id="hrSubmenu">
      <div class="nav-submenu-inner">
        <a href="employee-management.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Employee Management</a>
        <a href="attendance-management.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Attendance Management</a>
        <a href="time-tracking.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Time Tracking</a>
        <a href="payroll-management.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Payroll Management</a>
		<a href="appraisal-management.php" class="nav-sub-item" ><span class="nav-sub-dot"></span> Appraisal Management</a>
      </div>
    </div>
  </div> -->

  <!-- Sales & Distribution -->
	<!-- <div class="nav-item-wrap">
		<div class="nav-item-parent" id="salesParent">
		  <div class="nav-label"><i class="bi bi-shop"></i> Sales &amp; Distribution</div>
		  <i class="bi bi-chevron-down nav-arrow"></i>
		</div>
		<div class="nav-submenu" id="salesSubmenu">
		  <div class="nav-submenu-inner">
			<a href="#" class="nav-sub-item" ><span class="nav-sub-dot"></span> Customer Management</a>
			<a href="#" class="nav-sub-item" ><span class="nav-sub-dot"></span> Sales Order Creation</a>
			<a href="#" class="nav-sub-item" ><span class="nav-sub-dot"></span> Sales Order Approval</a>
		  </div>
		</div>
	  </div> -->

	<!-- Logistics -->
	<!-- <div class="nav-item-wrap">
		<div class="nav-item-parent" id="logisticsParent">
		  <div class="nav-label"><i class="bi bi-truck"></i> Logistics</div>
		  <i class="bi bi-chevron-down nav-arrow"></i>
		</div>
		<div class="nav-submenu" id="logisticsSubmenu">
		  <div class="nav-submenu-inner">
			<a href="#" class="nav-sub-item" ><span class="nav-sub-dot"></span> Shipment planning</a>
			<a href="#" class="nav-sub-item" ><span class="nav-sub-dot"></span> Dispatch management</a>
			<a href="#" class="nav-sub-item" ><span class="nav-sub-dot"></span> Delivery Tracking</a>
		  </div>
		</div>
	  </div> -->

  <!-- <span class="nav-section-label">Operations</span>
  <a href="#" class="nav-item" data-nav><i class="bi bi-file-earmark-bar-graph"></i> Reports</a> -->

  <div class="nav-spacer"></div>
  <div class="nav-divider"></div>
  <a href="#" class="nav-item nav-logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
</aside>
