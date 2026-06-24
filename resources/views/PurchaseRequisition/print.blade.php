<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchase Requisition Approved</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:13px;
            color:#333;
            padding:25px;
        }

        .header{
            width:100%;
            margin-bottom:20px;
            border-bottom:2px solid #2d3748;
            padding-bottom:15px;
        }

        .company-name{
            font-size:24px;
            font-weight:bold;
            color:#2d3748;
        }

        .report-title{
            font-size:18px;
            margin-top:5px;
            color:#4a5568;
        }

        .requisition-no{
            float:right;
            text-align:right;
            margin-top:-40px;
        }

        .requisition-no h4{
            color:#2d3748;
        }

        .section{
            margin-top:20px;
        }

        .section-title{
            background:#2d3748;
            color:#fff;
            padding:8px 12px;
            font-size:14px;
            font-weight:bold;
            margin-bottom:10px;
        }

        .info-table{
            width:100%;
            border-collapse:collapse;
        }

        .info-table td{
            border:1px solid #ddd;
            padding:10px;
        }

        .label{
            width:25%;
            background:#f7fafc;
            font-weight:bold;
        }

        .product-table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        .product-table th{
            background:#2d3748;
            color:#fff;
            border:1px solid #ddd;
            padding:10px;
            text-align:left;
        }

        .product-table td{
            border:1px solid #ddd;
            padding:10px;
        }

        .product-table tr:nth-child(even){
            background:#f8f9fa;
        }

        .status{
            display:inline-block;
            padding:6px 12px;
            border-radius:20px;
            font-size:12px;
            font-weight:bold;
        }

        .pending{
            background:#fff3cd;
            color:#856404;
        }

        .approved{
            background:#d4edda;
            color:#155724;
        }

        .completed{
            background:#d1ecf1;
            color:#0c5460;
        }

        .denied{
            background:#f8d7da;
            color:#721c24;
        }

        .footer{
            margin-top:60px;
        }

        .signature{
            width:250px;
            text-align:center;
            border-top:1px solid #333;
            padding-top:10px;
            float:right;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="company-name">
            Purchase Requisition Approved - {{ $requisition->requisition_id }}
        </div>
    </div>

    <div class="section">
        <div class="section-title">
            Request Details
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Request ID</td>
                <td>{{ $requisition->requisition_id }}</td>
                <td class="label">Department</td>
                <td>{{ $requisition->department->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td class="label">Requested By</td>
                <td>{{ $requisition->requested }}</td>
                <td class="label">Priority</td>
                <td>{{ $requisition->priority }}</td>
            </tr>

            <tr>
                <td class="label">Request Date</td>
                <td>{{ date('d M Y', strtotime($requisition->request_date)) }}</td>
                <td class="label">Required Date</td>
                <td>{{ date('d M Y', strtotime($requisition->required_date)) }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            Product Details
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Unit</th>
                </tr>
            </thead>

            <tbody>
                @foreach($requisition->details as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $detail->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $detail->category }}</td>
                    <td>{{ $detail->color }}</td>
                    <td>{{ $detail->size }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->unit }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            Additional Information
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Remarks</td>
                <td>{{ $requisition->remarks }}</td>
            </tr>

            <tr>
                <td class="label">Status</td>
                <td>
                    <span class="status
                        @if($requisition->status == 'Pending') pending
                        @elseif($requisition->status == 'Approved') approved
                        @elseif($requisition->status == 'Completed') completed
                        @elseif($requisition->status == 'Denied') denied
                        @endif">
                        {{ $requisition->status }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>