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
      Edit - {{ $appraisals_details->employee_code ?? '' }}</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Employee Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Employee Info</span>
      </div>

       <form action="{{ route('appraisal_update') }}"method="POST">
       @csrf
	  <input type="hidden" name="appraisal_id" value="{{ $appraisals_details->appraisal_id}}">
      <div class="form-row">
        <div class="form-group">
			  <label class="form-label">Employee <span class="text-danger">*</span></label>
				<select class="form-input" name="employee_id" id="employee_id" required>
					<option value="">Select Employee</option>
					@foreach($employees as $employee)
					<option value="{{ $employee->employee_id }}"  {{ $appraisals_details->employee_id == $employee->employee_id ? 'selected' : '' }}>
						{{ $employee->employee_name }}
					</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
			  <label class="form-label">Employee ID</label>
			  <input type="text" class="form-input"  name="employee_code"  id="employee_code"  value="{{ $appraisals_details->employee_code }}" placeholder="EMP-104" readonly />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			<label class="form-label">Designation</label>
			 <select class="form-input"   name="designation_id"  id="designation_id">
				  <option value="">Select Designation</option>
                  @foreach($designations as $designation)
					<option
						value="{{ $designation->designation_id }}"
						{{ $appraisals_details->designation_id == $designation->designation_id ? 'selected' : '' }}
					>
						{{ $designation->name }}
					</option>

				@endforeach
                </option>

                
			  </select>
			</div>
			<div class="form-group">
			<label class="form-label">Department</label>
				<select class="form-input" name="department_id"  id="department_id">
					<option value="">Select Department</option>
					@foreach($departments as $department)

						<option
							value="{{ $department->department_id }}"
							{{ $appraisals_details->department_id == $department->department_id ? 'selected' : '' }}
						>
							{{ $department->name }}
						</option>

					@endforeach
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
				<input type="text" id="dateRangePicker" class="form-control form-control-sm bg-white" name="review_period"  value="{{ $appraisals_details->review_period }}" placeholder="Select date range" readonly />
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
				<option value="1" {{ $appraisals_details->rating_scale == 1 ? 'selected' : '' }}>1</option>
				<option value="2" {{ $appraisals_details->rating_scale == 2 ? 'selected' : '' }}>2</option>
				<option value="3" {{ $appraisals_details->rating_scale == 3 ? 'selected' : '' }}>3</option>
				<option value="4" {{ $appraisals_details->rating_scale == 4 ? 'selected' : '' }}>4</option>
				<option value="5" {{ $appraisals_details->rating_scale == 5 ? 'selected' : '' }}>5</option>
			</select>
			</div>
			<div class="form-group">
				<label class="form-label">Salary Increment Recommendation <span class="text-danger">*</span></label>
				<input type="text" class="form-input"  name="salary_increment_recommendation" value="{{ $appraisals_details->salary_increment_recommendation }}" placeholder="₹50,000" required/>
			</div>			
		</div>
		<div class="form-group">
			<label class="form-label">ManagerFeedback <span class="text-danger">*</span></label>
			<textarea type="text" class="form-input" name="manager_feedback"  required>{{ $appraisals_details->manager_feedback }}</textarea>
		</div>
    </div>
	
    <div class="section-block text-end">
		<a class="btn-cancel"  onclick="window.location='{{ route('appraisal_management') }}'" >Cancel</a>
		@if($appraisals_details->status = 2)  
		 <button type="submit"  name="action" value="approval"  class="btn-po">Send Report for Approval</button>
	    @endif
		<button type="submit"  name="action" value="save"  class="btn-save">Save Appraisal</button>
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
$(document).ready(function () {

    let reviewPeriod = $('#dateRangePicker').val();

    let defaultDates = [];

    if (reviewPeriod) {

        let dates = reviewPeriod.split(' to ');

        if (dates.length === 2) {

            defaultDates = [
                dates[0].trim(),
                dates[1].trim()
            ];
        }
    }

    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "d M Y",
        defaultDate: defaultDates,

        onChange: function(selectedDates) {

            if (selectedDates.length === 2) {

                const start =
                    flatpickr.formatDate(selectedDates[0], "d M Y");

                const end =
                    flatpickr.formatDate(selectedDates[1], "d M Y");

                $('#dateRangePicker').val(start + ' to ' + end);
            }
        }
    });

});


</script>