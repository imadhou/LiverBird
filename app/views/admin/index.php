<?php $this->start('head'); ?>
<?php $this->end(); ?>


<?php $this->start('body'); ?>
<div class="card text-center">
    <h1 class="text-primary text-center">Connectez vous</h1>
    <form class="form" action="/admin/index" method="post">
        <div class="form-errors"><?= $this->displayErrors ?></div>


        <div class="form-group">
            <label for="user">Nom d'utilisateur</label>
            <input type="text" class="form-control" name="admin" id="admin">
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="adminpasswd" id="adminpasswd">
        </div>

        <div class="form-group">
            <input type="submit" value="Connecter" class="btn btn-large btn-primary"/>
        </div>

    </form>
</div>

<?php $this->end();?>


