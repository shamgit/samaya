@include('layouts.header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/> 
@include('layouts.sidebar')

<!-- ════════════════════════════════
     MAIN CONTENT
════════════════════════════════ -->
<main class="main-content">
   <!-- ══════════ PAGE HEADER ══════════ -->
  <div class="page-header">
    <h1 class="page-title">Purchase Order Approval<br/><small class="fs-6 fw-normal">Review and approve purchase orders based on role</small></h1>
  </div>

  <!-- ══════════ FILTER BAR ══════════ -->
  <div class="filter-bar">
    <div class="input-group date_picker" style="width:300px;">
        <span class="input-group-text bg-white">
          <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><rect x="2" y="3" width="12" height="11" rx="2" stroke="#6c757d" stroke-width="1.2"/><path d="M5 2v2M11 2v2M2 7h12" stroke="#6c757d" stroke-width="1.2" stroke-linecap="round"/></svg>
        </span>
        <input type="text" id="dateRangePicker" class="form-control form-control-sm bg-white" placeholder="Select date range" readonly />
      </div>
    <select class="filter-select" id="statusFilter">
      <option value="">Status: All</option>
      <option value="Approved">Approved</option>
      <option value="Pending">Pending</option>
      <option value="Rejected">Rejected</option>
    </select>
    <select class="filter-select" id="approvalLevelFilter">
      <option value="">Approval Level: All</option>
      <option value="Finance">Finance Approval</option>
      <option value="Director">Director Approval</option>
    </select>
	
    <select class="filter-select" id="sortFilter">
      <option value="recent">Sort By: Recent</option>
      <option value="po_no">Sort By: PO Number</option>
      <option value="supplier">Sort By: Supplier Name</option>
      <option value="amount">Sort By: Amount</option>
    </select>
  </div>

  <!-- ══════════ TABLE CARD ══════════ -->
  <div class="table-card">
    <div class="table-scroll">
      <table class="supplier-table">
        <thead>
          <tr>
            <th>PO Number</th>
            <th>Supplier</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Approval Level</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          <!-- Dynamic content will be inserted here -->
        </tbody>
      </table>
      <!-- Empty state -->
      <div class="empty-state" id="emptyState" style="display: none;">
        <i class="bi bi-inbox"></i>
        <p>No purchase orders found matching your filters.</p>
      </div>
    </div>

    <!-- ══════════ FOOTER / PAGINATION ══════════ -->
    <div class="table-footer">
      <div class="rows-per-page">
        Row Per Page
        <select class="rows-select" id="rowsSelect">
          <option value="5">5</option>
          <option value="10" selected>10</option>
          <option value="25">25</option>
          <option value="50">50</option>
        </select>
        Entries
      </div>
      <div class="pagination-wrap" id="paginationWrap"></div>
    </div>
  </div>
</main>

@include('layouts.footer')
@include('layouts.scripts')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
// Store the original data from server
let originalData = [];
let filteredData = [];
let currentPage = 1;
let rowsPerPage = 10;
let currentFilters = {
    status: '',
    approvalLevel: '',
    sortBy: 'recent',
    dateFrom: null,
    dateTo: null
};

// Get data from server-side blade
@php
    $purchaseOrdersArray = $purchaseOrders->map(function($po) {
        return [
            'id' => $po->id,
            'po_no' => $po->po_no,
            'supplier_name' => $po->supplier_name,
            'total_amount' => $po->total_amount,
            'delivery_date' => $po->delivery_date,
            'aproval_status' => $po->aproval_status,
            'approval_level' => $po->approval_level ?? 'Finance',
            'formatted_date' => \Carbon\Carbon::parse($po->delivery_date)->format('d M Y')
        ];
    })->toArray();
@endphp

// Initialize data
originalData = @json($purchaseOrdersArray);
filteredData = [...originalData];

// DOM Elements
const tableBody = document.getElementById('tableBody');
const emptyState = document.getElementById('emptyState');
const paginationWrap = document.getElementById('paginationWrap');
const rowsSelect = document.getElementById('rowsSelect');
const statusFilter = document.getElementById('statusFilter');
const approvalLevelFilter = document.getElementById('approvalLevelFilter');
const sortFilter = document.getElementById('sortFilter');
const dateRangePicker = document.getElementById('dateRangePicker');

// Initialize flatpickr
let flatpickrInstance = null;
if (dateRangePicker) {
    flatpickrInstance = flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "d M Y",
        placeholder: "Select date range",
        onChange: function(selectedDates) {
            if (selectedDates && selectedDates.length === 2) {
                currentFilters.dateFrom = selectedDates[0];
                currentFilters.dateTo = selectedDates[1];
            } else {
                currentFilters.dateFrom = null;
                currentFilters.dateTo = null;
            }
            applyFilters();
        }
    });
}

