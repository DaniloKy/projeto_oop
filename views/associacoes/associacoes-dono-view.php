<?
if (!defined('ABSPATH'))
    exit;
$adm_uri = HOME_URI . '/associacoes/dono/';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'del/';
$modelo->obtem_table();
$modelo->form_confirma = $modelo->apaga_table();
$modelo->sem_limite = false;
// Número de posts por página
?>
<div class="wrap">
    <?
    echo $modelo->form_confirma;
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
	                Nome: <br>
	                <input type="text" name="assoc_nome" value="<?= htmlentities(chk_array($modelo->form_data, 'assoc_nome')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Morada: <br>
	                <input type="text" name="assoc_morada" value="<?= htmlentities(chk_array($modelo->form_data, 'assoc_morada')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Num.Contribuinte: <br>
	                <input type="text" name="assoc_numContribuinte" value="<?= htmlentities(chk_array($modelo->form_data, 'assoc_numContribuinte')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Preco quotas: <br>
	                <input type="text" name="assoc_quotas_preco" value="<?= htmlentities(chk_array($modelo->form_data, 'assoc_quotas_preco')); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?= $modelo->form_msg; ?>
                    <input type="submit" value="Save" />
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_table" value="1" />
    </form>
    <?
    $iteratorAssociacoes = new _Iterator($this->associacoes);
    ?>
    <h1>Minha associacao</h1>
    <table id="tbl-table" class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Morada</th>
                <th>Num.Contribuinte</th>
                <th>Preco Quotas</th>
                <th>Dono</th>
                <th>edit</th>
                <th>Gerir</th>
            </tr>
        </thead>
        <tbody>
            <? while($iteratorAssociacoes->hasNext()): ?>
            <? $listaIt = $iteratorAssociacoes->currentPos();  ?>
            <tr>
                <td>
                    <a href="<?= HOME_URI ?>/associacoes/index/<?=$listaIt->getId() ?>"><?= $listaIt->getNome() ?></a>
                </td>
                <td><?= $listaIt->getMorada() ?></td>
                <td><?= $listaIt->getNumContribuinte() ?></td>
                <td><?= $listaIt->getAssoQuotas() ?>$</td>
                <td><?= $listaIt->getFirstSocio()->getNomeSocio() ?></td>
                <td>
                    <a href="<?= $edit_uri . $listaIt->getId() ?>">Editar</a> 
                    &nbsp;&nbsp;
                    <a href="<?= $delete_uri . $listaIt->getId() ?>">Apagar</a>
                </td>
                <td>
                    <a href="<?= HOME_URI.'/noticias/dono/'.$listaIt->getId() ?>">Noticias</a>
                    &nbsp;&nbsp;
                    <a href="<?= HOME_URI.'/galeria/dono/'.$listaIt->getId() ?>">Galeria</a>
                    &nbsp;&nbsp;
                    <a href="<?= HOME_URI.'/eventos/dono/'.$listaIt->getId() ?>">Eventos</a>
                </td>
            </tr>
            <? $iteratorMembers = new _Iterator($listaIt->socio); ?>
            <? $modelo->form_msg = $modelo->expulsar_member(); ?>
            <h3>Membros da associacao</h3>
            <table id="tbl-table" class="list-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>edit</th>
                    </tr>
                </thead>
                <tbody>
                    <? while($iteratorMembers->hasNext()): ?>
                    <? $members = $iteratorMembers->currentPos();  ?>
                    <tr>
                        <td><?= $members->getNomeSocio()?></a></td>
                        <td><?= $members->getEmailSocio()?></td>
                        <td>
                            <a href="<?= HOME_URI.'/associacoes/dono/exp/'.$listaIt->getId().'/'.$members->getIdSocio() ?>">Expulsar</a>
                        </td>
                    </tr>
                    <? $iteratorMembers->next();  ?>
                    <? endwhile; ?>
                </tbody>
            </table>
            <? $iteratorAssociacoes->next();  ?>
            <? endwhile; ?>
        </tbody>
    </table>
</div>