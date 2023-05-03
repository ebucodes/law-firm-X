@component('mail::message')
    # Welcome to our CRM

    Dear {{ $welcome['name'] }},

    Thank you for joining our CRM. We are excited to have you on board!

    {{-- Additional content here --}}

    Regards,
    Your CRM Team
@endcomponent
