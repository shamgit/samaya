@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('goods_receipt') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>Receive Receipt
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
					<td class="info-value">ABC Garments</td>
				</tr>
				<tr class="info-row">
					<td class="info-label">Receive Date</td>
					<td class="info-value">25 Mar 2026</td>
				</tr>	
		    </tbody>
		</table>	
		
		
    </div>
	
	
	 <!-- ── Material Receipt Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Material Receipt Details</span>
      </div>

		<div class="table-card mb-4">
					<div class="table-responsive">
						<table class="supplier-table product-table">				  
						  <thead>
							<tr>
							  <th>Material Name</th>
							  <th>Ordered Qty</th>
							  <th>Received Qty</th>
							  <th>Unit</th>
							  <th>Status</th>
							</tr>
						  </thead>
						  <tbody>						
							<tr>
							  <td>Cotton Fabric</td>
							  <td>500</td>
							  <td><input type="number" placeholder="500"></td>
							  <td>KG</td>
							  <td class="text-success"><i class="bi bi-check-circle-fill"> Full Received</td>
							</tr>
							<tr>
							  <td>Zipper</td>
							  <td>200</td>
							  <td><input type="number" placeholder="180"></td>
							  <td>Pieces</td>
							  <td class="text-warning"><i class="bi bi-check-circle-fill"> Partial</td>
							</tr>
						  </tbody>
						</table>
				    </div>
				</div>
		
    </div>

    <!-- ── Delivery Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Batch & Quality Details</span>
      </div>

      <div class="form-row">			
			<div class="form-group">
			  <label class="form-label">Batch Number</label>
			  <input type="text" class="form-input" id="" placeholder="BATCH-00102"/ >
			</div>
			<div class="form-group">
			  <label class="form-label">Warehouse Location</label>
			  <select class="form-input" id="">
				<option>Main Warehouse - chennai</option><option>Main Warehouse</option>
				<option>Main Warehouse</option><option>Main Warehouse</option>
			  </select>
			</div>
		</div>
		<div class="form-row">			
			<div class="form-group">
			  <label class="form-label">Quality Check</label>
			  <div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
				  <label class="form-check-label info-label p-0" for="inlineRadio1">Passed</label>
				</div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
				  <label class="form-check-label info-label p-0" for="inlineRadio2">Failed</label>
				</div>
			</div>
			<div class="form-group">
			  <label class="form-label">Remark</label>
			  <input type="text" class="form-input" id="" placeholder=""/ >
			</div>
		</div>		
		
    </div>
	

   
    <div class="section-block text-end">
		<button class="btn-cancel" >Cancel</button>
	    <button class="btn-po" >Reject Goods</button>	 	
		<button class="btn-save" >Accept Goods</button>
	</div>		
   
    

  </div><!-- /detail-card -->
  
  
</main>

@include('layouts.footer')

@include('layouts.scripts')  
