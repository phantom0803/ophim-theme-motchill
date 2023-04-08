@extends('themes::thememotchill.layout')

@push('header')
@endpush

@section('breadcrumb')
    <ol class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="/" itemprop="item">
                <span itemprop="name">Xem phim</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="{{ $currentMovie->regions->first()->getUrl() }}" itemprop="item">
                <span itemprop="name">{{ $currentMovie->regions->first()->name }}</span>
            </a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="active">{{ $currentMovie->name }}</li>
    </ol>
@endsection

@php
    $watchUrl = '#';
    if (!$currentMovie->is_copyright && count($currentMovie->episodes) && $currentMovie->episodes[0]['link'] != '') {
        $watchUrl = $currentMovie->episodes
            ->sortBy([['server', 'asc']])
            ->groupBy('server')
            ->first()
            ->sortByDesc('name', SORT_NATURAL)
            ->groupBy('name')
            ->last()
            ->sortByDesc('type')
            ->first()
            ->getUrl();
    }
@endphp

@section('content')
    <div class="left-content" id="page-info">
        <div class="blockbody">
            <div class="info" itemscope itemtype="https://schema.org/TVSeries">
                <div class="poster">
                    <a class="adspruce-streamlink" href="{{ $currentMovie->getUrl() }}" title="{{ $currentMovie->name }}">
                        <img itemprop="image" src="{{ $currentMovie->getThumbUrl() }}" title="{{ $currentMovie->name }}"
                            alt="{{ $currentMovie->name }}" />
                    </a>
                    <img class="hidden" itemprop="thumbnailUrl" src="{{ $currentMovie->getThumbUrl() }}">
                    <ul class="buttons two-button">
                        <li>
                            <a class="btn-see btn btn-primary btn-download-link"
                                onclick="alert('Chức năng download đang được xây dựng và sẽ sớm ra mắt ^^');return false;">
                                Tải phim </a>
                        </li>
                        <li>
                            <a class="btn-see btn btn-danger btn-stream-link" href="{{ $watchUrl }}"
                                title="Xem phim {{ $currentMovie->name }}"> Xem phim
                            </a>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="text">
                    <h1>
                        <span class="title" itemprop="name">{{ $currentMovie->name }}</span>
                    </h1>
                    <h2>
                        <span class="real-name">{{ $currentMovie->origin_name }}
                            ({{ $currentMovie->publish_year }})</span>
                    </h2>
                    <div class="dinfo">
                        <dl class="col">
                            <dt>Trạng thái:</dt>
                            <dd class="film-status">
                                <span class="badge badge-info"
                                    style="border-radius: 0px;">{{ $currentMovie->episode_current }}
                                    {{ $currentMovie->language }}</span>
                            </dd>
                            <dt>Đạo diễn:</dt>
                            <dd>
                                {!! count($currentMovie->directors)
                                    ? $currentMovie->directors->map(function ($director) {
                                            return '<a href="' .
                                                $director->getUrl() .
                                                '" tite="Đạo diễn ' .
                                                $director->name .
                                                '">' .
                                                $director->name .
                                                '</a>';
                                        })->implode(', ')
                                    : 'N/A' !!}
                            </dd>
                            <dt>Thời lượng:</dt>
                            <dd>{{ $currentMovie->episode_time }}</dd>
                            <dt>Số tập:</dt>
                            <dd>{{ $currentMovie->episode_total }}</dd>
                            <dt>Tình trạng:</dt>
                            <dd>
                                @php
                                    switch ($currentMovie->status) {
                                        case 'ongoing':
                                            echo 'Đang chiếu';
                                            break;
                                        case 'completed':
                                            echo 'Hoàn thành';
                                            break;
                                        default:
                                            echo 'Trailer';
                                            break;
                                    }
                                @endphp
                            </dd>
                            <dt>Ngôn ngữ:</dt>
                            <dd>{{ $currentMovie->language }}</dd>
                            <dt>Năm sản xuất:</dt>
                            <dd>{{ $currentMovie->publish_year }}</dd>
                            <dt>Quốc gia:</dt>
                            <dd>
                                {!! $currentMovie->regions->map(function ($region) {
                                        return '<a href="' . $region->getUrl() . '" tite="' . $region->name . '">' . $region->name . '</a>';
                                    })->implode(', ') !!}
                            </dd>
                            <dt>Thể loại:</dt>
                            <dd>
                                {!! $currentMovie->categories->map(function ($category) {
                                        return '<a href="' . $category->getUrl() . '" tite="' . $category->name . '">' . $category->name . '</a>';
                                    })->implode(', ') !!}
                            </dd>
                            <dt>Diễn viên:</dt>
                            <dd>
                                {!! count($currentMovie->actors)
                                    ? $currentMovie->actors->map(function ($actor) {
                                            return '<a href="' . $actor->getUrl() . '" tite="Diễn viên ' . $actor->name . '">' . $actor->name . '</a>';
                                        })->implode(', ')
                                    : 'N/A' !!}
                            </dd>
                        </dl>
                    </div>
                    <div class="clear"></div>
                    <div class="btn-groups">
                        <div class="box-btn clear">
                            <div class="fb-like" data-href="{{ $currentMovie->getUrl() }}" data-layout="button_count"
                                data-action="like" data-show-faces="false" data-share="true">
                            </div>
                            <div class="fb-save" data-uri="{{ $currentMovie->getUrl() }}" data-size="small">
                            </div>
                            <div class="gg-like"></div>
                        </div>
                        <div class="clear"></div>
                        <div class="col">
                            <div class="box-rating" itemprop="aggregateRating" itemscope
                                itemtype="https://schema.org/AggregateRating">
                                <div id="star"
                                    data-score="{{ $currentMovie->getRatingStar() }}"
                                    style="cursor: pointer;"></div>
                                <div>
                                    <div id="div_average" style="float: left; line-height: 16px; margin: 0 5px; ">
                                        <span id="hint"></span> ( <span class="average" id="average"
                                            itemprop="ratingValue">{{ $currentMovie->getRatingStar() }}</span>
                                        điểm / <span id="rate_count"
                                            itemprop="ratingCount">{{ $currentMovie->getRatingCount()}}</span>
                                        lượt)
                                    </div>
                                    <meta itemprop="bestRating" content="10" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            @if (
                $currentMovie->type === 'series' &&
                    !$currentMovie->is_copyright &&
                    count($currentMovie->episodes) &&
                    $currentMovie->episodes[0]['link'] != '')
                <div class="latest-episode">
                    <span class="heading">Tập mới nhất : </span>
                    @php
                        $currentMovie->episodes
                            ->sortBy([['name', 'desc'], ['type', 'desc']])
                            ->sortByDesc('name', SORT_NATURAL)
                            ->unique('name')
                            ->take(5)
                            ->map(function ($episode) {
                                echo '<a href="' . $episode->getUrl() . '">Tập ' . $episode->name . '</a>';
                            });
                    @endphp
                </div>
            @endif
            <div class="detail">
                <div class="tabs-content" id="info-film">
                    <h3 class="heading"> Nội dung phim </h3>
                    <div class="tab">
                        <div style="text-align: justify;">
                            <b>{{ $currentMovie->name }}</b>
                            {!! $currentMovie->content !!}
                        </div>
                    </div>
                </div>
                <ul class="tags">
                    <li class="caption">
                        <span>Tags</span>
                        <i class="fa fa-caret-right"></i>
                    </li>
                    @foreach ($currentMovie->tags as $tag)
                        <li class="tag-item">
                            <h2>
                                <a href="{{ $tag->getUrl() }}">{{ $tag->name }}</a>
                            </h2>
                        </li>
                    @endforeach
                </ul>
                <div class="clear"></div>
                <div class="keywords">
                    <h4>xem phim {{ $currentMovie->name }} vietsub, phim {{ $currentMovie->origin_name }} vietsub, xem
                        {{ $currentMovie->name }} vietsub online tap 1, tap 2,
                        tap
                        3, tap 4, phim {{ $currentMovie->origin_name }} ep 5, ep 6, ep 7, ep 8, ep 9, ep 10, xem
                        {{ $currentMovie->name }} tập 11, tập 12, tập
                        13,
                        tập 14, tập 15, phim {{ $currentMovie->name }} tap 16, tap 17, tap 18, tap 19, tap 20, xem phim
                        {{ $currentMovie->name }} tập
                        21,
                        23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47,
                        48,
                        49, 50, {{ $currentMovie->name }} tap cuoi, {{ $currentMovie->origin_name }} vietsub tron bo,
                        review {{ $currentMovie->name }} netflix, {{ $currentMovie->name }}
                        wetv, {{ $currentMovie->name }} phimmoi, {{ $currentMovie->name }} youtube,
                        {{ $currentMovie->name }} dongphym, {{ $currentMovie->name }} vieon, phim
                        keeng,
                        bilutv, biphim, hdvip, hayghe, motphim, tvhay, zingtv, fptplay, phim1080, luotphim, fimfast,
                        dongphim,
                        fullphim, phephim, vtvgiaitri {{ $currentMovie->name }} full, {{ $currentMovie->origin_name }}
                        online, {{ $currentMovie->name }} Thuyết Minh, {{ $currentMovie->name }}Vietsub,
                        {{ $currentMovie->name }} Lồng Tiếng</h4>
                </div>
            </div>
            @if ($currentMovie->notify && $currentMovie->notify != '')
                <div class="film-note">
                    <h4 class="hidden">Ghi chú</h4>GHI CHÚ: {{ strip_tags($currentMovie->notify) }}
                </div>
            @endif

            @if ($currentMovie->showtimes && $currentMovie->showtimes != '')
                <div class="film-note">
                    <h4 class="hidden">Lịch chiếu</h4>LỊCH CHIẾU: {!! $currentMovie->showtimes !!}
                </div>
            @endif

            <div id="comment-tab">
                <div class="box-comment" id="tabs-facebook" style="width: 100%; background-color: #fff">
                    <div id="mp-comments" class="fb-comments" data-href="{{ $currentMovie->getUrl() }}"
                        data-numposts="10" data-order-by="reverse_time" data-colorscheme="light"></div>
                    <script>
                        document.getElementById("mp-comments").dataset.width = $("#mp-comments").parent().width();
                    </script>
                </div>
            </div>

            <div class="list-films film-hot">
                <h2 class="title-box">
                    <i class="fa fa-star-o"></i>
                    <a href="javascript:void(0)">Phim đề cử</a>
                </h2>
                <ul id="film_related" class="relative">
                    @foreach ($movie_related as $movie)
                        <li class="item" title="{{ $movie->name }}">
                            <span class="label">{{ $movie->episode_current }} {{ $movie->language }}</span>
                            <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }}">
                                <img class="img-film" title="{{ $movie->name }}" alt="{{ $movie->name }}"
                                    src="{{ $movie->getThumbUrl() }}" />
                                <i class="icon-play"></i>
                            </a>
                            <div class="text absolute">
                                <span class="">
                                    <a href="{{ $movie->getUrl() }}"
                                        title="{{ $movie->name }}">{{ $movie->name }}</a>
                                </span>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        const URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
    </script>
    <script type="text/javascript" src="/themes/motchill/js/filmdetail.js?v=1.2.2"></script>
    <script type="text/javascript" src="/themes/motchill/js/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#film_related").owlCarousel({
                items: 4,
                itemsTablet: [700, 3],
                itemsMobile: [479, 2],
                navigation: true, // Show next and prev buttons
                slideSpeed: 300,
                paginationSpeed: 400,
                stopOnHover: true,
                pagination: false,
                navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            });

            //Tính lại chiều cao cho các ảnh bị lệch nhau trên mobile
            var first_img_w = $(".img-film").eq(0).width();
            var first_img_h = first_img_w * (1.25); // Chiều cao bằng chiều rộng x 1.42
            $(".img-film").height(first_img_h);

            $(function() {
                $('.dinfo').slimScroll({
                    height: '250px'
                });
            });

        })
    </script>
    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
