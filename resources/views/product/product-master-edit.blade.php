@include('layouts.header')
@include('layouts.sidebar')

<main class="main-content">

    <div class="page-header">
        <a href="{{ route('product_master') }}" class="back-title">
            <h1 class="page-title">
                <i class="bi bi-chevron-left"></i>
                Edit Product
            </h1>
        </a>
    </div>

    <div class="detail-card">

        <!-- Product Details -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Product Details</span>
            </div>

            <input type="hidden" id="editId" value="{{ $id }}"/>

            <div class="form-row">

                <!-- Product Image -->
                <div class="form-group">
                    <label class="form-label">Product Image <span class="text-danger">*</span></label>
                    <div class="input-group date_picker file_btn">
                        <input type="text" class="form-control" placeholder="Upload files" id="fileName" readonly>
                        {{-- FIXED: added name="product_image" --}}
                        <input type="file" class="d-none" id="fileInput" name="product_image" accept="image/*">
                        <button class="btn btn-primary" type="button"
                            onclick="document.getElementById('fileInput').click()">
                            Browse Files
                        </button>
                    </div>
                    <div class="d-flex gap-3 mt-2">
                        <div class="up-img">
                            <img src="" id="previewImage" class="img-fluid" width="120"
                                style="display:none; border-radius:6px;">
                        </div>
                    </div>
                </div>

                <!-- Product Name -->
                <div class="form-group">
                    <label class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" id="product_name">
                </div>

            </div>

            <div class="form-row">

                <!-- Product Code -->
                <div class="form-group">
                    <label class="form-label">Product Code</label>
                    <input type="text" class="form-input" id="product_code" disabled/>
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label class="form-label">Product Category <span class="text-danger">*</span></label>
                    <select class="form-input" id="category_id">
                        <option value="">Select Category</option>
                    </select>
                </div>

            </div>

            <div class="form-row">

                <!-- Measure -->
                <div class="form-group">
                    <label class="form-label">Unit of Measure <span class="text-danger">*</span></label>
                    <select class="form-input" id="measure">
                        <option value="">Select Measure</option>
                        <option value="KG">KG</option>
                        <option value="L">L</option>
                        <option value="Nos">Nos</option>
                        <option value="Mtr">Mtr</option>
                        <option value="Pcs">Pcs</option>
                    </select>
                </div>

                <!-- Color -->
                <div class="form-group">
                    <label class="form-label">Product Color <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" id="product_color">
                </div>

            </div>
        </div>

        <!-- Supplier & Price -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Supplier & Price</span>
            </div>
            <div class="form-row">

                <div class="form-group">
                    <label class="form-label">Supplier  <span class="text-danger">*</span></label>
                    <select class="form-input" id="supplier_id">
                        <option value="">Select Supplier</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Cost / Price  <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" id="cost_price">
                </div>

            </div>
        </div>

        <!-- Inventory Setting -->
        <div class="section-block">
            <div class="section-header">
                <span class="section-title">Inventory Setting</span>
            </div>
            <div class="form-row">

                <div class="form-group">
                    <label class="form-label">Reorder Level  <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" id="reorder_level">
                </div>

                <div class="form-group">
                    <label class="form-label">Warehouse Location  <span class="text-danger">*</span></label>
                    <input type="text" class="form-input" id="location">
                </div>

            </div>
        </div>

        <!-- Buttons -->
        <div class="section-block text-end">
            <a href="{{ route('product_master') }}" class="btn-cancel">Cancel</a>
            <button class="btn-save" id="updateProduct">Update Product</button>
        </div>

    </div>

</main>

@include('layouts.footer')
@include('layouts.scripts')

<script>
$(document).ready(function () {

    let id = $('#editId').val();

    // Wait for BOTH dropdowns first, then fill product values
    $.when(loadCategories(), loadSuppliers()).done(function () {
        loadProduct(id);
    });

});


