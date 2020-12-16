<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class sepatu extends REST_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('sepatu_model');
  }

  public function index_get()
  {

    $sepatu = $this->sepatu_model->getAllData();

    $data = [
      'status' => true,
      'data' => $sepatu
    ];

    $this->response($data, REST_Controller::HTTP_OK);
  }

  public function index_delete()
  {
    $id = $this->delete('id');
    if ($id === null) {
      $this->response([
        'status' => false,
        'msg' => 'Tidak ada id yang dipilih'
      ], REST_Controller::HTTP_BAD_REQUEST);
    } else {
      if ($this->sepatu_model->deletesepatu($id) > 0) {
        $this->response([
          'status' => true,
          'id' => $id,
          'msg' => 'Data berhasil dihapus'
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'msg' => 'Id tidak ditemukan'
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
  }

  public function index_post()
  {
    $data = [
      'id' => $this->post('id'),
      'nama_sepatu' => $this->post('nama_sepatu'),
      'jenis_sepatu' => $this->post('jenis_sepatu'),
      'warna' => $this->post('warna'),
      'ukuran' => $this->post('ukuran'),
      'jumlah' => $this->post('jumlah'),
    ];

    $simpan = $this->sepatu_model->tambahsepatu($data);
    
    if ($simpan['status']) {
      $this->response(['status' => true, 'msg' => 'Data telah ditambahkan'], REST_Controller::HTTP_OK);
    } else {
      $this->response(['status' => false, 'msg' => $simpan['msg']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function index_put()
  {
    $data = [
      'id' => $this->post('id'),
      'nama_sepatu' => $this->post('nama_sepatu'),
      'jenis_sepatu' => $this->post('jenis_sepatu'),
      'warna' => $this->post('warna'),
      'ukuran' => $this->post('ukuran'),
      'jumlah' => $this->post('jumlah'),
    ];

    $id = $this->put('id');
    
    $simpan = $this->sepatu_model->updatesepatu($data, $id);

    if ($simpan['status']) {
      $status = (int) $simpan['data'];
      if ($status > 0) {
        $this->response(['status' => true, 'msg' => 'Data telah diupdate'], REST_Controller::HTTP_OK);
      } else {
        $this->response(['status' => false, 'msg' => 'Tidak ada data yang dirubah'], REST_Controller::HTTP_BAD_REQUEST);
      }
    } else {
      $this->response(['status' => false, 'msg' => $simpan['msg']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
  

 
}
