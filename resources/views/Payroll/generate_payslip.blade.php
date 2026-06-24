@include('layouts.header')
@include('layouts.sidebar')

@php

function numberToWords($number)
{
    $number = floor($number);

    $ones = array(
        0 => '',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine',
        10 => 'ten',
        11 => 'eleven',
        12 => 'twelve',
        13 => 'thirteen',
        14 => 'fourteen',
        15 => 'fifteen',
        16 => 'sixteen',
        17 => 'seventeen',
        18 => 'eighteen',
        19 => 'nineteen'
    );

    $tens = array(
        2 => 'twenty',
        3 => 'thirty',
        4 => 'forty',
        5 => 'fifty',
        6 => 'sixty',
        7 => 'seventy',
        8 => 'eighty',
        9 => 'ninety'
    );

    if ($number == 0) {
        return 'zero';
    }

    $words = '';

    if ($number >= 10000000) {

        $words .= numberToWords(floor($number / 10000000)) . ' crore ';
        $number %= 10000000;
    }

    if ($number >= 100000) {

        $words .= numberToWords(floor($number / 100000)) . ' lakh ';
        $number %= 100000;
    }

    if ($number >= 1000) {

        $words .= numberToWords(floor($number / 1000)) . ' thousand ';
        $number %= 1000;
    }

    if ($number >= 100) {

        $words .= numberToWords(floor($number / 100)) . ' hundred ';
        $number %= 100;
    }

    if ($number >= 20) {

        $words .= $tens[floor($number / 10)];

        $number %= 10;

        if ($number > 0) {

            $words .= ' ' . $ones[$number];
        }

    } else {

        $words .= $ones[$number];
    }

    return trim($words);
}

@endphp

