@include('layouts.header')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('appraisal_management') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Appraisal Evaluation Form</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Employee Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Employee Info</span>
      </div>

    <form action="{{ route('appraisal_store') }}"method="POST">
    @csrf
      <div class="form-row">
        <div class="form-group">
			  <label class="form-label">Employee <span class="text-danger">*</span></label>
				<select class="form-input" name="employee_id" id="employee_id" required>
					<option value="">Select Employee</option>
					@foreach($employees as $employee)
					<option value="{{ $employee->employee_id }}">
						{{ $employee->employee_name }}
					</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			  <label class="form-label">Employee Code</label>
			  <input type="text" class="form-input" name="employee_code"  id="employee_code" placeholder="EMP-104" readonly />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Designation</label>
			   <select class="form-input"   name="designation_id"  id="designation_id">
				  <option value="">Select Designation</option>
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">Department</label>
				<select class="form-input" name="department_id" id="department_id">
					<option value="">Select Department</option>
				</select>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			<label class="form-label">Review Period</label>
				<div class="input-group date_picker" >
					<span class="input-group-text bg-white">
					<svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
					</span>
					<input type="text" id="dateRangePicker"   class="form-control form-control-sm bg-white" name="review_period" placeholder="Select date range" readonly />
				</div>
			</div>
		</div>
		
      </div>

		<!-- ── Increment Details ── -->
		<div class="section-block">
		<div class="section-header">
			<span class="section-title">Increment Details</span>
		</div>

			<div class="form-row">
				<div class="form-group">
				<label class="form-label">Rating Scale <span class="text-danger">*</span></label>
				<select class="form-input" name="rating_scale" required>
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				</div>
				<div class="form-group">
					<label class="form-label">Salary Increment Recommendation <span class="text-danger">*</span></label>
					<input type="text" class="form-input"   name="salary_increment_recommendation" placeholder="₹50,000" required/>
				</div>			
			</div>
			<div class="form-group">
				<label class="form-label">ManagerFeedback <span class="text-danger">*</span></label>
				<textarea type="text" class="form-input" name="manager_feedback"  required></textarea>
			</div>
		</div>

		<div class="section-block text-end">
			<a class="btn-cancel"  onclick="window.location='{{ route('appraisal_management') }}'" >Cancel</a>
			<button type="submit" class="btn-save">Save Appraisal</button>
		</div>	
    </form>	

  </div><!-- /detail-card -->
  
  
</main>
@include('layouts.footer')

@include('layouts.scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 

<script>

$("#employee_id").change(function () {

    let employee_id = $(this).val();

    if (employee_id != '') {

        $.ajax({

            url: "{{ route('get_employee_details') }}",

            type: "GET",

            data: {
                employee_id: employee_id
            },

            success: function (response) {

                // Employee Code
                $("#employee_code").val(response.employee_code);

                // Designation
                $("#designation_id").html(`
                    <option value="${response.designation_id}">
                        ${response.designation_name}
                    </option>
                `);

                // Department
                $("#department_id").html(`
                    <option value="${response.department_id}">
                        ${response.department_name}
                    </option>
                `);

            }

        });

    } else {

        $("#employee_code").val('');

        $("#designation_id").html(`
            <option value="">Select Designation</option>
        `);

        $("#department_id").html(`
            <option value="">Select Department</option>
        `);

    }

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
flatpickr("#f_requestDate", { dateFormat: "d M Y", defaultDate: "today" });
flatpickr("#f_requiredDate", { dateFormat: "d M Y" });

window._fromDate = 20260301;
window._toDate   = 20260430;
filterRows();


</script>