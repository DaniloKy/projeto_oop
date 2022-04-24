<?

class NoticiasDonoModel extends MainModel {

    public $posts_por_pagina = 5;
    public $uri = HOME_URI.'/noticias/dono/';
    public $table = 'noticias';
    public $table_id = 'noticia_id';
    public $table_image = 'noticia_image';
    public function __construct($db = false, $controller = null) {
        // Configura o DB (PDO)
        $this->db = $db;
        // Configura o controlador
        $this->controller = $controller;
        // Configura os parâmetros
        $this->parametros = $this->controller->parametros;
        // Configura os dados do user
        $this->userdata = $this->controller->userdata;
    }
    public function findQuery($query_limit = null){
        $where = $arr = null;
        $mainQuery = 'SELECT `noticias`.* FROM listar_assoc_dono INNER JOIN `noticias` ON `noticias`.`assoc_id` = listar_assoc_dono.`assoc_id`  ';
        $where = ' WHERE `user_id` = '.$this->userdata['user_id'].' ';
        if(chk_array($this->parametros, 1) == 'del'){
            $this->tableId = (int) chk_array($this->parametros, 2);
            return $this->db->query($mainQuery . $where.' AND `noticia_id` = '.$this->tableId);
        }else if (is_numeric(chk_array($this->parametros, 0))) {
            $arr[] = chk_array($this->parametros, 0);
            $where .= " AND `noticias`.`assoc_id` = ? ";
            if (is_numeric(chk_array($this->parametros, 1))) {
                $arr[] = chk_array($this->parametros, 1);
                $where .= " AND `noticia_id` = ? ";
            }
        }
        return $this->db->query($mainQuery . $where.' ORDER BY `noticia_id` DESC' . $query_limit, $arr);
    }
}// NoticiasAdmModel

?>