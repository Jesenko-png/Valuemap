@extends('layouts.app')
@php
    $content = [
        'privacy' => [
            'Privacy policy',
            'How VALUEMAP handles personal information.',
            [
                ['Information we receive', 'The contact form collects your name, email address, organisation, subject and message only when you choose to submit them.'],
                ['Why we use it', 'Information is used to respond to enquiries, coordinate requested project engagement and protect the website from misuse.'],
                ['Storage and access', 'Access is limited to authorised project personnel. Information is retained only for as long as needed for the enquiry and applicable project obligations.'],
                ['Your choices', 'You may contact the project coordination team to ask about access, correction or deletion of information you submitted.'],
            ],
        ],
        'cookies' => [
            'Cookie policy',
            'A clear explanation of website storage and analytics choices.',
            [
                ['Essential storage', 'The website uses essential session and security storage for login, form protection and normal operation. This storage cannot be disabled through the website because those functions would stop working.'],
                ['Optional analytics', 'If Google Analytics is enabled, it loads only after a visitor actively allows analytics. Google Analytics may set the first-party cookies _ga and _ga_<container-id>, which have a default lifetime of two years and are used to distinguish users and preserve session state.'],
                ['Consent preference', 'Your analytics choice and the time of that choice are stored locally in your browser. This preference is not used for advertising or profiling.'],
                ['Changing your choice', 'Use the Cookie settings control below or in the website footer at any time. Refusing optional analytics does not limit access to the website.'],
            ],
        ],
        'accessibility' => [
            'Accessibility statement',
            'VALUEMAP aims to make project information usable by as many people as possible.',
            [
                ['Our approach', 'The website uses semantic headings, keyboard-accessible navigation, visible focus states, descriptive labels, responsive layouts and reduced-motion support.'],
                ['Known limitations', 'Some third-party documents or linked resources may not be fully controlled by VALUEMAP. We will aim to provide accessible alternatives where feasible.'],
                ['Feedback', 'If you encounter an accessibility barrier, please use the contact form and describe the page and issue.'],
            ],
        ],
    ][$policy];
@endphp
@section('title', $content[0])
@section('description', $content[1])
@section('content')
<header class="page-hero compact"><p class="eyebrow">Website information</p><h1>{{ $content[0] }}</h1><p>{{ $content[1] }}</p></header>
<section class="section policy-content"><p class="policy-review">This operational statement should be reviewed by the project’s legal/data-protection contact before public launch.</p>@foreach($content[2] as $section)<article><h2>{{ $section[0] }}</h2><p>{{ $section[1] }}</p></article>@endforeach @if($policy === 'cookies')<button class="button cookie-settings-button" type="button" data-open-consent>Change cookie settings</button>@endif <a class="button" href="{{ route('contact') }}">Contact VALUEMAP ↗</a></section>
@endsection
