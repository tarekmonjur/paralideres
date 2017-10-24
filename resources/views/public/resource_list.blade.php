@extends('layouts.layout')
@section('content')

<section class="service_area recurso_list" id="app">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="recurso_filter clearfix">
                    <h2> Resultado de Busqueda  para:  <span></span></h2>
                    <form id="filterResource" v-on:submit.prevent="filterResource">
                        <span class="num" v-if="resources.data && resources.data.length > 0" v-text="resources.total+' Recursos'"></span>
                        <span class="num" v-else> 0 Recursos</span>
                        <span>
                                POR ORIGEN
                                <select name="origin">
                                  <option value="volvo">filter</option>
                                  <option value="saab">Saab</option>
                                  <option value="mercedes">Mer</option>
                                  <option value="audi">Audi</option>
                                </select>
                            </span>
                        <span>
                                POR CATEGORIA
                                <select name="category_id" v-on:change="filterResource">
                                  <option value="">..filter..</option>
                                  @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->label}}</option>
                                  @endforeach
                                </select>
                            </span>
                        <span class="recurso_btn">
                                PALABRA CLAVE
                                <input type="text" name="search_text" v-on:keyup="filterResource" placeholder="Escribe algo aquí...">
                                <button v-on:click.prevent="filterResource">FILTRAR</button>
                            </span>
                    </form>
                </div>
            </div>
            <div class="col-md-4" v-for="(resource_info, index) in resources.data">
                <div class="service_inner">
                    <div class="service_head">
                        <h2>
                            <img :src="base_url+'images/icon-1.jpg'" alt="">
                            <span v-if="resource_info.category" v-text="resource_info.category.label"></span>
                        </h2>
                    </div>
                    <h4><a :href="base_url+'recursos/'+resource_info.slug">@{{ resource_info.title | truncate(30) }}</a></h4>
                    <p>@{{ resource_info.review | truncate(100) }}</p>
                    <div class="author">
                        <h3>
                            <img width="45px" class="img-circle" v-if="resource_info.user.image" :src="base_url+'uploads/'+resource_info.user.image" alt="">
                            <img width="45px" class="img-circle" v-else :src="base_url+'images/user.png'" alt="">
                            author: <span v-text="resource_info.user.fullname"></span>
                        </h3>
                    </div>
                    <div class="comment">
                        <span><img :src="base_url+'images/share.png'" alt="">Compartir Recurso</span>
                        <span style="cursor: pointer" @if($auth) v-on:click.prevent="givenResourceLike(resource_info)" @else onclick="window.location.href='ingreser?redirect=resource_list'" @endif>
                            <span v-if="resource_info.likes_count.length > 0" v-text="resource_info.likes_count[0].total"></span>
                            <span v-else>0</span>
                            <img v-if="resource_info.like.length > 0" :src="base_url+'images/love3.png'" alt="">
                            <img v-else :src="base_url+'images/love.jpg'" alt="">
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 clearfix text-center">
                <div class="service_btn" v-if="resources.data && resources.data.length > 0">
                    <a href="#" v-if="resources.next_page_url" v-on:click.prevent="getNextResources(resources.next_page_url)">ver mus recursus</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/resource_list.js')}}"></script>
@endsection









