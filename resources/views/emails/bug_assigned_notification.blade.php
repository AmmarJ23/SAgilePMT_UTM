@component('mail::message')
# Bug Assigned Notification

Hello @if ($bugtrack->assignedTo) @else User @endif,

A new bugtrack has been assigned to you:

**Title:** {{ $bugtrack->title }}

**Description:** {{ $bugtrack->description }}

You can view more details by logging into our bugtracking system.

Thank you,
{{ config('app.name') }}
@endcomponent
