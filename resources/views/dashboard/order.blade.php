@extends('layouts.dashboard')

@section('title', 'LENGKO - Pesanan')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">
      @if ($auth == 'root' || $auth == 'waiter')
      <div class="row">
        <div class="col-md-12">
          <input type="hidden" name="search_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Konfirmasi Pesanan</div>
            <div class="panel-body">
              <div id="order-confirmation-panel">
                @if (count($data['order-confirmation']) > 0)
                  <div class="row">
                    <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">
                      <div class="input-group">
                        <input type="text" name="order-search-query" class="form-control input-lengko-default" placeholder="Cari Pesanan" />
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                          </button>
                        </span>
                      </div>
                    </div>
                  </div>

                  <!-- copied here -->
                  <div class="row">
                    <div class="col-md-12">

                      <div id="order-card-section" class="padd-tb-10">
                        <div class="row padd-lr-15 open-tooltip" data-placement="bottom" data-toggle="tooltip" title="Klik untuk melihat detil pesanan">
                          <div class="col-md-3 col-sm-3 col-xs-3">
                            <label>Transaksi</label>
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                            <label>Waktu</label>
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                            <label>Catatan</label>
                          </div>
                          <div class="col-md-3 col-sm-3 col-xs-3">
                            <label>Perangkat</label>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="seperator"></div>
                          </div>
                        </div>

                        @foreach ($data['order-confirmation'] as $key1 => $value1)
                          <div onclick="show_obj('order-confirmation-{{ $key1 }}');" class="row cursor-pointer padd-tb-10 padd-lr-15">
                            <div class="col-md-3 col-sm-3 col-xs-3">
                              [#{{ $value1->kode_pesanan }}] {{ $value1->pembeli_pesanan }}
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                              {{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                              {{ $value1->catatan_pesanan }}
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-3">
                              {{ $value1->nama_perangkat }}
                            </div>
                          </div>
                          @if (count($data[$key1]['order-confirmation-detail']) > 0)
                            <div class="row">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="order-confirmation-{{ $key1 }}" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">
                                  <table class="table table-hover table-striped">
                                    <tr>
                                      <th>Pesanan</th>
                                      <th>Harga</th>
                                      <th>Jumlah</th>
                                      <th>Sub-Total</th>
                                    </tr>
                                    @foreach ($data[$key1]['order-confirmation-detail'] as $key2 => $value2)
                                      <tr>
                                        <td>{{ $value2->nama_menu }}</td>
                                        <td>{{ $data['method']->num_to_rp($value2->harga_menu) }}</td>
                                        <td>{{ $value2->jumlah_pesanan_detil }}</td>
                                        <td>{{ $data['method']->num_to_rp($value2->harga_menu * $value2->jumlah_pesanan_detil) }}</td>
                                      </tr>
                                    @endforeach
                                    <tr>
                                      <td colspan="3" class="text-right"><label>Total</label></td>
                                      <td>{{ $data['method']->num_to_rp($value1->harga_pesanan) }}</td>
                                    </tr>
                                  </table>
                                  <div class="row">
                                    <div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 col-xs-12 padd-tb-10 padd-lr-15">
                                      <form name="" action="{{ url('/dashboard/confirm/order') }}" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="order-confirm-id" value="{{$value1->kode_pesanan}}" />
                                        <button type="submit" class="btn-lengko btn-lengko-success block" width="80px">
                                          <i class="material-icons md-18">done_all</i> Konfirmasi Pesanan
                                        </button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          @endif
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="seperator"></div>
                            </div>
                          </div>
                        @endforeach

                      </div>
                    <hr />
                    </div>
                  </div>
                  <!-- copied here -->
                @else
                  <div class="row">
                    <div class="col-md-4">
                      <img src="{{ url('/files/images/jokes/patrick-skripsi.png') }}" width="250px" height="250px" />
                    </div>
                    <div class="col-md-8">
                      <div class="alert alert-warning">
                        Belum ada pesanan baru;
                        <br />
                        Relax and enjoy yourlife!
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>

        </div>
      </div>
      @endif
      @if ($auth == 'root' || $auth == 'chef')
      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Antrian Pesanan</div>
            <div class="panel-body scrollable scrollable-@if(count($data['order']) > 2){{'xl'}}@else{{'lg'}}@endif">
              <div id="order-queue-panel">

                @if (count($data['order']) > 0)
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach ($data['order'] as $key => $value)
                      <div class="panel panel-default @if ($key == 0) {{'panel-custom'}} @endif">

                        <div class="panel-heading" role="tab" id="head-order-{{$value->kode_pesanan}}" style="height: 50px;">
                          <h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#order-{{$value->kode_pesanan}}" aria-expanded="true" aria-controls="order-{{$value->kode_pesanan}}"  style="height: 50px;">
                            #{{ $value->kode_pesanan }}
                            [{{ $value->nama_perangkat }}]
                          </h4>
                        </div>

                        <div id="order-{{$value->kode_pesanan}}" class="panel-collapse collapse @if($key == 0) {{'in'}}@endif" role="tabpanel" aria-labelledby="head-order-{{$value->kode_pesanan}}">
                          <div class="panel-body">
                            <div class="@if ($key > 0) {{'overlay'}} @endif">
                              <div class="row">
                                <div class="col-md-12">
                                  <h3 class="text-center">
                                    #{{ $value->kode_pesanan }}
                                    ({{ $value->nama_perangkat }})
                                  </h3>
                                  <hr />
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                  <label>Waktu:</label> <br />
                                  {{ $value->tanggal_pesanan }} {{ $value->waktu_pesanan }}
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-6">
                                  <label>Catatan:</label>
                                  <br />
                                  {{ $data['method']->rewrite('status', $value->catatan_pesanan) }}
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">

                                  <button type="button" class="btn-lengko btn-lengko-success block" onclick="done_order({{$value->kode_pesanan}});" title="Tandai sudah selesai semua">
                                    <i class="material-icons md-18">done_all</i> Selesai semua
                                  </button>
                                </div>
                              </div>

                              <div class="row padd-tb-0">
                                <div class="col-md-12">
                                  <hr />
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-6 col-sm-6">

                                  <div class="row">
                                    <div class="col-md-offset-4 col-md-4">
                                      <h3 class="text-center border-btm">Makanan</h3>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      @if (count($data[$key]['order-detail-food']) > 0)
                                        @foreach ($data[$key]['order-detail-food'] as $key2 => $value2)
                                          @if ($value2->kode_pesanan == $value2->kode_pesanan)
                                            <div class="row padd-tb-10">
                                              <div class="col-md-9 col-sm-9">
                                                {{ $value2->nama_menu }} ({{ $value2->jumlah_pesanan_detil }})
                                              </div>
                                              <div class="col-md-3 col-sm-3">
                                                @if ($value2->status_pesanan_detil == 'P')
                                                  <button type="button" class="btn-lengko btn-lengko-success block" onclick="done_menu({{$value2->kode_pesanan_detil}})" style="font-size: 10px;">
                                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                  </button>
                                                @elseif ($value2->status_pesanan_detil == 'D')
                                                  <button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                  </button>
                                                @endif
                                              </div>
                                            </div>

                                          @endif
                                        @endforeach
                                      @else
                                        <div class="row">
                                          <div class="col-md-12">
                                            <div class="alert alert-warning">
                                              Tidak pesan makanan
                                            </div>
                                          </div>
                                        </div>
                                      @endif
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                  <div class="row">
                                    <div class="col-md-offset-4 col-md-4">
                                      <h3 class="text-center border-btm">Minuman</h3>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                      @if (count($data[$key]['order-detail-drink']) > 0)
                                        @foreach ($data[$key]['order-detail-drink'] as $key3 => $value3)
                                          @if ($value3->kode_pesanan == $value3->kode_pesanan)
                                            <div class="row padd-tb-10">
                                              <div class="col-md-9 col-sm-9">
                                                {{ $value3->nama_menu }} ({{ $value3->jumlah_pesanan_detil }})
                                              </div>
                                              <div class="col-md-3 col-sm-3">
                                                @if ($value3->status_pesanan_detil == 'P')
                                                  <button type="button" class="btn-lengko btn-lengko-success block" onclick="done_menu({{$value3->kode_pesanan_detil}})" style="font-size: 10px;">
                                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                                  </button>
                                                @elseif ($value3->status_pesanan_detil == 'D')
                                                  <button type="button" class="btn-lengko btn-lengko-warning block" style="font-size: 10px;">
                                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                  </button>
                                                @endif
                                              </div>
                                            </div>

                                          @endif
                                        @endforeach
                                      @else
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="alert alert-warning">
                                            Tidak pesan minuman
                                          </div>
                                        </div>
                                      </div>
                                      @endif
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row padd-tb-0">
                                <div class="col-md-12">
                                  <hr />
                                </div>
                              </div>

                            </div><!--overlay -->

                          </div>
                        </div>

                      </div>
                    @endforeach
                  </div>
                @else
                  <div class="row">
                    <div class="col-md-8">
                      <div class="alert alert-warning">
                        Belum ada pesanan baru;
                        <br />
                        Relax and enjoy yourlife!
                      </div>
                    </div>
                    <div class="col-md-4">
                      <img src="{{ url('/files/images/jokes/i-see-what-u-did.jpg') }}" width="250px" height="250px" />
                    </div>
                  </div>
                @endif

              </div> <!-- end queue panel -->
            </div> <!-- end body -->
          </div> <!-- end panel -->

        </div>
      </div> <!-- end -->
      @endif
    </div>

  </div>

@endsection
