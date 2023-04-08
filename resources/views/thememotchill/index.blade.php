@extends('themes::thememotchill.layout')

@php
    use Ophim\Core\Models\Movie;

    $recommendations = Cache::remember('site.movies.recommendations', setting('site_cache_ttl', 5 * 60), function () {
        return Movie::where('is_recommended', true)
            ->limit(get_theme_option('recommendations_limit', 10))
            ->orderBy('updated_at', 'desc')
            ->get();
    });

    $data = Cache::remember('site.movies.latest', setting('site_cache_ttl', 5 * 60), function () {
        $lists = preg_split('/[\n\r]+/', get_theme_option('latest'));
        $data = [];
        foreach ($lists as $list) {
            if (trim($list)) {
                $list = explode('|', $list);
                [$label, $relation, $field, $val, $limit, $link, $template] = array_merge($list, ['Phim mới cập nhật', '', 'type', 'series', 8, '/', 'block_thumb']);
                try {
                    $data[] = [
                        'label' => $label,
                        'template' => $template,
                        'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                            $query->whereHas($relation, function ($rel) use ($field, $val) {
                                $rel->where($field, $val);
                            });
                        })
                            ->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })
                            ->limit($limit)
                            ->orderBy('updated_at', 'desc')
                            ->get(),
                        'link' => $link ?: '#',
                    ];
                } catch (\Exception $e) {
                }
            }
        }
        return $data;
    });

@endphp

@section('slider_recommended')
    @include('themes::thememotchill.inc.slider_recommended')
@endsection

@section('content')
    <div class="left-content">
        @foreach ($data as $item)
            @include('themes::thememotchill.inc.sections_movies')
        @endforeach
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="/themes/motchill/js/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#film_hot").owlCarousel({
                items: 5,
                itemsTablet: [700, 3],
                itemsMobile: [479, 2],
                scrollPerPage: true,
                lazyLoad: true,
                navigation: true, // Show next and prev buttons
                slideSpeed: 800,
                paginationSpeed: 400,
                stopOnHover: true,
                pagination: false,
                autoPlay: 8000,
                navigationText: ['<i class="fa fa-angle-left"></i>', ' <i class="fa fa-angle-right"></i>'],
            });

            @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
                var first_img_w = $("#film_hot .img-film").eq(0).width();
                var first_img_h = first_img_w * (1.42);
                $("#film_hot .img-film").height(first_img_h);

                // first_img_w = $(".film-moi .img-film").eq(0).width();
                // first_img_h = first_img_w * (1.42);
                // $(".film-moi .img-film").height(first_img_h);
                $(".film-moi .img-film").height(252);
            @endif
        });
    </script>
@endpush
