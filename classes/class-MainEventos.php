<?

abstract class MainEventos extends Pager{
    public $form_data;
    public $form_msg;
    public $form_enter;
    public $form_confirma;
    public $db;
    public $controller;
    public $parametros;
    public $userdata;

    public function list_my_table() {
        // Configura as variáveis que vamos utilizar
        $query_limit = null;
        $posts_por_pagina = $this->posts_por_pagina;
        // Esta propriedade foi configurada no modelo paraprevenir limite ou paginação na administração.
        if (empty($this->sem_limite))
            // Configura o limite da consulta
		    $query_limit = " LIMIT $posts_por_pagina ";
        //retorna a uma array associativo que 
        return $this->findQuery($query_limit)->fetchAll();
    }

    //class abstrata que pega a query de cada modelo específico
    abstract public function findQuery($query_limit = null);
    
    public function apaga_table() {
        if(!is_numeric(chk_array($this->parametros, 0)))
            return;
        if (chk_array($this->parametros, 1) != 'del')
            return;
        // O segundo parâmetro deverá ser um ID numérico
        if(!is_numeric(chk_array($this->parametros, 2)))
            return;
        
        $id = chk_array($this->parametros, 0);
        // Para excluir, o terceiro parâmetro deverá ser "confirma"
        if (chk_array($this->parametros, 3) != 'confirma') {
            // Configura uma mensagem de confirmação para o user
            $mensagem = '<p class="alert">Tem certeza que deseja apagar a table?</p>';
            $mensagem .= '<p><a href="'.$_SERVER['REQUEST_URI'].'/confirma/">Sim</a> | ';
            $mensagem .= '<a href="'.$this->uri.$id.'">Não</a></p>';
            // Retorna a mensagem e não excluir
            return $mensagem;
        }
        $fetch = $this->findQuery(null)->fetchAll();
        if($fetch > 0){
            // Executa a consulta
            $this->db->delete($this->table, $this->table_id, $this->tableId);
            $this->goto_page($this->uri.$id);
        }else
            return;
    }
    public function insere_table() {
        if ('POST' != $_SERVER['REQUEST_METHOD'] || empty($_POST['insere_table']))
            return;
        if (!is_numeric(chk_array($this->parametros, 0)))
            return;
        if (chk_array($this->parametros, 1) == 'edit')
            return;
        if (is_numeric(chk_array($this->parametros, 2)))
            return;
        foreach ($_POST as $key => $value) {
            if($key != 'assoc_id')
                // Sem campos em branco
                if (empty($value)) {
                    // Configura a mensagem
                    $this->form_msg = '<p class="form_error">There are empty fields. Data has not been sent.</p>';
                    return;
                }
        }
        //pega no primeiro parametro
        $id = chk_array($this->parametros, 0);
        //o primeiro parametro ]e o id da assoc
        $_POST['assoc_id'] = $id;
        //pega na data
        $data = $_POST['evento_data'];
        //verificacao se a data do evento ]e so para uma semana depois
        $data = strtotime($data);
        echo $data.'<br>';
        $data_hoje = strtotime('now + 7 days');
        if($data < $data_hoje){
            $this->form_msg = '<p class="error">A data tem que ter uma semana de antecedencia.</p>';
            return;
        }
        $data = date('Y-m-d', $data);
        echo $data;
        //inverte
        $nova_data = $this->inverte_data($data);
        //e insere no $_POST
        $_POST['evento_data'] = $nova_data;
        //criacao de um id unico para, buscar o evento acabado de criar
        $rand = rand(1,9999999999);
        $evento_unique_id = rand(1,9999999999);
        $evento_unique_id = md5($evento_unique_id*$rand);
        $_POST['evento_unique_id'] = $evento_unique_id;
        //unset no inserte_table
        print_r($_POST);
        unset($_POST['insere_table']);
        // Insere os dados na base de dados
        $query = $this->db->insert($this->table, $_POST);
        // Verifica a consulta
        if(!$query)
            return;
        $arr = array($evento_unique_id);
        //vai buscar o id do evento
        $query = $this->db->query('SELECT `evento_id` FROM `eventos` WHERE `evento_unique_id` = ? LIMIT 1 ', $arr);
        if(!$query)
            return;
        $fetch = $query->fetch(PDO::FETCH_ASSOC);
        $select_all_members = $this->db->query('SELECT `listar_assoc_socios`.`user_id` FROM `listar_assoc_socios` WHERE `listar_assoc_socios`.`assoc_id` = ? ', array(chk_array($this->parametros, 0)));
        $members = $select_all_members->fetchAll();
        print_r($members);
        foreach($members as $member){
            $insc = array('user_id' => chk_array($member, 'user_id')  , 'evento_id' => chk_array($fetch, 'evento_id'));
            $query = $this->db->insert('inscricoes', $insc);
        }
        if($query){
            // Retorna uma mensagem
            $this->form_msg = '<p class="success">'.$this->table.' atualizada com sucesso!</p>'; 
            //E vai para a mesma pagina
            $this->goto_page($this->uri.$id);
            return;
        }   
        $this->form_msg = '<p class="error">Erro ao enviar dados!</p>';
        //return;
    }
    
