@extends('layouts.layout')
@section('content')

<section class="service_area recurso_list">
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="recurso_filter clearfix">
                    <h2> Resultado de Busqueda  para:  Test</h2>
                    <form action="">
                        <span class="num" v-if="resources.data.length > 0" v-text="resources.total+' Recursos'"></span>
                        <span>
                                POR ORIGEN
                                <select>
                                  <option value="volvo">filter</option>
                                  <option value="saab">Saab</option>
                                  <option value="mercedes">Mer</option>
                                  <option value="audi">Audi</option>
                                </select>
                            </span>
                        <span>
                                POR CATEGORIA
                                <select>
                                  <option value="volvo">filter</option>
                                  <option value="saab">Saab</option>
                                  <option value="mercedes">Mer</option>
                                  <option value="audi">Audi</option>
                                </select>
                            </span>
                        <span class="recurso_btn">
                                PALABRA CLAVE
                                <input type="text" placeholder="Escribe algo aquí...">
                                <button>FILTRAR</button>
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
                    <p>@{{ resource_info.content | truncate(100) }}</p>
                    <div class="author">
                        <h3>
                            <img width="45px" class="img-circle" v-if="resource_info.user.image" :src="base_url+'uploads/'+resource_info.user.image" alt="">
                            <img width="45px" class="img-circle" v-else :src="base_url+'images/user.png'" alt="">
                            author: <span v-text="resource_info.user.fullname"></span>
                        </h3>
                    </div>
                    <div class="comment">
                        <span><img :src="base_url+'images/share.png'" alt="">Compartir Recurso</span>
                        <span style="cursor: pointer" @if($auth) v-on:click.prevent="givenResourceLike(resource_info)" @else onclick="window.location.href='ingreser'" @endif>
                            <span v-if="resource_info.likes_count.length > 0" v-text="resource_info.likes_count[0].total"></span>
                            <span v-else>0</span>
                            <img v-if="resource_info.like.length > 0" :src="base_url+'images/love3.png'" alt="">
                            <img v-else :src="base_url+'images/love.jpg'" alt="">
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-12 clearfix text-center">
                <div class="service_btn">
                    <a href="#" v-if="resources.next_page_url" v-on:click.prevent="getNextResources(resources.next_page_url)">ver mus recursus</a>
                    <a href="#" v-else v-on:click.prevent="getNextResources(resources.prev_page_url)">ver mus recursus</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{asset('js/resource_list.js')}}"></script>
@endsection