// Add event listeners for filters
if (statusFilter) {
    statusFilter.addEventListener('change', function(e) {
        currentFilters.status = e.target.value;
        currentPage = 1;
        applyFilters();
    });
}

if (approvalLevelFilter) {
    approvalLevelFilter.addEventListener('change', function(e) {
        currentFilters.approvalLevel = e.target.value;
        currentPage = 1;
        applyFilters();
    });
}

if (sortFilter) {
    sortFilter.addEventListener('change', function(e) {
        currentFilters.sortBy = e.target.value;
        applyFilters();
    });
}

if (rowsSelect) {
    rowsSelect.addEventListener('change', function(e) {
        rowsPerPage = parseInt(e.target.value);
        currentPage = 1;
        renderTable();
        renderPagination();
    });
}

// Apply all filters
function applyFilters() {
    let data = [...originalData];
    
    // Filter by status
    if (currentFilters.status) {
        data = data.filter(item => item.aproval_status === currentFilters.status);
    }
    
    // Filter by approval level
    if (currentFilters.approvalLevel) {
        data = data.filter(item => item.approval_level === currentFilters.approvalLevel);
    }
    
    // Filter by date range
    if (currentFilters.dateFrom && currentFilters.dateTo) {
        data = data.filter(item => {
            if (!item.delivery_date) return false;
            const itemDate = new Date(item.delivery_date);
            const fromDate = new Date(currentFilters.dateFrom);
            const toDate = new Date(currentFilters.dateTo);
            
            // Set time to beginning and end of day for accurate comparison
            fromDate.setHours(0, 0, 0, 0);
            toDate.setHours(23, 59, 59, 999);
            
            return itemDate >= fromDate && itemDate <= toDate;
        });
    }
    
    // Apply sorting
    data = sortData(data, currentFilters.sortBy);
    
    filteredData = data;
    renderTable();
    renderPagination();
}

// Sort data function
function sortData(data, sortBy) {
    const sortedData = [...data];
    
    switch(sortBy) {
        case 'po_no':
            return sortedData.sort((a, b) => (a.po_no || '').localeCompare(b.po_no || ''));
        case 'supplier':
            return sortedData.sort((a, b) => (a.supplier_name || '').localeCompare(b.supplier_name || ''));
        case 'amount':
            return sortedData.sort((a, b) => parseFloat(a.total_amount || 0) - parseFloat(b.total_amount || 0));
        case 'recent':
        default:
            return sortedData.sort((a, b) => {
                const dateA = a.delivery_date ? new Date(a.delivery_date) : new Date(0);
                const dateB = b.delivery_date ? new Date(b.delivery_date) : new Date(0);
                return dateB - dateA;
            });
    }
}

// Render table with pagination
function renderTable() {
    if (!tableBody) return;
    
    const startIndex = (currentPage - 1) * rowsPerPage;
    const endIndex = startIndex + rowsPerPage;
    const pageData = filteredData.slice(startIndex, endIndex);
    
    if (pageData.length === 0) {
        tableBody.innerHTML = '';
        if (emptyState) emptyState.style.display = 'block';
        return;
    }
    
    if (emptyState) emptyState.style.display = 'none';
    
    tableBody.innerHTML = pageData.map(item => `
        <tr>
            <td>${escapeHtml(item.po_no || '')}</td>
            <td>${escapeHtml(item.supplier_name || '')}</td>
            <td>${formatCurrency(item.total_amount)}</td>
            <td>${item.formatted_date || ''}</td>
            <td>${escapeHtml(item.approval_level || '--')}</td>
            <td>
                ${getStatusBadge(item.aproval_status)}
            </td>
            <td class="text-center">
            <a href="{{ url('purchase-order-approval/view') }}/${item.id}" class="btn btn-sm btn-primary">
            <i class="bi bi-eye"></i>
            </a>
     
            </td>
        </tr>
    `).join('');
}

