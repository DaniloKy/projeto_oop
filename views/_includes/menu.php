<? if (!defined('ABSPATH')) exit; ?>

<?
if ($this->login_required && !$this->logged_in)
    return;
if ($this->logged_in) {
   echo "BemVindo: " . $this->user_name;
    ?>
    <a href="<?= HOME_URI; ?>/login/delete">Logout</a>
    <? } else {
    ?>
    <a href="<?= HOME_URI; ?>/login">Login</a>
    <?
}
?>

<nav class="menu clearfix">
    <ul>
        <li><a href="<?= HOME_URI; ?>">Home</a></li>
        <li><a href="<?= HOME_URI; ?>/associacoes/">Associações</a></li>
        <li><a href="<?= HOME_URI; ?>/noticias/">Notícias</a></li>
        <? $this->permission_required = 'gerir-associacoes';
        if($this->logged_in && $this->check_permissions($this->permission_required, $this->userdata['user_permissions'])):?>
            <li><a href="<?= HOME_URI; ?>/associacoes/dono/">Associações Dono</a></li>
        <? endif; ?>
    </ul>
</nav>
<? if($this->logged_in && $this->check_permissions($this->permission_required='admin', $this->userdata['user_permissions'])): ?>
<nav class="menu clearfix">
    <h1>Navbar Admin</h1>
    <ul>
        <? $this->permission_required = 'adm-gerir-associacoes';
        if($this->logged_in && $this->check_permissions($this->permission_required, $this->userdata['user_permissions'])):?>
            <li><a href="<?= HOME_URI; ?>/associacoes/adm/">Associações Admin</a></li>
        <? endif; ?>
        <? $this->permission_required = 'adm-gerir-noticias';
        if($this->logged_in && $this->check_permissions($this->permission_required, $this->userdata['user_permissions'])):?>
            <li><a href="<?= HOME_URI; ?>/noticias/adm/">Notícias Admin</a></li>
        <? endif; ?>
        <? $this->permission_required = 'adm-gerir-galeria';
        if($this->logged_in && $this->check_permissions($this->permission_required, $this->userdata['user_permissions'])):?>
            <li><a href="<?= HOME_URI; ?>/galeria/adm/">Galeria Admin</a></li>
        <? endif; ?>
        <? $this->permission_required = 'user-register';
        if($this->logged_in && $this->check_permissions($this->permission_required, $this->userdata['user_permissions'])):?>
            <li><a href="<?= HOME_URI; ?>/user-register/">User Register</a></li>
        <? endif; ?>
    </ul>
</nav>
<? endif; ?>