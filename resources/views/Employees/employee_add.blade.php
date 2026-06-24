@include('layouts.header')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
@include('layouts.sidebar')
<style>
.form-group {
	margin-bottom: 1rem;
	position: relative;
}
.form-label {
	display: block;
	margin-bottom: 0.5rem;
	font-weight: 500;
}
#pwdIcon {
	position: absolute;
	right: 10px;
	bottom: 5px;
	cursor: pointer;
	font-size: 1.2rem;
	color: #6c757d;
}
#pwdIcon:hover {
	color: #000;
}
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('employee_management') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Add New Employee</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Basic Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Basic Info</span>
      </div>

      <form id="EmployeeForm" method="POST"action="{{ route('employee_store') }}"enctype="multipart/form-data">
       @csrf
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Employee Name <span class="text-danger">*</span></label>
          <input type="text" class="form-input"  name="employee_name" required placeholder="Enter Employee Name"/>
        </div>
        <div class="form-group">
          <label class="form-label">Employee Code</label>
          <input type="text" class="form-input" id="employee_code"  name="employee_code"  placeholder="EMP-104" readonly />
        </div>
      </div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Email <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="email"  autocomplete="off" required placeholder="Enter Email"/>
			</div>
			<div class="form-group"> 
				<label class="form-label">Password <span class="text-danger">*</span></label>
				<input type="password" id="password" name="password" class="form-input" autocomplete="new-password" placeholder="Enter Password"  required>
				 <i class="bi bi-eye-slash" id="pwdIcon"></i>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Phone <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="phone" required placeholder="Enter Phone"/>
			</div>
			<div class="form-group">
				<label class="form-label">Gender <span class="text-danger">*</span></label>
				<select class="form-input" name="gender" required>
					<option value="">Select Gender</option>
					<option value="1">Male</option>
					<option value="2">Female</option>
					<option value="3">Other</option>
				</select>
			</div>
		</div>
		 <div class="form-row">
		   <div class="form-group">
				<label class="form-label">Date Of Birth <span class="text-danger">*</span></label>
				<div class="input-group date_picker">
					<input type="text" class="form-control" id="d_requestDate"  name="date_of_birth" placeholder="Select date" readonly />
					<span class="input-group-text bg-white">
					<svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
					</span>
				</div>
			</div>
			<div class="form-group">
				<label class="form-label">Role <span class="text-danger">*</span></label>
				<select class="form-input" name="role_id" required>
				  <option value="">Select Roles</option>
				  @foreach($roles as $role)
					<option value="{{ $role->role_id }}">
						{{ $role->role_name }}
					</option>
					@endforeach
				</select>
			</div>
		</div>			
        <div class="form-row">
			<div class="form-group">
				<label class="form-label">Status <span class="text-danger">*</span></label>
				<select class="form-input" name="status" required>
					<option value="">Select Status</option>
					<option value="1"> Active</option>
					<option value="0"> Inactive</option>
				</select>
			</div>
			<div class="form-group">
			  <label class="form-label">Address <span class="text-danger">*</span></label>
			  <input type="text" class="form-input"  name="address" required placeholder="Enter Address"/>
			</div>
        </div>
		
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">City <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="city" required placeholder="Enter City"/>
			</div>
			<div class="form-group">
			  <label class="form-label">State <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="state" required placeholder="Enter State"/>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Zip Code <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="zip_code" required placeholder="Enter Zip Code"/>
			</div>
		</div>
		
    </div>

    <!-- ── Job Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Job Details</span>
      </div>

      <div class="form-row">
			<div class="form-group">
			  <label class="form-label">Designation <span class="text-danger">*</span></label>
			  <select class="form-input" name="designation_id" required>
				<option value="">Select Designation</option>
				  @foreach($designations as $designation)
					<option value="{{ $designation->designation_id }}">
						{{ $designation->name }}
					</option>
					@endforeach
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">Department <span class="text-danger">*</span></label>
			  <select class="form-input"  name="department_id" required>
				<option value="">Select Department</option>
				  @foreach($departments as $department)
					<option value="{{ $department->department_id }}">
						{{ $department->name }}
					</option>
					@endforeach
			  </select>
			</div>			
		</div>
		<div class="form-row">			
			<div class="form-group">
			  <label class="form-label">Joining Date <span class="text-danger">*</span></label>
			  <div class="input-group date_picker">
				<input type="text" class="form-control" id="f_requestDate"  name="joining_date" placeholder="Select date" required readonly />
				<span class="input-group-text bg-white">
				  <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
				</span>
			  </div>
			</div>
			<div class="form-group">
			  <label class="form-label">Employee Type <span class="text-danger">*</span></label>
			  <select class="form-input"  name="employee_type" required>
			    <option value="">Select Employee Type</option>
				<option value="1" >Full Time</option>
				<option value="0"> Part Time</option>
			  </select>
			</div>
		</div>	
		<div class="form-row">
		   <div class="form-group">
              <label class="form-label"> Company <span class="text-danger">*</span></label>
              <input type="text" class="form-input" name="company_name"  placeholder="Enter Company Name">
           </div>			
			<div class="form-group">
			  <label class="form-label">Employee Document <span class="text-danger">*</span></label>
			  <div class="input-group date_picker file_btn">
				<input type="text" class="form-control" placeholder="Upload files" id="fileName" readonly="">
				<input type="file" class="d-none" id="fileInput" name="employee_document" required>
				<button class="btn btn-primary" type="button" onclick="document.getElementById('fileInput').click()">
				  Browse Files
				</button>
			  </div>
			</div>
		</div>
		
    </div>

	<div class="section-block">
		<div class="section-header">
			<span class="section-title">Bank Details</span>
		</div>
	    <div class="form-row">
          <div class="form-group">
              <label class="form-label"> Bank Name <span class="text-danger">*</span></label>
              <input type="text" name="bank_name" class="form-input" placeholder="Enter Bank Name" required>
          </div>
           <div class="form-group">
                <label class="form-label">Bank Account No <span class="text-danger">*</span></label>
                <input type="text" name="bank_account_no" class="form-input" placeholder="Enter Bank Account No" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">IFSC Code <span class="text-danger">*</span></label>
				<input type="text" name="ifsc_code" class="form-input" placeholder="Enter IFSC Code" required>
            </div>
            <div class="form-group">
                <label class="form-label">Bank Address <span class="text-danger">*</span></label>
                <input type="text"name="bank_address" class="form-input" placeholder="Enter Bank Address" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
				<label class="form-label"> PF Number <span class="text-danger"></span></label>
				<input type="text" name="pf_number" class="form-input" placeholder="Enter PF Number">
            </div>
			<div class="form-group">
				<label class="form-label">Payment Type <span class="text-danger">*</span></label>
				<select name="payment_type"class="form-input" required>
					<option value="">Select Payment Type </option>
					<option value="Bank Transfer">Bank Transfer</option>
					<option value="Cash">Cash</option>
				</select>
			</div>
        </div>
    </div>
	
	<!-- ── Salary Details ── -->
    <div class="section-block">
		<div class="section-header">
			<span class="section-title">Salary Details</span>
		</div>

      <div class="form-row">
			<div class="form-group">
			  <label class="form-label">Basic Salary <span class="text-danger">*</span>
			  <input type="text" class="form-input" id="fBasicSalary"   name="basic_salary" required placeholder="Basic Salary"/>
			</div>
			<div class="form-group">
			  <label class="form-label">Allowances</label>
			  <input type="text" class="form-input" id="fAllowances"  name="allowances" required placeholder="Allowances"/>
			</div>			
		</div>
		<div class="form-row">			
			<div class="form-group">
			  <label class="form-label">Total Salary</label>
			  <input type="text" class="form-input" id="fTotalSalary"  name="total_salary"  placeholder="₹40,000" readonly />
			</div>
		</div>
		
				
    </div>

	
	
    <div class="section-block text-end">
		<a class="btn-cancel"  onclick="window.location='{{ route('employee_management') }}'" >Cancel</a>
		<button  type="submit" class="btn-save">Save Employee</button>
	</div>	
   </form>	
   
    

  </div><!-- /detail-card -->
  
  
