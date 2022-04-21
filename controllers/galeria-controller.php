<?

class GaleriaController extends MainController {

    public $login_required = false;
    public $permission_required;
    public $prev_page = false;
    /**
     * Carrega a página "/views/galeria/index.php"
     */

    public function index() {
        // Título da página
        $this->title = 'Galeria';
        // Carrega o modelo para este view
        $modelo = $this->load_model('galeria/galeria-adm-model');
        /** Carrega os arquivos do view * */
        // /views/_includes/header.php
        require ABSPATH . '/views/_includes/header.php';
        // /views/_includes/menu.php
        require ABSPATH . '/views/_includes/menu.php';
        // /views/galeria/index.php
        require ABSPATH . '/views/galeria/galeria-view.php';
        // /views/_includes/footer.php
        require ABSPATH . '/views/_includes/footer.php';
    }// index
    /*   Carrega a página "/views/galeria/galeria-adm-view.php"   */
    public function adm() {
        // Page title
        $this->title = 'Gerenciar galeria Adm';
        $this->permission_required = 'adm-gerir-galeria';
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
        $modelo = $this->load_model('galeria/galeria-adm-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/galeria/galeria-adm-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
    public function dono() {
        $this->title = 'Gerenciar galeria';
        $this->permission_required = 'gerir-galeria';
        if (!$this->logged_in) {
            $this->logout();
            $this->goto_login();
            return;
        }
        if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
            echo 'Não tem permissões para aceder essa página.';
            return;
        }
        $modelo = $this->load_model('galeria/galeria-dono-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/galeria/galeria-dono-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}

?>