<?
    class AssociacoesDonoModel extends MainAssociacao {
        public $posts_por_pagina = 10;
        public $uri = HOME_URI.'/associacoes/dono/';
        public $table = 'associacoes';
        public $table_id = 'assoc_id';
        public $table_image = null;
        public function __construct($db = false, $controller = null) {
            $this->db = $db;
            $this->controller = $controller;
            $this->parametros = $this->controller->parametros;
            $this->userdata = $this->controller->userdata;

        }
        public function findQuery($query_limit = null){
            $where = $id = null;
            $mainQuery = 'SELECT * FROM listar_assoc_dono ';
            $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
            if(chk_array($this->parametros, 0) == 'del'){
                $this->tableId = (int) chk_array($this->parametros, 1);
                return $this->db->query($mainQuery.' WHERE `assoc_id` = '.$this->tableId);
            }else if (is_numeric(chk_array($this->parametros, 0))) {
                $id = array(chk_array($this->parametros, 0));
                $where .= " AND `assoc_id` = ? ";
            }
            return $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC' . $query_limit, $id);
        }
    }
?>