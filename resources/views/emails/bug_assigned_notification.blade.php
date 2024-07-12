@component('mail::message')
{{-- Header --}}
<h1 class="text-center mb-4">Bug Assigned Notification</h1>

Hello,

A new bugtrack has been assigned to you for project <strong> {{ $bugtrack->projectName }} </strong>. Here are the details:

{{-- Table for Bug Details --}}
<div style="margin: 0 auto; max-width: 600px;">
    <table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 2px solid #007bff;">
        <tbody>
            <tr style="background-color: #f8f9fa;">
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Title</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->title }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Description</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->description }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Due Date</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->due_date }}</td>
            </tr>
            <tr style="background-color: #f8f9fa;">
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Severity</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->severity }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Status</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->status }}</td>
            </tr>
            <tr style="background-color: #f8f9fa;">
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Flow</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->flow ?: 'Not specified' }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Expected Results</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->expected_results ?: 'Not specified' }}</td>
            </tr>
            <tr style="background-color: #f8f9fa;">
                <th style="width: 30%; border: 1px solid #007bff; padding: 8px;" scope="row">Actual Results</th>
                <td style="border: 1px solid #007bff; padding: 8px;">{{ $bugtrack->actual_results ?: 'Not specified' }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Additional Information --}}
<p class="lead">
    You can view more details by logging into SAgile Project Management Tool.
</p>


Thank you,  
SAgile PMT Team
@endcomponent
