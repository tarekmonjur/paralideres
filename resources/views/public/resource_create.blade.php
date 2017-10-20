@extends('layouts.layout')
@section('content')

<div class="login_content create_resourse" id="app">
    <h2>Crear un Recurso - Paso 1 de 3 <br> <span>Completa los siguientes campos y da Click en Continuar </span></h2>
    <div class="clearfix">
        <form action="#">
            <div class="input_content clearfix">
                <label>TITULO RECURSO</label>
                <input type="text" name="title" placeholder="Escribe algo aquí...">
            </div>
            <div class="input_content clearfix">
                <label>RESEÑA O RESUME</label>
                <textarea name="review" id="" cols="30" rows="10" placeholder=""></textarea>
            </div>
            <div class="input_content clearfix">
                <label>CATEGORIA</label>
                <select name="category_id">
                    <option value="">...SELECT CATEGORIA...</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->label}}</option>
                    @endforeach
                </select>
            </div>
            <div class="input_content clearfix">
                <label>ETIQUETAS</label>
                <select id="select2" multiple name="tags">
                    <option value="">...SELECT ETIQUETAS...</option>
                    @foreach($tags as $tag)
                        <option value="{{$tag->id}}">{{$tag->label}}</option>
                    @endforeach
                </select>
            </div>
            <button class="resource_2">Continuar</button>
            <button class="resource_1">Cancelar</button>

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