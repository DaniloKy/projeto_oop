<?php

class MainController extends UserLogin {

    public $db;
    public $phpass;
    public $title;
    public $login_required = false;
    public $permission_required = 'any';
    public $parametros = array();

    public function __construct($parametros = array()) {
        // Instancia do DB
        $this->db = new SystemDB();
        // Phpass
        $this->phpass = new PasswordHash(8, false);
        // Parâmetros
        $this->parametros = $parametros;
        // Verifica o login classe - UserLogin
        $this->check_userlogin();
    }// __construct
    public function load_model($model_name = false) {
        // Um ficheiro deverá ser enviado
        if (!$model_name)
            return;
        // Garante que o nome do modelo tenha letras minúsculas
        $model_name = strtolower($model_name);
        // Inclui o ficheiro
        $model_path = ABSPATH . '/models/' . $model_name . '.php';
        // Verifica se o ficheiro existe
        if (file_exists($model_path)) {
            // Inclui o ficheiro
            require_once $model_path;
            // Remove os caminhos do ficheiro (se tiver algum)
            $model_name = explode('/', $model_name);
            // Captura o final do caminho(nome do modelo)
            $model_name = end($model_name);
            // Remove caracteres inválidos do nome do ficheiro
            $model_name = preg_replace('/[^a-zA-Z0-9]/is', '', $model_name);
            // Verifica se a classe existe
            if (class_exists($model_name)) {
                // Retorna um objeto da classe
                return new $model_name($this->db, $this);
            }
            return;
        }
    }// load_model
    public function load_class_assoc($model_name = false) {
        $modelo = $this->load_model($model_name);
        foreach($modelo->list_my_table() as $assoc){
            $associacao = new Associacoes($assoc['assoc_id'],$assoc['assoc_nome'],$assoc['assoc_morada'],$assoc['assoc_numContribuinte'],$assoc['assoc_quotas_preco']);
            $associacao->addSocio($assoc['user_id'],$assoc['user_name'],$assoc['user_email'],$assoc['user_password'],$assoc['user'], $assoc['user_session_id'], $assoc['user_permissions']);
            if(method_exists($modelo, 'listMembers'))
            foreach($modelo->listMembers(chk_array($assoc, 'assoc_id')) as $members){
                $associacao->addSocio($members['user_id'],$members['user_name'],$members['user_email'],$members['user_password'],$members['user'], $members['user_session_id'], $members['user_permissions']);
            }
            $this->associacoes[] = $associacao;
        }
    }
    public function load_class_noticas($model_name = false) {
        $modelo = $this->load_model($model_name);
        foreach($modelo->list_my_table() as $not){
            $associacao = new Associacoes($not['assoc_id'],$not['assoc_nome'],null,null,null);
            $noticias = new Noticias($not['noticia_id'],$not['noticia_titulo'],$not['noticia_descricao'],$not['noticia_image']);
            $associacao->addNoticia($noticias);
            $this->assoc_noticias[] = $associacao;
        }
    }
}
// class MainController