<!DOCTYPE html>
<html>
<head>
    <title>Bugtrack Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #007bff;
        }
        .header h3 {
            margin: 0;
            font-size: 20px;
            color: #555;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #777;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 12px;
            word-wrap: break-word;
        }
        .table th {
            background-color: #f8f9fa;
            color: #333;
            text-align: left;
            font-weight: bold;
        }
        .table td {
            background-color: #fff;
        }
        .table tr:nth-child(even) td {
            background-color: #f2f2f2;
        }
        .table tr:hover td {
            background-color: #e9ecef;
        }
        .footer {
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px 0;
            border-top: 1px solid #ddd;
            background-color: #f8f9fa;
            font-size: 12px;
            color: #555;
        }
        .footer .page-number:after {
            content: counter(page);
        }
        .table th, .table td {
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bugtrack Report</h1>
            <h3>Project: {{ $bugtrack->projectName }}</h3>
            <p>Date: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
        </div>
        <table class="table">
            <tbody>
                <tr>
                    <th style="width: 25%;">Name</th>
                    <td>{{ $bugtrack->title }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $bugtrack->description }}</td>
                </tr>
                <tr>
                    <th>Due Date</th>
                    <td>{{ $bugtrack->due_date ? \Carbon\Carbon::parse($bugtrack->due_date)->format('F j, Y') : 'Not Set' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($bugtrack->status) }}</td>
                </tr>
                <tr>
                    <th>Severity</th>
                    <td>{{ ucfirst($bugtrack->severity) }}</td>
                </tr>
                <tr>
                    <th>Flow</th>
                    <td>{{ $bugtrack->flow }}</td>
                </tr>
                <tr>
                    <th>Expected Results</th>
                    <td>{{ $bugtrack->expected_results }}</td>
                </tr>
                <tr>
                    <th>Actual Results</th>
                    <td>{{ $bugtrack->actual_results }}</td>
                </tr>
                <tr>
                    <th>Assigned To</th>
                    <td>{{ $bugtrack->assignee->name }}</td>
                </tr>
                <tr>
                    <th>Reported By</th>
                    <td>{{ $bugtrack->reporter->name }}</td>
                </tr>
                <tr>
                    <th>Created On</th>
                    <td>{{ \Carbon\Carbon::parse($bugtrack->created_at)->format('F j, Y, g:i a') }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ \Carbon\Carbon::parse($bugtrack->updated_at)->format('F j, Y, g:i a') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>Generated by Bugtrack System</p>
        <p class="page-number">Page </p>
    </div>
</body>
</html>
