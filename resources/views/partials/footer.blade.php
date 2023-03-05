<footer class="container-fluid footer_section">
    <hr>
    <div class="row">
        <div class="footer-content col text-right">
            @foreach (App\Page::all() as $page)
                <a href="/p-{{ $page->page_slug }}">{{ $page->page_title }}</a>
            @endforeach
            <a href="{{ route('contact') }}">{{ __('Get In Touch') }}</a>
            <a href="{{ route('sitemap') }}">{{ __('Sitemap') }}</a>
        </div><!-- /.pull-right -->
    </div><!-- /.row -->
</footer>
