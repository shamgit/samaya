@include('layouts.header')
@include('layouts.sidebar')

<style>
.error {
    color: red;
    font-size: 13px;
    margin-top: 4px;
    display: block;
}

.is-invalid {
    border: 1px solid red !important;
}
 </style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('supplier') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      Add New Supplier</h1>
    </a>
    
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── BASIC INFORMATION ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Basic Information</span>
      </div>

      <form  id="suppliersForm" method="POST" action="{{ route('suppliers_store') }}" enctype="multipart/form-data">
       @csrf
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Supplier Name <span class="text-danger">*</span></label>
          <input type="text" class="form-input" id="fName"  name="supplier_name" required placeholder="Supplier Name"/>
        </div>
        <div class="form-group">
          <label class="form-label">Contact Person <span class="text-danger">*</span></label>
          <input type="text" class="form-input" id="fContact" name="contact_person_name" required placeholder="Contact Person"/>
        </div>
      </div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Email<span class="text-danger">*</span></label>
			  <input type="text" class="form-input" id="fPhone" name="email" required placeholder="Email"/>
			</div>
			<div class="form-group">
			  <label class="form-label">Phone <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" id="fPhone" name="phone" required placeholder="Phone"/>
			</div>
		</div>	
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">Address <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="address" required placeholder="Address"/>
			</div>
			<div class="form-group">
			  <label class="form-label">City <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="city" required placeholder="City"/>
			</div>
		</div>
		<div class="form-row">
		   <div class="form-group">
			  <label class="form-label">State <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="state" required  placeholder="State"/>
			</div>
			<div class="form-group">
			  <label class="form-label">Zip Code<span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="zip_code" required placeholder="Zip Code"/>
			</div>
		</div>
		
    </div>

    <!-- ── BUSINESS DETAILS ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Business Details</span>
      </div>

      <div class="form-row">
			<div class="form-group">
			  <label class="form-label">Product Category <span class="text-danger">*</span></label>
			  <select class="form-input" id="fCategory" name="category_id" required>
				<option value="">Select Category</option>
				 @foreach($categorys as $category)
					<option value="{{ $category->category_id }}">
						{{ $category->category_name }}
					</option>
				  @endforeach
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">GST / Tex <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="gst_tex" required placeholder="GST / Tex"/>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group">
			  <label class="form-label">Payment Terms <span class="text-danger">*</span></label>
			  <select class="form-input" id="fTerms" name="payment_term_id" required>
				<option value="">Select Payment Terms</option>
				  @foreach($payment_terms as $payment_term)
					<option value="{{ $payment_term->payment_term_id }}">
						{{ $payment_term->name }}
					</option>
					@endforeach
			  </select>
			</div>
			<div class="form-group">
			  <label class="form-label">Bank Name <span class="text-danger">*</span></label>
			  <input type="text" class="form-input" name="bank_name" required  placeholder="Bank Name"/>
			</div>
		</div>
		<div class="form-row">			
			<div class="form-group">
			  <label class="form-label">Account Number <span class="text-danger">*</span></label>
			  <input type="text" class="form-input"  name="account_number" required  placeholder="Account Number"/>
			</div>
			<div class="form-group">
			  <label class="form-label">IFSC Code<span class="text-danger">*</span></label>
			  <input type="text" class="form-input"  name="ifsc_code" required placeholder="IFSC Code"/>
			</div>
		</div>
		<div class="form-row">
			
			<div class="form-group">
			  <label class="form-label">Status <span class="text-danger">*</span></label>
			  <select class="form-input" id="fStatus" name="status" required>
				<option value="status">Select Status</option>
				<option value="1">Active</option>
				<option value="2">Inactive</option>
			  </select>
			</div>
		</div>
		
    </div>
    <div class="section-block text-end">
		<a class="btn-cancel"  onclick="window.location='{{ route('supplier') }}'" >Cancel</a>
		<button type="submit" class="btn-save" >Save Supplier</button>
	</div>
   </form>		
   
    

  </div><!-- /detail-card -->
  
  
</main>

@include('layouts.footer')

@include('layouts.scripts')


<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(document).ready(function () {

    $('#suppliersForm').validate({

        errorClass: 'error',
        validClass: 'valid',
        errorElement: 'span',

        rules: {

            supplier_name: {
                required: true
            },

            contact_person_name: {
                required: true
            },

            email: {
                required: true,
                email: true
            },

            phone: {
                required: true,
                minlength: 10,
            },

            address: {
                required: true
            },

            city: {
                required: true
            },

            state: {
                required: true
            },

            zip_code: {
                required: true,
                digits: true
            },

            category_id: {
                required: true
            },

            gst_tex: {
                required: true
            },

            payment_term_id: {
                required: true
            },

            bank_name: {
                required: true
            },

            account_number: {
                required: true,
                digits: true
            },

            ifsc_code: {
                required: true
            },

            status: {
                required: true
            }
        },

        messages: {

            supplier_name: "Please enter supplier name",

            contact_person_name: "Please enter contact person name",

            email: {
                required: "Please enter email address",
                email: "Enter valid email address"
            },

            phone: {
                required: "Please enter phone number",
            },

            address: "Please enter address",

            city: "Please enter city",

            state: "Please enter state",

            zip_code: {
                required: "Please enter Zip code"
            },

            category_id: "Select product category",

            gst_tex: "Enter GST / Tax number",

            payment_term_id: "Select payment terms",

            bank_name: "Enter bank name",

            account_number: {
                required: "Enter account number",
            },

            ifsc_code: "Enter IFSC code",

            status: "Select status"
        },

        errorPlacement: function (error, element) {

            error.addClass('text-danger');

            if (element.is('select')) {

                error.insertAfter(element);

            } else {

                error.insertAfter(element);
            }
        },

        highlight: function (element) {

            $(element).addClass('is-invalid');
        },

        unhighlight: function (element) {

            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {

            form.submit();
        }

    });

});
</script>