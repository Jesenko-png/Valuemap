@extends('layouts.app')
@php
    $content = [
        'privacy' => [
            'Privacy policy',
            'How VALUEMAP handles personal information.',
            [
                ['Data controller', 'The website is operated by Naučnoistraživački institut Verlab za biomedicinski inžinjering, medicinske uređaje i vještačku inteligenciju, Ferhadija 27, 71000 Sarajevo, Bosnia and Herzegovina. Contact: info@verlabinstitute.com.'],
                ['Information we receive', 'The contact form collects your name, email address, organisation, subject and message. Newsletter registration collects your email address and consent record. Project accounts contain the information required for authentication and role management. The hosting infrastructure also processes essential technical and security logs.'],
                ['Why we use it', 'Information is used to respond to enquiries, manage requested project engagement, operate project accounts, deliver requested newsletters, maintain website security and meet applicable project obligations. Optional analytics is activated only after the visitor gives consent.'],
                ['Storage, access and retention', 'Access is limited to authorised project personnel and service providers required to operate the website. Personal information is not sold and is retained only for as long as needed for the relevant purpose and applicable legal or project obligations.'],
                ['Your rights and data-protection contact', 'You may request access, correction, deletion or restriction of your personal information, or withdraw consent where processing relies on consent. The data-protection contact is Matea Inić at matea@verlabinstitute.com. You may also contact the competent data-protection authority.'],
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
<section class="section policy-content"><p class="policy-review">Last updated: 8 November 2026.</p>@foreach($content[2] as $section)<article><h2>{{ $section[0] }}</h2><p>{{ $section[1] }}</p></article>@endforeach @if($policy === 'cookies')<button class="button cookie-settings-button" type="button" data-open-consent>Change cookie settings</button>@endif <a class="button" href="{{ route('contact') }}">Contact VALUEMAP ↗</a></section>
@endsection
