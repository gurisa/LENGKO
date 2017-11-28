<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Pengadaan;
use App\PengadaanDetil;
use App\BahanBaku;
use Hash;
use Validator;

class PengadaanController extends Controller {

  public function get($param) {
    $data = null;
    if ($param) {
      switch ($param) {
        case 'material':
          $data['material'] = DB::table('bahan_baku')
            ->orderBy('nama_bahan_baku', 'ASC')
            ->get();
        break;
        default:break;
      }
    }
    return $data;
  }


  public function createrequest(Request $request) {

    $data = $request->all();

    $items['material-request-create-subject'] = 'required|min:4';
    $items['material-request-create-priority'] = 'required|min:1';
    for ($i = 0; $i < $data['material-request-create-max'] + 1; $i++) {
      $items['material-request-create-item-' . $i] = 'required|min:1';
    }

    $this->validate($request, $items);

    $try = Pengadaan::create([
      'subjek_pengadaan_bahan_baku' => $data['material-request-create-subject'],
      'tanggal_pengadaan_bahan_baku' => date('Y-m-d'),
      'waktu_pengadaan_bahan_baku' => date('H:m:s'),
      'catatan_pengadaan_bahan_baku' => $data['material-request-create-addition'],
      'status_pengadaan_bahan_baku' => 0,
      'kode_pegawai' => 'toor',//sementara
      'kode_prioritas' => $data['material-request-create-priority']
    ]);
    $id = $try->kode_pengadaan_bahan_baku;

    for ($i = 0; $i < $data['material-request-create-max'] + 1; $i++) {
      $detils[] = array(
        'nama_bahan_baku' => $data['material-request-create-item-' . $i],
        'jumlah_bahan_baku' => 0,
        'satuan_bahan_baku' => '',
        'kode_pengadaan_bahan_baku' => $id,
      );
    }

    $try = PengadaanDetil::insert($detils);

    return redirect('/dashboard/material');
  }

  public function acceptrequest(Request $request) {
    $data = $request->all();
    $req = Pengadaan::findOrFail($data['_id']);
    if ($req) {
      $invalid = 0;
      foreach ($data['_data'] as $key => $value) {
        if ($data['_data'][$key]['material-request-detail-count'] > 0) {
          $items['material-request-detail-name-' . $data['_id'] . '-' . $key] = 'required|min:3';
          $items['material-request-detail-count-' . $data['_id'] . '-' . $key] = 'required|min:1';
          $items['material-request-detail-unit-' . $data['_id'] . '-' . $key] = 'required|min:1';
          $items['material-request-detail-date-' . $data['_id'] . '-' . $key] = 'required|date_format:Y-m-d';
          $data['_data'][$key]['material-request-detail-date'] = date('Y-m-d', strtotime($value['material-request-detail-date']));

          $assign['material-request-detail-name-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-name'];
          $assign['material-request-detail-count-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-count'];
          $assign['material-request-detail-unit-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-unit'];
          $assign['material-request-detail-date-' . $data['_id'] . '-' . $key] = $data['_data'][$key]['material-request-detail-date'];
        }
        else {
          $invalid++;
        }
      }
      if ($invalid == count($data['_data'])) {
        return response()->json(['status' => 400,'text' => 'Silahkan isi salah satu bahan baku.']);
      }
      else {
        $validator = Validator::make($assign, $items);

        if ($validator->fails()) {
          return response()->json(['status' => 500, 'text' => 'Perhatikan bahwa semua kolom harus diisi']);
        }
        else {
          $try = Pengadaan::find($data['_id'])->update([
            'status_pengadaan_bahan_baku' => 1
          ]);

          if ($try) {
            $tmp = 0;
            foreach ($data['_data'] as $key => $value) {
              if ($data['_data'][$key]['material-request-detail-count'] > 0) {
                $materials[] = array(
                  'nama_bahan_baku' => $data['_data'][$key]['material-request-detail-name'],
                  'stok_bahan_baku' => $data['_data'][$key]['material-request-detail-count'],
                  'satuan_bahan_baku' => $data['_data'][$key]['material-request-detail-unit'],
                  'tanggal_kadaluarsa_bahan_baku' => $data['_data'][$key]['material-request-detail-date']
                );

                $excludeid[$tmp] = $data['_data'][$key]['material-request-detail'];
                $tmp++;
                $materialdetails[] = array(
                  'nama_bahan_baku' => $data['_data'][$key]['material-request-detail-name'],
                  'jumlah_bahan_baku' => $data['_data'][$key]['material-request-detail-count'],
                  'satuan_bahan_baku' => $data['_data'][$key]['material-request-detail-unit'],
                  'kode_pengadaan_bahan_baku' => $data['_id']
                );
              }
            }

            $all = DB::table('pengadaan_bahan_baku_detil')
                  ->where('kode_pengadaan_bahan_baku', $data['_id'])
                  ->whereNotIn('kode_pengadaan_bahan_baku_detil', $excludeid)
                  ->get();

            foreach ($all as $key => $value) {
              PengadaanDetil::find($value->kode_pengadaan_bahan_baku_detil)->update($materialdetails[$key]);
            }

            $try = BahanBaku::insert($materials);
            if ($try) {
                return response()->json(['status' => 200,'text' => 'Berhasil menambahkan data bahan baku.']);
            }
          }
        }//end case validator

      }

    }
    else {
      return response()->json(['status' => 400,'text' => 'Kode pengajuan bahan baku tidak diketahui']);
    }
    return redirect('/dashboard/material');
  }

}
