@include('layouts.header')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')

<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
		<a href="purchase-order.php" class="back-title">
			<h1 class="page-title"><i class="bi bi-chevron-left"></i>Create Purchase Order
			</h1>
		</a>
  </div>
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

	<!-- ── Supplier INFORMATION ── -->
	<div class="section-block">
	<div class="section-header">
		<span class="section-title">Supplier Info</span>
	</div>

	<input type="hidden" id="editId"/>
		<div class="form-row">
		<div class="form-group">
		<label class="form-label">Supplier Name</label>
			<select class="form-input" name="supplier_id"id="supplier_id">
			<option value="">
			Select Supplier
			</option>
			@foreach($suppliers as $supplier)
			<option value="{{ $supplier->supplier_id }}">
			{{ $supplier->supplier_name }}
			</option>
			 @endforeach
			</select>
		</div>
		<div class="form-group">
			<label class="form-label">PO Number</label>
			<input type="text" class="form-input" name="po_number" id="" value="{{ $poNumber }}" readonly/>
		 </div>
		</div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Supplier Category</label>
			  <input type="text" class="form-input" id="supplier_category" name="supplier_category" placeholder="Supplier Category" readonly>
			</div>
			<div class="form-group">
			  <label class="form-label">PO Date</label>
			  <div class="input-group date_picker">
				<input type="text" class="form-control" id="f_requestDate" placeholder="Select date" readonly />
				<span class="input-group-text bg-white">
				  <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
				</span>
			  </div>
			</div>
		</div>	
		
		
    </div>
	  <!-- ── Product List ── -->
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
						  <tbody id="productTableBody">
							<tr>
							  <td colspan="6"class="text-center">
								Loading...
								</td>
							 </tr>
							</tbody>
						</table>
				    </div>
				</div>
		
    </div>

	
	 <!-- ── Price Details ── -->
	 

<!-- ── Price Details ── -->
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
              <tr>
                <td colspan="4" class="text-center">Loading...</td>
              </tr>
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
                <td id="subtotalAmt">₹0.00</td>
              </tr>
              <tr>
                <td>
                  GST 
                  <select id="gstRate" class="form-input form-input-sm" style="width:80px;display:inline-block;">
                    <option value="0">0%</option>
                    <option value="5">5%</option>
                    <option value="12">12%</option>
                    <option value="18" selected>18%</option>
                    <option value="28">28%</option>
                  </select>
                </td>
                <td id="gstAmt">₹0.00</td>
              </tr>
              <tr>
                <td><strong>Total Amount</strong></td>
                <td id="totalAmt"><strong>₹0.00</strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
    <!-- Add these hidden inputs inside .detail-card (before the buttons) -->
			<input type="hidden" id="h_requisition_id" value="{{ $requisition->id }}">
			<input type="hidden" id="h_po_number"      value="{{ $poNumber }}">
			<input type="hidden" id="h_subtotal"        value="0">
			<input type="hidden" id="h_gst_amount"      value="0">
			<input type="hidden" id="h_total_amount"    value="0">

		<!-- Add IDs to existing inputs -->
		<!-- PO Date:           id="f_requestDate"      (already exists) -->
		<!-- Delivery Date:     id="f_deliveryDate"     (add this id)    -->
		<!-- Delivery Location: id="delivery_location"  (add this id)    -->
		<!-- Payment Terms:     id="fTerms"             (already exists) -->
		<!-- Notes:             id="additional_notes"   (add this id)    -->
			<!-- ── Delivery Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Delivery Details</span>
      </div>

	<div class="form-row">
		<div class="form-group">
			<label class="form-label">Delivery Date</label>
			<div class="input-group date_picker">
			<input type="text" class="form-control" id="f_deliveryDate" placeholder="Select date" readonly />
			<span class="input-group-text bg-white">
				<svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
			</span>
			</div>
		</div>
		<div class="form-group">
			<label class="form-label">Delivery Location</label>
			<input type="text" class="form-input" id="delivery_location" placeholder=""/>
		</div>
	</div>	
		
    </div>
	
	<!-- ── Additional Info ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Additional Info</span>
      </div>

		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Payment Terms</label>
			  <select class="form-input" id="fTerms">
				<option>Net 30</option><option>Net 15</option>
				<option>Net 45</option><option>Net 60</option>
			  </select>
			</div>
			<div class="form-group">
				<label class="form-label">Additional Notes</label>
				<input type="text" class="form-input" id="additional_notes" placeholder=""/>
			</div>
		</div>
		<div class="form-row">			
			
			<div class="form-group">
			 <label class="form-label">Attachments</label>
			  <div class="input-group date_picker file_btn">
					<input type="text" class="form-control" placeholder="Upload files" id="fileName" readonly>
					<input type="file" class="d-none" id="fileInput">
					<button class="btn btn-primary" type="button" onclick="document.getElementById('fileInput').click()">
					Browse Files
					</button>
			  </div>
			</div> 
			
		</div>
		
		
    </div>
   <!-- Buttons -->
