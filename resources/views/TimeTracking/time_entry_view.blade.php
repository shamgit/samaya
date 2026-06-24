@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('time_tracking') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      View Time Entry</h1>
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
            <td class="info-value">{{ $time_entry_details->employee_code }}</td>
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
        <span class="section-title">Work Details</span>
      </div>
         <table class="info-table mb-4">
			<tbody>
			  <tr class="info-row">
				<td class="info-label">Project / Task</td>
				<td class="info-value">{{ $time_entry_details->project_task }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Form Date</td>
				<td class="info-value">{{ $time_entry_details->form_date }}</td>
			  </tr>
			  <tr class="info-row">
                <td class="info-label">Start Time</td>
                <td class="info-value">
                    {{ date('h:i A', strtotime($time_entry_details->start_time)) }}
                </td>
             </tr>
             <tr class="info-row">
                <td class="info-label">End Time</td>
                <td class="info-value">
                    {{ date('h:i A', strtotime($time_entry_details->end_time)) }}
                </td>
              </tr>
			  <tr class="info-row">
				<td class="info-label">Total Work Hours</td>
				<td class="info-value">{{ $time_entry_details->total_work_hours }}</td>
			  </tr>
               <tr class="info-row">
				<td class="info-label">Dask Description</td>
				<td class="info-value">{{ $time_entry_details->dask_description }}</td>
			  </tr>  
			 	
			</tbody>
		  </table> 
    </div>
	
	
  
  
</main>



@include('layouts.footer')

@include('layouts.scripts')
