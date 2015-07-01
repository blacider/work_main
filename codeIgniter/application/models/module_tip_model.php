<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
class Module_Tip_model extends Reim_Model {
    private $_table_name;
    //    private $db;

    const STATUS_NEW = 0;
    const STATUS_DONE = 1;
    const STATUS_DEL = -1;
    public function __construct(){
        //        $this->db = $this->load->database('scm',TRUE);
        $this->_table_name = 'tbl_module_tip';
    }

    public function get_model(){
        $this->db->select('id, title');
        $res = $this->db->get('tbl_module')->result();

        $module = array(
                -1 => "全局Tip",
                );
        foreach($res as $item){
            $module[$item->id] = $item->title;
        }
        unset($item);

        // var_dump($module);
        return $module;
    }

    public function get_tip($uid){

        // 获得module_id 和 module_title的sql查询
        $this->db->select('tbl_role_module_r.module_id module_id');
        $this->db->from('tbl_role_module_r');
        $this->db->join('tbl_user', 'tbl_role_module_r.role_id = tbl_user.role_id');
        $this->db->where('tbl_user.id', $uid);
        $this->db->order_by('module_id asc');
        $module = $this->db->get()->result();

        $_module_id = array(    // $_module_id 用来获取用户权限对应的module_id，作为IN的参数
                '-1',
                );
        foreach($module as $item){
            $_module_id[] = $item->module_id;
        }
        unset($item);

        /* 获得tip的sql查询 */
        $this->db->select('id, module_tip');
        $this->db->where_in('module_id', $_module_id);
        $this->db->where('status', self::STATUS_NEW);
        $this->db->order_by("id", "random");
        $res = $this->db->get($this->_table_name,1)->row();

        // var_dump($res);
        return $res;
    }

    public function get_page($pn = -1, $rn =20, $order = 'desc'){
        if($rn < 0){
            $rn = 20;
        }

        if($pn >= 0){
            $start = $pn * $rn;
            $this->db->limit($rn, $start);
        }

        if($order != 'asc'){
            $order = 'desc';
        }
        $this->db->order_by('id ' . $order);

        $this->db->select('tbl_module.title module_title, tbl_module_tip.id id, tbl_module_tip.module_id module_id, tbl_module_tip.module_tip module_tip');
        $this->db->from($this->_table_name);
        $this->db->join('tbl_module', 'tbl_module_tip.module_id = tbl_module.id', 'left');
        $this->db->where('status', self::STATUS_NEW);
        $res = $this->db->get()->result();

        foreach($res as &$item){
            if ($item->module_id == -1){
                $item->module_title = "全局Tip";
            }
        }
        unset($item);
        // var_dump($res);
        return $res;
    }

    public function get_total(){
        return $this->db->count_all_results($this->_table_name);
    }

    public function create($module_id, $module_tip){
        $create_time = time();
        $status = self::STATUS_NEW;
        $data = array(
                'module_id' => $module_id,
                'module_tip' => $module_tip,
                'create_time' => $create_time,
                'status' => $status,
                );
        return $this->db->insert($this->_table_name, $data);
    }

    public function del($id){
        $this->db->set('status', self::STATUS_DEL);
        $this->db->where('id', $id);
        return $this->db->update($this->_table_name);
    }
}
