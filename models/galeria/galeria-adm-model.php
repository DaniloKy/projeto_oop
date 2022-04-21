<?php

class GaleriaAdmModel extends MainModel {

    public $posts_por_pagina = 5;

    public function __construct($db = false, $controller = null) {
        $this->db = $db;
        $this->controller = $controller;
        $this->parametros = $this->controller->parametros;
        $this->userdata = $this->controller->userdata;
        $this->uri = HOME_URI.'/galeria/adm/';
        $this->table = 'imagens';
        $this->table_id = 'image_id';
        $this->table_image = 'image_src';
        $this->tableId = null;
    }
    public function findQuery($query_limit = null){
        $where = $id = null;
        $mainQuery = 'SELECT * FROM `imagens` INNER JOIN `associacoes` ON `imagens`.`assoc_id` = `associacoes`.`assoc_id`';
        if(chk_array($this->parametros, 0) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 1);
            return $this->db->query( $mainQuery.' WHERE `imagens`.`image_id` = '.$this->tableId);
        }else if (is_numeric(chk_array($this->parametros, 0))) {
            $id = array(chk_array($this->parametros, 0));
            $where .= " WHERE `imagens`.`image_id` = ? ";
        }
        return $this->db->query($mainQuery . $where.' ORDER BY `image_id` DESC' . $query_limit, $id);
    }
    public function list_gallery(){
        if (!is_numeric(chk_array($this->parametros, 0)))
            return;
        $arr[] = chk_array($this->parametros, 0);
        $where = " WHERE `imagens`.`assoc_id` = ? ";
        if(is_numeric(chk_array($this->parametros, 1))){
            $arr[] = chk_array($this->parametros, 1);
            $where .= " AND `imagens`.`image_id` = ? ";
        }
        $query = $this->db->query('SELECT * FROM `imagens` INNER JOIN `associacoes` ON `imagens`.`assoc_id` = `associacoes`.`assoc_id`' . $where.' ORDER BY `image_id` DESC', $arr);
        return $query->fetchAll();
    }
}// GaleriaAdmModel

?>