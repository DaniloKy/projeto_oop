<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    $lista = $modelo->list_noticias();
    $iteratorNoticias = new _Iterator($lista);
    ?>
    <h1>Lista de noticias</h1>
    <?if (is_numeric(chk_array($modelo->parametros, 0))): ?>
        <?
        $this->prev_page = true;
        if ($this->prev_page) {?>
            <a href="<?= HOME_URI ?>/noticias/index/">Voltar</a>
        <? } ?>
    <? endif;?>
    <? while($iteratorNoticias->hasNext()): ?>
        <? $listaIt = $iteratorNoticias->currentPos();  ?>
        <h1>
            <a href="<?=HOME_URI ?>/noticias/index/<?=$listaIt['assoc_id'].'/'.$listaIt['noticia_id'] ?>"><?=$listaIt['noticia_titulo'] ?></a>
        </h1>
        <p><small>De: <a href="<?=HOME_URI.'/associacoes/index/'.$listaIt['assoc_id'] ?>"><?=$listaIt['assoc_nome'] ?></a></small></p>
        <?
        if (is_numeric(chk_array($modelo->parametros, 1))): ?>
            <p><?=$listaIt['noticia_descricao'] ?></p>
            <p>
                <img src="<?=HOME_URI . '/views/_uploads/' . $listaIt['noticia_image']; ?>" width="200px">
            </p>
        <? endif;?>
        <hr />
        <? $iteratorNoticias->next(); ?>
    <? endwhile; ?>
</div>
