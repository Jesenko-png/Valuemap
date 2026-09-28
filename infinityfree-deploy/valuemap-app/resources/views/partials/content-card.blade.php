<article class="content-card">
    @if($item->image_path)<a class="content-card-image" href="{{ route('content.show', $item) }}"><img src="{{ asset('storage/'.$item->image_path) }}" alt="" loading="lazy"></a>@endif
    <div><span class="tag">{{ $item->type_label }}</span>@if($item->reference_code)<span class="reference">{{ $item->reference_code }}</span>@endif</div>
    <h3><a href="{{ route('content.show', $item) }}">{{ $item->title }}</a></h3>
    <p>{{ $item->excerpt }}</p>
    @if($item->category)<small>{{ $item->category }}</small>@endif
    @if($item->type === 'event' && $item->event_date)<p><time datetime="{{ $item->event_date->toIso8601String() }}">{{ $item->event_date->format('d M Y, H:i') }}</time>@if($item->location) · {{ $item->location }}@endif</p>@endif
    <footer><span>{{ $item->partner ?: optional($item->published_at)->format('d M Y') }}</span><a href="{{ route('content.show', $item) }}" aria-label="Read {{ $item->title }}">↗</a></footer>
</article>
