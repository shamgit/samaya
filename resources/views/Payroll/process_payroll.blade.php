@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('payroll_management') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Payroll Caculation Form</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Employee Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Employee Info</span>
      </div>

    <form method="POST" action="{{ route('save_payroll') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-row">
          <div class="form-group">
              <label class="form-label">Employee Name <span class="text-danger">*</span></label>
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
              <input type="text" class="form-input" name="employee_code" id="employee_code" placeholder="EMP-104" readonly />
          </div>
      </div>
      <div class="form-row">
          <div class="form-group">
              <label class="form-label">Designation</label>
              <select class="form-input" name="designation_id" id="designation_id">
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

      <div class="section-block">
          <div class="section-header">
              <span class="section-title">Payroll Details</span>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Pay Period (Start Date) <span class="text-danger">*</span></label>
                  <div class="input-group date_picker">
                      <input type="text" class="form-control" id="s_requestDate" name="pay_period_start_date" placeholder="Select date" readonly />
                      <span class="input-group-text bg-white">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
                      </span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="form-label">Pay Period (End Date) <span class="text-danger">*</span></label>
                  <div class="input-group date_picker">
                      <input type="text" class="form-control" id="e_requestDate" name="pay_period_end_date" placeholder="Select date" readonly />
                      <span class="input-group-text bg-white">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
                      </span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="form-label">Pay Date <span class="text-danger">*</span></label>
                  <div class="input-group date_picker">
                      <input type="text" class="form-control" id="f_requestDate" name="pay_date" placeholder="Select date" readonly />
                    <span class="input-group-text bg-white">
                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
                    </span>
                  </div>
              </div>
          </div>
      </div>

      <!-- Salary Details -->
      <div class="section-block">
          <div class="section-header">
              <span class="section-title">Salary Details</span>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Basic Salary <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="basic_salary" id="basic_salary" placeholder="0" required />
              </div>
          </div>
      </div>

      <!-- Allowance -->
      <div class="section-block">
          <div class="section-header">
              <span class="section-title">Allowance</span>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">House Rent Allowance <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="hra" id="hra" placeholder="0" required />
              </div>
              <div class="form-group">
                  <label class="form-label">Transport Allowance <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="transport_allowance" id="transport_allowance" placeholder="0" required />
              </div>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Other Allowance <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="other_allowance" id="other_allowance" placeholder="0" required />
              </div>
              <div class="form-group">
                  <label class="form-label">Total Allowance <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="total_allowance" id="total_allowance" placeholder="0" readonly />
              </div>
          </div>
      </div>

      <!-- Deductions -->
      <div class="section-block">
          <div class="section-header">
              <span class="section-title">Deductions</span>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Provident Fund (PF) <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="pf" id="pf" placeholder="0" required />
              </div>
              <div class="form-group">
                  <label class="form-label">Professional Tax <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="professional_tax" id="professional_tax" placeholder="0" required />
              </div>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Other Deductions <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="other_deduction" id="other_deduction" placeholder="0" required />
              </div>
              <div class="form-group">
                  <label class="form-label">Total Deductions <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="total_deduction" id="total_deduction" placeholder="0" readonly />
              </div>
          </div>
      </div>

      <!-- Tax Calculation -->
      <div class="section-block">
          <div class="section-header">
              <span class="section-title">Tax Calculation</span>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Income Tax <span class="text-danger">*</span></label>
                  <input type="text" class="form-input calc" name="income_tax" id="income_tax" placeholder="0" required />
              </div>
          </div>
      </div>

      <!-- Net Salary Calculation -->
      <div class="section-block">
          <div class="section-header">
              <span class="section-title">Net Salary Calculation</span>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Basic Salary</label>
                  <input type="text" class="form-input calc" name="net_basic_salary" id="net_basic_salary" placeholder="0" readonly />
              </div>
              <div class="form-group">
                  <label class="form-label">Allowance</label>
                  <input type="text" class="form-input calc" name="net_allowance" id="net_allowance" placeholder="0" readonly />
              </div>
          </div>
          <div class="form-row">
              <div class="form-group">
                  <label class="form-label">Deductions</label>
                  <input type="text" class="form-input calc" name="net_deduction" id="net_deduction" placeholder="0" readonly />
              </div>
              <div class="form-group">
                  <label class="form-label">Net Salary</label>
                  <input type="text" class="form-input calc" name="net_salary" id="net_salary" placeholder="0" readonly />
              </div>
          </div>
      </div>

       <div class="section-block text-end">
          <button type="button" class="btn-cancel" onclick="window.location='{{ route('payroll_management') }}'">Cancel</button>
          <button type="submit" class="btn-save">Save Payroll</button>
       </div>
    </form>
   
    

  </div><!-- /detail-card -->
  
  
</main>


@include('layouts.footer')

@include('layouts.scripts') 

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>

function calculatePayroll(){

    let basic_salary = parseFloat($('#basic_salary').val()) || 0;

    let hra = parseFloat($('#hra').val()) || 0;

    let transport_allowance =
        parseFloat($('#transport_allowance').val()) || 0;

    let other_allowance =
        parseFloat($('#other_allowance').val()) || 0;

    let pf = parseFloat($('#pf').val()) || 0;

    let professional_tax =
        parseFloat($('#professional_tax').val()) || 0;

    let other_deduction =
        parseFloat($('#other_deduction').val()) || 0;

    let income_tax =
        parseFloat($('#income_tax').val()) || 0;

    // Total Allowance
    let total_allowance =
        hra +
        transport_allowance +
        other_allowance;

    $('#total_allowance').val(total_allowance);

    // Total Deduction
    let total_deduction =
        pf +
        professional_tax +
        other_deduction +
        income_tax;

    $('#total_deduction').val(total_deduction);

    // Net Salary
    let net_salary =
        (basic_salary + total_allowance)
        - total_deduction;

    $('#net_basic_salary').val(basic_salary);

    $('#net_allowance').val(total_allowance);

    $('#net_deduction').val(total_deduction);

    $('#net_salary').val(net_salary);

}

// Auto Calculate
$(document).on('keyup change', '.calc', function(){

    calculatePayroll();

});

</script>

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
flatpickr("#s_requestDate", { dateFormat: "d M Y", defaultDate: "" });
flatpickr("#s_requiredDate", { dateFormat: "d M Y" });
flatpickr("#e_requestDate", { dateFormat: "d M Y", defaultDate: "" });
flatpickr("#e_requiredDate", { dateFormat: "d M Y" });
flatpickr("#f_requestDate", { dateFormat: "d M Y", defaultDate: "" });
flatpickr("#f_requiredDate", { dateFormat: "d M Y" });


window._fromDate = 20260301;
window._toDate   = 20260430;
filterRows();
</script>