<main class="main-content">

    <!-- PAGE HEADER -->
    <div class="page-header">

        <a href="{{ route('payroll_management') }}"
           class="back-title">

            <h1 class="page-title">

                <i class="bi bi-chevron-left"></i>

                Generated Payslip

            </h1>

        </a>

    </div>

    <!-- DETAIL CARD -->
    <div class="detail-card">
     <div  id="payslipContent">
        <!-- HEADER -->
      <div class="section-block pay-head d-flex justify-content-between align-items-center">
			
			<h5 class="fw-bold mb-0">
			
				{{ date('F Y', strtotime($payroll->pay_date)) }} Garments

			

			</h5>

				<div class="d-flex justify-content-center">

					<img src="{{ asset('assets/img/vivid-logo.png') }}"
						style="width:180px;">

				</div>

			<div class="text-end">

				<p class="mb-0 sm-p">
					Payslip for the month
				</p>

				<h6 class="fw-bold">
					{{ date('F Y', strtotime($payroll->pay_date)) }}
				</h6>

			</div>

		</div>

        <!-- EMPLOYEE SUMMARY -->
        <div class="section-block">

            <div class="section-header">

                <span class="section-title">

                    Employee Summary

                </span>

            </div>

            <div class="row">

                <!-- LEFT -->
                <div class="col-md-6">

                    <table class="info-table mb-4">

                        <tbody>

						  <tr class="info-row border-0">

                                <td class="info-label">

                                    Company Name

                                </td>

                                <td class="info-value">

                                     {{ $payroll->company_name }} 

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Employee Name

                                </td>

                                <td class="info-value">

                                    {{ $payroll->employee_name }}

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Employee ID

                                </td>

                                <td class="info-value">

                                    {{ $payroll->employee_code }}

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Department

                                </td>

                                <td class="info-value">

                                    {{ $payroll->department_name }}

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Designation

                                </td>

                                <td class="info-value">

                                    {{ $payroll->designation_name }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <!-- RIGHT -->
                <div class="col-md-6">

                    <table class="info-table mb-0">

                        <tbody>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Date of Joining

                                </td>

                                <td class="info-value">

                                    {{ date('d M Y', strtotime($payroll->joining_date)) }}

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Pay Period (Start Date)

                                </td>

                                <td class="info-value">

                                    {{ date('d M Y', strtotime($payroll->pay_period_start_date)) }}

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Pay Period (End Date)

                                </td>

                                <td class="info-value">

                                    {{ date('d M Y', strtotime($payroll->pay_period_end_date)) }}

                                </td>

                            </tr>

                            <tr class="info-row border-0">

                                <td class="info-label">

                                    Pay Date

                                </td>

                                <td class="info-value">

                                    {{ date('d M Y', strtotime($payroll->pay_date)) }}

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- PF & UAN -->
        <div class="section-block">

            <table class="table pays-table mb-2">

                <tbody>

                    <tr>

                        <td width="220">

                            PF A/C Number

                        </td>

                        <td>

                            {{ $payroll->pf_number ?? 'N/A' }}

                        </td>

                        <td width="100">

                            UAN

                        </td>

                        <td>

                            {{ $payroll->uan_number ?? 'N/A' }}

                        </td>

                    </tr>

                </tbody>

            </table>

            <!-- EARNINGS & DEDUCTIONS -->
            <div class="border rounded-3 p-3 mb-4">

                <div class="row">

                    <!-- EARNINGS -->
                    <div class="col-md-6">

                        <div class="section-header">

                            <span class="section-title">

                                Earnings

                            </span>

                        </div>

                        <table class="info-table mb-0">

                            <tbody>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Basic Salary

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->basic_salary, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        House Rent Allowance

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->hra, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Transport Allowance

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->transport_allowance, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Other Allowance

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->other_allowance, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                     <td class="info-label">

                                        Total Earnings

                                    </td>

                                <td class="info-value">

                                        ₹{{ number_format($payroll->basic_salary + $payroll->total_allowance, 2) }}

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <!-- DEDUCTIONS -->
                    <div class="col-md-6">

                        <div class="section-header">

                            <span class="section-title">

                                Deduction

                            </span>

                        </div>

                        <table class="info-table mb-0">

                            <tbody>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Provident Fund

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->pf, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Professional Tax

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->professional_tax, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Other Deduction

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->other_deduction, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0">

                                    <td class="info-label">

                                        Income Tax

                                    </td>

                                    <td class="info-value">

                                        ₹{{ number_format($payroll->income_tax, 2) }}

                                    </td>

                                </tr>

                                <tr class="info-row border-0 bg-light">

                                   <td class="info-label">

                                        Total Deductions

                                    </td>

                                   <td class="info-value">

                                        ₹{{ number_format($payroll->total_deduction, 2) }}

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- NET PAY -->
            <div class="border rounded-3 p-3 mb-3">

                <div class="pay-head d-flex justify-content-between align-items-center">

                    <div>

                        <h6 class="fw-bold mb-0">

                            Total Net Payable

                        </h6>

                        <p class="mb-0 sm-p">

                            Gross Earnings - Total Deductions

                        </p>

                    </div>

                    <h5 class="fw-bold mb-0">

                        ₹{{ number_format($payroll->net_salary, 2) }}

                    </h5>

                </div>

            </div>

            <!-- AMOUNT WORDS + SIGNATURE -->
            <div class="pay-head d-flex justify-content-between mb-4">	

                <p class="mb-0 sm-p">

                    Amount in words :

                    <b>

                        Indian Rupees

                        {{ ucwords(numberToWords($payroll->net_salary)) }}

                        Only

                    </b>

                </p>

                <div class="text-end">

                    <p class="mb-0 sm-p">

                        Authorized Signature

                    </p>

                   
                  

                        <img src="{{ asset('assets/img/signature.png') }}"
                             style="width:120px;height:60px;object-fit:contain;">

                   

                </div>

            </div>

        </div>
     </div>
        <!-- BUTTONS -->
        <div class="section-block text-end">

            <button class="btn-cancel"
                    onclick="window.history.back()">

                Close

            </button>

            <button class="btn-save2"
                    onclick="downloadPDF()">

                Download PDF

            </button>

            <button class="btn-po"
                      onclick="printPayslip()">

                Print

            </button>

            <button class="btn-save" onclick="sendEmail({{ $payroll->payroll_id }})">

                Send Email

            </button>

        </div>

    </div>

</main>


@include('layouts.footer')
@include('layouts.scripts')

<script>

function downloadPDF() {

    let employeeName = "{{ $payroll->employee_name }}";
    let month = "{{ date('F_Y', strtotime($payroll->pay_date)) }}";

    $.ajax({

        url: "{{ route('download_payslip_pdf') }}",

        type: "POST",

        data: {

            _token: "{{ csrf_token() }}",

            payroll_id: "{{ $payroll->payroll_id }}"

        },

        xhrFields: {

            responseType: 'blob'

        },

        beforeSend: function () {

            $('.btn-save2').prop('disabled', true).text('Downloading...');

        },

        success: function (response) {

            let blob = new Blob([response], {

                type: 'application/pdf'

            });

            let link = document.createElement('a');

            link.href = window.URL.createObjectURL(blob);

            link.download = employeeName + '_Payslip_' + month + '.pdf';

            document.body.appendChild(link);

            link.click();

            document.body.removeChild(link);

        },

        error: function (xhr) {

            alert('PDF download failed.');

            console.log(xhr);

        },

        complete: function () {

            $('.btn-save2').prop('disabled', false).text('Download PDF');

        }

    });

}

</script>

<script>


function sendEmail(payrollId)
{
    $.ajax({
        url: "{{ route('send_email') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            payroll_id: payrollId
        },
        beforeSend: function () {

            Swal.fire({
                title: 'Sending Email...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

        },
        success: function(response)
        {
            Swal.close();

            if(response.status)
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                });
            }
            else
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function()
        {
            Swal.close();

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Email sending failed.'
            });
        }
    });
}

</script>


<script>

function printPayslip() {

    let printContents =
        document.getElementById('payslipContent').innerHTML;

    let originalContents =
        document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;

    location.reload();

}

</script>


<!-- ===========================
     PRINT STYLE
=========================== -->
<style>

@media print {

    body * {
        visibility: hidden;
    }

    #payslipContent,
    #payslipContent * {
        visibility: visible;
    }

    #payslipContent {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

}

</style>