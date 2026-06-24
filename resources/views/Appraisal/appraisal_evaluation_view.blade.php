@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('appraisal_management') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      View - {{ $appraisals_details->employee_code ?? '' }}</h1>
    </a>
    
  </div>
  

  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Employee Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Employee Info</span>
      </div>
	  
	  
	  <table class="info-table mb-4">
        <tbody>
          <tr class="info-row">
            <td class="info-label">Employee Name</td>
            <td class="info-value">{{ $appraisals_details->employee_name  }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Employee Code</td>
            <td class="info-value">{{ $appraisals_details->employee_code }}</td>
          </tr>
          
		    <tr class="info-row">
            <td class="info-label">Designation</td>
            <td class="info-value">{{ $appraisals_details->designation_name }}</td>
          </tr>
        <tr class="info-row">
        <td class="info-label">Department</td>
        <td class="info-value">{{ $appraisals_details->department_name }}</td>
      </tr>
		  <tr class="info-row">
            <td class="info-label">Review Period</td>
            <td class="info-value">{{ $appraisals_details->review_period }}</td>
          </tr>         
        </tbody>
      </table>

      
		
		
    </div>
	 
	
	
    <!-- ── Increment Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Increment Details</span>
      </div>
         <table class="info-table mb-4">
			<tbody>
			  <tr class="info-row">
				<td class="info-label">Rating Scale</td>
				<td class="info-value">{{ $appraisals_details->rating_scale }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Salary Increment Recommendation</td>
				<td class="info-value">₹{{ $appraisals_details->salary_increment_recommendation }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">ManagerFeedback</td>
				<td class="info-value">{{ $appraisals_details->manager_feedback }}</td>
			  </tr> 
			 	
			</tbody>
		  </table> 
    </div>
	
	
  
  
</main>



@include('layouts.footer')

@include('layouts.scripts')
