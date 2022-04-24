<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    $lista = $modelo->list_gallery();
    $iteratorGaleria = new _Iterator($lista);
    ?>
    <a href="<?= HOME_URI ?>/associacoes/index/<?= chk_array($this->parametros, 0)?>">Voltar</a>
    <h1>Lista de galeria</h1>
    <? while($iteratorGaleria->hasNext()): ?>
        <? $listaIt = $iteratorGaleria->currentPos();  ?>
        <h1><?=$listaIt['image_title'] ?></h1>
        <p>
            <img src="<?=HOME_URI . '/views/_uploads/' . $listaIt['image_src']; ?>" width="200px">
        </p>
        <? $iteratorGaleria->next();  ?>
    <? endwhile; ?>
</div> <!-- .wrap -->