    public function obtem_table() {
        //verifica se o primeiro ]e um numero (id da assoc)
        if (!is_numeric(chk_array($this->parametros, 0)))
            return;
        // Verifica se o primeiro parâmetro é "edit"
        if (chk_array($this->parametros, 1) != 'edit') {
            return;
        }
        $id = chk_array($this->parametros, 0);
        $this->form_msg = '<p class="alert">A atualizar</p>';
        // Verifica se o segundo parâmetro é um número
        if (!is_numeric(chk_array($this->parametros, 2)))
            return;
        // Configura o ID da table
        $tableId = chk_array($this->parametros, 2);
        if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['insere_table'])) {
            //pega na data
            //verificacao se a data do evento ]e so para uma semana depois
            $data = $_POST['evento_data'];
            $data = strtotime($data);
            $data_hoje = strtotime('now + 7 days');
            //se a data inserida for menor que a data atual mais 7 dias
            if($data < $data_hoje){
                $this->form_msg = '<p class="error">A data tem que ter uma semana de antecedencia.</p>';
                return;
            }
            $data = date('Y-m-d', $data);
            //inverte
            $nova_data = $this->inverte_data($data);
            //e insere no $_POST
            $_POST['evento_data'] = $nova_data;  
            // Remove o campo insere_table para não gerar problemas com o PDO
            unset($_POST['insere_table']);
            $_POST['assoc_id'] = $id;
            // Atualiza os dados
            $query = $this->db->update($this->table, $this->table_id, $tableId, $_POST);
            // Verifica a consulta
            if ($query) {
                // Retorna uma mensagem
                $this->form_msg = '<p class="success">'.$this->table.' atualizado com sucesso!</p>';
                //Refresh
                $this->goto_page($this->uri.$id);
            }
        }
        // Faz a consulta para obter o valor
        $query = $this->db->query('SELECT * FROM '.$this->table.' WHERE '.$this->table_id.' = ? LIMIT 1', array($tableId));
        // Obtém os dados
        $fetch_data = $query->fetch();
        // Se os dados estiverem nulos, não faz nada
        if (empty($fetch_data)) {
            return;
        }
        //inverte a data ao buscar da base de dados
        $fetch_data['evento_data']= $this->inverte_data($fetch_data['evento_data']);
        // Configura os dados do formulário
        $this->form_data = $fetch_data;
    }// obtem_table

    public function inverte_data($data = null) {
        // Configura uma variável para receber a nova data
        $nova_data = null;
        // Se a data for enviada
        if ($data) {
            // Explode a data por -, /, : ou espaço
            $data = preg_split('/\-|\/|\s|:/', $data);
            // Remove os espaços no começo e no fim dos valores
            $data = array_map('trim', $data);
            // Cria a data invertida
            $nova_data .= chk_array($data, 2) . '-';
            $nova_data .= chk_array($data, 1) . '-';
            $nova_data .= chk_array($data, 0);
            // Configura a hora
            if (chk_array($data, 3)) {
                $nova_data .= ' ' . chk_array($data, 3);
            }
            // Configura os minutos
            if (chk_array($data, 4)) {
                $nova_data .= ':' . chk_array($data, 4);
            }
            // Configura os segundos
            if (chk_array($data, 5)) {
                $nova_data .= ':' . chk_array($data, 5);
            }
        }
        // Retorna a nova data
        return $nova_data;
    }// inverte_data
}// MainModel

?>