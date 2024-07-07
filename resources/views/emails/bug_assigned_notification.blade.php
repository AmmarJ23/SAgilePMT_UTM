@component('mail::message')
{{-- Header --}}
<h1 class="text-center mb-4">Bug Assigned Notification</h1>

Hello,

A new bugtrack has been assigned to you. Here are the details:

{{-- Table for Bug Details --}}
<div style="margin: 0 auto; max-width: 600px;">
    <table class="table table-bordered" style="width: 100%; border-collapse: collapse; border: 2px solid #333;">
        <tbody>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Title</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->title }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Description</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->description }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Severity</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->severity }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Status</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->status }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Flow</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->flow ?: 'Not specified' }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Expected Results</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->expected_results ?: 'Not specified' }}</td>
            </tr>
            <tr>
                <th style="width: 30%; border: 1px solid #333;" scope="row">Actual Results</th>
                <td style="border: 1px solid #333;">{{ $bugtrack->actual_results ?: 'Not specified' }}</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- Additional Information --}}
<p class="lead">
    You can view more details by logging into our bugtracking system.
</p>

If you have any questions or need further assistance, feel free to reach out.

Thank you,  
SAgile PMT Team
@endcomponent
