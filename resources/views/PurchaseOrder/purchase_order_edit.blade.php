@include('layouts.header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
@include('layouts.sidebar')

<main class="main-content">

    <div class="page-header">
        <a href="{{ route('purchase_order') }}" class="back-title">
            <h1 class="page-title">
                <i class="bi bi-chevron-left"></i>Purchase Order Edit
            </h1>
        </a>
    </div>

    <div class="detail-card">

        {{-- ── Hidden Fields ── --}}
        <input type="hidden" id="h_po_id"         value="{{ $po->id }}">
        <input type="hidden" id="h_requisition_id" value="{{ $requisition->id ?? '' }}">
        <input type="hidden" id="h_po_number"      value="{{ $po->po_no }}">
        <input type="hidden" id="h_subtotal"       value="{{ $po->subtotal }}">
        <input type="hidden" id="h_gst_amount"     value="{{ $po->gst_amount }}">
        <input type="hidden" id="h_total_amount"   value="{{ $po->total_amount }}">

        {{-- ── Supplier Info ── --}}
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Supplier Info</span>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Supplier Name</label>
                    <select class="form-input" id="supplier_id">
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->supplier_id }}"
                                {{ $po->supplier_id == $supplier->supplier_id ? 'selected' : '' }}>
                                {{ $supplier->supplier_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">PO Number</label>
                    <input type="text" class="form-input"
                           value="{{ $po->po_no }}" readonly/>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Supplier Category</label>
                    <input type="text" class="form-input" id="supplier_category"
                           value="{{ $po->supplier_category ?? '' }}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">PO Date</label>
                    <div class="input-group date_picker">
                        <input type="text" class="form-control" id="f_requestDate"
                               value="{{ $po->po_date ? \Carbon\Carbon::parse($po->po_date)->format('d M Y') : '' }}"
                               placeholder="Select date" readonly/>
                        <span class="input-group-text bg-white">
                            <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                                <rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/>
                                <path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Product List ── --}}
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
                                <th>Color</th>
                                <th>Size</th>
                                <th>Requested Qty</th>
                                <th>Qty</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
							<tbody id="productTableBody">
							@forelse($poItems as $item)
							<tr>
							<td>
							{{ $item->product_name ?? '-' }}
							</td>

							<td>
							{{ $item->product_color ?? '-' }}
							</td>

							<td>
							{{ $item->color ?? '-' }}
							</td>
							
							<td>
							{{ $item->requested_qty ?? 0 }}
							</td>
								<td>
								<input type="number" class="form-input qty-input" data-product-id="{{ $item->product_id }}"
									data-unit-price="{{ $item->cost_price }}" value="{{ $item->qty }}" min="1" style="width:80px;">
								</td>
								<td>
								{{ $item->unit_of_measure ?? '-' }}
								</td>
							</tr>
							@empty
								<tr>
									<td colspan="7" class="text-center">
									No Products Found
									</td>
								</tr>
							@endforelse
							</tbody>

                        
                    </table>
                </div>
            </div>
        </div>

        {{-- ── Price Details ── --}}
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
                                        <th>Unit Price (₹)</th>
                                        <th>Total (₹)</th>
                                    </tr>
                                </thead>
                                <tbody id="priceTableBody">
                                    @foreach($poItems as $item)
                                    <tr id="price-row-{{ $item->product_id }}">
                                        <td>{{ $item->product_name }}</td>
                                        <td class="row-qty">{{ $item->qty }}</td>
                                        <td>₹{{ number_format($item->cost_price, 2) }}</td>
                                        <td class="row-total">
                                            ₹{{ number_format($item->total, 2) }}
                                        </td>
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
                                        <td id="subtotalAmt">
                                            ₹{{ number_format($po->subtotal, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            GST
                                            <select id="gstRate"
                                                    class="form-input form-input-sm"
                                                    style="width:80px;display:inline-block;">
                                                @foreach([0,5,12,18,28] as $rate)
                                                    <option value="{{ $rate }}"
                                                        {{ $po->gst_rate == $rate ? 'selected' : '' }}>
                                                        {{ $rate }}%
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td id="gstAmt">
                                            ₹{{ number_format($po->gst_amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Amount</strong></td>
                                        <td id="totalAmt">
                                            <strong>
                                                ₹{{ number_format($po->total_amount, 2) }}
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

        {{-- ── Delivery Details ── --}}
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Delivery Details</span>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Delivery Date</label>
                    <div class="input-group date_picker">
                        <input type="text" class="form-control" id="f_deliveryDate"
                               value="{{ $po->delivery_date ? \Carbon\Carbon::parse($po->delivery_date)->format('d M Y') : '' }}"
                               placeholder="Select date" readonly/>
                        <span class="input-group-text bg-white">
                            <svg width="13" height="13" viewBox="0 0 16 16" fill="none">
                                <rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/>
                                <path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Delivery Location</label>
                    <input type="text" class="form-input" id="delivery_location"
                           value="{{ $po->delivery_location ?? '' }}"
                           placeholder="Enter delivery location"/>
                </div>
            </div>
        </div>

        {{-- ── Additional Info ── --}}
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Additional Info</span>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Payment Terms</label>
                    <select class="form-input" id="fTerms">
                        @foreach(['Net 30','Net 15','Net 45','Net 60'] as $term)
                            <option {{ $po->payment_terms == $term ? 'selected' : '' }}>
                                {{ $term }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Notes</label>
                    <input type="text" class="form-input" id="additional_notes"
                           value="{{ $po->notes ?? '' }}"
                           placeholder="Enter notes"/>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Attachments</label>
                    <div class="input-group file_btn">
                        <input type="text" class="form-control" id="fileName"
                               placeholder="{{ $po->attachment ? basename($po->attachment) : 'Upload files' }}"
                               readonly>
                        <input type="file" class="d-none" id="fileInput">
                        <button class="btn btn-primary" type="button"
                            onclick="document.getElementById('fileInput').click()">
                            Browse Files
                        </button>
                    </div>

                    @if($po->attachment)
                    <div class="d-flex gap-3 mt-2">
                        <div class="up-img">
                            <img src="{{ asset('storage/' . $po->attachment) }}"
                                 class="img-fluid"
                                 style="max-width:120px; border-radius:6px;">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Buttons ── --}}
        <div class="section-block text-end">
            <button class="btn-po"     type="button" id="btnUpdatePO">Update PO</button>
            <button class="btn-cancel" type="button">Print PO</button>
            <button class="btn-save"   type="button">Send to Supplier</button>
        </div>

    </div>
</main>

@include('layouts.footer')
@include('layouts.scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$(document).ready(function () {

    // ── Flatpickr ──
    flatpickr("#f_requestDate",  { dateFormat: "d M Y" });
    flatpickr("#f_deliveryDate", { dateFormat: "d M Y" });

    // ── Calendar icon click opens picker ──
    document.querySelectorAll(".date_picker").forEach(function (wrapper) {
        wrapper.addEventListener("click", function () {
            let input = wrapper.querySelector("input");
            if (input && input._flatpickr) input._flatpickr.open();
        });
    });

    // ── Supplier Category on change ──
    // $('#supplier_id').on('change', function () {
    //     let supplierId = $(this).val();
    //     $('#supplier_category').val('');
    //     if (!supplierId) return;
    //     $.ajax({
    //         url: "/get-supplier-category/" + supplierId,
    //         type: "GET",
    //         success: function (response) {
    //             if (response.status) $('#supplier_category').val(response.category);
    //         }
    //     });
    // });

    // ── File input display ──
    $('#fileInput').on('change', function () {
        $('#fileName').val($(this).val().split('\\').pop());
    });

    // ── GST change ──
    $('#gstRate').on('change', function () { recalcPrices(); });

    // ── Live qty update ──
    $(document).on('input', '.qty-input', function () {
        let productId = $(this).data('product-id');
        let unitPrice = parseFloat($(this).data('unit-price')) || 0;
        let qty       = parseFloat($(this).val()) || 0;
        let total     = qty * unitPrice;

        $(`#price-row-${productId} .row-qty`).text(qty);
        $(`#price-row-${productId} .row-total`).text('₹' + formatINR(total));

        recalcPrices();
    });

    // ── Initial calc on page load ──
    recalcPrices();

    // ── Update PO ──
    $('#btnUpdatePO').on('click', function () {

        let products = [];
        let valid    = true;

        $('#productTableBody tr').each(function () {
            let qtyInput  = $(this).find('.qty-input');
            if (!qtyInput.length) return;

            let productId = qtyInput.data('product-id');
            let unitPrice = parseFloat(qtyInput.data('unit-price')) || 0;
            let qty       = parseFloat(qtyInput.val()) || 0;

            if (qty <= 0) {
                valid = false;
                qtyInput.css('border', '1px solid red');
                return;
            }

            qtyInput.css('border', '');
            products.push({
                product_id : productId,
                qty        : qty,
                unit_price : unitPrice,
                total      : parseFloat((qty * unitPrice).toFixed(2))
            });
        });

        if (!valid) {
            alert('Please enter valid quantity for all products.');
            return;
        }

        if (!$('#supplier_id').val()) {
            alert('Please select a supplier.');
            return;
        }

        let formData = new FormData();
        formData.append('_token',            $('meta[name="csrf-token"]').attr('content'));
        formData.append('_method', 'PUT');
        formData.append('po_id',             $('#h_po_id').val());
        formData.append('requisition_id',    $('#h_requisition_id').val());
        formData.append('supplier_id',       $('#supplier_id').val());
        formData.append('po_number',         $('#h_po_number').val());
        formData.append('po_date',           $('#f_requestDate').val());
        formData.append('delivery_date',     $('#f_deliveryDate').val());
        formData.append('delivery_location', $('#delivery_location').val() || '');
        formData.append('payment_terms',     $('#fTerms').val());
        formData.append('notes',             $('#additional_notes').val() || '');
        formData.append('gst_rate',          $('#gstRate').val());
        formData.append('subtotal',          $('#h_subtotal').val());
        formData.append('gst_amount',        $('#h_gst_amount').val());
        formData.append('total_amount',      $('#h_total_amount').val());
        formData.append('products',          JSON.stringify(products));

        let fileInput = document.getElementById('fileInput');
        if (fileInput.files.length > 0) {
            formData.append('attachment', fileInput.files[0]);
			
        }

        $('#btnUpdatePO').prop('disabled', true).text('Updating...');

        $.ajax({
            url         : '/purchase_order/update/' + $('#h_po_id').val(),
            type        : 'POST',
            data        : formData,
            processData : false,
            contentType : false,
            success: function (response) {
                if (response.status) {
                    alert('Purchase Order updated successfully!');
                    window.location.href = '/purchase_order';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                alert(errors
                    ? 'Validation:\n' + Object.values(errors).flat().join('\n')
                    : 'Something went wrong.');
            },
            complete: function () {
                $('#btnUpdatePO').prop('disabled', false).text('Update PO');
            }
        });
    });

});

// ── Recalc Prices ──
function recalcPrices() {
    let subtotal = 0;

    $('#priceTableBody tr').each(function () {
        let val = $(this).find('.row-total').text().replace(/[₹,]/g, '');
        subtotal += parseFloat(val) || 0;
    });

    let gstRate = parseFloat($('#gstRate').val()) || 0;
    let gstAmt  = subtotal * gstRate / 100;
    let total   = subtotal + gstAmt;

    $('#subtotalAmt').text('₹' + formatINR(subtotal));
    $('#gstAmt').text('₹' + formatINR(gstAmt));
    $('#totalAmt').html('<strong>₹' + formatINR(total) + '</strong>');

    $('#h_subtotal').val(subtotal.toFixed(2));
    $('#h_gst_amount').val(gstAmt.toFixed(2));
    $('#h_total_amount').val(total.toFixed(2));
}

// ── Format INR ──
function formatINR(value) {
    return parseFloat(value).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}


function loadSupplierCategory(supplierId)
{
    $('#supplier_category').val('');

    if (!supplierId) {
        return;
    }

    $.ajax({
        url: "/get-supplier-category/" + supplierId,
        type: "GET",

        success: function(response)
        {
            if(response.status)
            {
                $('#supplier_category').val(response.category);
            }
        },

        error: function()
        {
            console.log('Supplier category not found');
        }
    });
}


// Change Event
$('#supplier_id').on('change', function ()
{
    loadSupplierCategory($(this).val());
});


// Default Load (Edit Page)
$(document).ready(function ()
{
    let supplierId = $('#supplier_id').val();

    loadSupplierCategory(supplierId);
});
</script>