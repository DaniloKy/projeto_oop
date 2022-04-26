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
    $iteratorAssoc_Noticias = new _Iterator($this->assoc_noticias);
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
        <? while($iteratorAssoc_Noticias->hasNext()): ?>
            <? $listaIt = $iteratorAssoc_Noticias->currentPos();?>
            <? $iteratorNoticias = new _Iterator($listaIt->noticias); ?>
            <? while($iteratorNoticias->hasNext()): ?>
                <? $listaNot = $iteratorNoticias->currentPos();?>
                <tr>
                    <td><a href="<?= HOME_URI ?>/noticias/index/<?=$listaIt->getId().'/'.$listaNot->getIdNot() ?>"><?= $listaNot->getTituloNot() ?></a></td>
                    <td><?= $listaNot->getDescNot() ?></td>
                    <td>
                        <p><img src="<?= HOME_URI . '/views/_uploads/' . $listaNot->getImagemNot(); ?>" width="30px"></p>
                    </td>
                    <td>
                        <a href="<?= $dono_uri.$listaIt->getId().'/edit/'.$listaNot->getIdNot() ?>">Editar</a>
                        &nbsp;&nbsp;
                        <a href="<?= $dono_uri.$listaIt->getId().'/del/'.$listaNot->getIdNot() ?>">Apagar</a>
                    </td>
                </tr>
            <? $iteratorNoticias->next();  ?>
            <? endwhile; ?>
        <? $iteratorAssoc_Noticias->next();  ?>
        <? endwhile; ?>
        </tbody>
    </table>
</div>