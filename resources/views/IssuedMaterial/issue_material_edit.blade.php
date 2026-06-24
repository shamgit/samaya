@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <a href="{{ route('issue_material') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Product Issue Edit</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Product Selection ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Product Selection</span>
      </div>

      <input type="hidden" id="editId"/>
      <div class="form-row">
		<div class="form-group">
			  <label class="form-label">Product Name </label>
			  <select class="form-input" id="fCategory">
				<option value="">Select Category</option>
				<option>Fabric</option><option>Trims</option>
				<option>Dyeing</option><option>Stitching</option>
			  </select>
			</div>  
        <div class="form-group">
          <label class="form-label">Available Stock</label>
          <input type="text" class="form-input" id="" placeholder="5000 meters" disabled />
        </div>
      </div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Product Code</label>
			  <input type="text" class="form-input" id="fPhone" placeholder="PR-00106" disabled />
			</div>
			
		</div>	
		
		
		
    </div>

    <!-- ── Issue Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Issue Details</span>
      </div>
        <div class="form-row">
			<div class="form-group">
			  <label class="form-label">Quantity *</label>
			  <input type="text" class="form-input" id="" placeholder="100" />
			</div>
			<div class="form-group">
			  <label class="form-label">Unit *</label>
			  <select class="form-input" id="">
				<option value="">Select Unit</option>
				<option>Meter</option><option>KG</option>
				<option>L</option><option>Pcs</option>
			  </select>
			</div>			
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Department *</label>
			  <select class="form-input" id="">
				<option value="">Select Department</option>
				<option value="Cutting Unit">Cutting Unit</option>
				<option value="Dyeing Unit">Dyeing Unit</option>
				<option value="Stitching Unit">Stitching Unit</option>
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">Issue Date</label>
			  <input type="text" class="form-input" id="" placeholder="21 Mar 2026" disabled />
			</div>						
		</div>
    </div>
	
	
	
    <div class="section-block text-end">
		<button class="btn-cancel" >Cancel</button>
		<button class="btn-save" >Issue Product</button>
	</div>		
   
    

  </div><!-- /detail-card -->
  
  
</main>


@include('layouts.footer')

@include('layouts.scripts')  
