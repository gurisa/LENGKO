@extends('layouts.dashboard')

@section('title', 'LENGKO - Dasbor')

@section('content')

  <div class="row mrg-b-20">
    <div class="col-md-12">

      <div class="row">
        <div class="col-md-8">

          <div class="panel panel-default panel-custom">
            <div class="panel-heading">Profil</div>
            <div class="panel-body">
              @if (count($errors) > 0)
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form class="" action="{{ url('/dashboard/update/profile/') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-3">
                    <div class="container-file-lengko block">
                      <img id="preview-profile" class="img-circle img-center" src="{{ url('/files/images/employee/') . '/' }}@if (file_exists(public_path('/files/images/employee/') . '/' . $data['employee']->gambar_pegawai)){{$data['employee']->gambar_pegawai}}@else{{'default.png'}}@endif" alt="" width="140px" height="140px" />
                      <input name="employee-photo" type="file" title="Ubah foto profil" onchange="reload_image(this, '#preview-profile');" />
                      <input type="hidden" name="employee-id" value="{{ $data['employee']->kode_pegawai }}">
                      <input type="hidden" name="_method" value="put">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>
                  </div>
                  <div class="col-md-9">
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Nama Pengguna</div>
                      <div class="col-md-8"><b>{{ $data['employee']->kode_pegawai }}</b></div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Nama Lengkap</div>
                      <div class="col-md-8">
                        <input type="text" id="employee-name" name="employee-name" class="input-lengko-default block" placeholder="Nama Lengkap" value="{{ $data['employee']->nama_pegawai }}" />
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Kata Sandi</div>
                      <div class="col-md-8">
                        <input type="password" id="employee-password" name="employee-password" class="input-lengko-default block" placeholder="*****" value="" />
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Jenis Kelamin</div>
                      <div class="col-md-8">
                        <div class="radio-lengko-default">
                          <input type="radio" name="employee-gender" id="gender-male" value="L" @if($data['employee']->jenis_kelamin_pegawai == "L") {{'checked="checked" checked'}} @endif /><label for="gender-male">Laki-Laki</label>
                          <input type="radio" name="employee-gender" id="gender-female" value="P" @if($data['employee']->jenis_kelamin_pegawai == "P") {{'checked="checked" checked'}} @endif /><label for="gender-female">Perempuan</label>
                        </div>
                      </div>
                    </div>
                    <div class="row mrg-b-10">
                      <div class="col-md-4">Otoritas</div>
                      <div class="col-md-8"><b>{{ $data['employee']->nama_otoritas }}</b></div>
                    </div>
                    <button type="submit" class="btn-lengko btn-lengko-default pull-right">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
        <div class="col-md-4">
          <!-- future reserved -->
        </div>
      </div>

    </div>

  </div>

@endsection
