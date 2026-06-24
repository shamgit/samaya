@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('leaves') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      View Leave</h1>
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
            <td class="info-value">{{ $employees->employee_name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Employee Code</td>
            <td class="info-value">{{ $leave_details->employee_code }}</td>
          </tr>
          
		   <tr class="info-row">
            <td class="info-label">Designation</td>
            <td class="info-value">{{ $designations->name }}</td>
          </tr>
		  <tr class="info-row">
            <td class="info-label">Department</td>
            <td class="info-value">{{ $departments->name }}</td>
          </tr>         
        </tbody>
      </table>
    </div>
	 
	
	
    <!-- ── Increment Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Leave Details</span>
      </div>
         <table class="info-table mb-4">
			<tbody>
			  <tr class="info-row">
				<td class="info-label">Leave Type</td>
				<td class="info-value">{{ $leave_types->name }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">From Date</td>
				<td class="info-value">{{ $leave_details->from_date }}</td>
			  </tr>
			  <tr class="info-row">
          <td class="info-label">To Date</td>
          <td class="info-value">
              {{ $leave_details->to_date }}
          </td>
        </tr>
			  <tr class="info-row">
				<td class="info-label">Manager Approval</td>
				<td class="info-value">{{ $users->name }}</td>
			  </tr>
        <tr class="info-row">
				<td class="info-label">Reason</td>
				<td class="info-value">{{ $leave_details->reason }}</td>
			  </tr>  
			 	
			</tbody>
		  </table> 
    </div>

</main>

@include('layouts.footer')

@include('layouts.scripts')
