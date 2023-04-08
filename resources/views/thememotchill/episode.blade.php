@extends('themes::thememotchill.layout_episode')

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
        <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <a href="{{ $currentMovie->getUrl() }}" itemprop="item">
                <span itemprop="name">{{ $currentMovie->name }}</span>
            </a>
            <meta itemprop="position" content="3" />
        </li>
        <li class="active">Tập {{ $episode->name }}</li>
    </ol>
@endsection

@section('content')
    <div class="left-content-player" id="player-video">
        <div class="box-player" id="box-player">
            <div class="film-note tip-change-server" style="margin:0; float:right;border: 1px dashed #e25ddb;padding: 5px">
                <span>Bạn xem phim bị lag, giật? Đổi server tại đây <i class="fa fa-arrow-right"></i>
                </span>
                @foreach ($currentMovie->episodes->where('slug', $episode->slug)->where('server', $episode->server) as $server)
                    <a data-id="{{ $server->id }}" data-link="{{ $server->link }}" data-type="{{ $server->type }}"
                        onclick="chooseStreamingServer(this)" class="streaming-server btn-sv btn-hls btn btn-primary">VIP
                        #{{ $loop->index + 1 }}</a>
                @endforeach
            </div>
            <div class="clear"></div>
            <div id="player" class="embed-responsive embed-responsive-16by9"></div>
            <div class="loading-container">
                <div class="loading-player"></div>
            </div>
        </div>
        <div class="div-control" style="margin-bottom:80px">
            <span class="video-btn" id="btn_lightbulb" title="Tắt đèn">
                <i class="fa fa-lightbulb-o"></i>
            </span>
        </div>


        @foreach ($currentMovie->episodes->sortBy([['server', 'asc']])->groupBy('server') as $server => $data)
            <div class="control-box clear">
                <div class="server-episode-block">
                    <i class="fa fa-film"></i> {{ $server }}:
                </div>
                <div class="episodes">
                    <div class="list-episode">
                        @foreach ($data->sortByDesc('name', SORT_NATURAL)->groupBy('name') as $name => $item)
                            <a href="{{ $item->sortByDesc('type')->first()->getUrl() }}"
                                class="@if ($item->contains($episode)) current @endif" title="{{ $name }}">Tập
                                {{ $name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

        <div class="details">
            <div class="clear"></div>
            <div class="clear"></div>
            <div href="{{ $currentMovie->getUrl() }}" class="name">
                <h1 itemprop="name">
                    <a href="{{ $currentMovie->getUrl() }}"
                        title="Xem phim {{ $currentMovie->name }}">{{ $currentMovie->name }}</a>
                    <span>&nbsp;-&nbsp;</span>
                    <span class="chapter-name"> Tập {{ $episode->name }}</span>
                </h1>
                <div class="clear"></div>
                <h2 class="real-name">
                    <a href="{{ $currentMovie->getUrl() }}">{{ $currentMovie->origin_name }}
                        ({{ $currentMovie->publish_year }})</a>
                </h2>
            </div>
            <div class="clear"></div>
            <p class="short-description"
                style="padding: 5px 8px;margin: 5px 0 20px 0;line-height: 26px;font-size: 12px;color: #BBB;background: #222;">
                {!! mb_substr(strip_tags($currentMovie->content), 0, 300, 'utf-8') !!}...
                [ <a style="color: #fff;" href="{{ $currentMovie->getUrl() }}"
                    title="{{ $currentMovie->name }} - {{ $currentMovie->origin_name }} ({{ $currentMovie->publish_year }})">Xem
                    thêm</a>] </p>
            <div class="clear"></div>
            <div class="social-icon">
                <div class="fb-like" data-href="{{ $currentMovie->getUrl() }}" data-layout="button_count"
                    data-action="like" data-show-faces="false" data-share="true"></div>
                <div class="gg-like"></div>
            </div>
            <div class="box-rating" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                <div id="star"
                    data-score="{{$currentMovie->getRatingStar()}}"
                    style="cursor: pointer;"></div>
                <div>
                    <div id="div_average" style="float: left; line-height: 16px; margin: 0 5px; ">
                        <span id="hint"></span> ( <span class="average" id="average"
                            itemprop="ratingValue">{{$currentMovie->getRatingStar()}}</span>
                        điểm / <span id="rate_count"
                            itemprop="ratingCount">{{$currentMovie->getRatingCount()}}</span>
                        lượt)
                    </div>
                    <meta itemprop="bestRating" content="10" />
                </div>
            </div>
            <div class="clear"></div>
        </div>

    </div>

    <div class="bottom-content">
        <div class="container">
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
                    <a href="javascript:void(0)">Có thể bạn muốn xem?</a>
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
    <script src="/themes/motchill/player/js/p2p-media-loader-core.min.js"></script>
    <script src="/themes/motchill/player/js/p2p-media-loader-hlsjs.min.js"></script>

    <script src="/js/jwplayer-8.9.3.js"></script>
    <script src="/js/hls.min.js"></script>
    <script src="/js/jwplayer.hlsjs.min.js"></script>

    <script>
        var episode_id = {{ $episode->id }};
        const wrapper = document.getElementById('player');
        const vastAds = "{{ Setting::get('jwplayer_advertising_file') }}";

        function chooseStreamingServer(el) {
            const type = el.dataset.type;
            const link = el.dataset.link.replace(/^http:\/\//i, 'https://');
            const id = el.dataset.id;

            const newUrl =
                location.protocol +
                "//" +
                location.host +
                location.pathname.replace(`-${episode_id}`, `-${id}`);

            history.pushState({
                path: newUrl
            }, "", newUrl);
            episode_id = id;


            Array.from(document.getElementsByClassName('streaming-server')).forEach(server => {
                server.classList.remove('btn-success');
            })
            el.classList.add('btn-success');

            renderPlayer(type, link, id);
        }

        function renderPlayer(type, link, id) {
            $('.loadingData').hide();
            if (type == 'embed') {
                if (vastAds) {
                    wrapper.innerHTML = `<div id="fake_jwplayer"></div>`;
                    const fake_player = jwplayer("fake_jwplayer");
                    const objSetupFake = {
                        key: "{{ Setting::get('jwplayer_license') }}",
                        aspectratio: "16:9",
                        width: "100%",
                        file: "/themes/motchil/player/1s_blank.mp4",
                        volume: 100,
                        mute: false,
                        autostart: true,
                        advertising: {
                            tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                            client: "vast",
                            vpaidmode: "insecure",
                            skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                            skipmessage: "Bỏ qua sau xx giây",
                            skiptext: "Bỏ qua"
                        }
                    };
                    fake_player.setup(objSetupFake);
                    fake_player.on('complete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adSkipped', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });

                    fake_player.on('adComplete', function(event) {
                        $("#fake_jwplayer").remove();
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                        fake_player.remove();
                    });
                } else {
                    if (wrapper) {
                        wrapper.innerHTML = `<iframe width="100%" height="350px" src="${link}" frameborder="0" scrolling="no"
                    allowfullscreen="" allow='autoplay'></iframe>`
                    }
                }
                return;
            }

            if (type == 'm3u8' || type == 'mp4') {
                wrapper.innerHTML = `<div id="jwplayer"></div>`;
                const player = jwplayer("jwplayer");
                const objSetup = {
                    key: "{{ Setting::get('jwplayer_license') }}",
                    aspectratio: "16:9",
                    width: "100%",
                    image: "{{ $currentMovie->getPosterUrl() }}",
                    file: link,
                    playbackRateControls: true,
                    playbackRates: [0.25, 0.75, 1, 1.25],
                    sharing: {
                        sites: [
                            "reddit",
                            "facebook",
                            "twitter",
                            "googleplus",
                            "email",
                            "linkedin",
                        ],
                    },
                    volume: 100,
                    mute: false,
                    autostart: true,
                    logo: {
                        file: "{{ Setting::get('jwplayer_logo_file') }}",
                        link: "{{ Setting::get('jwplayer_logo_link') }}",
                        position: "{{ Setting::get('jwplayer_logo_position') }}",
                    },
                    advertising: {
                        tag: "{{ Setting::get('jwplayer_advertising_file') }}",
                        client: "vast",
                        vpaidmode: "insecure",
                        skipoffset: {{ (int) Setting::get('jwplayer_advertising_skipoffset') ?: 5 }}, // Bỏ qua quảng cáo trong vòng 5 giây
                        skipmessage: "Bỏ qua sau xx giây",
                        skiptext: "Bỏ qua"
                    }
                };

                if (type == 'm3u8') {
                    const segments_in_queue = 50;

                    var engine_config = {
                        debug: !1,
                        segments: {
                            forwardSegmentCount: 50,
                        },
                        loader: {
                            cachedSegmentExpiration: 864e5,
                            cachedSegmentsCount: 1e3,
                            requiredSegmentsPriority: segments_in_queue,
                            httpDownloadMaxPriority: 9,
                            httpDownloadProbability: 0.06,
                            httpDownloadProbabilityInterval: 1e3,
                            httpDownloadProbabilitySkipIfNoPeers: !0,
                            p2pDownloadMaxPriority: 50,
                            httpFailedSegmentTimeout: 500,
                            simultaneousP2PDownloads: 20,
                            simultaneousHttpDownloads: 2,
                            // httpDownloadInitialTimeout: 12e4,
                            // httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpDownloadInitialTimeout: 0,
                            httpDownloadInitialTimeoutPerSegment: 17e3,
                            httpUseRanges: !0,
                            maxBufferLength: 300,
                            // useP2P: false,
                        },
                    };
                    if (Hls.isSupported() && p2pml.hlsjs.Engine.isSupported()) {
                        var engine = new p2pml.hlsjs.Engine(engine_config);
                        player.setup(objSetup);
                        jwplayer_hls_provider.attach();
                        p2pml.hlsjs.initJwPlayer(player, {
                            liveSyncDurationCount: segments_in_queue, // To have at least 7 segments in queue
                            maxBufferLength: 300,
                            loader: engine.createLoaderClass(),
                        });
                    } else {
                        player.setup(objSetup);
                    }
                } else {
                    player.setup(objSetup);
                }


                const resumeData = 'OPCMS-PlayerPosition-' + id;
                player.on('ready', function() {
                    if (typeof(Storage) !== 'undefined') {
                        if (localStorage[resumeData] == '' || localStorage[resumeData] == 'undefined') {
                            console.log("No cookie for position found");
                            var currentPosition = 0;
                        } else {
                            if (localStorage[resumeData] == "null") {
                                localStorage[resumeData] = 0;
                            } else {
                                var currentPosition = localStorage[resumeData];
                            }
                            console.log("Position cookie found: " + localStorage[resumeData]);
                        }
                        player.once('play', function() {
                            console.log('Checking position cookie!');
                            console.log(Math.abs(player.getDuration() - currentPosition));
                            if (currentPosition > 180 && Math.abs(player.getDuration() - currentPosition) >
                                5) {
                                player.seek(currentPosition);
                            }
                        });
                        window.onunload = function() {
                            localStorage[resumeData] = player.getPosition();
                        }
                    } else {
                        console.log('Your browser is too old!');
                    }
                });

                player.on('complete', function() {
                    if (typeof(Storage) !== 'undefined') {
                        localStorage.removeItem(resumeData);
                    } else {
                        console.log('Your browser is too old!');
                    }
                })

                function formatSeconds(seconds) {
                    var date = new Date(1970, 0, 1);
                    date.setSeconds(seconds);
                    return date.toTimeString().replace(/.*(\d{2}:\d{2}:\d{2}).*/, "$1");
                }
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const episode = '{{ $episode->id }}';
            let playing = document.querySelector(`[data-id="${episode}"]`);
            if (playing) {
                playing.click();
                return;
            }

            const servers = document.getElementsByClassName('streaming-server');
            if (servers[0]) {
                servers[0].click();
            }
        });
    </script>

    <script type="text/javascript">
        const URL_POST_RATING = '{{ route('movie.rating', ['movie' => $currentMovie->slug]) }}';
    </script>
    <script type="text/javascript" src="/themes/motchill/js/filmdetail.js?v=1.2.2"></script>

    {!! setting('site_scripts_facebook_sdk') !!}
@endpush
