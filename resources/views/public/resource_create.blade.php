@extends('layouts.layout')
@section('content')

<div class="login_content create_resourse" id="app">
    <h2>Crear un Recurso - Paso 1 de 3 <br> <span>Completa los siguientes campos y da Click en Continuar </span></h2>
    <div class="login_inner clearfix">
        <form action="#" v-on:submit.prevent="createResource">
            <div class="input_content clearfix" :class="{'has-error':errors.title}">
                <label>TITULO RECURSO</label>
                <input type="text" name="title" placeholder="Escribe algo aquí...">
                <span v-if="errors.title" class="has-error" v-text="errors.title[0]"></span>
            </div>
            <div class="input_content clearfix" :class="{'has-error':errors.review}">
                <label>RESEÑA O RESUME</label>
                <textarea name="review" id="" cols="30" rows="10" placeholder=""></textarea>
                <span v-if="errors.review" class="has-error" v-text="errors.review[0]"></span>
            </div>
            <div class="input_content clearfix" :class="{'has-error':errors.category_id}">
                <label>CATEGORIA</label>
                <select name="category_id">
                    <option value="">...SELECT CATEGORIA...</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->label}}</option>
                    @endforeach
                </select>
                <span v-if="errors.category_id" class="has-error" v-text="errors.category_id[0]"></span>
            </div>
            <div class="input_content clearfix">
                <label>ETIQUETAS</label>
                <select id="select2" multiple name="tag_id">
                    <option value="">...SELECT ETIQUETAS...</option>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->label}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="resource_2">Continuar</button>
            <button type="reset" class="resource_1">Cancelar</button>

        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $('#select2').select2();
        });
    </script>
    <script type="text/javascript" src="{{asset('js/resource_create.js')}}"></script>
@endsection