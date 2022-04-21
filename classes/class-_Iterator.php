<?
    interface IIterator{
        function hasNext();
        function next();
        function currentPos();
    }
    class _Iterator implements IIterator{
        protected $itens = array();
        protected $posicao = 0;
        public $i = 0;
        public function __construct($itens = null){
            $this->itens = $itens;
        }
        public function next(){
            $this->posicao++;
        }
        public function hasNext(){
            if($this->posicao >= count($this->itens) || $this->itens[$this->posicao] == null)
                return false;
            return true;
        }
        public function currentPos(){
            if(isset($this->itens[$this->posicao]))
                return $this->itens[$this->posicao];
        }
    }
?>