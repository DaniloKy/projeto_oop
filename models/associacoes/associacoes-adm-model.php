<?
    class AssociacoesAdmModel extends MainAssociacao {
        public $posts_por_pagina = 10;
        public $inscrito = false;
        public $uri = HOME_URI.'/associacoes/adm/';
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
            if(chk_array($this->parametros, 0) == 'del'){
                $this->tableId = (int) chk_array($this->parametros, 1);
                return $this->db->query($mainQuery.' WHERE `assoc_id` = '.$this->tableId);
            }else if(is_numeric(chk_array($this->parametros, 0))) {
                $id = array(chk_array($this->parametros, 0));
                $where .= " WHERE `assoc_id` = ? ";
            }
            return $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC ' . $query_limit, $id);
        }
        
        public function findIfInsc(){
            $where = null;
            $mainQuery = 'SELECT * FROM listar_assoc_socios ';
            $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
            if(chk_array($this->parametros, 1) == 'des'){
                echo "aba";
            }else if(chk_array($this->parametros, 1) == 'insc'){
                if(!is_numeric(chk_array($this->parametros, 0)))
                    return;
                if (chk_array($this->parametros, 2) != 'confirma') {
                    $mensagem = '<p class="alert">Tem certeza que deseja entrar na associacao?</p>';
                    $mensagem .= '<p><a href="'.$_SERVER['REQUEST_URI'].'/confirma/">Sim</a> | ';
                    $mensagem .= '<a href="'.$this->uri.'">Não</a></p>';
                    return $mensagem;
                }
                $assoc_id = chk_array($this->parametros, 0);
                $user_id = $this->userdata['user_id'];
                $query = $this->db->insert('assoc_socios', array(
                    'assoc_id' => $assoc_id,
                    'user_id' => $user_id,
                    'dono' => 0,));
                $permissions = $_SESSION['userdata']['user_permissions'];
                if(!in_array('ver-assocciacao',$permissions))
                    array_push($permissions, 'ver-assocciacao', 'ver-eventos', 'ver-quotas');
                $permissions = serialize($permissions);
                $arr = array(
                    'user_permissions' => $permissions,
                );
                $query = $this->db->update('socios', 'user_id', $user_id, $arr);
                if ($query) {
                    $this->form_msg = '<p class="success">Agora fazes parte da associacao!</p>';
                    $this->goto_page($this->uri);
                }
            }
            if(is_numeric(chk_array($this->parametros, 0)))
                $where .= ' AND `assoc_id` = '.chk_array($this->parametros, 0).' ';
            $query = $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC ');
            $fetch = $query->fetch();
            if(!empty($fetch))
                $this->inscrito = true;
        }
        
    }
?>