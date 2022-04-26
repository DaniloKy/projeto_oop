<?
    class EventosUserModel extends MainEventos {
        public $posts_por_pagina = 10;
        public $uri = HOME_URI.'/eventos/index/';
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
            $where = $id = $nId = $arr =null;
            $mainQuery = 'SELECT * FROM `eventos` INNER JOIN `associacoes` ON `eventos`.`assoc_id` = `associacoes`.`assoc_id`';
            if (is_numeric(chk_array($this->parametros, 0))) {
                $arr = array();
                (int)$id = chk_array($this->parametros, 0);
                $where = " WHERE `eventos`.`assoc_id` = ? ";
                $arr[] = $id;
                if(is_numeric(chk_array($this->parametros, 1))){
                    (int)$nId = chk_array($this->parametros, 1);
                    $where .= " AND `eventos`.`evento_id` = ? ";
                    $arr[] = $nId;
                }
            }
            return $this->db->query($mainQuery . $where.' ORDER BY `evento_id` DESC', $arr);
        }
        
        public function findIfInsc(){
            if (!$this->controller->logged_in)
                return '<p class="error">Para fazer parte desta associacao deve iniciar sessao.</p>';
            if(!is_numeric(chk_array($this->parametros, 1)))
                return;
            $mainQuery = 'SELECT * FROM `eventos` INNER JOIN `listar_assoc_socios` ON `listar_assoc_socios`.`assoc_id` = `eventos`.`assoc_id` INNER JOIN `inscricoes` ON `inscricoes`.`evento_id` = `eventos`.`evento_id` ';
            $where = ' WHERE `listar_assoc_socios`.`user_id` = '.chk_array($this->userdata, 'user_id').' ';
            $where .= ' AND `eventos`.`evento_id` = '.chk_array($this->parametros, 1).' ';
            $query = $this->db->query($mainQuery . $where);
            $fetch = $query->fetch();
            if(!empty($fetch))
                return '<h3 class="unsubscribe"><a href="'. HOME_URI.'/eventos/index/'.chk_array($this->parametros, 0).'/des/'.chk_array($this->parametros, 1).'">Cancelar inscrição do evento.</a></h3>';
            return '<h3 class="subscribe"><a href="'. HOME_URI.'/eventos/index/'.chk_array($this->parametros, 0).'/insc/'.chk_array($this->parametros, 1).'">Inscrever-se no evento!</a></h3>';
        }

        public function evento_insc(){
            if(chk_array($this->parametros, 1) == 'des'){
                if(!is_numeric(chk_array($this->parametros, 2)))
                    return;
                $evento_id = chk_array($this->parametros, 2);
                if (chk_array($this->parametros, 3) != 'confirma') {
                    $mensagem = '<p class="alert">Tem certeza que deseja se inscrever do evento?</p>';
                    $mensagem .= '<p><a href="'.$_SERVER['REQUEST_URI'].'/confirma/">Sim</a> | ';
                    $mensagem .= '<a href="'.$this->uri.$evento_id.'">Não</a></p>';
                    return $mensagem;
                }
                $user_id = $this->userdata['user_id'];
                $query = $this->db->delete('inscricoes', 'evento_id` = ? AND `user_id', array($evento_id, $user_id));
                if (!$query) {
                    $this->form_msg = '<p class="error">Error!</p>';
                    $this->goto_page($this->uri.$evento_id);
                    return;
                }
            }else if(chk_array($this->parametros, 1) == 'insc'){
                if(!is_numeric(chk_array($this->parametros, 2)))
                    return;
                $evento_id = chk_array($this->parametros, 2);
                if (chk_array($this->parametros, 3) != 'confirma') {
                    $mensagem = '<p class="alert">Tem certeza que deseja entrar na associacao?</p>';
                    $mensagem .= '<p><a href="'.$_SERVER['REQUEST_URI'].'/confirma/">Sim</a> | ';
                    $mensagem .= '<a href="'.$this->uri.$evento_id.'">Não</a></p>';
                    return $mensagem;
                }
                $user_id = $this->userdata['user_id'];
                $query = $this->db->insert('inscricoes', array(
                    'user_id' => $user_id,
                    'evento_id' => $evento_id,
                ));
            }
        }
    }
?>