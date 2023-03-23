@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<div id="header">
    <div class="container">
        <div class="btn-humber">
            <p></p>
            <p></p>
            <p></p>
        </div>
        <a href="/" title="{{ $title }}" class="logo">
            @if ($logo)
                {!! $logo !!}
            @else
                {!! $brand !!}
            @endif
        </a>
        <i class="fa fa-search mobile"></i>
        <form id="mform_search" method="GET" action="/">
            <input type="text" id="mkeyword" name="search" autocomplete="off"
                placeholder="Nhập tên phim bạn muốn tìm kiếm..." value="{{ request('search') }}">
            <i class="fa fa-arrow-circle-right" onclick="$('#mform_search').submit();"></i>
            <div style="display: block;" id="msuggestions" class="top-search-box"></div>
        </form>
        <script>
            $(document).ready(function() {
                $(".btn-humber").click(function() {
                    var $menu = $(".main-menu");
                    var overlay = '<div id="overlay_menu" onclick="$(\'.btn-humber\').click()"></div>';
                    $this = $(this);
                    var hw = $(window).height();
                    if ($menu.hasClass('expanded')) {
                        $menu.removeClass('expanded');
                        $this.removeClass('active');
                        $('#overlay_menu').remove();
                    } else {
                        $('.main-menu').height(hw);
                        $menu.addClass('expanded');
                        $this.addClass('active');
                        $('body').append(overlay);
                        setTimeout(function() {
                            $('#overlay_menu').addClass('slide');
                        }, 300)

                    }
                });


                $(".menu-item>a").click(function() {
                    var $this = $(this);
                    var $sub = $this.next();

                    if (!$sub.hasClass('sub-menu')) {
                        var link = $this.attr('href');
                        window.location.href = link;
                    } else {
                        if ($sub.hasClass('expanded')) {
                            $sub.removeClass('expanded');
                            $this.removeClass('active');

                        } else {
                            $('.sub-menu').removeClass('expanded');
                            $sub.addClass('expanded');
                            $this.addClass('active');
                        }
                        return false;
                    }
                });

                $(window).resize(function() {
                    hw = $(window).height();
                    $('.main-menu').height(hw);
                });


                $(".fa-search.mobile").click(function() {
                    var $this = $(this);
                    var $formsearch = $("#mform_search");
                    var overlay = '<div id="overlay_search" onclick="$(\'.fa-search.mobile\').click()"></div>';
                    if ($formsearch.hasClass('expanded')) {
                        $formsearch.removeClass('expanded');
                        $('#overlay_search').remove();
                    } else {
                        $formsearch.addClass('expanded');
                        $('body').append(overlay);
                        $("#mkeyword").focus();
                    }
                });
            })
        </script>
    </div>
    <div class="main-menu">
        <ul class="container">
            @foreach ($menu as $item)
                @if (count($item['children']))
                    <li class="menu-item ">
                        <a title="{{ $item['name'] }}">
                            {{ $item['name'] }}
                        </a>
                        <ul class="sub-menu span absolute">
                            @foreach ($item['children'] as $children)
                                <li class="sub-menu-item">
                                    <a title="{{ $children['name'] }}" href="{{ $children['link'] }}">{{ $children['name'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="menu-item {{$item['link'] === '/' ? 'active' : ''}}"><a title="{{ $item['name'] }}" href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
