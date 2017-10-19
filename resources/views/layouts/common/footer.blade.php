<footer class="footer_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer_top_link text-center">
                    <a href="#">VER RECURSOS</a>
                    <a href="#">CAPACITACIÓN</a>
                </div>
            </div>
            @foreach($categoriesCollections as $catColl)
            <div class="col-md-3">
                <div class="footer_content">
                    <h2><span><img src="{{asset('images/social-4.png')}}" alt=""></span>{{$catColl->label}}</h2>
                    <ul>
                        @foreach($catColl->collections as $collection)
                        <li><a href="{{url($collection->slug)}}">{{$collection->label}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <p>ParaLideres.org © 2014 | Términos | Privacidad | Todos los derechos reservados</p>
</footer>