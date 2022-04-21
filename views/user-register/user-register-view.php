<?php
    // Evita acesso direto a este ficheiro
    if (!defined('ABSPATH'))
        exit;
    $adm_uri = HOME_URI . '/user-register/index/';
    $edit_uri = $adm_uri . 'edit/';
    $delete_uri = $adm_uri . 'del/';
    $modelo->validate_register_form();
    $modelo->get_register_form( chk_array( $parametros, 1 ) );
    $modelo->del_user( $parametros );
?>
<div class="wrap">
    <form method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
            <tr>
                <td>
	                Nome: <br>
	                <input type="text" name="user_name" value="<?php echo htmlentities(chk_array($modelo->form_data, 'user_name'));?>" />
                </td>
            </tr>
            <tr>
			    <td>
	                User: <br>
	                <input type="text" name="user" value="<?php echo htmlentities(chk_array($modelo->form_data, 'user')); ?>" />
                </td>
            </tr>
            <tr>
			    <td>
	                Email: <br>
	                <input type="text" name="user_email" value="<?php echo htmlentities(chk_array($modelo->form_data, 'user_email')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Password: <br>
	                <input type="password" name="user_password" value="<?php echo htmlentities(chk_array($modelo->form_data, 'user_password')); ?>" />
                </td>
            </tr>
            <tr>
                <td>
	                Permissions<small>(Separate permissions using commas)</small>
                </td>
				<td>
                    <input type="text" name="user_permissions" value="<?php echo htmlentities( chk_array( $modelo->form_data, 'user_permissions') ); ?>" />				
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
    <!-- LISTA os user -->
    <?php 
	$lista = $modelo->get_user_list(); 
    ?>
    <h2>Lista de Users</h2>
    <table class="list-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilizador</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Permissões</th>
                <th>Edição</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lista as $user): ?>
            <tr>
                <td><?php echo $user['user_id'] ?></td>
                <td><?php echo $user['user'] ?></td>
                <td><?php echo $user['user_name'] ?></td>
                <td><?php echo $user['user_email'] ?></td>
                <td>
                    <?php 
                    echo implode(',', 
                    unserialize($user['user_permissions']))
                    ?>
                </td>
                <td>
                    <a href="<?=$edit_uri.$user['user_id'] ?>">Editar</a> 
                    &nbsp;&nbsp;
                    <a href="<?=$delete_uri.$user['user_id'] ?>">Delete</a> 
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php //$modelo->paginacao(); ?>
</div> <!-- .wrap -->
