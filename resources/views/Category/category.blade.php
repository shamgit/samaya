@include('layouts.header')
@include('layouts.sidebar')

<style>
 .error {
     color: red;
 }
  #dt-search-0 {
  display: none;
}
.dt-search{
	display: none;
}
</style>
<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Product Category </h1>
    <div class="header-actions">
      
      <button class="btn-add" data-bs-toggle="modal" data-bs-target="#masteradd">
        <i class="bi bi-plus-lg"></i>
        <span class="add-txt">Add Category</span>
      </button>
    </div>
  </div>

<!-- Add Masters -->
  <div class="modal fade" id="masteradd" tabindex="-1" aria-labelledby="masteraddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <form id="createCategoryForm" method="POST" action="{{ route('category_store') }}">
            @csrf
            <div class="modal-body">
            <div class="section-block p-2"> 
                <div class="form-group">
                  <label class="form-label">Category Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-input" name="category_name" required placeholder="Category Name"/>
                </div>
                <div class="text-end">
                  <a href="{{ route('category') }}"><button class="btn-cancel" >Cancel</button></a>
                  <button class="btn-save">Add</button>
                </div>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>

  <!-- ══════════ FILTER BAR ══════════ -->
  <div class="filter-bar">
    <div class="search-wrap">
      <i class="bi bi-search search-icon"></i>
      <input type="text" class="search-input" id="searchInput" placeholder="Search"/>
    </div>
    <select class="filter-select" id="categoryFilter">
      <option value="">Category: All</option>
       @foreach($categorys as $category)
          <option value="{{ $category->category_id }}">
              {{ $category->category_name }}
          </option>
        @endforeach
    </select>
   
    <select class="filter-select" id="sortFilter">
      <option value="recent">Sort By: Recent</option>
      <option value="name">Sort By: Name</option>
      <option value="sno">Sort By: S.No</option>
    </select>
  </div>

  <!-- ══════════ TABLE CARD ══════════ -->
  <div class="table-card">
    <div class="table-scroll">
      <table class="supplier-table" id="CategoryTable">
        <thead>
          <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Created By</th>
            <th>Ctreate At</th>
            <th>Updated By</th>
            <th>Updated At</th>
            <th style="text-align:center;">Actions</th>
          </tr>
        </thead>
        
		<tbody>
        </tbody>
		
      </table>
    
  </div>

</div><!-- /page-wrap -->

</main>
<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="masteraddLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form  method="POST" action="{{ route('category_updated') }}">
		 @csrf
          <div id="edit_medium_form"></div>
        </form>
    </div>
  </div>
</div>
<!-- Edit Modal -->

@include('layouts.footer')

@include('layouts.scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    let table = $('#CategoryTable').DataTable({

        processing: true,

        serverSide: true,

        lengthChange: false,

        info: false,

        ordering: false,

        ajax: {

            url: "{{ route('category_list_table') }}",

            type: "POST",

            data: function (d) {

                d._token = "{{ csrf_token() }}";
                d.category_id = $('#categoryFilter').val();
                d.sort = $('#sortFilter').val();
                d.search = {
                    value: $('#searchInput').val()
                };
            }
        },

        columns: [

            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'text-center',

                render: function (data, type, row, meta) {

                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },

            {
                data: 'category_name',
                className: 'text-center fw-bold'
            },

            {
                data: 'created_by',
                className: 'text-center',

                render: function(data){

                    return data ?? 'Admin';
                }
            },

            {
                data: 'created_at',
                className: 'text-center',

                render: function(data){

                    return moment(data).format('DD MMM YYYY');
                }
            },

            {
                data: 'updated_by',
                className: 'text-center',

                render: function(data){

                    return data ?? '-';
                }
            },

            {
                data: 'updated_at',
                className: 'text-center',

                render: function(data){

                    return moment(data).format('DD MMM YYYY');
                }
            },

            {
                data: 'category_id',

                orderable: false,

                searchable: false,

                className: 'text-center',

                render: function (data) {

                    return `
                      <div class="d-flex gap-2">
                        <a class="edit_model_btn" data-bs-toggle="modal" data-bs-target="#editRoleModal">
                          <div class="alert alert-secondary py-1 px-2 mb-0" >
                            <i class="bi bi-pencil"></i>
                          </div>
                        </a>
                        <div class="alert alert-danger py-1 px-2 mb-0 deleteRoleBtn" role="alert"  data-id="${data}" style="cursor:pointer;">
                          <i class="bi bi-trash"></i>
                        </div>
                      </div>
                      
                     
                        
                    `;
                }
            }
        ]
    });

    $('#categoryFilter').change(function () {

        table.ajax.reload();
    });

    $('#sortFilter').change(function () {

        table.ajax.reload();
    });

     $('#searchInput').keyup(function () {

        table.ajax.reload();

    });

});

</script>


<script>
$(document).ready(function() {
  $(document).on('click', '.edit_model_btn', function() {
        var table = $('#CategoryTable').DataTable();
	    var rowData = table.row($(this).closest('tr')).data();
	    var category_id = rowData.category_id;
	    // console.log('Delete ID:', category_id);

        $.ajax({
            url: 'category_edit/' + category_id, 
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}" 
            },
            success: function(data) {
                $("#editCategoryModal").modal('show');
                $("#edit_medium_form").html(data);

            },
            error: function(xhr, status, error) {
                // Handle error (e.g., display a message to the user)
                console.error("AJAX Error: " + error);
            }
        });
    });
 });
</script>

<script>



$(document).on('click', '.deleteRoleBtn', function () {

    let category_id = $(this).data('id');

    Swal.fire({

        title: 'Are you sure?',

        text: "You won't be able to revert this!",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Yes, delete it!'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('category_delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    category_id: category_id
                },

                success: function (response) {

                    if (response.status == true) {

                        Swal.fire({

                            icon: 'success',

                            title: 'Deleted!',

                            text: response.message,

                            timer: 2000,

                            showConfirmButton: false

                        });

                        $('#CategoryTable').DataTable().ajax.reload();

                    } else {

                        Swal.fire({

                            icon: 'error',

                            title: 'Oops...',

                            text: response.message
                        });
                    }
                },

                error: function () {

                    Swal.fire({

                        icon: 'error',

                        title: 'Server Error',

                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });

});

</script>


<script>
 $(document).ready(function () {      
   $('#createCategoryForm').validate({
       rules: {
           category_name: {
               required: true
           }
       },
       messages: {
           name: "Please enter a category name"
       }
   });
});
</script>




