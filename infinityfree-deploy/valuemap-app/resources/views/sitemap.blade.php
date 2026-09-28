{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($staticRoutes as $routeName)
    <url><loc>{{ route($routeName) }}</loc><changefreq>{{ $routeName === 'home' ? 'weekly' : 'monthly' }}</changefreq></url>
@endforeach
@foreach($items as $item)
    <url><loc>{{ route('content.show', $item->slug) }}</loc><lastmod>{{ $item->updated_at->toAtomString() }}</lastmod><changefreq>monthly</changefreq></url>
@endforeach
</urlset>
