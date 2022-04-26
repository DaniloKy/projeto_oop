<?
    class AssociacoesEntrarModel extends MainAssociacao {
        public $posts_por_pagina = 10;
        public $uri = HOME_URI.'/associacoes/index/';
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
            if(is_numeric(chk_array($this->parametros, 0))) {
                $id = array(chk_array($this->parametros, 0));
                $where .= " WHERE `assoc_id` = ? ";
            }
            return $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC ' . $query_limit, $id);
        }
        
        public function assoc_insc(){
            if(chk_array($this->parametros, 1) == 'des'){
                if(!is_numeric(chk_array($this->parametros, 0)))
                    return;
                $assoc_id = chk_array($this->parametros, 0);
                if (chk_array($this->parametros, 2) != 'confirma') {
                    $mensagem = '<p class="alert">Tem certeza que deseja sair na associacao?</p>';
                    $mensagem .= '<p><a href="'.$_SERVER['REQUEST_URI'].'confirma/">Sim</a> | ';
                    $mensagem .= '<a href="'.$this->uri.$assoc_id.'">Não</a></p>';
                    return $mensagem;
                }
                $user_id = $this->userdata['user_id'];
                $query = $this->db->delete('assoc_socios', 'assoc_id` = ? AND `user_id', array($assoc_id, $user_id));
                if (!$query) {
                    $this->form_msg = '<p class="success">Error!</p>';
                    $this->goto_page($this->uri.$assoc_id);
                    return;
                }
                $mainQuery = 'SELECT `user_id` FROM `assoc_socios` ';
                $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
                $query = $this->db->query($mainQuery. $where);
                $fetch =  $query->fetchAll();
                if(empty($fetch)){
                    $this_permissions = array('ver-associacao', 'ver-eventos', 'ver-quotas');
                    $arr = $this->controller->remove_permissions($this_permissions, $this->userdata['user_permissions']);    
                    $query = $this->db->update('socios', 'user_id', $user_id, $arr);
                }
                if ($query) {
                    $this->goto_page($this->uri.$assoc_id);
                    return;
                }
                //$arr = $this->controller->get_new_permissions($new_permissions, $this->userdata['user_permissions']);
            }else if(chk_array($this->parametros, 1) == 'insc'){
                if(!is_numeric(chk_array($this->parametros, 0)))
                    return;
                $assoc_id = chk_array($this->parametros, 0);
                if (chk_array($this->parametros, 2) != 'confirma') {
                    $mensagem = '<p class="alert">Tem certeza que deseja entrar na associacao?</p>';
                    $mensagem .= '<p><a href="'.$_SERVER['REQUEST_URI'].'confirma/">Sim</a> | ';
                    $mensagem .= '<a href="'.$this->uri.$assoc_id.'">Não</a></p>';
                    return $mensagem;
                }
                $user_id = $this->userdata['user_id'];
                $query = $this->db->insert('assoc_socios', array(
                    'assoc_id' => $assoc_id,
                    'user_id' => $user_id,
                    'dono' => 0,
                ));
                $new_permissions = array('ver-associacao', 'ver-eventos', 'ver-quotas');
                $arr = $this->controller->get_new_permissions($new_permissions, $this->userdata['user_permissions']);
                $query = $this->db->update('socios', 'user_id', $user_id, $arr);
                if ($query) {
                    $this->form_msg = '<p class="success">Agora fazes parte da associacao!</p>';
                    $this->goto_page($this->uri.$assoc_id);
                }
            }
        }
        public function findIfInsc(){
            if (!$this->controller->logged_in)
                return '<p class="error">Para fazer parte desta associacao deve iniciar sessao.</p>';
            $where = null;
            $mainQuery = 'SELECT * FROM listar_assoc_dono ';
            $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
            if(!is_numeric(chk_array($this->parametros, 0)))
                return;
            $where .= ' AND `assoc_id` = '.chk_array($this->parametros, 0).' ';
            $query = $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC ');
            $fetch = $query->fetch();
            if(!empty($fetch))
                return '<p>Voce é dono desta associacao.</p>';
            $mainQuery = 'SELECT * FROM listar_assoc_socios ';
            $query = $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC ');
            $fetch = $query->fetch();
            if(!empty($fetch))
                return '<h3 class="unsubscribe"><a href="'. HOME_URI.'/associacoes/index/'.chk_array($this->parametros, 0).'/des/">Cancelar inscrição</a></h3>';
            return '<h3 class="subscribe"><a href="'. HOME_URI.'/associacoes/index/'.chk_array($this->parametros, 0).'/insc/">Inscrever-se!</a></h3>';
        }
    }
?>