// ── Load Product ─────────────────────────────────────────────────────────────
function loadProduct(id) {
    $.ajax({
        url: '/product-show/' + id,
        type: 'GET',
        success: function (product) {

            $('#product_name').val(product.product_name);
            $('#product_code').val(product.product_code);
            $('#product_color').val(product.product_color);
            $('#cost_price').val(product.cost_price);
            $('#reorder_level').val(product.reorder_level);
            $('#location').val(product.warehouse_location);

            // Dropdowns — work now because both are pre-loaded
            $('#measure').val(product.unit_of_measure);
            $('#category_id').val(product.category_id);
            $('#supplier_id').val(product.supplier_id);

            // Product image preview
            if (product.product_image) {
                $('#previewImage')
                    .attr('src', '/uploads/products/' + product.product_image)
                    .show();
                $('#fileName').val(product.product_image);
            }

        },
        error: function (xhr) {
            console.error('Failed to load product:', xhr.responseText);
            alert('Failed to load product data.');
        }
    });
}


// ── Load Categories ───────────────────────────────────────────────────────────
function loadCategories() {
    return $.ajax({
        url: '/categories-list',
        type: 'GET',
        success: function (response) {
            let html = '<option value="">Select Category</option>';
            $.each(response, function (i, category) {
                html += `<option value="${category.category_id}">${category.category_name}</option>`;
            });
            $('#category_id').html(html);
        },
        error: function (xhr) {
            console.error('Failed to load categories:', xhr.responseText);
        }
    });
}


// ── Load Suppliers ────────────────────────────────────────────────────────────
function loadSuppliers() {
    return $.ajax({
        url: '/suppliers-list',
        type: 'GET',
        success: function (response) {
            let html = '<option value="">Select Supplier</option>';
            $.each(response, function (i, supplier) {
                html += `<option value="${supplier.supplier_id}">${supplier.supplier_name}</option>`;
            });
            $('#supplier_id').html(html);
        },
        error: function (xhr) {
            console.error('Failed to load suppliers:', xhr.responseText);
        }
    });
}


// ── File Preview ──────────────────────────────────────────────────────────────
$('#fileInput').change(function () {
    if (this.files && this.files[0]) {
        $('#fileName').val(this.files[0].name);

        let reader = new FileReader();
        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(this.files[0]);
    }
});


// ── Update Product ────────────────────────────────────────────────────────────
$('#updateProduct').click(function (e) {
    e.preventDefault();

    let id = $('#editId').val();

    // Basic validation
    if (!$('#product_name').val()) { alert('Product Name is required.');     return; }
    if (!$('#category_id').val())  { alert('Category is required.');         return; }
    if (!$('#measure').val())      { alert('Unit of Measure is required.');  return; }
    if (!$('#supplier_id').val())  { alert('Supplier is required.');         return; }
    if (!$('#cost_price').val())   { alert('Cost / Price is required.');     return; }

    let formData = new FormData();

    formData.append('product_name',  $('#product_name').val());
    formData.append('Category',      $('#category_id').val());
    formData.append('product_code',  $('#product_code').val());
    formData.append('measure',       $('#measure').val());
    formData.append('product_color', $('#product_color').val());
    formData.append('supplier',      $('#supplier_id').val());
    formData.append('cost_price',    $('#cost_price').val());
    formData.append('reorder_level', $('#reorder_level').val());
    formData.append('location',      $('#location').val());
    formData.append('_token',        '{{ csrf_token() }}');

    // FIXED: append as 'product_image' to match controller hasFile('product_image')
    if ($('#fileInput')[0].files[0]) {
        formData.append('product_image', $('#fileInput')[0].files[0]);
    }

    // Disable button to prevent double submit
    $('#updateProduct').prop('disabled', true).text('Updating...');

    $.ajax({
        url: '/product-update/' + id,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
		success: function (response) {

		Swal.fire({

			icon: 'success',

			title: 'Success',

			text: 'Product Updated Successfully',

			confirmButtonColor: '#3085d6'

		}).then((result) => {

			if(result.isConfirmed)
			{
				window.location.href = '/product_master';
			}

		});

	},
        error: function (xhr) {
            console.error('Update failed:', xhr.responseText);
            alert('Update failed. Please try again.');
            $('#updateProduct').prop('disabled', false).text('Update Product');
        }
    });

});
</script>