<?
class Noticias {
    private $id;
    private $titulo;
    private $descricao;
    private $imagem;
    public function __construct($id, $titulo, $descricao, $imagem) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->imagem = $imagem;
    }
    public function getIdNot(){
        return $this->id;
    }
    public function getTituloNot(){
        return $this->titulo;
    }
    public function getDescNot(){
        return $this->descricao;
    }
    public function getImagemNot(){
        return $this->imagem;
    }
}
?>