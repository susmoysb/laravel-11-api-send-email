<x-mail::message>
# {{ $data['subject'] }}

{{ $data['body'] }}

<x-mail::button :url="''">
Click to Verify
</x-mail::button>

@if (!empty($data['image']))
    <img src="{{ 'data:' . $data['image']->getClientMimeType() . ';base64,' . base64_encode($data['image']->get()) }}">
@endif

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
