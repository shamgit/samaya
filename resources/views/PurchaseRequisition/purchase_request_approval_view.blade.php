@include('layouts.header')
<link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css"/> 
@include('layouts.sidebar')

<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('purchase_request_approval') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      View – PR-2026-0012</h1>
    </a>
   
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── BASIC INFORMATION ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Request Details</span>       
      </div>

      <table class="info-table mb-4">
        <tbody>
          <tr class="info-row">
            <td class="info-label">Request ID</td>
            <td class="info-value">PR-2026-0012</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Department</td>
            <td class="info-value">Production</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Requested By</td>
            <td class="info-value">Merchandiser</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Request Date</td>
            <td class="info-value">12 Mar 2026</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Required Date</td>
            <td class="info-value">30 Mar 2026</td>
          </tr>
          
        </tbody>
      </table>
    </div>
	
	<div class="section-block">
      <div class="section-header">
        <span class="section-title">Product Details</span>
      </div>

      <div class="table-card mb-4">
		<div class="table-scroll">
			<table class="supplier-table " >
      
          <thead>
            <tr>
              <th >Product Name</th>
              <th >Category</th>
              <th >Color</th>
              <th >Size</th>
              <th >Quantity</th>
              <th >Unit</th>
            </tr>
          </thead>
          <tbody >
            
			<tr>
              <td>Cotton Fabric</td>
              <td>Fabric</td>
              <td>#012452</td>
              <td>40s</td>
              <td>500</td>
              <td>Meters</td>
            </tr>
			<tr>
              <td>Zipper</td>
              <td>Trims</td>
              <td>#012452</td>
              <td>1 Inch</td>
              <td>200</td>
              <td>Pieces</td>
            </tr>
			<tr>
              <td>Cotton Fabric</td>
              <td>Fabric</td>
              <td>#012452</td>
              <td>40s</td>
              <td>500</td>
              <td>Meters</td>
            </tr>
          </tbody>
        </table>
      </div>
	  </div>
    </div>

    <!-- ── BUSINESS DETAILS ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Additional Info</span>
      </div>

      <table class="info-table mb-4">
        <tbody>
          <tr class="info-row">
            <td class="info-label">Priority</td>
            <td class="info-value">High Priority</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Remark</td>
            <td class="info-value">Required for Summer Collection - Style #ST102</td>
          </tr>
         
        </tbody>
      </table>
    </div>

   
    <div class="section-block text-end">
		<button class="btn-cancel" >Reject</button>
		<button class="btn-save" id="b4">Approve Request</button>
	</div>		
   

  </div><!-- /detail-card -->
  
  
</main>


@include('layouts.footer')

@include('layouts.scripts')
<script src="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.min.js"></script>
<script>
document.getElementById('b4').onclick = function(){
	swal({
		title: "Are you sure you want to approve this request?",
		type: "success",
		showCancelButton: true,
		confirmButtonColor: '#c8f575',
		confirmButtonText: 'Yes',
		closeOnConfirm: false,
		//closeOnCancel: false
	},
	function(){
		swal("Approval", "Request has been Approval!", "success",);
	});
};
</script>