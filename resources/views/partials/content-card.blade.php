<article class="content-card">
    <div><span class="tag">{{ $item->type_label }}</span>@if($item->reference_code)<span class="reference">{{ $item->reference_code }}</span>@endif</div>
    <h3><a href="{{ route('content.show', $item) }}">{{ $item->title }}</a></h3>
    <p>{{ $item->excerpt }}</p>
    <footer><span>{{ $item->partner ?: optional($item->published_at)->format('d M Y') }}</span><a href="{{ route('content.show', $item) }}" aria-label="Read {{ $item->title }}">↗</a></footer>
</article>
