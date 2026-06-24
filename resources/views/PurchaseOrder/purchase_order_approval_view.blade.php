@include('layouts.header')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
	<a href="purchase-order-approval.php" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>View - PO-2026-0045
      </h1>
    </a>
    
  </div>
  
   <!-- ══════════ DETAIL CARD ══════════ -->
	<div class="detail-card mb-4">
		<!-- ── Status Timeline ── -->
		<div class="section-block">
		  <div class="section-header">
			<span class="section-title">Status Timeline</span>
		  </div>
		  
			<div class="tl-wrapper">   

				<div class="tl-steps">

				  <!-- Step 1: Approved -->
				  <div class="tl-step">
					<div class="tl-circle done">
					  <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
						   stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="20 6 9 17 4 12"/>
					  </svg>
					</div>
					<div class="tl-step-text">
					  <p class="tl-name mb-0">Procurement Manager</p>
					  <p class="tl-status approved mb-0">Approved</p>
					</div>
				  </div>

				  <!-- Connector: solid green -->
				  <div class="tl-connector done"></div>

				  <!-- Step 2: Active Pending -->
				  <div class="tl-step">
					<div class="tl-circle active">
					  <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
						   stroke="#787878" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<polyline points="9 18 15 12 9 6"/>
					  </svg>					
					</div>
					<div class="tl-step-text">
					  <p class="tl-name mb-0">Finance Manager</p>
					  <p class="tl-status active mb-0">Pending</p>
					</div>
				  </div>

				  <!-- Connector: dashed gray -->
				  <div class="tl-connector pending"></div>

				  <!-- Step 3: Idle Pending -->
				  <div class="tl-step">
					<div class="tl-circle idle">
					  <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
						   stroke="#adb5bd" stroke-width="2" stroke-linecap="round">
						<circle cx="12" cy="12" r="1"/>
						<circle cx="19" cy="12" r="1"/>
						<circle cx="5" cy="12" r="1"/>
					  </svg>
					</div>
					<div class="tl-step-text">
					  <p class="tl-name text-secondary mb-0">Director</p>
					  <p class="tl-status idle mb-0">Pending</p>
					</div>
				  </div>

				</div>
  </div>
		  
		</div>  
	</div>
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- Basic Info -->
    <div class="section-block">
        <div class="section-header">
            <span class="section-title">Basic Info</span>
        </div>

        <table class="info-table mb-4">
            <tbody>
                <tr class="info-row">
                    <td class="info-label">PO Number</td>
                    <td class="info-value">{{ $po->po_no ?? '-' }}</td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">Supplier</td>
                    <td class="info-value">{{ $po->supplier_name ?? '-' }}</td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">Department</td>
                    <td class="info-value">{{ $po->department_name ?? '-' }}</td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">Requested By</td>
                    <td class="info-value">{{ $po->requested ?? '-' }}</td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">PO Date</td>
                    <td class="info-value">
                        {{ !empty($po->po_date) ? \Carbon\Carbon::parse($po->po_date)->format('d M Y') : '-' }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Material & Cost Details -->
    <div class="section-block">
        <div class="section-header">
            <span class="section-title">Material & Cost Details</span>
        </div>

        <div class="row">

            <div class="col-md-8">
                <div class="table-card mb-4">
                    <div class="table-responsive">

                        <table class="supplier-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($poItems as $item)

                                <tr>
                                    <td>{{ $item->product_name ?? '-' }}</td>
                                    <td>{{ $item->qty ?? 0 }}</td>
                                    <td>₹{{ number_format($item->unit_price ?? 0, 2) }}</td>
                                    <td>₹{{ number_format($item->total ?? 0, 2) }}</td>
                                </tr>

                                @empty

                                <tr>
                                    <td colspan="4" class="text-center">
                                        No Products Found
                                    </td>
                                </tr>

                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="table-card mb-4">
                    <div class="table-responsive">

                        <table class="supplier-table">
                            <tbody>

                                <tr>
                                    <td>Subtotal</td>
                                    <td>
                                        ₹{{ number_format($po->subtotal ?? 0, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td>GST ({{ $po->gst_rate ?? 0 }}%)</td>
                                    <td>
                                        ₹{{ number_format($po->gst_amount ?? 0, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>Total Amount</strong></td>
                                    <td>
                                        <strong>
                                            ₹{{ number_format($po->total_amount ?? 0, 2) }}
                                        </strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Delivery & Payment -->
    <div class="section-block">
        <div class="section-header">
            <span class="section-title">Delivery & Payment</span>
        </div>

        <table class="info-table mb-4">
            <tbody>

                <tr class="info-row">
                    <td class="info-label">Delivery Date</td>
                    <td class="info-value">
                        {{ !empty($po->delivery_date) ? \Carbon\Carbon::parse($po->delivery_date)->format('d M Y') : '-' }}
                    </td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">Delivery Location</td>
                    <td class="info-value">
                        {{ $po->delivery_location ?? '-' }}
                    </td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">Payment Terms</td>
                    <td class="info-value">
                        {{ $po->payment_terms ?? '-' }}
                    </td>
                </tr>

                <tr class="info-row">
                    <td class="info-label">Notes</td>
                    <td class="info-value">
                        {{ $po->notes ?? '-' }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    @if(!empty($po->attachment))
    <div class="section-block">
        <div class="section-header">
            <span class="section-title">Attachment</span>
        </div>

        <a href="{{ asset('storage/'.$po->attachment) }}" target="_blank">
            View Attachment
        </a>
    </div>
    @endif

<input type="hidden" id="po_id" value="{{ $po->id }}">
@php
    $status = strtolower(trim($po->aproval_status ?? 'pending'));
@endphp

@if($status == 'pending')

<div class="section-block text-end">
    <button class="btn-po" id="btnComment">Add Comment</button>
    <button class="btn-cancel" id="btnReject">Reject</button>
    <button class="btn-save" id="btnApprove">Approve</button>
</div>

@else

<div class="section-block text-end">

    @if($status == 'approved')
        <span class="badge bg-success fs-6 p-2">
            ✓ Approved
        </span>

    @elseif($status == 'rejected')
        <span class="badge bg-danger fs-6 p-2">
            ✕ Rejected
        </span>

    @else
        <span class="badge bg-secondary fs-6 p-2">
            {{ $po->aproval_status }}
        </span>
    @endif

</div>

@endif

</div>
  
  
</main>
@include('layouts.footer')

@include('layouts.scripts') 
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
<script>


$('#btnApprove').click(function () {

    let poId = $('#po_id').val();

    Swal.fire({
        title: 'Approve Purchase Order?',
        text: 'Do you want to approve this Purchase Order?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Approve',
        confirmButtonColor: '#28a745'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/purchase-order/approve/' + poId,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Approved',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        }
    });

});


$('#btnReject').click(function () {

    let poId = $('#po_id').val();

    Swal.fire({
        title: 'Reject Purchase Order?',
        text: 'Do you want to reject this Purchase Order?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Reject',
        confirmButtonColor: '#dc3545'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: '/purchase-order/reject/' + poId,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Rejected',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        }
    });

});

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