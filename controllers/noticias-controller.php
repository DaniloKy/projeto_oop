<?

class NoticiasController extends MainController {

    public $login_required = false;
    public $permission_required;
    public $prev_page = false;
    public $assoc_noticias = array();
    /**
     * Carrega a página "/views/noticias/index.php"
     */

    public function index() {
        // Título da página
        $this->title = 'Noticias';
        $this->load_class_noticas('noticias/noticias-adm-model');
        // Carrega o modelo para este view
        $modelo = $this->load_model('noticias/noticias-adm-model');
        /** Carrega os arquivos do view * */
        // /views/_includes/header.php
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/noticias/index.php
        require ABSPATH . '/views/noticias/noticias-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }// index
    /*   Carrega a página "/views/noticias/noticias-adm-view.php"   */
    public function adm() {
        // Page title
        $this->title = 'Gerenciar noticias Adm';
        $this->permission_required = array('adm-gerir-noticias');
        if (!$this->logged_in) {
            $this->logout();
            $this->goto_login();
            return;
        }
        // Verifica se o user tem a permissão para aceder essa página
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
            // Exibe uma mensagem
            echo 'Não tem permissões para aceder essa página.';
            // Finaliza aqui
            return;
        }
        // Carrega o modelo para este view
        $this->load_class_noticas('noticias/noticias-adm-model');
        $modelo = $this->load_model('noticias/noticias-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-adm-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
    public function dono() {
        $this->title = 'Gerenciar noticias';
        $this->permission_required = array('gerir-noticias');
        if (!$this->logged_in) {
            $this->logout();
            $this->goto_login();
            return;
        }
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
            echo 'Não tem permissões para aceder essa página.';
            return;
        }
        $this->load_class_noticas('noticias/noticias-dono-model');
        $modelo = $this->load_model('noticias/noticias-dono-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/noticias/noticias-dono-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}

?>