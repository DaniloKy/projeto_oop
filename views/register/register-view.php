<?php if (!defined('ABSPATH')) exit;
if ( $this->logged_in ) {
	echo '<p class="alert">Sessão ativa.</p>';
}
$modelo->new_register_form();
?>
<div class="wrap">
	<form method="post">
		<table class="form-table">
			<tr>
				<td>User</td> 
				<td><input type="text" name="user"></td>
			</tr>
			<tr>
				<td>User Name</td> 
				<td><input type="text" name="user_name"></td>
			</tr>
			<tr>
				<td>Email</td> 
				<td><input type="email" name="user_email"></td>
			</tr>
			<tr>
				<td>Password </td>
				<td><input type="password" name="user_password"></td>
			</tr>
			<tr>
				<td>Confirm Password </td>
				<td><input type="password" name="user_password_conf"></td>
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