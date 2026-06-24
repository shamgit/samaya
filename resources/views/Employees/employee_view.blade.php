@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('employee_management') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>View -  {{ $employee_details->employee_code  ?? '-'  }}
      </h1>
    </a>
    
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
            <td class="info-label">Employee Name</td>
            <td class="info-value">{{ $employee_details->employee_name  ?? '-' }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Employee Code</td>
            <td class="info-value">{{ $employee_details->employee_code  ?? '-'  }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Email</td>
            <td class="info-value">{{ $employee_details->email  ?? '-' }} </td>
          </tr> 
          <tr class="info-row">
            <td class="info-label">Date Of Birth</td>
            <td class="info-value">{{ $employee_details->date_of_birth  ?? '-' }} </td>
          </tr>         
          <tr class="info-row">
            <td class="info-label">Phone</td>
            <td class="info-value">{{ $employee_details->phone  ?? '-'  }}</td>
          </tr>
		   <tr class="info-row">
            <td class="info-label">Address</td>
            <td class="info-value">{{ $employee_details->address  ?? '-' }}</td>
          </tr>
		   <tr class="info-row">
            <td class="info-label">City</td>
            <td class="info-value">{{ $employee_details->city  ?? '-'  }}</td>
          </tr>
		  <tr class="info-row">
            <td class="info-label">State</td>
            <td class="info-value">{{ $employee_details->state  ?? '-'  }}</td>
          </tr>
		  <tr class="info-row">
            <td class="info-label">Zip Code</td>
            <td class="info-value">{{ $employee_details->zip_code  ?? '-'  }}</td>
          </tr>
         
        </tbody>
      </table>

      
		
		
    </div>
	 
	  <div class="section-block">
      <div class="section-header">
        <span class="section-title">Bank Details</span>
      </div>
         <table class="info-table mb-4">
			<tbody>
			  <tr class="info-row">
				<td class="info-label">Bank Name</td>
				<td class="info-value">{{ $employee_details->bank_name  ?? '-'  }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Bank Account No</td>
				<td class="info-value">{{ $employee_details->bank_account_no  ?? '-'  }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">IFSC Code</td>
				<td class="info-value">{{ $employee_details->ifsc_code  ?? '-'  }}</td>
			  </tr> 
        <tr class="info-row">
				<td class="info-label">Bank Address</td>
				<td class="info-value">{{ $employee_details->bank_address  ?? '-'  }}</td>
			  </tr> 
        <tr class="info-row">
				<td class="info-label">PF Number</td>
				<td class="info-value">{{ $employee_details->pf_number  ?? '-'  }}</td>
			  </tr> 
			  <tr class="info-row">
				<td class="info-label">Payment Type</td>
				<td class="info-value">  
          @if($employee_details->payment_type == 'Bank Transfer')
            <span>
                Bank Transfer
            </span>
          @else
          <span>
             Cash
          </span>

          @endif
              
        </td>
			  </tr>
        </tbody>
		</table>
    </div>

	
    <!-- ── Job Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Job Details</span>
      </div>
         <table class="info-table mb-4">
			<tbody>
			  <tr class="info-row">
				<td class="info-label">Designation</td>
				<td class="info-value">{{ $employee_details->designation_name  ?? '-'  }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Department</td>
				<td class="info-value">{{ $employee_details->name  ?? '-'  }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Joining Date</td>
				<td class="info-value">{{ $employee_details->joining_date  ?? '-'  }}</td>
			  </tr> 
        <td class="info-label">Company Name</td>
				<td class="info-value">{{ $employee_details->company_name  ?? '-'  }}</td>
			  </tr> 
			  <tr class="info-row">
				<td class="info-label">Employee Type</td>
				<td class="info-value">  
          @if($employee_details->employee_type == 1)
            <span>
                Full Time
            </span>
          @else
          <span>
              Part Time
          </span>

          @endif
              
        </td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Employee Document</td>
				<td class="info-value">
            <div class="d-flex gap-3">
                <div class="file-box">
                    <a 
                        href="{{ asset('assets/employee_document/'.$employee_details->employee_document) }}"
                        target="_blank"
                        class="text-decoration-none"
                    >
                        <i class="bi bi-folder2-open"></i>

                        {{ $employee_details->employee_document  ?? '-'  }}
                    </a>

                </div>

            </div>

        </td>
			  </tr>	
			</tbody>
		  </table> 
    </div>
	
	<!-- ── Salary Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Salary Details</span>
      </div>
        <table class="info-table mb-4">
			<tbody>
			  <tr class="info-row">
				<td class="info-label">Basic Salary</td>
				<td class="info-value">₹{{ $employee_details->basic_salary  ?? '-'  }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Allowances</td>
				<td class="info-value">₹{{ $employee_details->allowances  ?? '-'  }}</td>
			  </tr>
			  <tr class="info-row">
				<td class="info-label">Total Salary</td>
				<td class="info-value">₹{{ $employee_details->total_salary  ?? '-'  }}</td>
			  </tr>	
			</tbody>
		</table>
    </div>
  </div><!-- /detail-card -->
  
  
</main>

<!-- FileModal -->
<div class="modal fade" id="FileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Document</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>     
    </div>
  </div>
</div>
@include('layouts.footer')

@include('layouts.scripts')
