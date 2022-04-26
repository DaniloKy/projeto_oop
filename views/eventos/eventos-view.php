<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    $lista = $modelo->list_my_table();
    $modelo->form_confirma = $modelo->evento_insc();
    $modelo->form_enter = $modelo->findIfInsc();
    $iteratorEvento = new _Iterator($lista);
    ?>
    <a href="<?= HOME_URI ?>/eventos/index/<?= chk_array($this->parametros, 0)?>">Voltar</a>
    <h1>Lista de eventos</h1>
    <?
        echo $modelo->form_confirma;
    ?>
    <? while($iteratorEvento->hasNext()): ?>
        <? $listaIt = $iteratorEvento->currentPos();  ?>
        <h1><a href="<?=HOME_URI ?>/eventos/index/<?=$listaIt['assoc_id'].'/'.$listaIt['evento_id'] ?>"><?=$listaIt['evento_titulo'] ?></a></h1>
        <? if (is_numeric(chk_array($modelo->parametros, 1))): ?>
            <p><?=$listaIt['evento_descricao'] ?></p>
            <p>Data de evento: <?=$listaIt['evento_data'] ?> as <?=$listaIt['evento_horas']?>h</p>
            <?= $modelo->form_enter;?>
        <? endif;?>
        <p><a href="<?=HOME_URI.'/associacoes/index/'.$listaIt['assoc_id']?>"><?=$listaIt['assoc_nome']?></a></p>
        <hr />
        <? $iteratorEvento->next();  ?>
    <? endwhile; ?>
</div> <!-- .wrap -->
