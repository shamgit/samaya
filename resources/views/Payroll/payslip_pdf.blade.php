<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>Payslip</title>

    <style>

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }

        .section-block {
            margin-bottom: 20px;
        }

        .pay-head {
            width: 100%;
            display: table;
        }

        .pay-head-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .pay-head-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            display: block;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 45%;
        }

        .info-value {
            width: 55%;
        }

        .border-box {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .earnings-table td,
        .deduction-table td {
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .net-pay {
            border: 1px solid #ddd;
            padding: 12px;
            margin-top: 15px;
        }

        .signature {
            width: 120px;
            height: 60px;
            object-fit: contain;
        }

        .mt-20 {
            margin-top: 20px;
        }

    </style>

</head>

<body>

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


<!-- HEADER -->

<div class="section-block">

    <table width="100%">

        <tr>

            <!-- LOGO -->

           <td width="40%" valign="middle">

                <img src="{{ public_path('assets/img/vivid-logo1.jpg') }}" style="width:180px;">

            </td>

            <!-- COMPANY DETAILS -->

            <td width="45%" valign="middle">

                <h2 style="
                    margin:0;
                    color:#1f5faa;
                    font-size:28px;
                    font-weight:bold;
                    letter-spacing:1px;
                ">

                    VIVIDINFOTECH

                </h2>

            </td>

            <!-- PAYSLIP MONTH -->

            <td width="30%" valign="middle" align="right">

                <div style="font-size:13px;">

                    Payslip for the month

                </div>

                <strong style="font-size:16px;">

                    {{ date('F Y', strtotime($payroll->pay_date)) }}

                </strong>

            </td>

        </tr>

    </table>

</div>


<!-- EMPLOYEE DETAILS -->

<div class="section-block">

    <span class="section-title">
        Employee Summary
    </span>

    <table>

        <tr>

            <td width="50%">

                <table class="info-table">

                    <tr>
                        <td class="info-label">Employee Name</td>
                        <td class="info-value">{{ $payroll->employee_name }}</td>
                    </tr>

                    <tr>
                        <td class="info-label">Employee ID</td>
                        <td class="info-value">{{ $payroll->employee_code }}</td>
                    </tr>

                    <tr>
                        <td class="info-label">Department</td>
                        <td class="info-value">{{ $payroll->department_name }}</td>
                    </tr>

                    <tr>
                        <td class="info-label">Designation</td>
                        <td class="info-value">{{ $payroll->designation_name }}</td>
                    </tr>

                </table>

            </td>

            <td width="50%">

                <table class="info-table">

                    <tr>
                        <td class="info-label">Date of Joining</td>
                        <td class="info-value">
                            {{ date('d M Y', strtotime($payroll->joining_date)) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="info-label">Pay Start</td>
                        <td class="info-value">
                            {{ date('d M Y', strtotime($payroll->pay_period_start_date)) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="info-label">Pay End</td>
                        <td class="info-value">
                            {{ date('d M Y', strtotime($payroll->pay_period_end_date)) }}
                        </td>
                    </tr>

                    <tr>
                        <td class="info-label">Pay Date</td>
                        <td class="info-value">
                            {{ date('d M Y', strtotime($payroll->pay_date)) }}
                        </td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>

</div>


<!-- PF -->

<div class="section-block border-box">

    <table>

        <tr>

            <td><strong>PF A/C Number:</strong></td>

            <td>{{ $payroll->pf_number ?? 'N/A' }}</td>

            <td><strong>UAN:</strong></td>

            <td>{{ $payroll->uan_number ?? 'N/A' }}</td>

        </tr>

    </table>

</div>


<!-- EARNINGS & DEDUCTIONS -->

<div class="section-block border-box">

    <table>

        <tr>

            <td width="50%" valign="top">

                <span class="section-title">Earnings</span>

                <table class="earnings-table">

                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->basic_salary, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>House Rent Allowance</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->hra, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Transport Allowance</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->transport_allowance, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Other Allowance</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->other_allowance, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Total Earnings</strong></td>
                        <td class="text-right">
                            <strong>
                                ₹{{ number_format($payroll->basic_salary + $payroll->total_allowance, 2) }}
                            </strong>
                        </td>
                    </tr>

                </table>

            </td>

            <td width="50%" valign="top">

                <span class="section-title">Deductions</span>

                <table class="deduction-table">

                    <tr>
                        <td>Provident Fund</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->pf, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Professional Tax</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->professional_tax, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Other Deduction</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->other_deduction, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td>Income Tax</td>
                        <td class="text-right">
                            ₹{{ number_format($payroll->income_tax, 2) }}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Total Deductions</strong></td>
                        <td class="text-right">
                            <strong>
                                ₹{{ number_format($payroll->total_deduction, 2) }}
                            </strong>
                        </td>
                    </tr>

                </table>

            </td>

        </tr>

    </table>

</div>


<!-- NET SALARY -->

<div class="net-pay">

    <table>

        <tr>

            <td>

                <strong>Total Net Payable</strong><br>

                Gross Earnings - Total Deductions

            </td>

            <td class="text-right">

                <strong>
                    ₹{{ number_format($payroll->net_salary, 2) }}
                </strong>

            </td>

        </tr>

    </table>

</div>


<!-- AMOUNT IN WORDS -->

<div class="mt-20">

    <table>

        <tr>

            <td width="70%">

                Amount in words :

                <strong>

                    Indian Rupees

                    {{ ucwords(numberToWords($payroll->net_salary)) }}

                    Only

                </strong>

            </td>

            <td width="30%" class="text-right">

                <div>Authorized Signature</div>

                <img src="{{ public_path('assets/img/signature.png') }}"
                     class="signature">

            </td>

        </tr>

    </table>

</div>

</body>
</html>





