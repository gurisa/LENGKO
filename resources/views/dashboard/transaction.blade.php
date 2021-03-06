@extends('layouts.dashboard')

@section('title', 'LENGKO - Transaksi')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-12">
          <input type="hidden" name="search_token" value="{{ csrf_token() }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Transaksi</div>
            <div class="panel-body">
              <div id="transaction-panel">
                @if (count($data['transaction']) > 0)

                <div class="row">
                  <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">
                    <div class="input-group padd-tb-10">
                      <input type="text" name="transaction-search-query" class="form-control input-lengko-default" placeholder="Cari Transaksi" />
                      <span class="input-group-btn">
                        <button class="btn btn-default" name="transaction-search-button" type="button">
                          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- copied here -->
                <div class="row">
                  <div class="col-md-3  text-center">
                    <i class="material-icons md-180 desktop-only">attach_money</i>
                    <h3 class="desktop-only mrg-t-0">Transaksi</h3>
                  </div>

                  <div class="col-md-9">

                    <div id="transaction-card-section" class="padd-tb-10">
                      <div class="row padd-lr-15">
                        <div class="col-md-5 col-sm-6 col-xs-6">
                          <i class="material-icons md-18">arrow_drop_down</i>
                          <label>Transaksi</label>
                        </div>
                        <div class="col-md-7 col-sm-6 col-xs-6">
                          <label>Waktu</label>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="seperator"></div>
                        </div>
                      </div>
                      @foreach ($data['transaction'] as $key1 => $value1)
                        <div onclick="show_obj('transaction-{{ $key1 }}');" class="cursor-pointer padd-tb-10 padd-lr-15">
                          <div class="row">
                            <div class="col-md-5 col-sm-6 col-xs-6">
                              #{{ $value1->kode_pesanan }} {{ $value1->pembeli_pesanan }}
                              [{{ $value1->nama_perangkat }}]
                            </div>
                            <div class="col-md-7 col-sm-6 col-xs-6">
                              {{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}
                            </div>
                          </div>

                        </div>
                        @if (count($data[$key1]['transaction-detail']) > 0)
                          <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                              <div id="transaction-{{ $key1 }}" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">
                                <table class="table table-hover table-striped">
                                  <tr>
                                    <th>Pesanan</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub-Total</th>
                                  </tr>
                                @foreach ($data[$key1]['transaction-detail'] as $key2 => $value2)
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
                                <tr>
                                  <td colspan="3" class="text-right"><label>Tunai</label></td>
                                  <td width="170px">
                                    <input type="number" id="transaction-cash-{{$value1->kode_pesanan}}" name="transaction-cash-{{$value1->kode_pesanan}}" min="{{$value1->harga_pesanan}}" step="5000" class="input-lengko-default block" placeholder="0" value="{{ $value1->harga_pesanan }}" onchange="cash_back('transaction-cash-{{$value1->kode_pesanan}}', 'transaction-cash-back-{{$value1->kode_pesanan}}', {{ $value1->harga_pesanan }}, 'Rp');" />
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="text-right"><label>Kembali</label></td>
                                  <td>
                                    <input type="text" id="transaction-cash-back-{{$value1->kode_pesanan}}" class="input-lengko-default block" value="0" disabled="disabled" disabled />
                                  </td>
                                </tr>
                                </table>
                                <div class="row padd-tb-10">
                                  <div class="col-md-offset-1 col-md-10 col-sm-offset-2 col-sm-8">
                                    <button type="button" class="btn-lengko btn-lengko-success pull-right block" onclick="done_transaction({{ $value1->kode_pesanan }}, {{$value1->harga_pesanan}});">
                                      <span class="glyphicon glyphicon-usd" aria-hidden="true"></span> Bayar
                                    </button>
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

                        <!-- print dialog -->
                        <div id="transaction-print-{{$value1->kode_pesanan}}" class="print-overlay" style="display:none; visibility: none;">
                          <div class="row print-overlay-content">
                            <div class="col-md-12">
                              <div class="row">
                                <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">
                                  <span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj('transaction-print-{{$value1->kode_pesanan}}'); window.location = '/dashboard/transaction/';"></span>
                                </div>
                              </div>

                              <div class="row mrg-t-20">
                                <div class="col-md-3">
                                  <h2>Transaksi #{{$value1->kode_pesanan}}</h2>
                                  <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                      <button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="print_dialog('transaction', {{$value1->kode_pesanan}});">
                                        <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                        Cetak
                                      </button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                      <a href="{{ url('/dashboard/transaction/report/' . $value1->kode_pesanan) }}" target="_blank">
                                        <button type="button" name="" class="btn-lengko btn-lengko-default block">
                                          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                          Lihat
                                        </button>
                                      </a>
                                    </div>
                                  </div>

                                </div>
                                <div class="col-md-9 mrg-t-20 fluidMedia">
                                  <iframe id="transaction-print" src="{{url('/dashboard/transaction/report/' . $value1->kode_pesanan)}}" width="100%" height="250px" scrolling="yes"></iframe>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                        <!-- print dialog -->

                      @endforeach
                    </div>

                  </div>
                </div>
                <!-- copied here -->

                @else
                  <div class="row">
                    <div class="col-md-8">
                      <div class="alert alert-warning">
                        Belum ada Transaksi baru, relax and be happy!
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>

        </div>
      </div> <!-- end -->

      <div class="row">
        <div class="col-md-12">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Catatan Transaksi</div>
            <div class="panel-body">
              @if (count($data['transaction-history']) > 0)

              <div class="row">
                <div class="col-md-offset-8 col-md-4 col-sm-offset-6 col-sm-6">
                  <div class="input-group padd-tb-10">
                    <input type="text" name="transaction-history-search-query" class="form-control input-lengko-default" placeholder="Cari Catatan Transaksi" />
                    <span class="input-group-btn">
                      <button class="btn btn-default" name="transaction-history-search-button" type="button">
                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                      </button>
                    </span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-9">

                  <div id="transaction-history-card-section" class="padd-tb-10">
                    <div class="row padd-lr-15">
                      <div class="col-md-5 col-sm-6 col-xs-6">
                        <i class="material-icons md-18">arrow_drop_down</i>
                        <label>Transaksi</label>
                      </div>
                      <div class="col-md-7 col-sm-6 col-xs-6">
                        <label>Waktu</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="seperator"></div>
                      </div>
                    </div>
                    @foreach ($data['transaction-history'] as $key1 => $value1)
                      <div onclick="show_obj('transaction-history-{{ $key1 }}');" class="cursor-pointer padd-tb-10 padd-lr-15">
                        <div class="row">
                          <div class="col-md-5 col-sm-6 col-xs-6">
                            #{{ $value1->kode_pesanan }} {{ $value1->pembeli_pesanan }}
                            [{{ $value1->nama_perangkat }}]
                          </div>
                          <div class="col-md-7 col-sm-6 col-xs-6">
                            {{ $value1->tanggal_pesanan }} {{ $value1->waktu_pesanan }}
                          </div>
                        </div>

                      </div>
                      @if (count($data[$key1]['transaction-history-detail']) > 0)
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div id="transaction-history-{{ $key1 }}" class="mrg-t-20 padd-lr-15" style="display:none; visibility: none;">
                              <table class="table table-hover table-striped stackable">
                                <tr>
                                  <th>Pesanan</th>
                                  <th>Harga</th>
                                  <th>Jumlah</th>
                                  <th>Sub-Total</th>
                                </tr>
                              @foreach ($data[$key1]['transaction-history-detail'] as $key2 => $value2)
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
                              <tr>
                                <td colspan="3" class="text-right"><label>Tunai</label></td>
                                <td width="170px">
                                  {{ $data['method']->num_to_rp($value1->tunai_pesanan) }}
                                </td>
                              </tr>
                              <tr>
                                <td colspan="3" class="text-right"><label>Kembali</label></td>
                                <td width="170px">
                                  {{ $data['method']->num_to_rp($value1->tunai_pesanan - $value1->harga_pesanan) }}
                                </td>
                              </tr>
                              </table>
                              <div class="row padd-tb-10">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                  <button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="show_obj('transaction-history-print-{{$value1->kode_pesanan}}');">
                                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                    Cetak
                                  </button>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                  <a href="{{ url('/dashboard/transaction/report/' . $value1->kode_pesanan) }}" target="_blank">
                                    <button type="button" name="" class="btn-lengko btn-lengko-default block">
                                      <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                      Lihat
                                    </button>
                                  </a>
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

                      <!-- print dialog -->
                      <div id="transaction-history-print-{{$value1->kode_pesanan}}" class="print-overlay" style="display:none; visibility: none;">
                        <div class="row print-overlay-content">
                          <div class="col-md-12">
                            <div class="row">
                              <div class="col-md-offset-11 col-md-1" style="font-size:20pt;">
                                <span class="glyphicon glyphicon-remove pull-right cursor-pointer" aria-hidden="true" onclick="hide_obj('transaction-history-print-{{$value1->kode_pesanan}}');"></span>
                              </div>
                            </div>

                            <div class="row mrg-t-20">
                              <div class="col-md-3">
                                <h2>Transaksi #{{$value1->kode_pesanan}}</h2>
                                <div class="row">
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <button type="button" name="" class="btn-lengko btn-lengko-warning block" onclick="print_dialog('transaction-history', {{$value1->kode_pesanan}});">
                                      <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                                      Cetak
                                    </button>
                                  </div>
                                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <a href="{{ url('/dashboard/transaction/report/' . $value1->kode_pesanan) }}" target="_blank">
                                      <button type="button" name="" class="btn-lengko btn-lengko-default block">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                        Lihat
                                      </button>
                                    </a>
                                  </div>
                                </div>

                              </div>
                              <div class="col-md-9 mrg-t-20 fluidMedia">
                                <iframe id="transaction-history-print" src="{{url('/dashboard/transaction/report/' . $value1->kode_pesanan)}}" width="100%" height="250px" scrolling="yes"></iframe>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                      <!-- print dialog -->

                    @endforeach
                  </div>

                </div>
                <div class="col-md-3  text-center">
                  <i class="material-icons md-180 desktop-only">history</i>
                  <h3 class="desktop-only mrg-t-0">Catatan Transaksi</h3>
                </div>
              </div>

              @else
                <div class="row">
                  <div class="col-md-8">
                    <div class="alert alert-warning">
                      Belum ada Catatan Transaksi, relax and be happy!
                    </div>
                  </div>
                </div>
              @endif

            </div>
          </div>

        </div>
      </div> <!-- end -->

    </div>
  </div>

@endsection
