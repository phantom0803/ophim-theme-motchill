<li class="{{$xClass}}">
    <span class="label">{{$movie->episode_current}} {{$movie->language}}</span>
    <a href="{{$movie->getUrl()}}" title="{{$movie->name}}">
        <img class="img-film lazy"
            data-original="{{$movie->getThumbUrl()}}"
            title="{{$movie->name}}"
            alt="{{$movie->name}}" />
        <i class="icon-play"></i>
    </a>
    <div class="name">
        <span>
            <a href="{{$movie->getUrl()}}" title="{{$movie->name}} {{$movie->publish_year}}">
                {{$movie->name}} {{$movie->publish_year}}
            </a>
        </span>
    </div>
</li>
