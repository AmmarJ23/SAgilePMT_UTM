<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Due Date Approaching</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }
        .header {
            background-color: #1f2937;
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .content {
            padding: 1rem;
            color: #374151;
        }
        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.875rem;
            color: #9ca3af;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container">
        <div class="header">
            <h1 class="text-2xl font-bold">Bug Due Date Approaching</h1>
        </div>
        <div class="content">
            <p>Dear {{ $bug->assignee->name }},</p>
            <p class="mt-4">The due date for the bug titled "<strong>{{ $bug->title }}</strong>" in the project "<strong>{{ $bug->projectName }}</strong>" is approaching soon.</p>
            <p class="mt-4"><strong>Due Date:</strong> {{ $bug->due_date }}</p>
            <p class="mt-4">Please make sure to address this issue promptly.</p>
            <p class="mt-4">Thank you,</p>
            <p class="mt-2">SAgile Team</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 SAgile PMT. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
