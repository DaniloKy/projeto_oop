<?
    class EventosAdmModel extends MainEventos {
        public $posts_por_pagina = 10;
        public $uri = HOME_URI.'/eventos/adm/';
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
            $where = $id = null;
            $mainQuery = 'SELECT * FROM listar_assoc_dono INNER JOIN `eventos` ON `eventos`.`assoc_id` = `listar_assoc_dono`.`assoc_id`';
            if(chk_array($this->parametros, 1) == 'del'){
                $this->tableId = (int) chk_array($this->parametros, 2);
                return $this->db->query($mainQuery.' WHERE `evento_id` = '.$this->tableId);
            }
            return $this->db->query($mainQuery . $where.' ORDER BY `evento_id` DESC ' . $query_limit, $id);
        }
    }
?>