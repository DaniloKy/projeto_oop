<?
    class EventosController extends MainController {
        public $login_required = true;
        public $permission_required;
        public $prev_page = false;
        public function index() {
            $this->title = 'Eventos';
            $this->permission_required = array('ver-eventos');
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
                echo 'Não tem permissões para aceder essa página.';
                return;
            }
            $modelo = $this->load_model('eventos/eventos-user-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/eventos/eventos-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
        
        public function adm() {
            $this->title = 'Adm Gerenciar eventos';
            $this->permission_required = array('adm-gerir-eventos');
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
                echo 'Não tem permissões para aceder essa página.';
                return;
            }
            $modelo = $this->load_model('eventos/eventos-adm-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/eventos/eventos-adm-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }

        public function dono() {
            $this->title = 'Gerenciar eventos';
            $this->permission_required = array('gerir-eventos');
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
                echo 'Não tem permissões para aceder essa página.';
                return;
            }
            $modelo = $this->load_model('eventos/eventos-dono-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/eventos/eventos-dono-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }

        public function user() {
            $this->title = 'Eventos';
            $this->permission_required = array('ver-eventos');
            if (!$this->logged_in) {
                $this->logout();
                $this->goto_login();
                return;
            }
            if (!$this->check_permissions($this->permission_required, $this->userdata['user_permissions'])) {
                echo 'Não tem permissões para aceder essa página.';
                return;
            }
            $modelo = $this->load_model('eventos/eventos-user-model');
            require ABSPATH . '/views/_includes/header.php';
            require ABSPATH . '/views/_includes/menu.php';
            require ABSPATH . '/views/eventos/associacoes-user-view.php';
            require ABSPATH . '/views/_includes/footer.php';
        }
    }
?>