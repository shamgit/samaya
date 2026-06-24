@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
  <h1 class="page-title">Dashboard</h1>

  <!-- STAT CARDS -->
  <div class="row g-3">
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-purple d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
		<div>
			<div class="stat-label">Pending Request</div>
			<div class="stat-value">122</div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-blue d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
		<div>
			<div class="stat-label">Awaiting Approval</div>
			<div class="stat-value">108</div>
		</div>
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-green d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-box-fill"></i></div>
		<div>
			<div class="stat-label">Sales Orders</div>
			<div class="stat-value">₹4.2L</div>
		</div>	
      </div>
    </div>
    <div class="col-6 col-xl-3 mb-4">
      <div class="stat-card stat-card-pink d-flex gap-3">
        <div class="stat-icon"><i class="bi bi-person-fill"></i></div>
		<div>
			<div class="stat-label">Attendance</div>
			<div class="stat-value" style="font-size:clamp(18px,3vw,30px);">142/150</div>
		</div>	
      </div>
    </div>
  </div>

  <!-- FINANCIAL + BUDGET + PURCHASE ORDERS -->
  <div class="row g-3">
    <div class="col-12 col-lg-5 d-flex flex-column gap-3">

      <!-- Financial Summary -->
      <div class="dash-card ">
        <div class="card-title mb-3">
          <div class="stat-icon"><i class="bi bi-bar-chart-line-fill"></i></div> Financial Summary
        </div>
        <div class="d-flex align-items-end justify-content-between flex-wrap gap-2">
          <div>
            <div class="fin-amount">₹18.5L</div>
            <div class="fin-sub">of ₹22L budget used</div>
          </div>
          <span class="badge-utilised">84% utilised</span>
        </div>
      </div>

      <!-- Budget Utilisation -->
      <div class="dash-card">
        <div class="card-header-row">
          <div class="card-title">Budget Utilisation</div>
          <button class="filter-btn">This Month <i class="bi bi-chevron-down" style="font-size:9px;"></i></button>
        </div>
        <div class="budget-row">
          <div class="budget-meta"><span class="budget-label">Procurement</span><span class="budget-values">₹8.2L / ₹10L</span></div>
          <div class="progress"><div class="progress-bar bar-purple" style="width:0" data-width="82%"></div></div>
        </div>
        <div class="budget-row">
          <div class="budget-meta"><span class="budget-label">HR &amp; Payroll</span><span class="budget-values">₹6.1L / ₹7L</span></div>
          <div class="progress"><div class="progress-bar bar-green" style="width:0" data-width="87%"></div></div>
        </div>
        <div class="budget-row">
          <div class="budget-meta"><span class="budget-label">Logistics</span><span class="budget-values">₹4.2L / ₹5L</span></div>
          <div class="progress"><div class="progress-bar bar-red" style="width:0" data-width="84%"></div></div>
        </div>
      </div>

    </div>

    <!-- Purchase Orders -->
    <div class="col-12 col-lg-7">
      <div class="dash-card h-100">
        <div class="card-header-row">
          <div class="card-title">Recent Purchase Orders</div>
          <button class="filter-btn">This Week <i class="bi bi-chevron-down" style="font-size:9px;"></i></button>
        </div>
        <div class="po-item">
          <div class="po-row">
            <div class="po-info">
              <div class="po-title">PO-2026-0041 · Mul Cotton fabric (500 kg)</div>
              <div class="po-meta">Supplier: ABC Garment &nbsp;·&nbsp; Raised by Ravi S</div>
            </div>
            <span class="badge-status badge-pending">Pending</span>
          </div>
        </div>
        <div class="po-item">
          <div class="po-row">
            <div class="po-info">
              <div class="po-title">PO-2026-0040 · Packaging Material (500 kg)</div>
              <div class="po-meta">Supplier: ABC Garment &nbsp;·&nbsp; Raised by Arjun R</div>
            </div>
            <span class="badge-status badge-approved">Approved</span>
          </div>
        </div>
        <div class="po-item">
          <div class="po-row">
            <div class="po-info">
              <div class="po-title">PO-2026-0039 · Copper Buttons (600 Pieces)</div>
              <div class="po-meta">Supplier: SJ Garment &nbsp;·&nbsp; Raised by Suresh G</div>
            </div>
            <span class="badge-status badge-delivery">In Delivery</span>
          </div>
        </div>
        <div class="po-item">
          <div class="po-row">
            <div class="po-info">
              <div class="po-title">PO-2026-0038 · Overlock Machine (5)</div>
              <div class="po-meta">Supplier: LT Machinery &nbsp;·&nbsp; Raised by Ravi P</div>
            </div>
            <span class="badge-status badge-completed">Completed</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@include('layouts.footer')