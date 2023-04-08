@extends('themes::thememotchill.layout')

@php
    $years = Cache::remember('all_years', \Backpack\Settings\app\Models\Setting::get('site_cache_ttl', 5 * 60), function () {
        return \Ophim\Core\Models\Movie::select('publish_year')
            ->distinct()
            ->pluck('publish_year')
            ->sortDesc();
    });
@endphp

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
        <li class="active">{{ $section_name }}</li>
    </ol>
    @include('themes::thememotchill.inc.catalog_filter')
@endsection

@section('content')
    <div class="left-content" id="page-info">
        <div class="list-films film-new">
            <ul>
                @foreach ($data as $key => $movie)
                    @php
                        $xClass = 'item';
                        if ($key === 0 || $key % 4 === 0) {
                            $xClass .= ' no-margin-left';
                        }
                    @endphp
                    @include('themes::thememotchill.inc.sections_movies_item')
                @endforeach
            </ul>

            <div class="clear"></div>
            <div class="pagination">
                {{ $data->appends(request()->all())->links('themes::thememotchill.inc.pagination') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if(!(new \Jenssegers\Agent\Agent())->isDesktop())
        <script>
            $(document).ready(function() {
                // first_img_w = $(".list-films .img-film").eq(0).width();
                // first_img_h = first_img_w * (1.42);
                // $(".list-films .img-film").height(first_img_h);
                $(".list-films .img-film").height(252);
            });
        </script>
    @endif
@endpush
