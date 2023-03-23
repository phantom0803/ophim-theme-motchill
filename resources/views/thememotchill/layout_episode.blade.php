@extends('themes::layout')

@php
    $menu = \Ophim\Core\Models\Menu::getTree();
    $tops = Cache::remember('site.movies.tops', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('hotest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $sortKey, $alg, $limit, $template] = array_merge($list, ['Phim hot', '', 'type', 'series', 'view_total', 'desc', 4, 'top_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => \Ophim\Core\Models\Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->orderBy($sortKey, $alg)
                            ->limit($limit)
                            ->get(),
                    ];
                } catch (\Exception $e) {
                    # code
                }
            }
        }

        return $data;
    });
@endphp

@push('header')
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/owl.carousel.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,500" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/font-face.css?v=1.3.1" />
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/jquery-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/default.css?v=0.3.9" />
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/styles.css?v=1.1.9" />
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/responsive.css?v=1.0.5" />
    @if (!(new \Jenssegers\Agent\Agent())->isDesktop())
        <link rel="stylesheet" type="text/css" href="/themes/motchill/css/ipad.css?v=1.0.5" />
    @endif
    <link rel="stylesheet" type="text/css" href="/themes/motchill/css/custom.css" />
    <script type="text/javascript" src="/themes/motchill/js/jquery.min.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/bootstrap2.min.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/jquery.lazyload.min.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/jquery.core.min.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/functions.js?v=2.0.1"></script>
    <script type="text/javascript" src="/themes/motchill/js/js.cookie.js?v=2.1"></script>
@endpush

@section('body')
    <div id="page">
        @if ((new \Jenssegers\Agent\Agent())->isDesktop())
            @include('themes::thememotchill.inc.header')
        @else
            @include('themes::thememotchill.inc.header_mobile')
        @endif
        <div id="content">
            <div class="main-content">
                <div class="container">
                    @if (get_theme_option('ads_header'))
                        {!! get_theme_option('ads_header') !!}
                    @endif
                    @yield('slider_recommended')
                    <div class="clear"></div>
                    @yield('breadcrumb')
                    @yield('content')
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        {!! get_theme_option('footer') !!}
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("img.lazy").lazyload({
                effect: "fadeIn"
            });
        });
    </script>
@endpush

@section('footer')
    @if (get_theme_option('ads_catfish'))
        {!! get_theme_option('ads_catfish') !!}
    @endif
    <script src="/themes/motchill/js/jquery.raty.js"></script>
    <script type="text/javascript" src="/themes/motchill/js/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#film_related").owlCarousel({
                items: 5,
                itemsTablet: [700, 3],
                itemsMobile: [479, 2],
                navigation: true, // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                stopOnHover: true,
                pagination: false,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            });

            @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
                //Tính lại chiều cao cho các ảnh bị lệch nhau trên mobile
                var first_img_w = $(".img-film").eq(0).width();
                var first_img_h = first_img_w * (1.25); // Chiều cao bằng chiều rộng x 1.42
                $(".img-film").height(first_img_h);

                $(function() {
                    $('.dinfo').slimScroll({
                        height: '250px'
                    });
                });
            @endif

            //Loading video
            $("#btn_lightbulb").click(function() {
                var $this = $(this);
                var $overlay = '<div id="background_lamp"></div>';
                if ($this.hasClass('off')) {
                    $this.removeClass('off');
                    $this.attr('title', 'Tắt đèn');
                    $("#background_lamp").remove();
                } else {
                    $this.addClass('off');
                    $this.attr('title', 'Bật đèn');
                    $('body').append($overlay);
                }
            });

        })
    </script>

    {!! setting('site_scripts_google_analytics') !!}
@endsection
