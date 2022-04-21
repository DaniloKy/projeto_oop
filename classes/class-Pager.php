<?

class Pager{
    private function refresh($page = null){
        echo "<br />";
        // Redireciona
        echo '<meta http-equiv="Refresh" content="0; url=' . $page . '">';
        echo '<script type="text/javascript">window.location.href = "' . $page . '";</script>';
    }
    /*    Vai para a página de login     */
    protected function goto_login(){
        // Verifica se a URL da HOME está configurada
        if (defined('HOME_URI')) {
            // Configura a URL de login
            $login_uri = HOME_URI . '/login';
            // A página em que o user estava
            $_SESSION['goto_url'] = rtrim(urlencode($_SERVER['REQUEST_URI']),'delete');
            // Redireciona
			$this->refresh($login_uri);
        }
        return;
    }
    final protected function goto_page($page_uri = null){
        if (isset($_GET['url']) && !empty($_GET['url']) && !$page_uri)
            // Configura a URL
            $page_uri = urldecode($_GET['url']);
        if ($page_uri) {
            $this->refresh($page_uri);
            return;
        }
    }
}
?>