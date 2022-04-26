<?
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
?>
<div class="wrap">
    <?
    $modelo->form_confirma = $modelo->assoc_insc();
    $modelo->form_enter = $modelo->findIfInsc();
    $iteratorAssociacoes = new _Iterator($this->associacoes);
    ?>
    <p><a href="<?=HOME_URI?>/associacoes/criar/">Criar</a> uma associacao</p>
    <?
        echo $modelo->form_confirma;
    ?>
    <h1>Lista de associacoes</h1>
    <? while($iteratorAssociacoes->hasNext()): ?>
        <? $associacao = $iteratorAssociacoes->currentPos();  ?>
        <h1>
            <a href="<?=HOME_URI ?>/associacoes/index/<?=$associacao->getId() ?>"><?=$associacao->getNome() ?></a>
        </h1>
        <h2>Preco quota: <?=$associacao->getAssoQuotas() ?>$</h2>
        <? if (is_numeric(chk_array($modelo->parametros, 0))):?>
            <?$this->prev_page = true;
            if ($this->prev_page) {?>
                <a href="<?= HOME_URI ?>/associacoes/index/">Voltar</a>
            <? } ?>
            <p><a href="<?=HOME_URI?>/galeria/index/<?=$associacao->getId()?>">Galeria</a> da associacao | <a href="<?=HOME_URI?>/noticias/index/<?=$associacao->getId()?>">Noticias</a> da associacao</p>
            <p>Morada: <?=$associacao->getMorada() ?></p>
            <p>Numero Contribuinte: <?=$associacao->getNumContribuinte() ?></p>
            <p>Dono: <?=$associacao->getFirstSocio()->getNomeSocio() ?></p>        
            <?= $modelo->form_enter;?>
        <? endif;?>
        <hr />
        <? $iteratorAssociacoes->next();  ?>
    <? endwhile; ?>
</div>