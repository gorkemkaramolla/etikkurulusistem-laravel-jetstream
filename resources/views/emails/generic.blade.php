<x-emails.email-layout>
    @isset($emailMessageTr)
        <p>{{ $emailMessageTr }}</p>
    @endisset
    @isset($emailMessageEn)
        <p>{{ $emailMessageEn }}</p>
    @endisset
    @isset($decideReason)
        <p>{{ $decideReason }}</p>
    @endisset
    @isset($emailMessage)
        <p>{{ $emailMessage }}</p>
    @endisset
</x-emails.email-layout>
