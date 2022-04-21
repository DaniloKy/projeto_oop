<?php

class GaleriaDonoModel extends MainModel {

    public $posts_por_pagina = 5;

    public function __construct($db = false, $controller = null) {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        $this->uri = HOME_URI.'/galeria/dono/';
        $this->table = 'imagens';
        $this->table_id = 'image_id';
        $this->table_image = 'image_src';
        $this->tableId = null;
    }
    public function findQuery($query_limit = null){
        $where = $arr = null;
        $mainQuery = 'SELECT * FROM `assoc_socios` INNER JOIN `socios` ON `assoc_socios`.`user_id` = `socios`.`user_id` INNER JOIN `associacoes` ON `assoc_socios`.`assoc_id` = `associacoes`.`assoc_id` INNER JOIN `imagens` ON `imagens`.`assoc_id` = `associacoes`.`assoc_id`';
        $where = ' WHERE `socios`.`user_id` = '.$this->userdata['user_id'].' ';
        if(chk_array($this->parametros, 0) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 1);
            return $this->db->query($mainQuery.' WHERE `imagens`.`image_id` = '.$this->tableId);
        }else if (is_numeric(chk_array($this->parametros, 0))) {
            $arr[] = chk_array($this->parametros, 0);
            $where .= " AND `imagens`.`assoc_id` = ? ";
            if (is_numeric(chk_array($this->parametros, 1))) {
                $arr[] = chk_array($this->parametros, 1);
                $where .= " AND `imagens`.`image_id` = ? ";
            }
        }
        return $this->db->query($mainQuery . $where.' ORDER BY `image_id` DESC' . $query_limit, $arr);
    }
}// GaleriaAdmModel

?>