@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('issue_material') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>View - IP-0099
      </h1>
    </a>
    
  </div>
  
 

  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Product Selection ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Product Selection</span>
      </div>

        <table class="info-table mb-4">
			<tbody>
				<tr class="info-row">
					<td class="info-label">Product Code</td>
					<td class="info-value">IP-0099</td>
				</tr>
				<tr class="info-row">
					<td class="info-label">Product Name</td>
					<td class="info-value">Fabric</td>
				</tr>
				<tr class="info-row">
					<td class="info-label">Available Stock</td>
					<td class="info-value">5000 Meter</td>
				</tr>
					
		    </tbody>
		</table>	
		
		
    </div>
	
	
    <!-- ── Issue Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Issue Details</span>
      </div>

      	  <table class="info-table mb-4">
			<tbody>
				<tr class="info-row">
					<td class="info-label">Quantity</td>
					<td class="info-value">100</td>
				</tr>
				<tr class="info-row">
					<td class="info-label">Unit</td>
					<td class="info-value">Meter</td>
				</tr>
				<tr class="info-row">
					<td class="info-label">Department</td>
					<td class="info-value">Cutting Unit</td>
				</tr>
				<tr class="info-row">
					<td class="info-label">Issue Date</td>
					<td class="info-value">21 Mar 2026</td>
				</tr>
					
		    </tbody>
		</table>
		
    </div>
	

   
    

  </div><!-- /detail-card -->
  
  
</main>


@include('layouts.footer')

@include('layouts.scripts')  
