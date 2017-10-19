<header class="header_area">
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('images/logo.png')}}" alt=""></a>
            </div>
            <div class="filter">
                <div class="filter_content">
                    <select>
                        <option value="volvo">filter</option>
                        <option value="saab">Saab</option>
                        <option value="mercedes">Mer</option>
                        <option value="audi">Audi</option>
                    </select>
                    <form action="#">
                        <input type="text" name="googlesearch" placeholder="Buscador de Recursos">
                        <input type="submit" id="searchsubmit" value="Search">
                    </form>
                </div>
                @if($auth)
                    <a href="{{url('salir')}}">salir</a>
                @else
                    <a href="{{url('/')}}">Registrarse</a>
                @endif
            </div>
        </div><!-- /.container-fluid -->
    </nav>
</header>