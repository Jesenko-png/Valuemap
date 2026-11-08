@extends('layouts.app')
@section('title', 'Legal notice / Impressum')
@section('description', 'Legal and publisher information for the VALUEMAP project website.')
@section('content')
<header class="page-hero compact">
    <p class="eyebrow">Website information</p>
    <h1>Legal notice <em>/ Impressum</em></h1>
    <p>Legal, contact and editorial information for the VALUEMAP project website.</p>
</header>
<section class="section policy-content">
    <p class="policy-review">Last updated: 8 November 2026.</p>

    <article>
        <h2>Website operator</h2>
        <p><strong>Naučnoistraživački institut Verlab za biomedicinski inžinjering, medicinske uređaje i vještačku inteligenciju</strong><br>Legal form: Institute</p>
        <address>Ferhadija 27<br>71000 Sarajevo<br>Bosnia and Herzegovina</address>
    </article>

    <article>
        <h2>Legal representative</h2>
        <p>Dr. Lejla Gurbeta Pokvić</p>
    </article>

    <article>
        <h2>Contact</h2>
        <p>Email: <a href="mailto:info@verlabinstitute.com">info@verlabinstitute.com</a><br>Telephone: <a href="tel:+38733569540">+387 33 569 540</a></p>
    </article>

    <article>
        <h2>Registration and tax information</h2>
        <p>Register: Register of Business Entities in Bosnia and Herzegovina<br>Registration number: 65-05-0002-22<br>VAT identification number: 203009220006</p>
    </article>

    <article>
        <h2>Editorial responsibility</h2>
        <p>Adna Ašić<br>Contact: <a href="mailto:info@verlabinstitute.com">info@verlabinstitute.com</a></p>
    </article>

    <article>
        <h2>Data-protection contact</h2>
        <p>Matea Inić<br>Email: <a href="mailto:matea@verlabinstitute.com">matea@verlabinstitute.com</a></p>
    </article>

    <article>
        <h2>Responsibility for content and links</h2>
        <p>The operator aims to keep the information on this website accurate and current. External websites linked from VALUEMAP are controlled by their respective operators, who remain responsible for their content and privacy practices.</p>
    </article>

    <a class="button" href="{{ route('contact') }}">Contact VALUEMAP ↗</a>
</section>
@endsection
