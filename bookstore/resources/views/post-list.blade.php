@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-12 col-lg-9">
                @foreach($news as $post)
                    <div class="spost clearfix">
                        <div class="entry-image e-img">
                            <a href="{{ route('posts_detail', $post->slug) }}" class="nobg a-circle">
                                <img class="img-circle-custom" src="{{ url('assets/upload/' . data_get($post, 'img')) }}"
                                     alt="Mua phụ kiện theo Combo giảm đến 30%">
                            </a>
                        </div>
                        <div class="entry-c">
                            <div class="entry-title e-title">
                                <h4>
                                    <a href="{{ route('posts_detail', $post->slug) }}">{{ $post->title }}</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-lg-3">
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection



