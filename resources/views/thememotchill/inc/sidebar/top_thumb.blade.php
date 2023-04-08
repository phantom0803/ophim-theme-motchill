<div class="trailer block">
    <div class="caption">
        <span class="uppercase">{{ $top['label'] }}</span>
    </div>
    <ul class="list-film">
        @foreach ($top['data'] as $key => $movie)
            <li class="film-item-ver">
                <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
                    <img class="avatar" title="{{$movie->name}}" alt="{{$movie->name}}" src="{{$movie->getThumbUrl()}}" />
                </a>
                <div class="title">
                    <p class="name">
                        <a href="{{$movie->getUrl()}}" title="{{$movie->name}} {{$movie->publish_year}}">{{$movie->name}}</a>
                    </p>
                    <p class="real-name">{{$movie->publish_year}}</p>
                </div>
                <p class="top-star" data-rating="{{($movie->getRatingStar())*10}}"></p>
            </li>
        @endforeach
    </ul>
</div>
