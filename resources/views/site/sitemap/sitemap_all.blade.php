<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($sitemaps as $site)
        <sitemap>
            <loc>{{ $site }}</loc>
        </sitemap>
    @endforeach
</sitemapindex>