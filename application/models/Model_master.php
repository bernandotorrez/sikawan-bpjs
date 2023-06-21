<?php if(!defined('BASEPATH')) exit('Hacking Attempt: Out now...!');

class Model_master extends CI_Model{

  function __construct(){
    parent::__construct();
  }

  function display_data(){
		return $this->db->get('tb_master');
	}

	function display_data_paging($halaman,$list){
		return $this->db->query("select * from tb_master order by id_master desc limit $halaman, $list");
	}

  function input($data){
			$this->db->insert('tb_master',$data);
	}

  function edit($data,$id){
      $this->db->where('id',$id);
      $this->db->update('tb_master',$data);
  }

  function delete($id){
      $this->db->where('id',$id);
      $this->db->delete('tb_master');
  }

}
