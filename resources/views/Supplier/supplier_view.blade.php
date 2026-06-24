@include('layouts.header')
@include('layouts.sidebar')
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('supplier') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      View – {{ $supplier_details->supplier_name }} Supplier</h1>
    </a>
    <!-- <div class="header-btns">
      <a href="supplier-edit.php">
          <button class="btn-edit">
            <i class="bi bi-pencil"></i> Edit
          </button>
      </a>  
      <button class="btn-delete">
        <i class="bi bi-trash"></i> Delete
      </button>
    </div> -->
  </div>
  
  
  <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── BASIC INFORMATION ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Basic Information</span>
      </div>

      <table class="info-table">
        <tbody>
          <tr class="info-row">
            <td class="info-label">Supplier Name</td>
            <td class="info-value">{{ $supplier_details->supplier_name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Contact Person</td>
            <td class="info-value">{{ $supplier_details->contact_person_name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Email</td>
            <td class="info-value"><a href="{{ $supplier_details->supplier_name }}">{{ $supplier_details->email }}</a></td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Phone Number</td>
            <td class="info-value mono"><a href="{{ $supplier_details->supplier_name }}">{{ $supplier_details->phone }}</a></td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Address</td>
            <td class="info-value">{{ $supplier_details->address }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">City</td>
            <td class="info-value">{{ $supplier_details->city }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Zip Code</td>
            <td class="info-value mono">{{ $supplier_details->zip_code }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ── BUSINESS DETAILS ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">Business Details</span>
      </div>

      <table class="info-table">
        <tbody>
          <tr class="info-row">
            <td class="info-label">Product Category</td>
            <td class="info-value">{{ $supplier_details->category_name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">GST / Tax ID</td>
            <td class="info-value mono">{{ $supplier_details->gst_tex }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Payment Terms</td>
            <td class="info-value">{{ $supplier_details->name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Bank Name</td>
            <td class="info-value">{{ $supplier_details->bank_name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Account Number</td>
            <td class="info-value mono">{{ $supplier_details->account_number }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">IFSC Code</td>
            <td class="info-value mono">{{ $supplier_details->ifsc_code }}</td>
          </tr>
		   <tr class="info-row">
            <td class="info-label">Status</td>
             <td class="info-value mono"> 
              @if($supplier_details->status == 1)
                    <span class="badge-status badge-active">
                        Active
                    </span>
                @else

                <span class="badge-status badge-inactive">
                    Inactive
                </span>

                @endif
              </td>
          </tr>
        </tbody>
      </table>
    </div>

   
    

  </div><!-- /detail-card -->
  
  
</main>

@include('layouts.footer')

@include('layouts.scripts')
