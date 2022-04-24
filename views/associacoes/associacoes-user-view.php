<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    $lista = $modelo->list_my_table();
    $iteratorAssociacoes = new _Iterator($lista);
    ?>
    <h1>Lista das tuas associacoes</h1>
    <? while($iteratorAssociacoes->hasNext()): ?>
        <? $listaIt = $iteratorAssociacoes->currentPos();  ?>
        <h1>
            <a href="<?=HOME_URI ?>/associacoes/index/<?=$listaIt['assoc_id'] ?>"><?=$listaIt['assoc_nome'] ?></a>
        </h1>
        <ul>
            <li><p><a href="<?=HOME_URI?>/galeria/index/<?=$listaIt['assoc_id']?>">Galeria</a> da associacao</p></li>
            <li><p><a href="<?=HOME_URI?>/noticias/index/<?=$listaIt['assoc_id']?>">Noticias</a> da associacao</p></li>
            <li><p><a href="<?=HOME_URI?>/eventos/index/<?=$listaIt['assoc_id']?>">Eventos</a> da associacao</p></li>
            <li><p><a href="<?=HOME_URI?>/quotas/index/<?=$listaIt['assoc_id']?>">Quotas</a> da associacao</p></li>
        </ul>
        <p>Morada: <?=$listaIt['assoc_morada'] ?></p>
        <p>Numero Contribuinte: <?=$listaIt['assoc_numContribuinte'] ?></p>
        <p>Dono: <?=$listaIt['user_name'] ?></p>
        <hr />
        <? $iteratorAssociacoes->next();  ?>
    <? endwhile; ?>
</div> <!-- .wrap -->
