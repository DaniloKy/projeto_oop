<?php
class Singleton{
	// SINGLETON ***********
	private static $instance;
	// SINGLETON ***********
	
    /** DB properties */
    public $host = 'localhost',
            $db_name = '',
            $password = '',
            $user = 'root',
            $charset = 'utf8',
            $pdo = null,
            $error = null,
            $debug = false,
            $last_id = null;

    public function __construct($host = null, $db_name = null, $password = null, $user = null, $charset = null, $debug = null) {
        // Configura as propriedades novamente.
        // Feito isso no início dessa classe, as constantes não serão
        // necessárias. 
        $this->host = defined('HOSTNAME') ? HOSTNAME : $this->host;
        $this->db_name = defined('DB_NAME') ? DB_NAME : $this->db_name;
        $this->password = defined('DB_PASSWORD') ? DB_PASSWORD : $this->password;
        $this->user = defined('DB_USER') ? DB_USER : $this->user;
        $this->charset = defined('DB_CHARSET') ? DB_CHARSET : $this->charset;
        $this->debug = defined('DEBUG') ? DEBUG : $this->debug;

        // Conecta
       $this->connect();
    }// __construct
	
	public static function getInstance($d,$u,$p) {
                if (!isset(self::$instance)) {
                    self::$instance = new PDO($d, $u, $p);
                }
                echo 'Ligação estabelecida<br />';
                return self::$instance;
            }
	
	// SINGLETON
    final protected function connect() {
        /* Os detalhes da conexão PDO */
        $pdo_details = "mysql:host={$this->host};";
        $pdo_details .= "dbname={$this->db_name};";
        $pdo_details .= "charset={$this->charset};";

        // Tenta conexão
        try {
			$this->pdo=self::getInstance($pdo_details, $this->user, $this->password);
			
            // Libertar as propriedades
            unset($this->host);
            unset($this->db_name);
            unset($this->password);
            unset($this->user);
            unset($this->charset);
        } catch (PDOException $e) {
            if ($this->debug === true) {
                // Mostra a mensagem de erro
                echo "Erro: " . $e->getMessage();
            }
            die();
        } // catch
    }
}
?>