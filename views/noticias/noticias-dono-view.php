<?
if (!defined('ABSPATH'))
    exit;
$dono_uri = HOME_URI . '/noticias/dono/';
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
	                Noticia titulo: <br>
	                <input type="text" name="noticia_titulo" value="<?= htmlentities(chk_array($modelo->form_data, 'noticia_titulo')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Noticia descricao: <br>
	                <input type="text" name="noticia_descricao" value="<?= htmlentities(chk_array($modelo->form_data, 'noticia_descricao')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
                    Imagem: <br>
                    <input type="file" name="noticia_image" value="" />
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
    $iteratorNoticias = new _Iterator($lista);
    ?>
    <h1>Minhas noticias</h1>
    <table id="tbl-table" class="list-table">
    <thead>
            <tr>
                <th>ID</th>
                <th>desc</th>
                <th>img</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody>
            <? while($iteratorNoticias->hasNext()): ?>
            <? $listaIt = $iteratorNoticias->currentPos();  ?>
            <tr>
                <td><a href="<?= HOME_URI ?>/noticias/index/<?=$listaIt['assoc_id'].'/'.$listaIt['noticia_id'] ?>"><?= $listaIt['noticia_titulo'] ?></a></td>
                <td><?= $listaIt['noticia_descricao'] ?></td>
                <td>
                    <p><img src="<?= HOME_URI . '/views/_uploads/' . $listaIt['noticia_image']; ?>" width="30px"></p>
                </td>
                <td>
                    <a href="<?= $edit_uri.$listaIt['noticia_id'] ?>">Editar</a>
                    &nbsp;&nbsp;
                    <a href="<?= $delete_uri . $listaIt['noticia_id'] ?>">Apagar</a>
                </td>
            </tr>
            <? $iteratorNoticias->next();  ?>
            <? endwhile; ?>
        </tbody>
    </table>
</div>