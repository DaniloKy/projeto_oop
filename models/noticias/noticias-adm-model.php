<?php

class NoticiasAdmModel extends MainModel {

    public $posts_por_pagina = 5;
    public $uri = HOME_URI.'/noticias/adm/';
    public $table = 'noticias';
    public $table_id = 'noticia_id';
    public $table_image = 'noticia_image';
    public function __construct($db = false, $controller = null) {
        // Configura o DB (PDO)
        $this->db = $db;
        // Configura o controlador
        $this->controller = $controller;
        // Configura os parâmetros
        $this->parametros = $this->controller->parametros;
        // Configura os dados do user
        $this->userdata = $this->controller->userdata;
    }
    public function findQuery($query_limit = null){
        $where =null;
        $mainQuery = 'SELECT * FROM `noticias` INNER JOIN `associacoes` ON `noticias`.`assoc_id` = `associacoes`.`assoc_id`';
        if(chk_array($this->parametros, 1) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 2);
            return $this->db->query($mainQuery .'WHERE `noticias`.`noticia_id` = '.$this->tableId);
        }
        return $this->db->query($mainQuery . $where.' ORDER BY `noticia_id` DESC' . $query_limit);
    }
    public function list_noticias(){
        $where = $id = $nId = $arr =null;
        $mainQuery = 'SELECT * FROM `noticias` INNER JOIN `associacoes` ON `noticias`.`assoc_id` = `associacoes`.`assoc_id`';
        if (is_numeric(chk_array($this->parametros, 0))) {
            $arr = array();
            (int)$id = chk_array($this->parametros, 0);
            $where = " WHERE `noticias`.`assoc_id` = ? ";
            $arr[] = $id;
            if(is_numeric(chk_array($this->parametros, 1))){
                (int)$nId = chk_array($this->parametros, 1);
                $where .= " AND `noticias`.`noticia_id` = ? ";
                $arr[] = $nId;
            }
        }
        return $this->db->query($mainQuery . $where.' ORDER BY `noticia_id` DESC', $arr)->fetchAll();
    }
}// NoticiasAdmModel

?>