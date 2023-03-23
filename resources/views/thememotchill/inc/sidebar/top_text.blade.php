<div class="most-view block">
    <div class="caption">
        <span class="uppercase">{{ $top['label'] }}</span>
    </div>
    <div class="clear"></div>
    <ul class="list-film">
        @foreach ($top['data'] as $key => $movie)
            <li class="item">
                <span class="number-rank absolute">{{ $key + 1 }}</span>
                <span>
                    <a href="{{ $movie->getUrl() }}" title="{{ $movie->name }}">{{ $movie->name }}</a>
                </span>
                <div class="count_view">{{ $movie->view_week }} lượt xem</div>
            </li>
        @endforeach
    </ul>
</div>
