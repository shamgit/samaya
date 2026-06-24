@include('layouts.header')
@include('layouts.sidebar')

<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">

    <!-- ══════════ PAGE HEADER ══════════ -->
    <div class="page-header">

        <a href="{{ route('attendance_management') }}" class="back-title">
            <h1 class="page-title">
                <i class="bi bi-chevron-left"></i>
                Edit Mark Daily Attendance
            </h1>
        </a>

    </div>

    <!-- ══════════ TABLE CARD ══════════ -->
    <div class="table-card">

        <div class="table-scroll">

            <table class="supplier-table" id="attendanceTable">

                <thead>

                    <tr>
                        <th>Attendance ID</th>
                        <th>Employee ID</th>
                        <th>Employee Code</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Attendance Date</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Attendance Status</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($attendance_details as $attendance_detail)

                    <tr>

                        <!-- Attendance ID -->
                        <td>
                            {{ $attendance_detail->attendance_id }}

                            <input
                                type="hidden"
                                name="attendance_id[]"
                                value="{{ $attendance_detail->attendance_id }}"
                            >
                        </td>

                        <!-- Employee ID -->
                        <td>
                            {{ $attendance_detail->employee_id }}

                            <input
                                type="hidden"
                                name="employee_id[]"
                                value="{{ $attendance_detail->employee_id }}"
                            >
                        </td>

                        <!-- Employee Code -->
                        <td>
                            {{ $attendance_detail->employee_code }}

                            <input
                                type="hidden"
                                name="employee_code[]"
                                value="{{ $attendance_detail->employee_code }}"
                            >
                        </td>

                        <!-- Employee Name -->
                        <td class="td-name">
                            {{ $attendance_detail->employee_name }}
                        </td>

                        <!-- Department -->
                        <td>
                            {{ $attendance_detail->department_name }}

                            <input
                                type="hidden"
                                name="department_id[]"
                                class="department_id"
                                value="{{ $attendance_detail->department_id }}"
                            >
                        </td>

                        <!-- Attendance Date -->
                        <td>
                            <input
                                class="time_input"
                                name="attendance_date[]"
                                type="date"
                                value="{{ $attendance_detail->attendance_date }}"
                            >
                        </td>

                        <!-- Check In -->
                        <td>
                            <input
                                class="time_input"
                                name="check_in[]"
                                type="time"
                                value="{{ $attendance_detail->check_in }}"
                            >
                        </td>

                        <!-- Check Out -->
                        <td>
                            <input
                                class="time_input"
                                name="check_out[]"
                                type="time"
                                value="{{ $attendance_detail->check_out }}"
                            >
                        </td>

                        <!-- Attendance Status -->
                        <td>

                            <select
                                class="filter-select add-select"
                                name="attendance_status_id[]"
                            >

                                @foreach($attendance_status as $attendance_statu)

                                <option
                                    value="{{ $attendance_statu->attendance_statu_id }}"
                                    {{ $attendance_detail->attendance_status_id == $attendance_statu->attendance_statu_id ? 'selected' : '' }}
                                >
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

    <!-- Buttons -->
    <div class="section-block text-end">

        <button
            class="btn-cancel"
            type="button"
            onclick="window.location='{{ route('attendance_management') }}'"
        >
            Cancel
        </button>

        <button
            class="btn-save"
            id="saveAttendanceBtn"
            type="button"
        >
            Update Attendance
        </button>

    </div>

</main>

@include('layouts.footer')
@include('layouts.scripts')

<script>

$(document).ready(function () {

    $("#saveAttendanceBtn").click(function () {

        let attendanceData = [];

        $("#attendanceTable tbody tr").each(function () {

            attendanceData.push({

                attendance_id: $(this)
                    .find('input[name="attendance_id[]"]')
                    .val(),

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

            url: "{{ route('update_daily_attendance') }}",

            type: "POST",

            data: {

                _token: "{{ csrf_token() }}",

                attendanceData: attendanceData

            },

            beforeSend: function () {

                $("#saveAttendanceBtn").prop("disabled", true).text("Updating...");

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

            error: function (xhr) {

                let errorMessage = 'Something went wrong';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({

                    icon: 'error',

                    title: 'Error',

                    text: errorMessage

                });

            },

            complete: function () {

                $("#saveAttendanceBtn").prop("disabled", false).text("Update Attendance");

            }

        });

    });

});

</script>