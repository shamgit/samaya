@include('layouts.header')
@include('layouts.sidebar')

<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
   <a href="{{ route('users') }}" class="back-title">
      <h1 class="page-title"><i class="bi bi-chevron-left"></i>
      View User</h1>
    </a>
    
  </div>
  
   <!-- ══════════ DETAIL CARD ══════════ -->
  <div class="detail-card">

    <!-- ── Product Details ── -->
    <div class="section-block">
      <div class="section-header">
        <span class="section-title">User Details</span>
      </div>
     <input type="hidden" name="id" value="{{ $user_details->id }}">
      <table class="info-table mb-4">
        <tbody>
          <tr class="info-row">
            <td class="info-label">Profile Image</td>
            <td class="info-value">
				<div class="d-flex gap-3">
                    @if($user_details->profile)
					<div class="up-img">
						<img src="{{ asset('assets/profile/'.$user_details->profile) }}" class="img-fluid" width="100" height="100">
					</div>
                     @endif
				</div>
		  </td>
          </tr>
          <tr class="info-row">
            <td class="info-label">User Name</td>
            <td class="info-value">{{ $user_details->name }}</td>
          </tr>
          <tr class="info-row">
            <td class="info-label">Email</td>
            <td class="info-value">{{ $user_details->email }}</td>
          </tr>
		  <tr class="info-row">
            <td class="info-label">Phone</td>
            <td class="info-value">{{ $user_details->phone }}</td>
          </tr>
		  <tr class="info-row">
            <td class="info-label">Role</td>
            <td class="info-value">{{$user_details->role_name}}</td>
          </tr>	
           <tr class="info-row">
            <td class="info-label">Status</td>
            <td>
                @if($user_details->status == 1)
                    <span class="badge-status badge-active">
                        Active
                    </span>
                @else

                <span class="badge-status badge-inactive">
                    Inactive
                </span>

                @endif

            </td>
        </tbody>
      </table>	
		
    </div>
	
  </div><!-- /detail-card -->
</main>

@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

