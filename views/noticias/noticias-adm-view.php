<?php
// Evita acesso direto a este ficheiro
if (!defined('ABSPATH'))
    exit;
// Configura as URLs
$adm_uri = HOME_URI . '/noticias/adm/';
$edit_uri = $adm_uri . 'edit/';
$delete_uri = $adm_uri . 'del/';
// Carrega o método para obter uma noticias
$modelo->obtem_table();
// Carrega o método para inserir uma noticias
$modelo->insere_table();
// Carrega o método para apagar a noticias
$modelo->form_confirma = $modelo->apaga_table();
// Remove o limite de valores da lista de noticias
$modelo->sem_limite = false;
// Número de posts por página
?>
<?=$_SESSION['userdata']['user_session_id'] ?>
<div class="wrap">
    <?php
    // Mensagem de configuração caso o user tente apagar algo
    echo $modelo->form_confirma;
    ?>
    <!-- Formulário de edição das noticias -->
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
	                Titulo: <br>
	                <input type="text" name="noticia_titulo" value="<?php echo htmlentities(chk_array($modelo->form_data, 'noticia_titulo')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Descricao: <br />
	                <input type="text" name="noticia_descricao" value="<?php echo htmlentities(chk_array($modelo->form_data, 'noticia_descricao')); ?>" />
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
    <h1>Lista de noticias</h1>
    <table id="tbl-table" class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>desc</th>
                <th>img</th>
                <th>Associacao</th>
                <th>edit</th>
            </tr>
        </thead>
        <tbody>
            <? while($iteratorAssociacoes->hasNext()): ?>
            <? $listaIt = $iteratorAssociacoes->currentPos();  ?>
            <tr>
                <td><a href="<?= HOME_URI ?>/noticias/index/<?=$listaIt['assoc_id'].'/'.$listaIt['noticia_id'] ?>"><?php echo $listaIt['noticia_titulo'] ?></a></td>
                <td><?= $listaIt['noticia_descricao'] ?></td>
                <td>
                    <p><img src="<?php echo HOME_URI . '/views/_uploads/' . $listaIt['noticia_image']; ?>" width="30px"></p>
                </td>
                <td><?= $listaIt['assoc_nome'] ?></td>
                <td>
                    <a href="<?php echo $edit_uri . $listaIt['noticia_id'] ?>">Editar</a> 
                    &nbsp;&nbsp;
                    <a href="<?php echo $delete_uri . $listaIt['noticia_id'] ?>">Apagar</a>
                </td>
            </tr>
            <? $iteratorAssociacoes->next();  ?>
            <? endwhile; ?>
        </tbody>
    </table>
</div> <!-- .wrap -->