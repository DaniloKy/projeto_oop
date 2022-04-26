<?php

class EventosDonoModel extends MainEventos {

    public $posts_por_pagina = 5;
    public $uri = HOME_URI.'/eventos/dono/';
    public $table = 'eventos';
    public $table_id = 'evento_id';
    public $table_image = null;
    public function __construct($db = false, $controller = null) {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }
    public function findQuery($query_limit = null){
        $where = $arr = null;
        $mainQuery = 'SELECT `eventos`.*, `listar_assoc_dono`.* FROM `listar_assoc_dono` INNER JOIN `eventos` ON `listar_assoc_dono`.`assoc_id` = `eventos`.`assoc_id`';
        $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
        if(chk_array($this->parametros, 1) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 2);
            return $this->db->query($mainQuery.' WHERE `eventos`.`evento_id` = '.$this->tableId);
        }else if (is_numeric(chk_array($this->parametros, 0))) {
            $arr[] = chk_array($this->parametros, 0);
            $where .= " AND `eventos`.`assoc_id` = ? ";
            if (is_numeric(chk_array($this->parametros, 1))) {
                $arr[] = chk_array($this->parametros, 1);
                $where .= " AND `eventos`.`evento_id` = ? ";
            }
        }
        return $this->db->query($mainQuery . $where.' ORDER BY `evento_id` DESC' . $query_limit, $arr);
    }
}// GaleriaAdmModel

?>