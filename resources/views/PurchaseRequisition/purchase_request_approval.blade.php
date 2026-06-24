@include('layouts.header')

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>

@include('layouts.sidebar')

<style>


.table-scroll{
    overflow:visible !important;
}

.action-wrap{
    position:relative;
}

.action-menu{
    position:absolute;
    right:0;
    top:35px;
    background:#fff;
    border-radius:10px;
    min-width:150px;
    box-shadow:0 5px 15px rgba(0,0,0,0.15);
    display:none;
    z-index:9999;
}

.action-menu-item{
    padding:10px 15px;
}

.action-menu-item a{
    text-decoration:none;
    color:#333;
    display:block;
}

.action-menu-item:hover{
    background:#f5f5f5;
}

.page-btn.active{
    background:#000;
    color:#fff;
}

</style>


<main class="main-content">

    <div class="page-header">

        <h1 class="page-title">
            Purchase Request Approval
        </h1>

    </div>


    <!-- FILTER -->
    <div class="filter-bar">

        <div class="input-group date_picker"
             style="width:300px;">

            <span class="input-group-text bg-white">

                <i class="bi bi-calendar"></i>

            </span>

            <input type="text"
                   id="dateRangePicker"
                   class="form-control form-control-sm bg-white"
                   placeholder="Select date range"
                   readonly />

        </div>


        <select class="filter-select"
                id="statusFilter">

            <option value="">Status: All</option>

            <option value="Approved">Approved</option>

            <option value="Pending">Pending</option>

            <option value="Completed">Completed</option>

            <option value="Denied">Denied</option>

        </select>



        <select class="filter-select"
                id="DepartmentFilter">

            <option value="">Department: All</option>

        </select>



        <select class="filter-select"
                id="PriorityFilter">

            <option value="">Priority: All</option>

            <option value="High">High</option>

            <option value="Medium">Medium</option>

            <option value="Low">Low</option>

        </select>



        <select class="filter-select"
                id="sortFilter">

            <option value="recent">
                Sort By: Recent
            </option>

            <option value="name">
                Sort By: Name
            </option>

        </select>

    </div>



    <!-- TABLE -->
    <div class="table-card">

        <div class="table-scroll">

            <table class="supplier-table">

                <thead>

                    <tr>

                        <th>Requisition ID</th>

                        <th>Department</th>

                        <th>requested</th>

                        <th>Date Required</th>

                        <th>Priority</th>

                        <th>Status</th>

                        <th style="text-align:center;">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody id="tableBody">

                    <tr>

                        <td colspan="7"
                            class="text-center">

                            Loading...

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>



        <!-- PAGINATION -->
        <div class="table-footer">

            <div class="rows-per-page">

                Row Per Page

                <select class="rows-select"
                        id="rowsSelect">

                    <option value="5">5</option>

                    <option value="10">10</option>

                    <option value="25">25</option>

                    <option value="50">50</option>

                </select>

                Entries

            </div>

            <div class="pagination-wrap"
                 id="paginationWrap">

            </div>

        </div>

    </div>

</main>



@include('layouts.footer')

@include('layouts.scripts')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>

let allData = [];

let filtered = [];

let currentPage = 1;

let rowsPerPage = 5;



// LOAD TABLE
function loadApprovalTable()
{
    $.ajax({

        url: "{{ route('purchase-requisition.list') }}",

        type: "GET",

        dataType: "json",

        success: function(response)
        {
            allData = [];

            let departments = [];

            $.each(response, function(index, item){

                let priorityClass = 'badge-info';

                if(item.priority == 'High'){

                    priorityClass = 'badge-status badge-completed';

                } else if(item.priority == 'Low'){

                    priorityClass = 'badge-pending';
                }

                let statusClass = 'badge-pending';

                if(item.status == 'Approved'){

                    statusClass = 'badge-approved';

                } else if(item.status == 'Denied'){

                    statusClass = 'badge-denied';

                } else if(item.status == 'Completed'){

                    statusClass = 'badge-completed';
                }

                let deptName = item.department
                    ? item.department.name
                    : 'N/A';

                departments.push(deptName);

                allData.push({

                    requisition_id : item.requisition_id,

                    department : deptName,

                    requested : item.requested,

                    required_date : item.required_date,

                    priority : item.priority,

                    priorityClass : priorityClass,

                    status : item.status,

                    statusClass : statusClass
                });

            });

            // UNIQUE DEPARTMENT
            departments = [...new Set(departments)];

            let deptHtml =
                '<option value="">Department: All</option>';

            $.each(departments, function(i, dept){

                deptHtml += `
                    <option value="${dept}">
                        ${dept}
                    </option>
                `;
            });

            $('#DepartmentFilter').html(deptHtml);

            filtered = allData;

            renderTable();
        }
    });
}