</main>

@include('layouts.footer')

@include('layouts.scripts') 
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 

<script>
$(document).ready(function () {

    $.ajax({

        url: "{{ route('get_employee_code') }}",
        type: "GET",

        success: function (response) {

          
            let lastEmployeeId = response.last_id;

           
            let nextEmployeeId = lastEmployeeId + 1;

           
            let formattedNumber = String(nextEmployeeId).padStart(2, '0');

            
            let employeeCode = `EMP-${formattedNumber}`;

            $("#employee_code").val(employeeCode);
        },

        error: function () {

            alert("Failed to generate employee code");
        }

    });

});

</script>
<script>

   // TOTAL SALARY CALCULATION
    $("#fBasicSalary, #fAllowances").on("keyup change", function () {

        let basic = parseFloat($("#fBasicSalary").val()) || 0;

        let allowance = parseFloat($("#fAllowances").val()) || 0;

        let total = basic + allowance;

        $("#fTotalSalary").val(total);
    });
</script>
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
flatpickr("#f_requestDate", { dateFormat: "d M Y", defaultDate: "" });
flatpickr("#f_requiredDate", { dateFormat: "d M Y" });
flatpickr("#d_requestDate", { dateFormat: "d M Y", defaultDate: "" });
flatpickr("#d_requiredDate", { dateFormat: "d M Y" });

window._fromDate = 20260301;
window._toDate   = 20260430;
filterRows();
</script>
<script>
	const pwdInput = document.getElementById('password');
	const pwdIcon = document.getElementById('pwdIcon');

	pwdIcon.addEventListener('click', function () {
		// Toggle the type attribute
		const type = pwdInput.getAttribute('type') === 'password' ? 'text' : 'password';
		pwdInput.setAttribute('type', type);
		// Toggle the icon class
		this.classList.toggle('bi-eye');
		this.classList.toggle('bi-eye-slash');
	});
</script>