<x-mail::message>
# {{$newsletter['title']}}

{{$newsletter['body']}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
