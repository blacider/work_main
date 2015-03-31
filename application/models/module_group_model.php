<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Module_Group_model extends CI_Model {

        private $_table_name;
          //  private $db;

              public function __construct(){
                  //        $this->db = $this->load->database('admin', TRUE);
                          $this->_table_name = 'tbl_module_group';
                              }

                                  public function get(){
                                              $query = $this->db->get($this->_table_name);
                                                      return $query->result();
                                                          }

                                                              public function get_by_id($id){
                                                                          $query = $this->db->get($this->_table_name);
                                                                                  return $query->row();
                                                                                      }

                                                                                          public function create($title, $desc){
                                                                                                      if(empty($title)){
                                                                                                                      return false;
                                                                                                                              }
                                                                                                                                      $create_time = time();
                                                                                                                                              $data = array(
                                                                                                                                                          'title' => $title,
                                                                                                                                                                      'description' => $desc,
                                                                                                                                                                                  'create_time' => $create_time,
                                                                                                                                                                                          );
                                                                                                                                                      $insert_res = $this->db->insert($this->_table_name, $data);
                                                                                                                                                              if($insert_res){
                                                                                                                                                                              $_id = $this->db->insert_id();
                                                                                                                                                                                          return $_id;
                                                                                                                                                                                                  }
                                                                                                                                                                                                          else{
                                                                                                                                                                                                                          return false;
                                                                                                                                                                                                                                  }
                                                                                                                                                                                                                                      }

                                                                                                                                                                                                                                          public function delete($id){
                                                                                                                                                                                                                                                      return $this->db->delete($this->_table_name, array('id' => $id));
                                                                                                                                                                                                                                                          }
}
