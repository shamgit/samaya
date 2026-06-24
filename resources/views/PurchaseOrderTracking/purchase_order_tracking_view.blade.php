@include('layouts.header')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
	<a href="{{ route('purchase_order_tracking') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>View - PO-2026-0045
      </h1>
    </a>
    
  </div>
  
   <!-- ══════════ DETAIL CARD ══════════ -->
	<div class="detail-card mb-4">
		<!-- ── Status Timeline ── -->
		<div class="section-block">
		  <div class="section-header">
			<span class="section-title">Status Timeline</span>
		  </div>
		  
			<div class="tl-wrapper">   

				<div class="tl-steps">

				  <!-- Step 1: Approved -->
				  <div class="tl-step">
					<div class="tl-circle done">
					  <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
						   stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="20 6 9 17 4 12"/>
					  </svg>
					</div>
					<div class="tl-step-text">
					  <p class="tl-name mb-0">Sent</p>
					</div>
				  </div>

				  <!-- Connector: solid green -->
				  <div class="tl-connector done"></div>

				  <!-- Step 2: Active Pending -->
				  <div class="tl-step">
					<div class="tl-circle done">
					  <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
						   stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="20 6 9 17 4 12"/>
					  </svg>
					</div>
					<div class="tl-step-text">
					  <p class="tl-name mb-0">Accepted</p>
					</div>
				  </div>
				  <!-- Connector: solid green -->
				  <div class="tl-connector done"></div>

				  <!-- Step 3: Active Pending -->
				  <div class="tl-step">
					<div class="tl-circle done">
					  <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
						   stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="20 6 9 17 4 12"/>
					  </svg>
					</div>
					<div class="tl-step-text">
					  <p class="tl-name mb-0">In Delivery</p>
					</div>
				  </div>

				  <!-- Connector: dashed gray -->
				  <div class="tl-connector pending"></div>

				  <!-- Step 4: Idle Pending -->
				  <div class="tl-step">
					<div class="tl-circle idle">
					  <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
						   stroke="#adb5bd" stroke-width="2" stroke-linecap="round">
						<circle cx="12" cy="12" r="1"/>
						<circle cx="19" cy="12" r="1"/>
						<circle cx="5" cy="12" r="1"/>
					  </svg>
					</div>
					<div class="tl-step-text">
					  <p class="tl-name text-secondary mb-0">Completed</p>
					</div>
				  </div>

				</div>
  </div>
		  
		</div>  
	</div>
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Basic Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Basic Info</span>
      </div>

      <table class="info-table mb-4">
        <tbody>
          <tr class="info-row">
            <td class="info-label">PO Number</td>
            <td class="info-value">PO-2026-0045</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Supplier</td>
            <td class="info-value">Sri Lakshmi Fabric</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Product</td>
            <td class="info-value">Cotton Fabric (500 meters) & Zipper (200 pcs)</td>
          </tr>          
        </tbody>
      </table>	
		
		
    </div>
	
	
	 <!-- ── Shipment Delivery ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Shipment Delivery</span>
      </div>

			<table class="info-table mb-4">
				<tbody>
				  <tr class="info-row">
					<td class="info-label">Dispatch Date</td>
					<td class="info-value">23 Mar 2026</td>
				  </tr>
				  <tr class="info-row">
					<td class="info-label">Transport Mode</td>
					<td class="info-value">Road</td>
				  </tr>
				  <tr class="info-row">
					<td class="info-label">Tracking ID</td>
					<td class="info-value">TRK-526456</td>
				  </tr>
				  <tr class="info-row">
					<td class="info-label">Carrier</td>
					<td class="info-value">ABC Logistics</td>
				  </tr>
				</tbody>
			</table>	
		
    </div>
	
	<!-- ── Delivery & Payment ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Delivery Delivery</span>
      </div>

		<table class="info-table mb-4">
				<tbody>
				  <tr class="info-row">
					<td class="info-label">Expected Delivery</td>
					<td class="info-value">25 Mar 2026</td>
				  </tr>
				  <tr class="info-row">
					<td class="info-label">Delivery Location</td>
					<td class="info-value">Main warehouse - chennai</td>
				  </tr>				  
				</tbody>
		</table>
		
		
    </div>
   	
	
	 <!-- ── Material & Cost Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Material & Cost Details</span>
      </div>

		<div class="row">
			<div class="col-md-8">
				<div class="table-card mb-4">
					<div class="table-responsive">
						<table class="supplier-table">				  
						  <thead>
							<tr>
							  <th>Product Name</th>
							  <th>Quantity</th>
							  <th>Unit Price</th>
							  <th>Total</th>
							</tr>
						  </thead>
						  <tbody>						
							<tr>
							  <td>Cotton Fabric</td>
							  <td>500</td>
							  <td>₹120</td>
							  <td>₹60,000</td>
							</tr>
							<tr>
							  <td>Zipper</td>
							  <td>200</td>
							  <td>₹10</td>
							  <td>₹2,000</td>
							</tr>
						  </tbody>
						</table>
				    </div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="table-card mb-4">
					<div class="table-responsive">
						<table class="supplier-table">				  
						
						  <tbody>						
							<tr>
							  <td>Subtotal</td>							  
							  <td>₹62,000</td>
							</tr>
							<tr>
							  <td>GST(18%)</td>
							  <td>₹11,160</td>
							</tr>
							<tr>
							  <td>Total Amount</td>
							  <td>₹73,160</td>
							</tr>
						  </tbody>
						</table>
				    </div>
				</div>
			</div>
		</div>
		
    </div>

   
   
    

  </div><!-- /detail-card -->
  
  
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