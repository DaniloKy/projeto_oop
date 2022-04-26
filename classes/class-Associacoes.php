<?
class Associacoes {
    private $id;
    private $nome;
    private $morada;
    private $numContribuinte;
    private $assoc_quotas_preco;
    public $socio;
    public $noticias;
    public function __construct($id, $nome, $morada, $numContribuinte, $assoc_quotas_preco) {
        $this->socio = array();
        $this->id = $id;
        $this->nome = $nome;
        $this->morada = $morada;
        $this->numContribuinte = $numContribuinte;
        $this->assoc_quotas_preco = $assoc_quotas_preco;
    }
    public function getId(){
        return $this->id;
    }
    public function getNome(){
        return $this->nome;
    }
    public function getMorada(){
        return $this->morada;
    }
    public function getNumContribuinte(){
        return $this->numContribuinte;
    }
    public function getAssoQuotas(){
        return $this->assoc_quotas_preco;
    }
    public function addSocio($id, $nome, $email, $user, $password, $session_id, $permissions){
        $this->socio[] = new Socios($this, $id, $nome, $email, $user, $password, $session_id, $permissions);
    }
    public function addNoticia(Noticias $noticias){
        $this->noticias[] = $noticias;
    }
    public function getFirstSocio(){
        return $this->socio[0];
    }
}
?>