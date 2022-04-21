<?php

class RegisterModel{
    public $form_data;
    public $form_msg;
    public $db;
    public function __construct($db = false) {
        $this->db = $db;
    }
    public function new_register_form() {
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
        $db_check_user = $this->db->query('SELECT * FROM `socios` WHERE `user` = ?', array(chk_array($this->form_data, 'user')));
        $fetch_user = $db_check_user->fetch();
        // Se ja existir um user com o mesmo nome retorna erro
        if ($fetch_user > 0) {
            $this->form_msg = '<p class="form_error">User already taken.</p>';
            return;
        }
        $db_check_email = $this->db->query('SELECT * FROM `socios` WHERE `user_email` = ?', array(chk_array($this->form_data, 'user_email')));
        $fetch_email = $db_check_email->fetch();
        // Se ja existir um email retorna erro
        if ($fetch_email > 0) {
            $this->form_msg = '<p class="form_error">Email already taken.</p>';
            return;
        }
        //Verificar se as passwords sao iguais
        if($this->form_data['user_password'] != $this->form_data['user_password_conf']){
            $this->form_msg = '<p class="form_error">Password does not match.</p>';
            return;
        }
        unset($_POST['user_password_conf']);
        // Precisaremos de uma instância da classe Phpass
        // veja http://www.openwall.com/phpass/
        $password_hash = new PasswordHash(8, FALSE);
        // Cria o hash da senha
        $password = $password_hash->HashPassword($this->form_data['user_password']);
        //cria o array das permissoes
        $permissions = array();
        // Serializa as permissões
        $permissions = serialize($permissions);
        // Da insert no novo user
        $query = $this->db->insert('socios', array(
            'user' => chk_array($this->form_data, 'user'),
            'user_password' => $password,
            'user_name' => chk_array($this->form_data, 'user_name'),
            'user_email' => chk_array($this->form_data, 'user_email'),
            'user_session_id' => md5(time()),
            'user_permissions' => $permissions,));
        // Verifica se a consulta está OK e configura a mensagem
        if (!$query) {
            $this->form_msg = '<p class="form_error">Internal error. Data has not been sent.</p>';
            return;
        } else {
            $this->form_msg = '<p class="form_success">User successfully registered.</p>';
            return;
        }
    }// validate_register_form
}
