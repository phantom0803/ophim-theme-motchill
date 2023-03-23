@php
    $logo = setting('site_logo', '');
    $brand = setting('site_brand', '');
    $title = isset($title) ? $title : setting('site_homepage_title', '');
@endphp

<div id="header">
    <div class="container">
        <div class="top">
            <div class="left logo" style="box-shadow: 0px 1px 3px rgba(0,0,0,0.2);">
                <a href="/" title="{{ $title }}">
                    @if ($logo)
                        {!! $logo !!}
                    @else
                        {!! $brand !!}
                    @endif
                </a>
            </div>
            <div class="right-header">
                <div class="search-container relative">
                    <form id="form_search" method="GET" action="/">
                        <input type="text" id="keyword" name="search" autocomplete="off"
                            placeholder="Nhập tên phim bạn muốn tìm kiếm..." value="{{ request('search') }}" />
                        <i class="fa fa-search" onclick="$('#form_search').submit();"></i>
                    </form>
                </div>
                <div id="box-user-menu" class="actions-user right">
                    <ul>
                        <li>
                            <i class="fa fa-sign-in"></i>
                            <a onclick="alert('Chức năng này đang cập nhật');return false;">Đăng nhập</a>
                        </li>
                        <li>
                            <i class="fa fa-users"></i>
                            <a onclick="alert('Chức năng này đang cập nhật');return false;">Đăng ký</a>
                        </li>
                        <li>
                            <i class="fa fa-bookmark-o"></i>
                            <a onclick="alert('Chức năng này đang cập nhật');return false;">Bookmark</a>
                        </li>
                    </ul>
                </div>
                <div class="suggest-dns">
                    <p>Công cụ tìm kiếm phim.</p>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="main-menu">
        <ul class="container">
            @foreach ($menu as $item)
                @if (count($item['children']))
                    <li class="menu-item ">
                        <a title="{{ $item['name'] }}">
                            {{ $item['name'] }}
                        </a>
                        <ul class="sub-menu span-4 absolute">
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