// RENDER TABLE
function renderTable()
{
    let tbody = $('#tableBody');

    tbody.html('');

    if(filtered.length == 0){

        tbody.html(`
            <tr>
                <td colspan="7"
                    class="text-center">

                    No Data Found

                </td>
            </tr>
        `);

        $('#paginationWrap').html('');

        return;
    }

    let start = (currentPage - 1) * rowsPerPage;

    let end = start + rowsPerPage;

    let pageData = filtered.slice(start, end);

    $.each(pageData, function(index, row){

        tbody.append(`

            <tr>

                <td>${row.requisition_id}</td>

                <td>${row.department}</td>

                <td>${row.requested}</td>

                <td>${row.required_date}</td>

                <td>

                    <span class="badge-status ${row.priorityClass}">

                        ${row.priority}

                    </span>

                </td>

                <td>

                    <span class="badge-status ${row.statusClass}">

                        ${row.status}

                    </span>

                </td>

                <td style="text-align:center;">

                    <div class="action-wrap">

                        <button class="btn-action"
                                data-id="${row.requisition_id}"
                                onclick="toggleMenu(this,event)">

                            <i class="bi bi-three-dots-vertical"></i>

                        </button>

                          <div class="action-menu">

                            <div class="action-menu-item">

                                <a href="/purchase-requisition-view/${row.requisition_id}">

                                    <i class="bi bi-eye"></i>

                                    View

                                </a>

                            </div>

                              <!-- DELETE -->
                            <div class="action-menu-item delete"
                                onclick="deleteRequest('${row.requisition_id}')">

                                <i class="bi bi-trash"></i>

                                Delete

                            </div>

                        </div>

                    </div>

                </td>

            </tr>

        `);

    });

    renderPagination();
}



// PAGINATION
function renderPagination()
{
    let totalPages =
        Math.ceil(filtered.length / rowsPerPage);

    let html = '';

    html += `
        <button class="page-btn"
                onclick="goPage(${currentPage - 1})"
                ${currentPage == 1 ? 'disabled' : ''}>

            <i class="bi bi-chevron-left"></i>

        </button>
    `;

    for(let i = 1; i <= totalPages; i++){

        html += `
            <button class="page-btn ${currentPage == i ? 'active' : ''}"
                    onclick="goPage(${i})">

                ${i}

            </button>
        `;
    }

    html += `
        <button class="page-btn"
                onclick="goPage(${currentPage + 1})"
                ${currentPage == totalPages ? 'disabled' : ''}>

            <i class="bi bi-chevron-right"></i>

        </button>
    `;

    $('#paginationWrap').html(html);
}



// CHANGE PAGE
function goPage(page)
{
    let totalPages =
        Math.ceil(filtered.length / rowsPerPage);

    if(page < 1 || page > totalPages){

        return;
    }

    currentPage = page;

    renderTable();
}



// ROWS CHANGE
$('#rowsSelect').change(function(){

    rowsPerPage = parseInt($(this).val());

    currentPage = 1;

    renderTable();

});



// STATUS FILTER
$('#statusFilter').change(function(){

    let value = $(this).val();

    if(value == ''){

        filtered = allData;

    } else {

        filtered = allData.filter(x => x.status == value);
    }

    currentPage = 1;

    renderTable();

});



// DEPARTMENT FILTER
$('#DepartmentFilter').change(function(){

    let value = $(this).val();

    if(value == ''){

        filtered = allData;

    } else {

        filtered = allData.filter(x => x.department == value);
    }

    currentPage = 1;

    renderTable();

});



// PRIORITY FILTER
$('#PriorityFilter').change(function(){

    let value = $(this).val();

    if(value == ''){

        filtered = allData;

    } else {

        filtered = allData.filter(x => x.priority == value);
    }

    currentPage = 1;

    renderTable();

});



// ACTION MENU
function toggleMenu(button, event)
{
    event.stopPropagation();

    $('.action-menu').hide();

    $(button)
        .closest('.action-wrap')
        .find('.action-menu')
        .toggle();
}


$(document).click(function(){

    $('.action-menu').hide();

});



// DATE PICKER
flatpickr("#dateRangePicker", {

    mode: "range",

    dateFormat: "Y-m-d"

});



// PAGE LOAD
$(document).ready(function(){

    loadApprovalTable();

});


function deleteRequest(id)
{
    Swal.fire({

        title: 'Delete Request?',

        text: "This record will be permanently deleted.",

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Yes, Delete'

    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({

                url: "{{ route('purchase-requisition.delete') }}",

                type: "POST",

                data: {

                    _token: "{{ csrf_token() }}",

                    requisition_id: id
                },

                success: function(response)
                {
                    Swal.fire({

                        icon: 'success',

                        title: 'Deleted',

                        text: response.message,

                        timer: 1500,

                        showConfirmButton: false

                    });

                    loadApprovalTable();
                },

                error: function(xhr)
                {
                    console.log(xhr.responseText);

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Delete failed'

                    });
                }

            });

        }

    });
}

</script>