<?
class Socios {
    private $id;
    private $nome;
    private $email;
    private $user;
    private $password;
    private $session_id;
    private $permissions;
    public Associacoes $associacoes;
    public function __construct(Associacoes $a, $id, $nome, $email, $user, $password, $session_id, $permissions) {
        $this->associacoes = $a;
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->user = $user;
        $this->password = $password;
        $this->session_id = $session_id;
        $this->permissions = $permissions;
    }
    public function getIdSocio(){
        return $this->id;
    }
    public function getNomeSocio(){
        return $this->nome;
    }
    public function getEmailSocio(){
        return $this->email;
    }
    public function getUserSocio(){
        return $this->user;
    }
    public function getPassowordSocio(){
        return $this->password;
    }
    public function getSessionId(){
        return $this->session_id;
    }
    public function getPermissions(){
        return $this->permissions;
    }
}
?>