@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">

    <!-- ══════════ PAGE HEADER ══════════ -->
    <div class="page-header">

        <a href="{{ route('purchase_request_approval') }}"
           class="back-title">

            <h1 class="page-title">

                <i class="bi bi-chevron-left"></i>

                View – {{ $requisition->requisition_id }}

            </h1>
      

        </a>

    </div>

    <input type="hidden"id="requisitionId value="{{ $requisition->id }}">
    <!-- ══════════ DETAIL CARD ══════════ -->
    <div class="detail-card">

        <!-- ── REQUEST DETAILS ── -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">
                    Request Details
                </span>
                <div class="text-end">

                    @if($requisition->status == 'Approved')
                        <a href="{{ route('purchase-requisition.print', $requisition->requisition_id) }}"
                        target="_blank"
                        class="stat-icon">
                            <i class="bi bi-printer-fill"></i>
                        </a>

                        <a href="{{ route('purchase-requisition.download', $requisition->requisition_id) }}"
                        class="stat-icon">
                            <i class="bi bi-download"></i>
                        </a>

                    @endif

                </div>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <tr class="info-row">

                        <td class="info-label">
                            Request ID
                        </td>

                        <td class="info-value">
                            {{ $requisition->requisition_id }}
                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Department
                        </td>

                        <td class="info-value">

                            {{ $requisition->department->name ?? 'N/A' }}

                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Requested By
                        </td>

                        <td class="info-value">

                            {{ $requisition->   requested ?? 'N/A' }}

                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Request Date
                        </td>

                        <td class="info-value">

                            {{ $requisition->request_date }}

                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Required Date
                        </td>

                        <td class="info-value">

                            {{ $requisition->required_date }}

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- ── PRODUCT DETAILS ── -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">
                    Product Details
                </span>

            </div>

            <div class="table-card mb-4">

                <div class="table-scroll">

                    <table class="supplier-table">

                        <thead>

                            <tr>

                                <th>Product Name</th>

                                <th>Category</th>

                                <th>Color</th>

                                <th>Size</th>

                                <th>Quantity</th>

                                <th>Unit</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($requisition->details as $detail)

                            <tr>

                                <td>
                                    {{ $detail->product->product_name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $detail->category }}
                                </td>

                                <td>
                                    {{ $detail->color }}
                                </td>

                                <td>
                                    {{ $detail->size }}
                                </td>

                                <td>
                                    {{ $detail->quantity }}
                                </td>

                                <td>
                                    {{ $detail->unit }}
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center">

                                    No Products Found

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- ── ADDITIONAL INFO ── -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">
                    Additional Info
                </span>

            </div>

            <table class="info-table mb-4">

                <tbody>

                    <tr class="info-row">

                        <td class="info-label">
                            Priority
                        </td>

                        <td class="info-value">

                            {{ $requisition->priority }}

                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Remark
                        </td>

                        <td class="info-value">

                            {{ $requisition->remarks }}

                        </td>

                    </tr>

                    <tr class="info-row">

                        <td class="info-label">
                            Status
                        </td>

                        <td class="info-value">
                          @if($requisition->status == 'Pending')
                            <span class="badge-status badge-pending">
                                {{ $requisition->status }}
                            </span>

                            @elseif($requisition->status == 'Approved')

                                <span class="badge-status badge-approved">
                                    {{ $requisition->status }}
                                </span>

                            @elseif($requisition->status == 'Completed')

                                <span class="badge-status badge-completed">
                                    {{ $requisition->status }}
                                </span>

                            @elseif($requisition->status == 'Denied')

                                <span class="badge-status badge-denied">
                                    {{ $requisition->status }}
                                </span>

                            @else

                                <span class="badge-status badge-pending">
                                    {{ $requisition->status ?? 'Pending' }}
                                </span>

                            @endif

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        <!-- HIDDEN ID -->
        <input type="hidden"
               id="requisitionId"
               value="{{ $requisition->id }}">


        <!-- ── ACTION BUTTONS ── -->
        <div class="section-block text-end">

            @if($requisition->status == 'Pending')

                <button class="btn-cancel"
                        id="rejectBtn">

                    Reject

                </button>

                <button class="btn-save"
                        id="approveBtn">

                    Approve Request

                </button>

            @endif

        </div>

    </div>

</main>

@include('layouts.footer')

@include('layouts.scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// =========================
// APPROVE REQUEST
// =========================

$('#approveBtn').click(function () {

    let id = $('#requisitionId').val();

    Swal.fire({

        title: 'Approve this request?',

        text: "Status will be updated to Approved.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#28a745',

        cancelButtonColor: '#d33',

        confirmButtonText: 'Yes, Approve'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('purchase-requisition.approve') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    id: id
                },

                success: function (response) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Approved!',

                        text: response.message,

                        timer: 1500,

                        showConfirmButton: false

                    });

                    setTimeout(function () {

                        location.reload();

                    }, 1500);
                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Failed to approve request.'

                    });
                }
            });
        }
    });

});

// =========================
// REJECT REQUEST
// =========================

$('#rejectBtn').click(function () {

    let id = $('#requisitionId').val();

    Swal.fire({

        title: 'Reject this request?',

        text: "Status will be updated to Denied.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Yes, Reject'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('purchase-requisition.reject') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    id: id
                },

                success: function (response) {

                    Swal.fire({

                        icon: 'success',

                        title: 'Rejected!',

                        text: response.message,

                        timer: 1500,

                        showConfirmButton: false

                    });

                    setTimeout(function () {

                        location.reload();

                    }, 1500);
                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Failed to reject request.'

                    });
                }
            });
        }
    });

});

</script>