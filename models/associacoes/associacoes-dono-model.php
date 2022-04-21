<?
    class AssociacoesDonoModel extends MainModel {
        public $posts_por_pagina = 10;
        public function __construct($db = false, $controller = null) {
            $this->db = $db;
            $this->controller = $controller;
            $this->parametros = $this->controller->parametros;
            $this->userdata = $this->controller->userdata;
            $this->uri = HOME_URI.'/associacoes/dono/';
            $this->table = 'associacoes';
            $this->table_id = 'assoc_id';
            $this->tableId = null;
        }
        public function findQuery($query_limit = null){
            $where = $id = null;
            $mainQuery = 'SELECT * FROM listar_assoc_dono ';
            $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
            //$where .= ' AND `assoc_socios`.`dono` = 1';
            //$where .= ' AND `socios`.`user_permissions` REGEXP \'dono4|dono1\'';
            //$where .= ' AND `socios`.`user_permissions` LIKE \'%dono4%\'';
            if(chk_array($this->parametros, 0) == 'del'){
                $this->tableId = (int) chk_array($this->parametros, 1);
                //return $this->db->query($mainQuery.' AND `assoc_id` = '.$this->tableId);
                return $this->db->query($mainQuery.' WHERE `assoc_id` = '.$this->tableId);
            }else if (is_numeric(chk_array($this->parametros, 0))) {
                $id = array(chk_array($this->parametros, 0));
                $where .= " AND `assoc_id` = ? ";
            }
            return $this->db->query($mainQuery . $where.' ORDER BY `assoc_id` DESC' . $query_limit, $id);
        }
        public function new_associacao_form() {
            // Configura os dados do formulário
            $this->form_data = array();
            // Verifica se algo foi passado
            if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST)) {
                // Faz o loop dos dados do post
                foreach ($_POST as $key => $value) {
                    // Configura os dados do post para a propriedade $form_data
                    $this->form_data[$key] = $value;
                    // Sem campos em branco
                    if(empty($value)){
                        // Configura a mensagem
                        $this->form_msg = '<p class="form_error">There are empty fields. Data has not been sent.</p>';
                        return;
                    }
                }
            } else {
                // Termina se nada foi enviado
                return;
            }
            // Verifica se a propriedade $form_data foi preenchida
            if (empty($this->form_data)) {
                return;
            }
            // Verifica se o user existe
            $db_check_assoc_name = $this->db->query('SELECT * FROM `associacoes` WHERE `assoc_nome` = ?', array(chk_array($this->form_data, 'assoc_nome')));
            $fetch_user = $db_check_assoc_name->fetch();
            // Se ja existir um user com o mesmo nome retorna erro (nome ]e 'Unique')
            if ($fetch_user > 0) {
                $this->form_msg = '<p class="form_error">Nome da Associacao ja em uso.</p>';
                return;
            }
            $db_check_numContr = $this->db->query('SELECT * FROM `associacoes` WHERE `assoc_numContribuinte` = ?', array(chk_array($this->form_data, 'assoc_numContribuinte')));
            $fetch_email = $db_check_numContr->fetch();
            // Se ja existir o mesmo numero de contribuinte retorna erro (num de contribuinte ]e 'Unique')
            if ($fetch_email > 0) {
                $this->form_msg = '<p class="form_error">Numero de Contribuinte ja em uso.</p>';
                return;
            }
            // Da insert no novo user
            $query = $this->db->insert('associacoes', array(
                'assoc_nome' => chk_array($this->form_data, 'assoc_nome'),
                'assoc_morada' => chk_array($this->form_data, 'assoc_morada'),
                'assoc_numContribuinte' => chk_array($this->form_data, 'assoc_numContribuinte'),
                'assoc_quotas_preco' => chk_array($this->form_data, 'assoc_quotas_preco'),));
            // Verifica se a consulta está OK e configura a mensagem
            if (!$query) {
                $this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';
                return;
            } else
                $this->form_msg = '<p class="form_success">Associação registada com sucesso</p>';
            $db_check_assoc_id = $this->db->query('SELECT `assoc_id` FROM `associacoes` WHERE `assoc_nome` = ? ', array(chk_array($this->form_data, 'assoc_nome')));
            $fetch_assoc_id = $db_check_assoc_id->fetch();
            if(chk_array($this->userdata, 'user_id') && !empty($this->userdata['user_id']))
                $user_id = $this->userdata['user_id'];
            else
                return;
            $query = $this->db->insert('assoc_socios', array(
                'assoc_id' => chk_array($fetch_assoc_id, 'assoc_id'),
                'user_id' => $user_id,
                'dono' => 1,));
            $permissions = $_SESSION['userdata']['user_permissions'];
            //se ainda tiver permissoes de gerir-noticias, por exemplo
            //vai se adicionado as permissions as permissoes de um dono.
            if(!in_array('gerir-noticias',$permissions))
                array_push($permissions, 'gerir-eventos', 'gerir-noticias', 'gerir-associacoes', 'gerir-galeria');
            //para que cada um tenha permissoes unicas
            // Serializa as permissões
            $permissions = serialize($permissions);
            $arr = array(
                'user_permissions' => $permissions,
            );
            $query = $this->db->update('socios', 'user_id', $user_id, $arr);
            // Verifica a consulta
            if ($query) {
                // Retorna uma mensagem
                $this->form_msg = '<p class="success">Permissoes de user atualizado com sucesso!</p>';
                //Refresh
                echo '<meta http-equiv="Refresh" content="0; url='.$this->uri.'">';
            }
        }// validate_register_form
    }
?>