<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitOfMeasureController;
use App\Http\Controllers\MenuGroupController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PaymentTermController;
use App\Http\Controllers\AttendanceStatusController;
use App\Http\Controllers\LeaveTypesController;
use App\Http\Controllers\PurchaseRequestStatusController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TimeTrackingController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\AppraisalController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GoodReceiptController;
use App\Http\Controllers\InventoryOverviewController;
use App\Http\Controllers\IssuedMaterialController;
use App\Http\Controllers\PurchaseRequisitionController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseOrderTrackingController;



/* Login */

Route::get('/', function () {
  
    return view('auth.login');
});

/* Dashboard */

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
});


/* Users */

Route::middleware(['auth'])->group(function () {

    Route::get('/users', [UsersController::class, 'users'])
        ->name('users');

    Route::get('/user_add', [UsersController::class, 'user_add'])
    ->name('user_add');

    Route::post('/users_store', [UsersController::class, 'users_store'])
        ->name('users_store');

    Route::post('/users-list-table', [UsersController::class, 'users_list_table'])
        ->name('users_list_table');

    Route::get('/user_edit/{id}', [UsersController::class, 'user_edit'])
        ->name('user_edit');

    Route::get('/user_view/{id}', [UsersController::class, 'user_view'])
    ->name('user_view');

    Route::post('/users_update', [UsersController::class, 'users_update'])
        ->name('users_update');

    Route::post('/users_delete', [UsersController::class, 'users_delete'])
        ->name('users_delete');

    /* Designations */

    Route::get('/designations', [DesignationController::class, 'designations'])->name('designations');

    Route::get('/designation_add', [DesignationController::class, 'designation_add'])->name('designation_add');

    Route::post('/designation_list_table', [DesignationController::class, 'designation_list_table'])->name('designation_list_table');

    Route::post('/designation_list', [DesignationController::class, 'designation_list'])->name('designation_list');

    Route::post('/designation_store', [DesignationController::class, 'designation_store'])->name('designation_store');

    Route::post('/designation_update', [DesignationController::class, 'designation_update'])->name('designation_update');

    Route::get('/designation_edit/{designation_id}', [DesignationController::class, 'designation_edit'])->name('designation_edit');

    Route::post('/designation_delete', [DesignationController::class, 'designation_delete'])
        ->name('designation_delete');

    Route::post('/store', [DesignationController::class, 'store'])->name('store');  
    
    Route::post('/designations_update', [DesignationController::class, 'designations_update'])->name('designations_update'); 
    
    Route::get('/edit/{designation_id}', [DesignationController::class, 'edit'])->name('edit');  

    Route::post('/get_user_details', [DesignationController::class, 'get_user_details'])
    ->name('get_user_details');   


     /* roles */

    Route::get('/roles', [RoleController::class, 'roles'])->name('roles');

    Route::post('/roles_list_table', [RoleController::class, 'roles_list_table'])->name('roles_list_table');

    Route::get('/roles_edit/{role_id}', [RoleController::class, 'roles_edit'])->name('roles_edit');

    Route::post('/roles_store', [RoleController::class, 'roles_store'])->name('roles_store');

    Route::post('/roles_updated', [RoleController::class, 'roles_updated'])->name('roles_updated');

    Route::post('/roles-delete', [RoleController::class, 'roles_delete'])
        ->name('roles_delete');
        
        
    /* Department */

    Route::get('/department_master', [DepartmentController::class, 'department_master'])->name('department_master');

    Route::post('/department_list_table', [DepartmentController::class, 'department_list_table'])->name('department_list_table');

    Route::get('/department_edit/{department_id}', [DepartmentController::class, 'department_edit'])->name('department_edit');

    Route::post('/department_store', [DepartmentController::class, 'department_store'])->name('department_store');

    Route::post('/department_updated', [DepartmentController::class, 'department_updated'])->name('department_updated');

    Route::post('/department-delete', [DepartmentController::class, 'department_delete'])
        ->name('department_delete');


    /* Category */

    Route::get('/category', [CategoryController::class, 'category'])->name('category');

    Route::post('/category_list_table', [CategoryController::class, 'category_list_table'])->name('category_list_table');

    Route::get('/category_edit/{category_id}', [CategoryController::class, 'category_edit'])->name('category_edit');

    Route::post('/category_store', [CategoryController::class, 'category_store'])->name('category_store');

    Route::post('/category_updated', [CategoryController::class, 'category_updated'])->name('category_updated');

    Route::post('/category-delete', [CategoryController::class, 'category_delete'])
        ->name('category_delete');


    /*  Unit of Measure */

    Route::get('/unit_of_measure', [UnitOfMeasureController::class, 'unit_of_measure'])->name('unit_of_measure');

    Route::post('/unit_list_table', [UnitOfMeasureController::class, 'unit_list_table'])->name('unit_list_table');

    Route::get('/unit_edit/{unit_id}', [UnitOfMeasureController::class, 'unit_edit'])->name('unit_edit');

    Route::post('/unit_store', [UnitOfMeasureController::class, 'unit_store'])->name('unit_store');

    Route::post('/unit_updated', [UnitOfMeasureController::class, 'unit_updated'])->name('unit_updated');

    Route::post('/unit-delete', [UnitOfMeasureController::class, 'unit_delete'])
        ->name('unit_delete');


    /*  Menu Groups */

    Route::get('/menu_groups', [MenuGroupController::class, 'menu_groups'])->name('menu_groups');

    Route::post('/menu_group_list_table', [MenuGroupController::class, 'menu_group_list_table'])->name('menu_group_list_table');

    Route::get('/menu_group_edit/{menu_group_id}', [MenuGroupController::class, 'menu_group_edit'])->name('menu_group_edit');

    Route::post('/menu_group_store', [MenuGroupController::class, 'menu_group_store'])->name('menu_group_store');

    Route::post('/menu_group_updated', [MenuGroupController::class, 'menu_group_updated'])->name('menu_group_updated');

    Route::post('/menu_group_delete', [MenuGroupController::class, 'menu_group_delete'])
        ->name('menu_group_delete');


    /*  Menus */

    Route::get('/menus', [MenuController::class, 'menus'])->name('menus');

    Route::post('/menu_list_table', [MenuController::class, 'menu_list_table'])->name('menu_list_table');

    Route::get('/menu_edit/{menu_id}', [MenuController::class, 'menu_edit'])->name('menu_edit');

    Route::post('/menu_store', [MenuController::class, 'menu_store'])->name('menu_store');

    Route::post('/menu_updated', [MenuController::class, 'menu_updated'])->name('menu_updated');

    Route::post('/menu_delete', [MenuController::class, 'menu_delete'])
        ->name('menu_delete');    

    /* Payment Terms */

    Route::get('/payment_terms', [PaymentTermController::class, 'payment_terms'])->name('payment_terms');

    Route::post('/payment_term_list_table', [PaymentTermController::class, 'payment_term_list_table'])->name('payment_term_list_table');

    Route::get('/payment_term_edit/{payment_term_id}', [PaymentTermController::class, 'payment_term_edit'])->name('payment_term_edit');

    Route::post('/payment_term_store', [PaymentTermController::class, 'payment_term_store'])->name('payment_term_store');

    Route::post('/payment_term_updated', [PaymentTermController::class, 'payment_term_updated'])->name('payment_term_updated');

    Route::post('/payment_term_delete', [PaymentTermController::class, 'payment_term_delete'])
        ->name('payment_term_delete');

    /* Attendance Status */

    Route::get('/attendance_status', [AttendanceStatusController::class, 'attendance_status'])->name('attendance_status');

    Route::post('/attendance_status_list_table', [AttendanceStatusController::class, 'attendance_status_list_table'])->name('attendance_status_list_table');

    Route::get('/attendance_status_edit/{attendance_statu_id}', [AttendanceStatusController::class, 'attendance_status_edit'])->name('attendance_status_edit');

    Route::post('/attendance_status_store', [AttendanceStatusController::class, 'attendance_status_store'])->name('attendance_status_store');

    Route::post('/attendance_status_updated', [AttendanceStatusController::class, 'attendance_status_updated'])->name('attendance_status_updated');

    Route::post('/attendance_status_delete', [AttendanceStatusController::class, 'attendance_status_delete'])
        ->name('attendance_status_delete');

    /* Leave Types */

    Route::get('/leave_types', [LeaveTypesController::class, 'leave_types'])->name('leave_types');

    Route::post('/leave_types_list_table', [LeaveTypesController::class, 'leave_types_list_table'])->name('leave_types_list_table');

    Route::get('/leave_types_edit/{leave_type_id}', [LeaveTypesController::class, 'leave_types_edit'])->name('leave_types_edit');

    Route::post('/leave_types_store', [LeaveTypesController::class, 'leave_types_store'])->name('leave_types_store');

    Route::post('/leave_types_updated', [LeaveTypesController::class, 'leave_types_updated'])->name('leave_types_updated');

    Route::post('/leave_types_delete', [LeaveTypesController::class, 'leave_types_delete'])
        ->name('leave_types_delete'); 

    /* Supplier */

    Route::get('/supplier', [SupplierController::class, 'supplier'])->name('supplier');

    Route::get('/supplier_add', [SupplierController::class, 'supplier_add'])->name('supplier_add');

    Route::post('/suppliers_store', [SupplierController::class, 'suppliers_store'])->name('suppliers_store');

    Route::post('/suppliers_list_table', [SupplierController::class, 'suppliers_list_table'])->name('suppliers_list_table');

    Route::get('/supplier_edit/{supplier_id}', [SupplierController::class, 'supplier_edit'])->name('supplier_edit');

    Route::get('/supplier_view/{supplier_id}', [SupplierController::class, 'supplier_view'])->name('supplier_view'); 

    Route::post('/suppliers_update', [SupplierController::class, 'suppliers_update'])->name('suppliers_update');

    Route::post('/suppliers_delete', [SupplierController::class, 'suppliers_delete'])->name('suppliers_delete');

    Route::get('/supplier_excel', [SupplierController::class, 'supplier_excel'])->name('supplier_excel');


    /* Purchase Request Status  */

    Route::get('/purchase_request_status', [PurchaseRequestStatusController::class, 'purchase_request_status'])->name('purchase_request_status');

    Route::post('/purchase_request_status_list_table', [PurchaseRequestStatusController::class, 'purchase_request_status_list_table'])->name('purchase_request_status_list_table');

    Route::get('/purchase_request_status_edit/{purchase_request_status_id}', [PurchaseRequestStatusController::class, 'purchase_request_status_edit'])->name('purchase_request_status_edit');

    Route::post('/purchase_request_status_store', [PurchaseRequestStatusController::class, 'purchase_request_status_store'])->name('purchase_request_status_store');

    Route::post('/purchase_request_status_updated', [PurchaseRequestStatusController::class, 'purchase_request_status_updated'])->name('purchase_request_status_updated');

    Route::post('/purchase_request_status_delete', [PurchaseRequestStatusController::class, 'purchase_request_status_delete'])
        ->name('purchase_request_status_delete');
    
    /* Employee   */

    Route::get('/employee_management', [EmployeeController::class, 'employee_management'])->name('employee_management');

    Route::get('/employee_add', [EmployeeController::class, 'employee_add'])->name('employee_add');

    Route::get('/get_employee_code', [EmployeeController::class, 'get_employee_code'])
        ->name('get_employee_code');

    Route::post('/employee_store', [EmployeeController::class, 'employee_store'])->name('employee_store');

    Route::post('/employee_list_table', [EmployeeController::class, 'employee_list_table'])->name('employee_list_table');

    Route::get('/employee_edit/{employee_id}', [EmployeeController::class, 'employee_edit'])->name('employee_edit');

    Route::get('/employee_view/{employee_id}', [EmployeeController::class, 'employee_view'])->name('employee_view'); 

    Route::post('/employee_update', [EmployeeController::class, 'employee_update'])->name('employee_update');

    Route::post('/employee_delete', [EmployeeController::class, 'employee_delete'])->name('employee_delete');

    Route::get('/employee_excel', [EmployeeController::class, 'employee_excel'])->name('employee_excel'); 

    /* Attendance   */

    Route::get('/attendance_management', [AttendanceController::class, 'attendance_management'])->name('attendance_management');

    Route::post('/attendance_list_table', [AttendanceController::class, 'attendance_list_table'])->name('attendance_list_table');

    Route::get('/absence_tracking', [AttendanceController::class, 'absence_tracking'])->name('absence_tracking');

    Route::get('/absence_tracking_view/{leave_id}', [AttendanceController::class, 'absence_tracking_view'])->name('absence_tracking_view');

    Route::post('/leave_status_update',[AttendanceController::class, 'leave_status_update'])->name('leave_status_update');

    Route::post('/absence_tracking_list_table', [AttendanceController::class, 'absence_tracking_list_table'])->name('absence_tracking_list_table');

    Route::get('/mark_daily_attendance', [AttendanceController::class, 'mark_daily_attendance'])->name('mark_daily_attendance');

    Route::get('/mark_daily_attendance_edit/{attendance_id}', [AttendanceController::class, 'mark_daily_attendance_edit'])->name('mark_daily_attendance_edit');

    Route::post('/save_daily_attendance',[AttendanceController::class, 'save_daily_attendance'])->name('save_daily_attendance');

    Route::post('/update_daily_attendance',[AttendanceController::class, 'update_daily_attendance'])->name('update_daily_attendance');

    Route::post('/attendance_delete',[AttendanceController::class, 'attendance_delete'])->name('attendance_delete');

    Route::get('/attendance_excel', [AttendanceController::class, 'attendance_excel'])->name('attendance_excel');



    /* Time Tracking */

    Route::get('/time_tracking', [TimeTrackingController::class, 'time_tracking'])->name('time_tracking');

    Route::post('/time_entry_list_table', [TimeTrackingController::class, 'time_entry_list_table'])->name('time_entry_list_table');

    Route::get('/time_entry_add', [TimeTrackingController::class, 'time_entry_add'])->name('time_entry_add');

    Route::get('/get_employee_details',[TimeTrackingController::class, 'get_employee_details'])->name('get_employee_details');

    Route::post('/store_time_tracking',[TimeTrackingController::class, 'store_time_tracking'])->name('store_time_tracking');

    Route::post('/update_time_tracking',[TimeTrackingController::class, 'update_time_tracking'])->name('update_time_tracking');

    Route::get('/time_entry_edit/{time_tracking_id}', [TimeTrackingController::class, 'time_entry_edit'])->name('time_entry_edit');

    Route::get('/time_entry_view/{time_tracking_id}', [TimeTrackingController::class, 'time_entry_view'])->name('time_entry_view'); 
    
    Route::post('/time_tracking_delete',[TimeTrackingController::class, 'time_tracking_delete'])->name('time_tracking_delete');

    Route::get('/time_entry_excel', [TimeTrackingController::class, 'time_entry_excel'])->name('time_entry_excel');


    /* Leaves */

    Route::get('/leaves', [LeaveController::class, 'leaves'])->name('leaves');

    Route::post('/leave_list_table', [LeaveController::class, 'leave_list_table'])->name('leave_list_table');

    Route::get('/leave_add', [LeaveController::class, 'leave_add'])->name('leave_add');

    Route::get('/leave_edit/{leave_id}', [LeaveController::class, 'leave_edit'])->name('leave_edit');
  
    Route::get('/leave_view/{leave_id}', [LeaveController::class, 'leave_view'])->name('leave_view');

    Route::post('/store_leave', [LeaveController::class, 'store_leave'])->name('store_leave');

    Route::post('/update_leave', [LeaveController::class, 'update_leave'])->name('update_leave');

    Route::post('/leave_delete', [LeaveController::class, 'leave_delete'])->name('leave_delete');


    /* Payroll */

    Route::get('/payroll_management', [PayrollController::class, 'payroll_management'])->name('payroll_management');

    Route::get('/process_payroll', [PayrollController::class, 'process_payroll'])->name('process_payroll');

    Route::post('/payroll_list_table', [PayrollController::class, 'payroll_list_table'])->name('payroll_list_table');

    Route::post('/save_payroll', [PayrollController::class, 'save_payroll'])->name('save_payroll');

    Route::post('/update_payroll', [PayrollController::class, 'update_payroll'])->name('update_payroll');

    Route::get('/process_payroll_edit/{payroll_id}', [PayrollController::class, 'process_payroll_edit'])->name('process_payroll_edit');

    Route::get('/generate_payslip/{payroll_id}', [PayrollController::class, 'generate_payslip'])->name('generate_payslip');

    Route::post('/download_payslip_pdf', [PayrollController::class, 'download_payslip_pdf']) ->name('download_payslip_pdf');

    Route::post('/send_email', [PayrollController::class, 'send_email'])->name('send_email');

    Route::get('/payroll_excel', [PayrollController::class, 'payroll_excel'])->name('payroll_excel');

    /* Appraisal */

    Route::get('/appraisal_management', [AppraisalController::class, 'appraisal_management'])->name('appraisal_management');

    Route::post('/appraisal_list_table', [AppraisalController::class, 'appraisal_list_table'])->name('appraisal_list_table');

    Route::get('/appraisal_evaluation_form', [AppraisalController::class, 'appraisal_evaluation_form'])->name('appraisal_evaluation_form');

    Route::post('/appraisal_store',[AppraisalController::class, 'appraisal_store'])->name('appraisal_store');

    Route::post('/appraisal_update',[AppraisalController::class, 'appraisal_update'])->name('appraisal_update');

    Route::get('/appraisal_evaluation_edit/{appraisal_id}', [AppraisalController::class, 'appraisal_evaluation_edit'])->name('appraisal_evaluation_edit');

    Route::get('/appraisal_evaluation_view/{appraisal_id}', [AppraisalController::class, 'appraisal_evaluation_view'])->name('appraisal_evaluation_view');



    /* Goods Receipt   */

        Route::get('/goods_receipt', [GoodReceiptController::class, 'goods_receipt'])->name('goods_receipt');
        Route::get('/goods-receipt-list', [GoodReceiptController::class, 'getPurchaseOrders']);
        Route::get('/goods_receipt_view', [GoodReceiptController::class, 'goods_receipt_view'])->name('goods_receipt_view');



    /*Inventory Overview */

    Route::get('/inventory_overview', [InventoryOverviewController::class, 'inventory_overview'])->name('inventory_overview');
    Route::get('/inventory-list', [InventoryOverviewController::class, 'inventoryList']);

    /*Issued Material */
    
    Route::get('/issue_material', [IssuedMaterialController::class, 'issue_material'])->name('issue_material');

    Route::get('/issue_material_add', [IssuedMaterialController::class, 'issue_material_add'])->name('issue_material_add');
    
    Route::get('/issue_material_edit', [IssuedMaterialController::class, 'issue_material_edit'])->name('issue_material_edit');

    Route::get('/issue_material_view', [IssuedMaterialController::class, 'issue_material_view'])->name('issue_material_view');


    /* Purchase Requisition  */
    Route::get('/purchase_requisition', [PurchaseRequisitionController::class, 'purchase_requisition'])->name('purchase_requisition');
    Route::post('/purchase-requisition/store',[PurchaseRequisitionController::class, 'store'])->name('purchase-requisition.store');
    Route::get('/purchase-requisition/list',[PurchaseRequisitionController::class, 'list'])->name('purchase-requisition.list');
    Route::get('/purchase-requisition-view/{id}', [PurchaseRequisitionController::class, 'view'])->name('purchase-requisition.view');
    Route::get('/purchase_request_approval', [PurchaseRequisitionController::class, 'purchase_request_approval'])->name('purchase_request_approval');
    Route::post('/purchase-requisition/approve',[PurchaseRequisitionController::class, 'approve'])->name('purchase-requisition.approve');
    Route::post('/purchase-requisition/reject',[PurchaseRequisitionController::class, 'reject'])->name('purchase-requisition.reject');
    Route::post('/purchase-requisition-delete',[PurchaseRequisitionController::class, 'delete'])->name('purchase-requisition.delete');
    Route::get('/purchase_request_approval_view', [PurchaseRequisitionController::class, 'purchase_request_approval_view'])->name('purchase_request_approval_view');

    Route::get('/purchase-requisition/{id}/print',[PurchaseRequisitionController::class, 'print'])->name('purchase-requisition.print');

    Route::get('/purchase-requisition/{id}/download',[PurchaseRequisitionController::class, 'download'])->name('purchase-requisition.download');

    Route::get('/departments-list',[PurchaseRequisitionController::class,'getDepartments'])->name('departments.list');

    Route::get('/purchase-requisition/generate-id', [PurchaseRequisitionController::class, 'getRequisitionId'])->name('requisition.generate-id');
    
    Route::get('/products-list', [ProductController::class,'getProducts'])->name('products.list');

    Route::get('/product-details/{id}',[ProductController::class,'getProductDetails'])->name('product.details');
    /*Purchase Order  */
    Route::any('/purchase_requition', [PurchaseController::class, 'index'])->name('purchase_requition');
     Route::any('/product_master', [ProductController::class, 'index'])->name('product_master');
     Route::any('/products-master-add', [ProductController::class, 'create'])->name('products-master-add');
    Route::get('/generate-product-code', [ProductController::class, 'generateProductCode'])->name('product.code');
    Route::post('/product-store', [ProductController::class, 'store'])->name('product.store');
   
    /* Purchase Order Routes */
    Route::get('/purchase-order', [PurchaseOrderController::class, 'index'])->name('purchase.order');
    Route::get('purchase-order/create/{id}', [PurchaseOrderController::class, 'create'])->name('purchase-order.create');
    Route::get('/purchase_order', [PurchaseOrderController::class, 'purchase_order'])->name('purchase_order');
    Route::get('/get-supplier-category/{id}', [PurchaseOrderController::class, 'getSupplierCategory'])->name('supplier.category');
    Route::post('/purchase-order/store', [PurchaseOrderController::class, 'store'])->name('po.store');
    Route::get('/purchase_order_approval', [PurchaseOrderController::class, 'purchase_order_approval'])->name('purchase_order_approval');
    Route::get('/get-products/{id}', [PurchaseOrderController::class, 'getProductlist']);
    Route::get('/purchase-order/edit/{id}',[PurchaseOrderController::class, 'edit_purchase'])->name('purchase-order-edit');
    Route::put('/purchase_order/update/{id}', [PurchaseOrderController::class, 'update']);
    Route::post('/purchase-order/send/{id}', [PurchaseOrderController::class, 'sendPO']);
    Route::get('/purchase-order/view/{id}', [PurchaseOrderController::class, 'view'])
    ->name('purchase-order.view');
    Route::get('/purchase-order-approval/view/{id}',[PurchaseOrderController::class, 'approval_view'])->name('purchase-order-approval-view');
    Route::get('/purchase-order-approval', [PurchaseOrderController::class, 'purchase_order_approval'])
    ->name('purchase-order-approval');
    
    Route::post('/purchase-order/approve/{id}', [PurchaseOrderController::class, 'approvePO'])
    ->name('purchase-order.approve');

    Route::post('/purchase-order/reject/{id}', [PurchaseOrderController::class, 'rejectPO'])
    ->name('purchase-order.reject');

    Route::get('/purchase_order_print/{id}',[PurchaseOrderController::class, 'purchase_order_print'])->name('purchase_order_print');

    
    
    
    Route::get('/get-category', [ProductController::class, 'getCategory']) ->name('get.category');   
    Route::get('/get-suppliers', [ProductController::class, 'getSuppliers'])->name('get.suppliers'); 
    Route::get('/products-list',  [ProductController::class, 'productList']) ->name('products.list');
    Route::get( '/product-view/{id}',[ProductController::class, 'view'])->name('product.view');
   // ── Route ─────────────────────────────────────────────────────────────────────
    Route::get('/product-edit/{id}', [ProductController::class, 'edit'])->name('product_edit');
    Route::any('/product-delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    // ── Product Dropdown Routes ───────────────────────────────────────────────────
    Route::get('/categories-list', [ProductController::class, 'categoriesList'])->name('categories.list');
    Route::get('/suppliers-list',  [ProductController::class, 'suppliersList'])->name('suppliers.list');
    Route::get('/product-show/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/product-update/{id}', [ProductController::class, 'update'])->name('product.update');


   
    /*Purchase Order Tracking */

    Route::get('/purchase_order_tracking', [PurchaseOrderTrackingController::class, 'purchase_order_tracking'])->name('purchase_order_tracking');

    Route::get('/purchase_order_tracking_view', [PurchaseOrderTrackingController::class, 'purchase_order_tracking_view'])->name('purchase_order_tracking_view');


});    

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my_profile/{id}', [ProfileController::class, 'my_profile'])->name('my_profile');
    Route::get('/change_password', [ProfileController::class, 'change_password'])->name('change_password');
    Route::post('/update_password', [ProfileController::class, 'update_password'])->name('update_password');
});

require __DIR__.'/auth.php';
