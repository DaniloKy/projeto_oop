<?
if (!defined('ABSPATH'))
    exit;
$adm_uri = HOME_URI . '/associacoes/adm/';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'del/';
$modelo->obtem_table();
$modelo->form_confirma = $modelo->apaga_table();
$modelo->sem_limite = false;
// Número de posts por página
?>
<?=$_SESSION['userdata']['user_session_id'] ?>
<div class="wrap">
    <?
    echo $modelo->form_confirma;
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
	                Nome: <br>
	                <input type="text" name="assoc_nome" value="<?php echo htmlentities(chk_array($modelo->form_data, 'assoc_nome')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Num.Contribuinte: <br>
	                <input type="text" name="assoc_morada" value="<?php echo htmlentities(chk_array($modelo->form_data, 'assoc_morada')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Num.Contribuinte: <br>
	                <input type="text" name="assoc_numContribuinte" value="<?php echo htmlentities(chk_array($modelo->form_data, 'assoc_numContribuinte')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Preco quotas: <br>
	                <input type="text" name="assoc_quotas_preco" value="<?php echo htmlentities(chk_array($modelo->form_data, 'assoc_quotas_preco')); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $modelo->form_msg; ?>
                    <input type="submit" value="Save" />
                </td>
            </tr>
        </table>
        <input type="hidden" name="insere_table" value="1" />
    </form>
    <?
    $lista = $modelo->list_my_table();
    $iteratorAssociacoes = new _Iterator($lista);
    ?>
    <h1>Lista de associacoes</h1>
    <table id="tbl-table" class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Morada</th>
                <th>Num.Contribuinte</th>
                <th>Preco Quotas</th>
                <th>Dono</th>
                <th>Email Dono</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody>
            <? while($iteratorAssociacoes->hasNext()): ?> 
            <? $listaIt = $iteratorAssociacoes->currentPos(); ?>
            <tr>
                <td>
                    <a href="<?php echo HOME_URI ?>/associacoes/index/<?php echo $listaIt['assoc_id'] ?>"><?php echo $listaIt['assoc_nome'] ?></a>
                </td>
                <td><?= $listaIt['assoc_morada'] ?></td>
                <td><?= $listaIt['assoc_numContribuinte'] ?></td>
                <td><?= $listaIt['assoc_quotas_preco'] ?>$</td>
                <td><?= $listaIt['user_name'] ?></td>
                <td><?= $listaIt['user_email'] ?></td>
                <td>
                    <a href="<?php echo $edit_uri . $listaIt['assoc_id'] ?>">Editar</a> 
                    &nbsp;&nbsp;
                    <a href="<?php echo $delete_uri . $listaIt['assoc_id'] ?>">Apagar</a>
                </td>
            </tr>
            <? $iteratorAssociacoes->next();  ?>
            <? endwhile; ?>
        </tbody>
    </table>
</div>