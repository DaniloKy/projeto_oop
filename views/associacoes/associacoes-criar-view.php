<?php if (!defined('ABSPATH')) exit;
$modelo->new_associacao_form();
?>
<div class="wrap">
    <a href="<?= HOME_URI ?>/associacoes/index/">Voltar</a>
	<form method="post">
		<table class="form-table">
			<tr>
				<td>Assoc.Nome</td> 
				<td><input type="text" name="assoc_nome"></td>
			</tr>
			<tr>
				<td>Assoc.Morada</td> 
				<td><input type="text" name="assoc_morada"></td>
			</tr>
			<tr>
				<td>Assoc.NumContribuinte</td>
				<td><input type="text" name="assoc_numContribuinte"></td>
			</tr>
			<tr>
				<td>Assoc.Preco Quotas</td>
				<td><input type="text" name="assoc_quotas_preco">$</td>
			</tr>
			<tr>
				<td colspan="2">
					<?=$modelo->form_msg; ?>
					<input type="submit" value="Enter"> 
				</td>
			</tr>
		</table>
	</form>
</div>