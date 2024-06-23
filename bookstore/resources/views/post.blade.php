@extends('layouts.app')

@section('content')

    <div class="wrapper-row pd-page py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="content-page">
                        <div class="article-content">
                            <div class="box-article-heading clearfix">
                                <div class="background-img">
                                    <img src="{{ url('assets/upload/' . data_get($post, 'img')) }}" alt="vinabook">
                                </div>
                                <h1 class="sb-title-article">{{ $post->title }}</h1>
                                <ul class="article-info-more">
                                    <li> Người viết: {{ $post->author }} <time pubdate="" datetime="{{ date('d.m.Y', strtotime($post->created_at)) }}">{{ date('d.m.Y', strtotime($post->created_at)) }}</time></li>
                                </ul>
                            </div>
                            <div class="article-pages"> <p>{{ data_get($post, 'description') }}</p><div>&nbsp;</div></div>
                            <div class="article-pages"> <p>{!! data_get($post, 'content') !!}</p><div>&nbsp;</div></div>
                            <div class="post-navigation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="sidebar-blog">
                        <div class="news-latest sidebar-block">
                            <div class="sidebar-title title_block">
                                <h3>Bài viết mới nhất<span class="fal fa-angle-down"></span></h3>
                            </div>
                            <div class="list-news-latest layered">
                                @foreach($news as $post)
                                    <div class="item-article clearfix">
                                        <div class="post-image">
                                            <a href="{{ route('posts_detail', $post->slug) }}"><img
                                                    src="{{ url('assets/upload/' . data_get($post, 'img')) }}"
                                                    alt="book"/></a>
                                        </div>
                                        <div class="post-content">
                                            <h3>
                                                <a href="{{ route('posts_detail', $post->slug) }}">{{ $post->title }}</a>
                                            </h3>
                                            <span class="date">{{ date('d.m.Y', strtotime($post->created_at)) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
{{--                        <div class="menu-blog sidebar-block">--}}
{{--                            <div class="group-menu">--}}
{{--                                <div class="sidebar-title title_block">--}}
{{--                                    <h3>Tin tức<span class="fal fa-angle-down"></span></h3>--}}
{{--                                </div>--}}
{{--                                <div class="layered layered-category">--}}
{{--                                    <div class="layered-content">--}}
{{--                                        <ul class="tree-menu">--}}
{{--                                        </ul>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




