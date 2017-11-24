@extends('layouts.main')

@section('title', 'LENGKO - Menu')

@section('content')

  <div class="container-fluid">
    @if (count($data['menu']) > 0)
    <div class="row mrg-b-30">
      @foreach ($data['menu'] as $key => $value)
        <div class="col-md-4 col-sm-6">
          <div class="menu">
            <img src="/files/images/menus/@if($value->gambar_menu){{$value->gambar_menu}}@else{{'not-available.png'}}@endif" alt="{{ $value->nama_menu }}" width="100%" height="150px" />
            <h2 class="menu-title">{{ $value->nama_menu }}</h2>
            {{ $data['menu_obj']->num_to_rp($value->harga_menu) }}
            <a href="{{ url('/') }}" class="pull-right"><i class="material-icons">add_shopping_cart</i></a>
            <br />
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-sm-12 col-md-push-4 col-md-4">
        <nav aria-label="Page navigation" class="text-center">
          <ul class="pagination pagination-lg">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li>
              <a href="#">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
              </a>
            </li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  @else
    <div class="row mrg-b-30">
      <div class="col-md-12 col-xs-12 text-center" style="font-size: 24pt;">
        <h1>Oops, sepertinya terjadi sesuatu</h1>
        <br />
        <a href="{{url('/about/')}}"><img src="{{ url('/files/images/dino-walking.png') }}" alt="LENGKO" width="180px" height="120px" /></a>
        <br />
        <br />
        <a href="{{ url('/about/') }}">
          Dinosaurus jahat sudah memakan semuanya! <br />
          Kami butuh bantuan kamu untuk menghentikannya
        </a>
      </div>
    </div>
  @endif
  </div>

@endsection

@section('footer-section')
  @include('addition')
  @yield('footer-copyright')
@endsection
