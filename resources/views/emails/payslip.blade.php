<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip</title>
</head>
<body>

<p>Dear {{ $employeeName }},</p>

<p>
    Please find attached your payslip for
    <strong>{{ date('F Y', strtotime($payroll->pay_date)) }}</strong>.
</p>

<p>
    Regards,<br>
    {{ $payroll->department_name }} Department
</p>

</body>
</html>