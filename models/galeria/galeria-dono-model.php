<?php

class GaleriaDonoModel extends MainModel {

    public $posts_por_pagina = 5;
    public $uri = HOME_URI.'/galeria/dono/';
    public $table = 'imagens';
    public $table_id = 'image_id';
    public $table_image = 'image_src';
    public $tableId = null;
    public function __construct($db = false, $controller = null) {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
    }
    public function findQuery($query_limit = null){
        $where = $arr = null;
        //$mainQuery = 'SELECT * FROM `assoc_socios` INNER JOIN `socios` ON `assoc_socios`.`user_id` = `socios`.`user_id` INNER JOIN `associacoes` ON `assoc_socios`.`assoc_id` = `associacoes`.`assoc_id` INNER JOIN `imagens` ON `imagens`.`assoc_id` = `associacoes`.`assoc_id`';
        $mainQuery = 'SELECT `imagens`.*, `listar_assoc_dono`.* FROM `listar_assoc_dono` INNER JOIN `imagens` ON `listar_assoc_dono`.`assoc_id` = `imagens`.`assoc_id`';
        $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
        if(chk_array($this->parametros, 1) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 2);
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