// Get status badge HTML
function getStatusBadge(status) {
    if (!status) return '<span class="badge-status badge-pending">Pending</span>';
    
    switch(status.toLowerCase()) {
        case 'approved':
            return '<span class="badge-status badge-approved">Approved</span>';
        case 'rejected':
            return '<span class="badge-status badge-denied">Rejected</span>';
        default:
            return '<span class="badge-status badge-pending">Pending</span>';
    }
}

// Format currency
function formatCurrency(amount) {
    if (!amount && amount !== 0) return '₹0.00';
    return new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2
    }).format(parseFloat(amount));
}

// Escape HTML to prevent XSS
function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

// Render pagination
function renderPagination() {
    if (!paginationWrap) return;
    
    const totalPages = Math.ceil(filteredData.length / rowsPerPage);
    
    if (totalPages <= 1) {
        paginationWrap.innerHTML = '';
        return;
    }
    
    let paginationHTML = '';
    
    // Previous button
    paginationHTML += `
        <button class="page-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
            <i class="bi bi-chevron-left"></i>
        </button>
    `;
    
    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    if (startPage > 1) {
        paginationHTML += `<button class="page-btn" onclick="changePage(1)">1</button>`;
        if (startPage > 2) paginationHTML += `<button class="page-btn disabled" style="cursor: default;">...</button>`;
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">
                ${i}
            </button>
        `;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) paginationHTML += `<button class="page-btn disabled" style="cursor: default;">...</button>`;
        paginationHTML += `<button class="page-btn" onclick="changePage(${totalPages})">${totalPages}</button>`;
    }
    
    // Next button
    paginationHTML += `
        <button class="page-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
            <i class="bi bi-chevron-right"></i>
        </button>
    `;
    
    paginationWrap.innerHTML = paginationHTML;
}

// Change page function (make it global)
window.changePage = function(page) {
    const totalPages = Math.ceil(filteredData.length / rowsPerPage);
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    renderTable();
    renderPagination();
};

// Reset all filters (optional utility function)
window.resetFilters = function() {
    currentFilters = {
        status: '',
        approvalLevel: '',
        sortBy: 'recent',
        dateFrom: null,
        dateTo: null
    };
    
    if (statusFilter) statusFilter.value = '';
    if (approvalLevelFilter) approvalLevelFilter.value = '';
    if (sortFilter) sortFilter.value = 'recent';
    if (flatpickrInstance) flatpickrInstance.clear();
    
    currentPage = 1;
    applyFilters();
};

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    applyFilters();
});
</script>

<style>
/* Additional styles for better UI */
.badge-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
}

.badge-pending {
    background-color: #fff3cd;
    color: #856404;
}

.badge-approved {
    background-color: #d4edda;
    color: #155724;
}

.badge-denied {
    background-color: #f8d7da;
    color: #721c24;
}

.page-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
    pointer-events: none;
}

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
    background-color: #f9fafb;
}

.rows-per-page {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #6b7280;
}

.rows-select {
    padding: 4px 8px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background-color: white;
    cursor: pointer;
}

.pagination-wrap {
    display: flex;
    gap: 6px;
    align-items: center;
}

.page-btn {
    padding: 6px 12px;
    border: 1px solid #d1d5db;
    background-color: white;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
}

.page-btn:hover:not(:disabled):not(.disabled) {
    background-color: #f3f4f6;
    border-color: #9ca3af;
}

.page-btn.active {
    background-color: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.empty-state {
    text-align: center;
    padding: 48px 20px;
    color: #9ca3af;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 12px;
}

.filter-bar {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
    align-items: center;
}

.filter-select {
    padding: 6px 12px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background-color: white;
    font-size: 14px;
    cursor: pointer;
}

.text-center {
    text-align: center;
}
</style>