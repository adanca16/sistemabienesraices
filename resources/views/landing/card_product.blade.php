 <div class="col-lg-3 col-md-6 d-flex">
          <div class="product-card w-100">

            @if($p->coverPhoto)
            <img
                class="card-img-top"
               id="mainImage" src="{{ $p->coverPhoto->publicUrl() }}" alt="{{ $p->title }}">
      @endif
            <div class="card-body">
              <div>
                <h5 class="card-title">{{$p->title}}</h5>
                <p class="card-text">
                {{$p->summary}}
                </p>
                <p class="price">₡{{number_format($p->price_crc,2)}}</p>
              </div>
              <a href="{{route('product-detail', $p->slug)}}" class="btn btn-secondary mt-auto">Detalles</a>
            </div>
          </div>
        </div>