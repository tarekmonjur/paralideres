@extends('layouts.layout')
@section('content')
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-559b5a0c386679ae" async="async"></script>
<div id="app">
<!-- =========================
        START BANNER SECTION
============================== -->

<section class="recurso_content_area form_hide_m">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="recurso_main_content">
                    <div class="author_head">
                        <span>
                            @if($resource->user->image)
                                <img class="img-circle" src="{{asset('uploads/'.$resource->user->image)}}" alt="" width="50px">
                            @else
                                <img class="img-circle" src="{{asset('images/user.png')}}" alt="" width="50px">
                            @endif
                            <img src="{{asset('images/icon-14.jpg')}}" alt="">{{$resource->title}}
                        </span>
                        <span>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><img src="{{asset('images/icon-2.png')}}" alt=""></button>
                                <ul class="dropdown-menu addthis_toolbox">
                                    <li><a class="addthis_button_email" style="margin-left: 0px"> Goolge</a></li>
                                    <li><a class="addthis_button_facebook" style="margin-left: 0px"> Facebook</a></li>
                                    <li><a class="addthis_button_twitter" style="margin-left: 0px"> Twitter</a></li>
                              </ul>
                            </div>
                            @if($auth)
                                <a href="#" :class="{'love_red_bg':userLike}" v-on:click.prevent="givenResourceLike('{{$resource->id}}')">
                                    <img v-if="userLike" src="{{asset('images/love-red.png')}}" alt="">
                                    <img v-else src="{{asset('images/love2.png')}}" alt="">
                                </a>
                            @else
                                <a href="{{url('/ingreser?redirect=resource&slug='.$resource->slug)}}"><img src="{{asset('images/love2.png')}}" alt=""></a>
                            @endif
                            <a href="#"><img src="{{asset('images/icon-3.png')}}" alt=""></a>
                        </span>
                    </div>
                    <div class="author_desc">
                        <h2>RESUMEN</h2>
                        <p>{{$resource->review}}</p>
                        @if($resource->attachment)
                        <h3>
                            @if($auth)
                                <span><a href="{{url('recursos/'.$resource->slug.'/download')}}">Descargar Recurso</a> ( {{$resource->downloads->count()}} )</span>
                            @else
                                <span>Descargar Recurso</span>
                                Para descargar este recurso debes estar registrado en nuestro portal
                                <a href="{{url('registrarme')}}">Registrate es fácil!</a>
                            @endif
                        </h3>
                        @endif
                    </div>
                    <div class="author_contect_wrapper">
                        @if($resource->attachment)
                        <div class="author_contect">
                            <div class="author_contect_inner">
                                <h2>{{$resource->title}}</h2>
                                <iframe src="https://drive.google.com/viewerng/viewer?url={{$resource->attachment}}?pid=explorer&efh=false&a=v&chrome=false&embedded=true" style="width:100%; height:770px">
                                </iframe>
                            </div>
                        </div>
                        @else
                            <div class="author_contect_inner">
                                <h2>{{$resource->title}}</h2>
                                <h3></h3>
                                <p>{!! $resource->content !!}</p>
                            </div>
                        @endif
                    </div>
                    <div class="author_bottom">
                        <h4>Encuentra <span>recursos similares</span>  a este haciendo click en cualquiera de las siguientes <span> etiquetas</span></h4>
                        @foreach($resource->tags as $tag)
                        <a href="{{url('recursos?tag='.$tag->slug)}}">{{$tag->label}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar text-right">
                    <h2>modulo de publicidad</h2>
                    <img src="{{asset('images/sidebar-img.png')}}" alt="" class="img-responsive">
                    <h2>crea tu equipo de trabajo hoy</h2>
                    <img src="{{asset('images/sidebar-img.png')}}" alt="" class="img-responsive">
                    <h2>ENCUESTA DE LA SEMANA</h2>
                    <img src="{{asset('images/sidebar-img.png')}}" alt="" class="img-responsive">
                    <div class="sidebar_content">
                        <h2>ULTIMOS RECURSOS AGREGADOS</h2>
                        @foreach($latestResources as $latestResource)
                        <h3>{{$latestResource->category->label}}</h3>
                        <p><a href="{{url('recursos/'.$latestResource->slug)}}">{{$latestResource->title}} </a><br> Agregado el {{$latestResource->created_at->format('d M Y')}}</span> </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="recurso_content_area form_hide_d">
    <div class="container">
        <div class="row">
            <div class="col-md-12 no-padding">
                <div class="recurso_main_content">
                    <div class="author_head_m">
                        <span></span>
                        <h3>{{$resource->title}}</h3>
                        <p>AUTOR: {{$resource->user->fullname}} / <span>PUBLICADO: @if($resource->user->created_at){{$resource->user->created_at->format('d M Y')}}@endif</span> </p>
                    </div>
                    <div class="author_desc author_desc_m">
                        <p>{{$resource->review}}</p>
                    </div>
                    <div class="author_head author_head_m_2">
                        <span></span>
                        <span>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><img src="{{asset('images/icon-2.png')}}" alt=""></button>
                                <ul class="dropdown-menu addthis_toolbox">
                                    <li><a  class="addthis_button_email">Goolge</a></li>
                                    <li><a  class="addthis_button_facebook">Facebook</a></li>
                                    <li><a  class="addthis_button_twitter">Twitter</a></li>
                              </ul>
                            </div>
                            @if($auth)
                                <a href="#" :class="{'love_red_bg':userLike}" v-on:click.prevent="givenResourceLike('{{$resource->id}}')">
                                    <img v-if="userLike" src="{{asset('images/love-red.png')}}" alt="">
                                    <img v-else src="{{asset('images/love2.png')}}" alt="">
                                </a>
                            @else
                                <a href="{{url('/ingreser?redirect=resource&slug='.$resource->slug)}}"><img src="{{asset('images/love2.png')}}" alt=""></a>
                            @endif
                            <a href="#"><img src="{{asset('images/icon-3.png')}}" alt=""></a>
                        </span>
                    </div>
                    <div class="author_contect">
                        @if($resource->attachment)
                            <div class="author_contect">
                                <div class="author_contect_inner">
                                    <h2>{{$resource->title}}</h2>
                                    <iframe src="https://drive.google.com/viewerng/viewer?url={{$resource->attachment}}?pid=explorer&efh=false&a=v&chrome=false&embedded=true" style="width:100%; height:770px">
                                    </iframe>
                                </div>
                            </div>
                        @else
                            <div class="author_contect_inner">
                                <h2>{{$resource->title}}</h2>
                                <h3></h3>
                                <p>{!! $resource->content !!}</p>
                            </div>
                        @endif
                    </div>
                    <div class="author_desc">
                        @if($resource->attachment)
                        <h3>
                            @if($auth)
                                <span><a href="{{url('recursos/'.$resource->slug.'/download')}}">Descargar Recurso</a> ( {{$resource->downloads->count()}} ) </span>
                            @else
                                <span>Descargar Recurso</span>
                            @endif
                        </h3>
                        @endif
                        </h3>
                    </div>
                    <div class="author_bottom">
                        <h4>Encuentra <span>recursos similares</span>  a este haciendo click en cualquiera de las siguientes <span> etiquetas</span>
                            @if(!$auth)<a href="{{url('registrarme')}}">Registrate es fácil!</a>@endif
                        </h4>
                        @foreach($resource->tags as $tag)
                            <a href="{{url('recursos?tag='.$tag->slug)}}">{{$tag->label}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========================
    END BANNER SECTION
============================== -->


<!-- =========================
    START OPTION SECTION
============================== -->
<section class="option_area form_hide_m">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="option_head text-center">
                    <h2>otros recursos</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="blog_content">
        <div class="container">
            <div class="row">
                @foreach($resource->category->resources as $otherResource)
                <div class="col-md-3">
                    <div class="blog_content_inner">
                        <h2><a href="{{url('recursos/'.$otherResource->slug)}}">{{$otherResource->title}}</a></h2>
                        <span>PUBLICADO {{$otherResource->created_at->format('d M Y')}}</span>
                        <h3>AUTOR: {{$otherResource->user->fullname}} <br>
                            @if($otherResource->user->created_at){{$otherResource->user->created_at->format('d M Y')}}@endif
                        </h3>
                        <p>{{$otherResource->review}}</p>
                        <img src="{{asset('images/icon-1.jpg')}}" alt="">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<section class="option_area form_hide_d">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="option_head text-center">
                    <h2>similares</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="blog_content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div id="test_slider" class="owl-carousel owl-theme">
                        @foreach($resource->category->resources as $otherResource)
                        <div class="blog_content_inner">
                            <h2><a href="{{url('recursos/'.$otherResource->slug)}}">{{$otherResource->title}}</a></h2>
                            <span>PUBLICADO {{$otherResource->created_at->format('d M Y')}}</span>
                            <h3>AUTOR: {{$otherResource->user->fullname}} <br> @if($otherResource->user->created_at){{$otherResource->user->created_at->format('d M Y')}}@endif</h3>
                            <p>{{$otherResource->review}}</p>
                            <img src="{{asset('images/cursoarrow.jpg')}}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- =========================
    END OPTION SECTION
============================== -->
</div>
@endsection

@section('scripts')
    <script>
        var userLike = '<?php if(count($resource->like)>0){echo true;}else{false;}?>';
    </script>
    <script type="text/javascript" src="{{asset('js/resource.js')}}"></script>
@endsection









