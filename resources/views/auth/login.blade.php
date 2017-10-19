@extends('layouts.layout')
@section('content')

<div class="login_content">
    <div class="login_inner">
        <h2>Ingresa a Paralideres.org</h2>
        <form id="login_form" v-on:submit.prevent="login('login_form','login')">
            <div class="input_content clearfix" :class="{'has-error':errors.email}">
                <label>USUARIO</label>
                <input type="text" name="email" v-on:keyup="login('login_form','')" placeholder="USUARIO">
                <span v-if="errors.email" class="has-error" v-text="errors.email[0]"></span>
            </div>
            <div class="input_content" :class="{'has-error':errors.password}">
                <label>CONTRASEÑA</label>
                <input type="password" name="password" v-on:keyup="login('login_form','')" placeholder="CONTRASEÑA">
                <span v-if="errors.password" class="has-error" v-text="errors.password[0]"></span>
            </div>
            <p>Olvide mi contrasena</p>
            <button type="submit" :disabled="submitDisable">Ingresar</button>
            <span>No tengo cuenta en Paralideres.org, <a href="{{url('/')}}">Registrarme</a></span>

        </form>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('js/auth.js')}}"></script>
@endsection