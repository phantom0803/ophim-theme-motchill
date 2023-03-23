<div class="list-films film-new">
    <h2 class="title-box">
        <a title="{{ $item['label'] }}" rel="nofollow" href="{{ $item['link'] }}" class="tab active">{{ $item['label'] }}</a>
    </h2>
    <ul class="film-moi tab-content">
        @foreach ($item['data'] as $key => $movie)
            @php
                $xClass = 'item';
                if ($key === 0 || $key % 4 === 0) {
                    $xClass .= ' no-margin-left';
                }
            @endphp
            @include('themes::thememotchill.inc.sections_movies_item')
        @endforeach
    </ul>
</div>
