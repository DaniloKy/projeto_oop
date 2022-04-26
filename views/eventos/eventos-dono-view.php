<?
if (!defined('ABSPATH'))
    exit;
$dono_uri = HOME_URI . '/eventos/dono/';
$edit_uri = $dono_uri . 'edit/';
$delete_uri = $dono_uri . 'del/';
$modelo->obtem_table();
$modelo->insere_table();
$modelo->form_confirma = $modelo->apaga_table();
$modelo->sem_limite = false;
?>
<div class="wrap">
    <?
    echo $modelo->form_confirma;
    ?>
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
	                Evento titulo: <br>
	                <input type="text" name="evento_titulo" value="<?= htmlentities(chk_array($modelo->form_data, 'evento_titulo')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Evento descricao: <br>
	                <input type="text" name="evento_descricao" value="<?= htmlentities(chk_array($modelo->form_data, 'evento_descricao')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Evento data: <br>
	                <input type="date" name="evento_data" value="<?= htmlentities(chk_array($modelo->form_data, 'evento_data')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Evento horas: <br>
	                <input type="time" name="evento_horas" value="<?= htmlentities(chk_array($modelo->form_data, 'evento_horas')); ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?= $modelo->form_msg; ?>
                    <input type="submit" value="Save" />
                </td>
            </tr>
        </table>
        <input type="hidden" name="assoc_id" value="" />
        <input type="hidden" name="insere_table" value="1" />
    </form>
    <?
    $lista = $modelo->list_my_table();
    $iteratorEventos = new _Iterator($lista);
    ?>
    <h1>Meus eventos</h1>
    <table id="tbl-table" class="list-table">
    <thead>
            <tr>
                <th>ID</th>
                <th>desc</th>
                <th>data</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody>
            <? while($iteratorEventos->hasNext()): ?>
            <? $listaIt = $iteratorEventos->currentPos();  ?>
            <tr>
                <td><a href="<?= HOME_URI ?>/eventos/index/<?=$listaIt['assoc_id'].'/'.$listaIt['evento_id'] ?>"><?= $listaIt['evento_titulo'] ?></a></td>
                <td><?= $listaIt['evento_descricao'] ?></td>
                <td>
                    <p><?= $listaIt['evento_data'].' '.$listaIt['evento_horas'] ?></p>
                </td>
                <td>
                    <a href="<?= $dono_uri.$listaIt['assoc_id'].'/edit/'.$listaIt['evento_id'] ?>">Editar</a>
                    &nbsp;&nbsp;
                    <a href="<?= $dono_uri.$listaIt['assoc_id'].'/del/'.$listaIt['evento_id'] ?>">Apagar</a>
                </td>
            </tr>
            <? $iteratorEventos->next();  ?>
            <? endwhile; ?>
        </tbody>
    </table>
</div>