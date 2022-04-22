<?
if (!defined('ABSPATH'))
    exit;
$dono_uri = HOME_URI . '/galeria/dono/';
$edit_uri = $dono_uri . 'edit/';
$delete_uri = $dono_uri . 'del/';
$modelo->obtem_table();
$modelo->insere_table();
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
	                Titulo da imagem: <br>
	                <input type="text" name="image_title" value="<?= htmlentities(chk_array($modelo->form_data, 'image_title')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="image_src" value="" />
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
    $lista = $modelo->list_my_table();
    $iteratorGaleria = new _Iterator($lista);
    ?>
    <h1>Lista de galeria</h1>
    <table id="tbl-table" class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Associacao</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody>
            <? while($iteratorGaleria->hasNext()): ?> 
            <? $listaIt = $iteratorGaleria->currentPos(); ?>
            <tr>
                <td>
                    <a href="<?= HOME_URI ?>/galeria/index/<?= $listaIt['assoc_id'] ?>"><?= $listaIt['image_title'] ?></a>
                </td>
                <td>
                    <p><img src="<?= HOME_URI . '/views/_uploads/' . $listaIt['image_src']; ?>" width="30px"></p>
                </td>
                <td><?= $listaIt['assoc_nome'] ?></td>
                <td>
                    <a href="<?=$dono_uri.$listaIt['assoc_id'].'/edit/'.$listaIt['image_id'] ?>">Editar</a>
                    &nbsp;&nbsp;
                    <a href="<?=$dono_uri.$listaIt['assoc_id'].'/del/'.$listaIt['image_id'] ?>">Apagar</a>
                </td>
            </tr>
            <? $iteratorGaleria->next();  ?>
            <? endwhile; ?>
        </tbody>
    </table>
</div>