<?php

class GaleriaAdmModel extends MainModel {

    public $posts_por_pagina = 5;
    public $uri = HOME_URI.'/galeria/adm/';
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
        $where = $id = null;
        $mainQuery = 'SELECT * FROM `imagens` INNER JOIN `associacoes` ON `imagens`.`assoc_id` = `associacoes`.`assoc_id`';
        if(chk_array($this->parametros, 1) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 2);
            return $this->db->query( $mainQuery.' WHERE `imagens`.`image_id` = '.$this->tableId);
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