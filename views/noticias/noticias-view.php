<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    //$lista = $modelo->list_noticias();
    $iteratorAssoc_Noticias = new _Iterator($this->assoc_noticias);
    ?>
    <h1>Lista de noticias</h1>
    <?if (is_numeric(chk_array($modelo->parametros, 0))): ?>
        <?
        $this->prev_page = true;
        if ($this->prev_page) {?>
            <a href="<?= HOME_URI ?>/noticias/index/">Voltar</a>
        <? } ?>
    <? endif;?>
    <? while($iteratorAssoc_Noticias->hasNext()): ?>
        <? $listaIt = $iteratorAssoc_Noticias->currentPos();?>
        <? $iteratorNoticias = new _Iterator($listaIt->noticias); ?>
        <? while($iteratorNoticias->hasNext()): ?>
            <? $listaNot = $iteratorNoticias->currentPos();?>
            <h1>
                <a href="<?=HOME_URI ?>/noticias/index/<?=$listaIt->getId().'/'.$listaNot->getIdNot() ?>"><?=$listaNot->getTituloNot() ?></a>
            </h1>
            <p><small>De: <a href="<?=HOME_URI.'/associacoes/index/'.$listaIt->getId() ?>"><?=$listaIt->getNome() ?></a></small></p>
            <?
            if (is_numeric(chk_array($modelo->parametros, 1))): ?>
                <p><?=$listaNot->getDescNot() ?></p>
                <p>
                    <img src="<?=HOME_URI . '/views/_uploads/' . $listaNot->getImagemNot(); ?>" width="200px">
                </p>
            <? endif;?>
            <hr />
            <? $iteratorNoticias->next(); ?>
        <? endwhile; ?>
        <? $iteratorAssoc_Noticias->next(); ?>
    <? endwhile; ?>
</div>
