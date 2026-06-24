@include('layouts.header')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('time_tracking') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Edit Time Entry</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Employee Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Employee Info</span>
      </div>

      <form   method="POST" action="{{ route('update_time_tracking') }}" enctype="multipart/form-data">
       @csrf
     <input type="hidden" name="time_tracking_id" value="{{ $time_entry_details->time_tracking_id }}">
      <div class="form-row">
        <div class="form-group">
			  <label class="form-label">Employee <span class="text-danger">*</span></label>
			    <select class="form-input" name="employee_id" id="employee_id"  required>
					<option value="">Select Employee</option>
					 @foreach($employees as $employee)
						<option value="{{ $employee->employee_id }}" {{ $time_entry_details->employee_id == $employee->employee_id ? 'selected' : '' }}>
							{{ $employee->employee_name }}
						</option>
					@endforeach
				</select>
            </div>
			<div class="form-group">
			  <label class="form-label">Employee Code</label>
			  <input type="text" class="form-input"  name="employee_code"  value="{{ $time_entry_details->employee_code }}"  id="employee_code" placeholder="EMP-104" readonly />
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Designation</label>
			   <select class="form-input"   name="designation_id"  id="designation_id">
				  <option value="">Select Designation</option>
            @foreach($designations as $designation)
            <option value="{{ $designation->designation_id }}" {{ $time_entry_details->designation_id == $designation->designation_id ? 'selected' : '' }}>
                {{ $designation->name }}
            </option>
            @endforeach
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">Department</label>
				<select class="form-input" name="department_id"  id="department_id">
					<option value="">Select Department</option>
            @foreach($departments as $department)

                <option
                    value="{{ $department->department_id }}"
                    {{ $time_entry_details->department_id == $department->department_id ? 'selected' : '' }}
                >
                    {{ $department->name }}
                </option>

            @endforeach
				</select>
			</div>
		</div>	
		
		
    </div>

    <!-- ── Work Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Work Details</span>
      </div>

      <div class="form-row">
			<div class="form-group">
			  <label class="form-label">Project / Task <span class="text-danger">*</span></label>
			  <input type="text" class="form-input"  name="project_task"  value="{{ $time_entry_details->project_task }}" placeholder="Project / Task"/>
			</div>
			<div class="form-group">
			  <div class="form-group">
			  <label class="form-label">Form Date </label>
			  <div class="input-group date_picker">
				<input type="text" class="form-control" name="form_date"  value="{{ $time_entry_details->form_date }}"  id="f_requestDate" placeholder="Select date" readonly />
				<span class="input-group-text bg-white">
				  <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
				</span>
			  </div>
			</div>
			</div>			
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Start Time <span class="text-danger">*</span></label>
			  <input type="time" class="form-input" id="start_time" name="start_time"  value="{{ $time_entry_details->start_time }}" placeholder="Start Time" required/>
			</div>
			<div class="form-group">
			  <label class="form-label">End Time <span class="text-danger">*</span></label>
			  <input type="time" class="form-input" id="end_time" name="end_time"  value="{{ $time_entry_details->end_time }}" placeholder="End Time" required/>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Total Work Hours</label>
			  <input type="text" class="form-input" id="total_work_hours" name="total_work_hours"  value="{{ $time_entry_details->total_work_hours }}" placeholder="9 hrs" readonly />
			</div>
		
		</div>
		
		<div class="form-group">
			<label class="form-label">Dask Description <span class="text-danger">*</span></label>
			<textarea type="text" name="dask_description"  class="form-input" required>{{ $time_entry_details->dask_description }}</textarea>
		</div>
    </div>
	
    <div class="section-block text-end">
		<a class="btn-cancel" onclick="window.location='{{ route('time_tracking') }}'" >Cancel</a>
		<button  type="submit" class="btn-save">Save Time Entry</button>
	</div>
</form>				
   
  </div><!-- /detail-card -->
  
  
</main>


@include('layouts.footer')

@include('layouts.scripts') 

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

function calculateWorkHours() {

    let startTime = $("#start_time").val();
    let endTime = $("#end_time").val();

    if (startTime && endTime) {

        let start = new Date(`2000-01-01 ${startTime}`);
        let end = new Date(`2000-01-01 ${endTime}`);

        let diff = (end - start) / 1000 / 60 / 60;

        // If end time is next day
        if (diff < 0) {
            diff += 24;
        }

        // Round value
        diff = Math.round(diff * 100) / 100;

        $("#total_work_hours").val(diff + ' hrs');
    }
}

$("#start_time, #end_time").on("change", function () {

    calculateWorkHours();

});

</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
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

window._fromDate = 20260301;
window._toDate   = 20260430;
filterRows();
</script>