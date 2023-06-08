@php
$blogs = App\Models\Blog::latest()->limit(4)->get();
@endphp

<section class="blog">
    <div class="container">
        <div class="row gx-0 justify-content-center">

        @foreach($blogs as $items)
            <div class="col-lg-3 col-md-6 col-sm-9">
                <div class="blog__post__item">
                    <div class="blog__post__thumb">
                        <a href="blog-details.html"><img src="{{asset($items->blog_image)}}" alt=""></a>
                        <div class="blog__post__tags">
                            <a href="blog.html">{{$items['category'] ['blog_category']}}</a>
                        </div>
                    </div>
                    <div class="blog__post__content">
                        <span class="date">{{Carbon\Carbon::parse($items->created_at)->diffForHumans()}}</span>
                        <h3 class="title"><a href="{{route('blog.details', $items->id)}}">{{$items->blog_title}}</a></h3>
                        <a href="{{route('blog.details', $items->id)}}" class="read__more">Read mORe</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="blog__button text-center">
            <a href="blog.html" class="btn">more blog</a>
        </div>
    </div>
</section>