@include('layouts.header')
@include('layouts.sidebar')
<style>

.badge-status{

    padding: 6px 14px;

    border-radius: 20px;

    color: #fff;

    font-size: 13px;

    font-weight: 600;
}

.badge-warning{

    background: orange;
}

.badge-success{

    background: green;
}

.badge-danger{

    background: red;
}

</style>
<main class="main-content">

 
    <div class="page-header">

        <a href="{{ route('absence_tracking') }}"
           class="back-title">

            <h1 class="page-title">

                <i class="bi bi-chevron-left"></i>

                View Absence Tracking

            </h1>

        </a>

    </div>

   
    <div class="detail-card">

        <!-- Employee Info -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">
                    Employee Info
                </span>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <tr class="info-row">

                        <td class="info-label">
                            Employee Name
                        </td>

                        <td class="info-value">
                            {{ $employees->employee_name }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Employee Code
                        </td>

                        <td class="info-value">
                            {{ $leave_details->employee_code }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Designation
                        </td>

                        <td class="info-value">
                            {{ $designations->name }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Department
                        </td>

                        <td class="info-value">
                            {{ $departments->name }}
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <!-- Leave Details -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">
                    Leave Details
                </span>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <tr class="info-row">

                        <td class="info-label">
                            Leave Type
                        </td>

                        <td class="info-value">
                            {{ $leave_types->name }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            From Date
                        </td>

                        <td class="info-value">
                            {{ $leave_details->from_date }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            To Date
                        </td>

                        <td class="info-value">
                            {{ $leave_details->to_date }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Manager Approval
                        </td>

                        <td class="info-value">
                            {{ $users->name }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Reason
                        </td>

                        <td class="info-value">
                            {{ $leave_details->reason }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Status
                        </td>

                        <td class="info-value">

                            @if($leave_details->leave_status == 1)

                                <span class="badge-status badge-warning">
                                    Pending
                                </span>

                            @elseif($leave_details->leave_status == 2)

                                <span class="badge-status badge-success">
                                    Approved
                                </span>

                            @else

                                <span class="badge-status badge-danger">
                                    Rejected
                                </span>

                            @endif

                        </td>

                    </tr>

                </tbody>

            </table>

            <!-- ACTION BUTTONS -->
           @if(Auth::user()->role_id != 4)

              @if($leave_details->leave_status == 1)

                  <div class="section-block text-end">

                      <button type="button"
                              class="btn-cancel statusBtn"
                              data-status="3"
                              data-id="{{ $leave_details->leave_id }}">

                          Rejected

                      </button>

                      <button type="button"
                              class="btn-save statusBtn"
                              data-status="2"
                              data-id="{{ $leave_details->leave_id }}">

                          Approved

                      </button>

                  </div>

              @endif

          @endif

        </div>

    </div>

</main>

@include('layouts.footer')
@include('layouts.scripts')


<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

$(document).on('click', '.statusBtn', function () {

    let button = $(this);

    let leave_status = button.data('status');

    let leave_id = button.data('id');

    let statusText = leave_status == 2
        ? 'approve'
        : 'reject';

    Swal.fire({

        title: 'Are you sure?',

        text: 'Do you want to ' + statusText + ' this request?',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#3085d6',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes'

    }).then((result) => {

        if (result.isConfirmed) {

            button.prop('disabled', true);

            $.ajax({

                url: "{{ route('leave_status_update') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    leave_id: leave_id,

                    leave_status: leave_status
                },

                success: function (response) {

                    if(response.status == true){

                        Swal.fire(
                            'Success!',
                            'Leave status updated successfully.',
                            'success'
                        ).then(() => {

                            location.reload();

                        });

                    } else {

                        Swal.fire(
                            'Error!',
                            'Something went wrong.',
                            'error'
                        );
                    }
                },

                error: function () {

                    Swal.fire(
                        'Error!',
                        'Server error occurred.',
                        'error'
                    );

                    button.prop('disabled', false);
                }

            });

        }

    });

});

</script>