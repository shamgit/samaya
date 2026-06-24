@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">   
     
	    <a href="{{ route('attendance_management') }}" class="back-title">
		  <h1 class="page-title"><i class="bi bi-chevron-left"></i>Mark Daily Attendance
		  </h1>
		</a>
  </div>
 
</div>

 
  <!-- ══════════ FILTER BAR ══════════ -->
   <div class="filter-bar">
    <div class="search-wrap">
      <i class="bi bi-search search-icon"></i>
      <input type="text" class="search-input" id="searchInput" placeholder="Search"/>
    </div>
    <select class="filter-select" id="categoryFilter">
      <option value="">Department: All</option>
       @foreach($departments as $department)
          <option value="{{ $department->department_id }}">
              {{ $department->name }}
          </option>
        @endforeach
    </select>   
  </div>

  
   <!-- ══════════ TABLE CARD ══════════ -->
 <div class="table-card">

    <div class="table-scroll">

        <table class="supplier-table" id="attendanceTable">

            <thead>

                <tr>
                    <th>Employee Id</th>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Attendance Date
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Attendance Status</th>

                </tr>

            </thead>

            <tbody>

                @foreach($employee as $employees)

                <tr>

                <td>
                        {{ $employees->employee_id }}

                        <input
                            type="hidden"
                            name="employee_id[]"
                            value="{{ $employees->employee_id }}"
                        >
                        

                    </td>

                    <td>

                        {{ $employees->employee_code }}
                          <input
                            type="hidden"
                            name="employee_code[]"
                            value="{{ $employees->employee_code }}"
                        >
 
                    </td>

                    <td class="td-name">

                        {{ $employees->employee_name }}

                    </td>

                    <td>

                        {{ $employees->department_name }}
                        <input
                            type="hidden"
                            name="department_id[]"
                            class="department_id"
                            value="{{ $employees->department_id }}"
                        >
                    </td>

                     <td>

                        <input
                            class="time_input"
                            name="attendance_date[]"
                            type="date"
                            value="{{ date('Y-m-d') }}"
                        >

                    </td>

                    <td>

                        <input
                            class="time_input"
                            name="check_in[]"
                            type="time"
                        >

                    </td>

                    <td>

                        <input
                            class="time_input"
                            name="check_out[]"
                            type="time"
                        >

                    </td>

                    <td>

                        <select
                            class="filter-select add-select"
                            name="attendance_status_id[]"
                        >

                            @foreach($attendance_status as $attendance_statu)

                            <option value="{{ $attendance_statu->attendance_statu_id }}">

                                {{ $attendance_statu->attendance_status_name }}

                            </option>

                            @endforeach

                        </select>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<div class="section-block text-end">

    <a class="btn-cancel" type="button"  onclick="window.location='{{ route('attendance_management') }}'">
        Cancel
    </a>

    <button
        class="btn-save"
        id="saveAttendanceBtn"
        type="button"
    >
        Save Attendance
    </button>

</div>

</div><!-- /page-wrap -->

</main>

@include('layouts.footer')

@include('layouts.scripts')


<script>

$("#saveAttendanceBtn").click(function () {

    let attendanceData = [];

    $("#attendanceTable tbody tr").each(function () {

        attendanceData.push({

        employee_id: $(this)
                .find('input[name="employee_id[]"]')
                .val(),

          employee_code: $(this)
              .find('input[name="employee_code[]"]')
              .val(),

          department_id: $(this)
              .find('input[name="department_id[]"]')
              .val(),
  

          attendance_date: $(this)
              .find('input[name="attendance_date[]"]')
              .val(),

          check_in: $(this)
              .find('input[name="check_in[]"]')
              .val(),

          check_out: $(this)
              .find('input[name="check_out[]"]')
              .val(),

          attendance_status_id: $(this)
              .find('select[name="attendance_status_id[]"]')
              .val()
        });

    });

    $.ajax({

        url: "{{ route('save_daily_attendance') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            attendanceData: attendanceData

        },

        
      success: function (response) {

        Swal.fire({

            icon: 'success',

            title: 'Success',

            text: response.message,

            confirmButtonColor: '#3085d6',

            confirmButtonText: 'OK'

        }).then(() => {

            window.location.href = "{{ route('attendance_management') }}";

        });

    },

    error: function () {

        Swal.fire({

            icon: 'error',

            title: 'Error',

            text: 'Something went wrong'

        });

    }
          

    });

});

</script>


<script>

$(document).ready(function () {

    // SEARCH
    $("#searchInput").on("keyup", function () {

        let value = $(this).val().toLowerCase();

        $("#attendanceTable tbody tr").filter(function () {

            $(this).toggle(

                $(this).text().toLowerCase().indexOf(value) > -1

            );

        });

    });

    // DEPARTMENT FILTER
    $("#categoryFilter").on("change", function () {

        let departmentId = $(this).val();

        $("#attendanceTable tbody tr").each(function () {

            let rowDepartment = $(this)
                .find(".department_id")
                .val();

            if (
                departmentId == "" ||
                rowDepartment == departmentId
            ) {

                $(this).show();

            } else {

                $(this).hide();
            }

        });

    });

});

</script>

