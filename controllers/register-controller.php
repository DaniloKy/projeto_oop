<?php
class RegisterController extends MainController {
    public $login_required = false;
    public $permission_required='any';
    public function index() {
        $this->title = 'New User register';
        if($this->logged_in){
			$this->logout();
            $this->goto_page(HOME_URI . '/register');
        }
        $modelo = $this->load_model('register/register-model');
        require ABSPATH . '/views/_includes/header.php';
        require ABSPATH . '/views/_includes/menu.php';
        require ABSPATH . '/views/register/register-view.php';
        require ABSPATH . '/views/_includes/footer.php';
    }
}
?>
