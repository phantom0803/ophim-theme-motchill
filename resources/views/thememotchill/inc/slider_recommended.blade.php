<div class="list-films film-hot">
    <h2 class="title-box">
        <a class="tophot">Phim hot</a>
    </h2>
    <ul id="film_hot" class="relative">
        @if (count($recommendations))
            @foreach ($recommendations as $movie)
                <li class="item" title="{{$movie->name}}">
                    <span class="label">{{$movie->episode_current}} {{$movie->language}}</span>
                    <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
                        <img class="img-film" title="{{$movie->name}}" alt="{{$movie->name}}" src="{{$movie->getThumbUrl()}}" />
                        <i class="icon-play"></i>
                    </a>
                    <div class="text absolute">
                        <span class="title">
                            <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">{{$movie->name}}</a>
                        </span>
                    </div>
                </li>
            @endforeach
        @endif
    </ul>
</div>
