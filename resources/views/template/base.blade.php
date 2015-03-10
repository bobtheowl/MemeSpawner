@extends('template.html5')

{{-- <!--

    Base template for all Meme Generator pages.

    Views extending this template should include the following sections:

     * page-title   -- Displayed in the title after "Meme Generator | "
     * page-css     -- Section used to link to page-specific CSS files
     * page-content -- Section used to add page content
     * page-js      -- Section used to add page-specific JS script tags
     * onload       -- Section used to add JS which runs when the page is loaded

    These sections can also be added, but shouldn't be needed for all views:

     * top-css      -- Used to add CSS links before any other CSS is loaded
     * top-js       -- Used to add JS script tags before any other JS is loaded
     * navbar-right -- Used to add additional content to the right side of the navbar

--> --}}

@section('title')
    MemeSpawner | @yield('page-title')
@stop

@section('css')
    @yield('top-css', '')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/meme.css') }}" />
    @yield('page-css', '')
@stop

@section('content')
    @include('template.nav')
    <div class="container-fluid">
        @yield('page-content', '')
    </div>{{-- /.container-fluid --}}
    @yield('other-content', '')
@stop

@section('js')
    <script type="text/javascript">
        var siteUrl = '{{ URL::to('/') }}';
        var assetUrl = '{{ URL::asset('') }}';
        if (siteUrl.slice(-1) !== '/') {
            siteUrl += '/';
        }//end if
        if (assetUrl.slice(-1) !== '/') {
            assetUrl += '/';
        }//end if
    </script>
    @yield('top-js', '')
    <script type="text/javascript" src="{{ URL::asset('js/plugins/jquery/jquery-2.1.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/plugins/bootbox/bootbox.min.js') }}"></script>
    @yield('page-js', '')
    <script type="text/javascript">
        $(document).on('ready', function () {
            $.ajaxSetup({
                'headers': {
                    'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            @yield('onload', '')
        });
    </script>
@stop
