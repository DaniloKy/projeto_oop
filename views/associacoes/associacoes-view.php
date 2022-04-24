<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    $lista = $modelo->list_my_table();
    $modelo->form_confirma = $modelo->assoc_insc();
    $modelo->form_enter = $modelo->findIfInsc();
    $iteratorAssociacoes = new _Iterator($lista);
    ?>
    <p><a href="<?=HOME_URI?>/associacoes/criar/">Criar</a> uma associacao</p>
    <?
        echo $modelo->form_confirma;
    ?>
    <h1>Lista de associacoes</h1>
    <? while($iteratorAssociacoes->hasNext()): ?>
        <? $listaIt = $iteratorAssociacoes->currentPos();  ?>
        <h1>
            <a href="<?=HOME_URI ?>/associacoes/index/<?=$listaIt['assoc_id'] ?>"><?=$listaIt['assoc_nome'] ?></a>
        </h1>
        <h2>Preco quota: <?=$listaIt['assoc_quotas_preco'] ?>$</h2>
        <? if (is_numeric(chk_array($modelo->parametros, 0))):?>
            <?$this->prev_page = true;
            if ($this->prev_page) {?>
                <a href="<?= HOME_URI ?>/associacoes/index/">Voltar</a>
            <? } ?>
            <p><a href="<?=HOME_URI?>/galeria/index/<?=$listaIt['assoc_id']?>">Galeria</a> da associacao | <a href="<?=HOME_URI?>/noticias/index/<?=$listaIt['assoc_id']?>">Noticias</a> da associacao</p>
            <p>Morada: <?=$listaIt['assoc_morada'] ?></p>
            <p>Numero Contribuinte: <?=$listaIt['assoc_numContribuinte'] ?></p>
            <p>Dono: <?=$listaIt['user_name'] ?></p>        
            <?= $modelo->form_enter;?>
        <? endif;?>
        <hr />
        <? $iteratorAssociacoes->next();  ?>
    <? endwhile; ?>
</div> <!-- .wrap -->