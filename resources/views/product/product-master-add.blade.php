@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('product_master') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Add New Product</h1>
    </a>

  </div>
  <!-- ══════════ DETAIL CARD ══════════ -->
  <form id="productForm" enctype="multipart/form-data">
   @csrf
  <div class="detail-card">
    <!-- ── Product Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Product Details</span>
      </div>

      <input type="hidden" id="editId"/>
      <div class="form-row">
		<div class="form-group">
			<label class="form-label">Product Image <span class="text-danger">*</span></label>
			<div class="input-group date_picker file_btn">
				<input type="text" class="form-control" placeholder="Upload files" id="fileName" readonly>
			<input type="file" class="d-none" id="fileInput" name="product_image">
				<button class="btn btn-primary" type="button" onclick="document.getElementById('fileInput').click()">
				  Browse Files
				</button>
			</div>
			<div class="mt-2"><img id="previewImage" src="{{asset('assets/img/images.jpg')}}" style="width:80px;height:80px;border-radius:6px;object-fit:cover;border:1px solid #ddd;"></div>
		</div>
        <div class="form-group">
          <label class="form-label">Product Name <span class="text-danger">*</span></label>
          <input type="text" class="form-input" id="product_name" name="product_name" aria-colspan=""placeholder=""/>
        </div>
      </div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Product Code</label> 
			    <input type="text"class="form-input"id="product_code" name="product_code"readonly>
			</div>
			<div class="form-group">
				<label class="form-label">Product Category <span class="text-danger">*</span></label>

				<select class="form-input" id="fCategory" name="Category">
					<option value="">Select Category</option>
				</select>
			</div>
		</div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Unit of Measure <span class="text-danger">*</span></label>
			  <select class="form-input" id="measure" name="measure">
				<option value="">Select Measure</option>
				<option>KG</option><option>L</option>
				<option>Nos</option><option>Mtr</option><option>Pcs</option>
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">Product Color  <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" id="product_color" name="product_color" placeholder=""/>
			</div>
		</div>


    </div>

    <!-- ── Supplier & Price ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Supplier & Price</span>
      </div>
      <div class="form-row">
			<div class="form-group">
			  <label class="form-label">Supplier <span class="text-danger">*</span></label>
			<select name="supplier" id="supplier_id" class="form-input">
			   <option value="">Select Supplier</option>
			</select>
			</div>
			<div class="form-group">
			  <label class="form-label">Cost / Price <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" id="cost_price" name="cost_price" placeholder=""/>
			</div>
		</div>
    </div>

	<!-- ── Inventory Setting ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Inventory Setting</span>
      </div>
      <div class="form-row">

			<div class="form-group">
			  <label class="form-label">Reorder Level <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" id="reorder_level" name="reorder_level" placeholder=""/>
			</div>
			<div class="form-group">
			  <label class="form-label">Warehouse Location <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" id="location" name="location" placeholder=""/>
			</div>
		</div>
    </div>

    <div class="section-block text-end">
		<a href="{{ route('product_master') }}" class="btn-cancel">Cancel</a>
		<button type="button" class="btn-save" id="saveProduct">Save Product</button>
	</div>

  </div><!-- /detail-card -->
  </form>
</main>
@include('layouts.footer')
@include('layouts.scripts')
<script>
$(document).ready(function () {

    generateProductCode();

    // File Preview
    $('#fileInput').on('change', function () {

        if (this.files && this.files[0]) {

            $('#fileName').val(this.files[0].name);

            let reader = new FileReader();

            reader.onload = function (e) {

                $('#previewImage').attr('src', e.target.result);
            };

            reader.readAsDataURL(this.files[0]);
        }
    });

    // Save Product
    $('#saveProduct').click(function (e) {

        e.preventDefault();

        let formData = new FormData($('#productForm')[0]);

        $.ajax({

            url: "{{ route('product.store') }}",

            type: "POST",

            data: formData,

            processData: false,

            contentType: false,

            success: function(response) {

                Swal.fire({

                    icon: 'success',

                    title: 'Success',

                    text: response.message,

                    confirmButtonColor: '#3085d6'

                });

                $('#productForm')[0].reset();

                $('#previewImage').attr(
                    'src',
                    'https://via.placeholder.com/80'
                );

                $('#fileName').val('');

                generateProductCode();
            },

            error: function(xhr) {

                console.log(xhr.responseText);

                if(xhr.responseJSON.errors)
                {
                    let errorMessage = '';

                    $.each(xhr.responseJSON.errors, function(key, value){

                        errorMessage += value[0] + '<br>';

                    });

                    Swal.fire({

                        icon: 'error',

                        title: 'Validation Error',

                        html: errorMessage,

                        confirmButtonColor: '#d33'

                    });

                }
                else
                {
                    Swal.fire({

                        icon: 'error',

                        title: 'Oops...',

                        text: 'Save Failed',

                        confirmButtonColor: '#d33'

                    });
                }
            }
        });

    });

});


// Generate Product Code
function generateProductCode()
{
    $.ajax({

        url: "{{ route('product.code') }}",

        type: "GET",

        success: function(response)
        {
            $('#product_code').val(response.product_code);
        },

        error: function(xhr)
        {
            console.log(xhr.responseText);
        }
    });
}


$(document).ready(function () {

    $.ajax({
        url: "{{ route('get.category') }}",
        type: "GET",
        dataType: "json",

        success: function (response) {

            $('#fCategory').empty();

            $('#fCategory').append(
                '<option value="">Select Category</option>'
            );

            $.each(response, function (key, value) {

                $('#fCategory').append(
                    '<option value="' + value.category_id + '">' 
                    + value.category_name + 
                    '</option>'
                );

            });

        },

        error: function (xhr) {
            console.log(xhr.responseText);
        }
    });

});

$(document).ready(function () {

    loadSuppliers();

});

function loadSuppliers()
{
    $.ajax({

        url: "{{ route('get.suppliers') }}",
        type: "GET",
        dataType: "json",

        success: function (response) {

            $('#supplier_id').empty();

            $('#supplier_id').append(
                '<option value="">Select Supplier</option>'
            );

            $.each(response, function (key, supplier) {

                $('#supplier_id').append(

                    '<option value="' + supplier.supplier_id + '">' 
                    + supplier.supplier_name + 
                    '</option>'

                );

            });

        },

        error: function (xhr) {

            console.log(xhr.responseText);

        }

    });
}

</script>