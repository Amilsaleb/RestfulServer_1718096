<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sepatu_model extends CI_Model
{
  public function getAllData()
  {
    return $this->db->get('tb_sepatu')->result();
  }

  public function deletesepatu($id)
  {
    $this->db->delete('tb_sepatu', ['id' => $id]);
    return $this->db->affected_rows();
  }

  public function tambahsepatu($data)
  {
    try {
      $this->db->insert('tb_sepatu', $data);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

  public function updatesepatu($data, $id)
  {
    try {
      $this->db->where('id', $id);
      $this->db->update('tb_sepatu', $data);

      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

}