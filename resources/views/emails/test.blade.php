<x-mail::message>
# {{ $data['subject'] }}

{{ $data['body'] }}

<x-mail::button :url="''">
Click to Verify
</x-mail::button>

@if (!empty($image))
<img src="{{ 'data:' . $image['mime'] . ';base64,' . $image['contents'] }}" alt="Uploaded Image" style="max-width: 100%; height: auto;">
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
