<x-mail::message>
# {{ $data['subject'] }}

{{ $data['body'] }}

<x-mail::button :url="''">
Click to Verify
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
