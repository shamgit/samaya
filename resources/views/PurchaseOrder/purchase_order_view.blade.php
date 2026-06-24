@include('layouts.header')
@include('layouts.sidebar')

<main class="main-content">

    <div class="page-header">
        <a href="{{ url('purchase_order') }}" class="back-title">
            <h1 class="page-title">
                <i class="bi bi-chevron-left"></i>
                View - {{ $po->po_number ?? $po->po_no ?? '-' }}
            </h1>
        </a>
    </div>

    <div class="detail-card">

        <!-- Supplier Information -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Supplier Info</span>
            </div>

            <table class="info-table mb-4">
                <tbody>
                    <tr class="info-row">
                        <td class="info-label">Supplier Name</td>
                        <td class="info-value">{{ $po->supplier_name ?? '-' }}</td>
                    </tr>

                    <tr class="info-row">
                        <td class="info-label">PO Number</td>
                        <td class="info-value">{{ $po->po_number ?? $po->po_no ?? '-' }}</td>
                    </tr>

                    <tr class="info-row">
                        <td class="info-label">PO Date</td>
                        <td class="info-value">
                            {{ !empty($po->po_date) ? date('d M Y', strtotime($po->po_date)) : '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Product List -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Product List</span>
            </div>

			<div class="table-card mb-4">
				<div class="table-responsive">
				<table class="supplier-table product-table">

				<thead>
				<tr>
				<th>Product Name</th>
				<th>Category</th>
				<th>Color</th>
				<th>Size</th>
				<th>Qty</th>
				<th>Unit</th>
				</tr>
				</thead>
				<tbody>
				@forelse($items as $item)
				<tr>
					<td>{{ $item->product_name ?? '-' }}</td>
					<td>{{ $item->category ?? '-' }}</td>
					<td>{{ $item->color ?? '-' }}</td>
					<td>{{ $item->size ?? '-' }}</td>
					<td>{{ $item->qty ?? 0 }}</td>
					<td>{{ $item->unit ?? '-' }}</td>
				</tr>
				@empty
				<tr>
					<td colspan="6" class="text-center">No Products Found</td>
				</tr>
				@endforelse
				</tbody>

				</table>
				</div>
			</div>
        </div>

        <!-- Price Details -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Price Details</span>
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

                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->product_name ?? '-' }}</td>
                                            <td>{{ $item->qty ?? 0 }}</td>
                                            <td>₹{{ number_format($item->unit_price ?? 0, 2) }}</td>
                                            <td>₹{{ number_format($item->total ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach

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
                                        <td>₹{{ number_format($po->subtotal ?? 0, 2) }}</td>
                                    </tr>

                                    <tr>
                                        <td>GST ({{ $po->gst_rate ?? 0 }}%)</td>
                                        <td>₹{{ number_format($po->gst_amount ?? 0, 2) }}</td>
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

        <!-- Delivery Details -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Delivery Details</span>
            </div>

            <table class="info-table mb-4">
                <tbody>

                    <tr class="info-row">
                        <td class="info-label">Delivery Date</td>
                        <td class="info-value">
                            {{ !empty($po->delivery_date) ? date('d M Y', strtotime($po->delivery_date)) : '-' }}
                        </td>
                    </tr>

                    <tr class="info-row">
                        <td class="info-label">Delivery Location</td>
                        <td class="info-value">
                            {{ $po->delivery_location ?? '-' }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Additional Info -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Additional Info</span>
            </div>

            <table class="info-table mb-4">
                <tbody>

                    <tr class="info-row">
                        <td class="info-label">Payment Terms</td>
                        <td class="info-value">
                            {{ $po->payment_terms ?? '-' }}
                        </td>
                    </tr>

                    <tr class="info-row">
                        <td class="info-label">Additional Notes</td>
                        <td class="info-value">
                            {{ $po->notes ?? '-' }}
                        </td>
                    </tr>

                    <tr class="info-row">
                        <td class="info-label">Attachment</td>
                        <td class="info-value">

                            @if(!empty($po->attachment))
                                <a href="{{ asset('uploads/purchase_orders/'.$po->attachment) }}"
                                   target="_blank">
                                    View Attachment
                                </a>
                            @else
                                No Attachment
                            @endif

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</main>

@include('layouts.footer')