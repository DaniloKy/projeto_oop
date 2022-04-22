<?
    class AssociacoesController extends MainController {
        public $login_required = false;
        public $permission_required;
        public $prev_page = false;
        public function index() {
            $this->title = 'Associacoes';
            $modelo = $this->load_model('associacoes/associacoes-adm-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/associacoes/associacoes-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
        public function adm() {
            $this->title = 'Adm Gerenciar associacoes';
            $this->permission_required = 'adm-gerir-associacoes';
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
                echo 'Não tem permissões para aceder essa página.';
                return;
            }
            $modelo = $this->load_model('associacoes/associacoes-adm-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/associacoes/associacoes-adm-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
        public function dono() {
            $this->title = 'Gerenciar associacoes';
            $this->permission_required = 'gerir-associacoes';
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
                echo 'Não tem permissões para aceder essa página.';
                return;
            }
            $modelo = $this->load_model('associacoes/associacoes-dono-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/associacoes/associacoes-dono-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
        public function criar() {
            $this->title = 'Criar associacoes';
            $this->permission_required = 'any';
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            $modelo = $this->load_model('associacoes/associacoes-criar-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/associacoes/associacoes-criar-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
    }
?>