<?php if(!defined('BASEPATH')) exit('Hacking Attempt: Out now...!');

class Model_home extends CI_Model{

  function __construct(){
    parent::__construct();
  }

  function display_data(){
		$this->db->order_by('no_pasien', 'asc');
    return $this->db->get('bpjs');
	}

  function get_data_pdf()
  {
    $this->db->order_by('id', 'desc');
    return $this->db->get('bpjs');
  }

	function display_data_paging($halaman,$list){
		return $this->db->query("select * from bpjs order by id desc limit $halaman, $list");
	}

  function input($data){
			$this->db->insert('bpjs',$data);
	}

  function edit($data,$id){
      $this->db->where('id',$id);
      $this->db->update('bpjs',$data);
  }

  function delete($id){
      $this->db->where('id',$id);
      $this->db->delete('bpjs');
  }

}