<div class="section-block text-end">
    <button class="btn-po"     type="button" id="btnCreatePO">Create PO</button>
    <button class="btn-cancel" type="button">Print PO</button>
    <button class="btn-save"   type="button">Send to Supplier</button>
</div>	
   
  </div><!-- /detail-card -->
</main>
@include('layouts.footer')
@include('layouts.scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
<script>
$(document).ready(function(){

	$('#supplier_id').on('change', function(){

		let supplierId = $(this).val();
		$('#supplier_category').val('');

		if(supplierId == ''){

			return;

		}

		$.ajax({

			url: "/get-supplier-category/" + supplierId,

			type: "GET",

			success: function(response){

				if(response.status){

					$('#supplier_category').val(
						response.category
					);

				}

			},

			error:function(){

				alert('Supplier Category Not Found');

			}

		});

	});

});
flatpickr("#dateRangePicker", {
    mode: "range",
    dateFormat: "d M Y",
    defaultDate: ["2026-03-01", "2026-04-30"],

    onChange: function(selectedDates) {

        if (selectedDates.length === 2) {

            const fmt = d =>
                parseInt(
                    d.getFullYear() * 10000 +
                    (d.getMonth() + 1) * 100 +
                    d.getDate()
                );

            window._fromDate = fmt(selectedDates[0]);
            window._toDate = fmt(selectedDates[1]);

        } else {

            window._fromDate = null;
            window._toDate = null;

        }

        filterRows();
    }
});

flatpickr("#f_requestDate", {
    dateFormat: "d M Y",
    defaultDate: "today"
});

flatpickr("#f_deliveryDate", {
    dateFormat: "d M Y"
});

flatpickr("#f_requiredDate", {
    dateFormat: "d M Y"
});

window._fromDate = 20260301;
window._toDate = 20260430;

filterRows();
</script>

<script>

$(document).ready(function(){
	loadProducts();
});

function loadProducts()
{

let requisitionId ="{{ $requisition->id }}";
$.ajax({url:"/get-products/"+requisitionId,
type:"GET",
dataType:"json",
	success:function(response){
	let html='';
	$.each(response,
	function(index,item){
	html+=`
	<tr>
		<td>
		${item.product_name}
		</td>
		<td>
		${item.category}
		</td>
		<td>
		${item.color}
		</td>
		<td>
		${item.size}

		</td>
		<td><input type="number" placeholder="500"></td>
		<td>
		${item.unit}
		</td>
	</tr>`;

	});

	$('#productTableBody').html(html);

}

});

}
$(document).ready(function () {
    loadProducts();
    $('#gstRate').on('change', function () {
        recalcPrices();
    });
});

// Store product price map globally
window._productPrices = {};

function loadProducts(){
    let requisitionId = "{{ $requisition->id }}";

    $.ajax({
        url: "/get-products/" + requisitionId,
        type: "GET",
        dataType: "json",
        success: function (response) {

            let productHtml = '';
            let priceHtml   = '';

            $.each(response, function (index, item) {
                let productId  = item.product_id ?? index;
                let unitPrice  = parseFloat(item.cost_price) || 0;

                // Store unit price for calculation
                window._productPrices[productId] = unitPrice;

                // Product List table row (with editable qty)
                productHtml += `
                <tr>
                    <td>${item.product_name}</td>
                    <td>${item.category}</td>
                    <td>${item.color}</td>
                    <td>${item.size}</td>
                    <td>
						<input type="number"  class="form-input qty-input" 
						data-product-id="${productId}" data-unit-price="${unitPrice}"
						value="${item.quantity ?? 1}" min="1" style="width:80px;">
                    </td>
                    <td>${item.unit}</td>
                </tr>`;

                // Price Details table row
                let qty   = parseFloat(item.quantity) || 1;
                let total = qty * unitPrice;
                priceHtml += `
                <tr id="price-row-${productId}">
                    <td>${item.product_name}</td>
                    <td class="row-qty">${qty}</td>
                    <td>₹${formatINR(unitPrice)}</td>
                    <td class="row-total">₹${formatINR(total)}</td>
                </tr>`;
            });

            $('#productTableBody').html(productHtml);
            $('#priceTableBody').html(priceHtml);

            // Live qty change → update price row + totals
            $(document).on('input', '.qty-input', function () {
                let productId = $(this).data('product-id');
                let unitPrice = parseFloat($(this).data('unit-price')) || 0;
                let qty       = parseFloat($(this).val()) || 0;
                let total     = qty * unitPrice;

                $(`#price-row-${productId} .row-qty`).text(qty);
                $(`#price-row-${productId} .row-total`).text('₹' + formatINR(total));

                recalcPrices();
            });

            recalcPrices();
        },
        error: function () {
            $('#productTableBody').html('<tr><td colspan="6" class="text-center text-danger">Failed to load products.</td></tr>');
            $('#priceTableBody').html('<tr><td colspan="4" class="text-center text-danger">Failed to load prices.</td></tr>');
        }
    });
}

function recalcPrices() {
    let subtotal = 0;

    // Sum all row totals from price table
    $('#priceTableBody tr').each(function () {
        let totalText = $(this).find('.row-total').text().replace(/[₹,]/g, '');
        subtotal += parseFloat(totalText) || 0;
    });

    let gstRate  = parseFloat($('#gstRate').val()) || 0;
    let gstAmt   = subtotal * gstRate / 100;
    let total    = subtotal + gstAmt;

    $('#subtotalAmt').text('₹' + formatINR(subtotal));
    $('#gstAmt').text('₹' + formatINR(gstAmt));
    $('#totalAmt').html('<strong>₹' + formatINR(total) + '</strong>');
}

// Format number Indian style: 1,23,456.78
function formatINR(value) {
    return parseFloat(value).toLocaleString('en-IN', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

    $('#btnCreatePO').on('click', function () {

        // Collect products
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

        let requisitionId = $('#h_requisition_id').val();
        if (!requisitionId) {
            alert('Requisition ID missing!');
            return;
        }

        let formData = new FormData();
        formData.append('_token',            $('meta[name="csrf-token"]').attr('content'));
        formData.append('requisition_id',    requisitionId);
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

        $('#btnCreatePO').prop('disabled', true).text('Saving...');

        $.ajax({
            url         : '/purchase-order/store',
            type        : 'POST',
            data        : formData,
            processData : false,
            contentType : false,
            success: function (response) {
                if (response.status) {
                    alert('Purchase Order created successfully!');
                    window.location.href = '/purchase-order';
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr) {
                let errors = xhr.responseJSON?.errors;
                if (errors) {
                    alert('Validation:\n' + Object.values(errors).flat().join('\n'));
                } else {
                    alert('Something went wrong.');
                }
            },
            complete: function () {
                $('#btnCreatePO').prop('disabled', false).text('Create PO');
            }
        });
    });

</script>