<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="row">
        <div class="card col-sm" style="padding: 5%">
            <div class="card-body">
                <h5 class="card-title" style="margin-bottom: 8%">Vos informations sont ici!</h5>
                <table class="table">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td><p>Nom</p></td>
                        <td><p><?= $this->enseignant->nom ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Prenom</p></td>
                        <td><p><?= $this->enseignant->prenom ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Email</p></td>
                        <td><p><?= $this->enseignant->email ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Numero enseignant</p></td>
                        <td><p><?= $this->enseignant->numero_enseignant ?></p></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-sm" style="padding: 5%">
            <div class="card-body">
                <h5 class="card-title">Reinitialiser votre mot de passe</h5>
                <form method="post" action="/enseignant/profile" >
                    <ul class="form-errors text-primary">
                        <?php foreach ($this->h as $value) :?>
                        <li><?=$value?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="form-group" style="margin: 2%">
                        <label for="pass1">Votre mot de passe actuel:</label>
                        <input type="password" class="form-control" id="pass1" name="pass1" >
                        <p id="correction_psw"> </p>
                    </div>
                    <div class="form-group" style="margin: 2%">
                        <label for="pass2">Saisissez votre nouveau mot de passe:</label>
                        <input type="password" class="form-control" id="pass2" name="pass2" >
                        <p id="correction_conf"> </p>
                    </div>
                    <div class="form-group" style="margin: 2%">
                        <label for="pass3">Confirmez votre npuveau mot de passe:</label>
                        <input type="password" class="form-control" id="pass3" name="pass3" >
                        <p id="correction_conf"> </p>
                    </div>
                    <div class="form-group" style="margin: 2%">
                        <button type="submit" class="btn btn-primary" id="subm" name="subm">Reinitialiser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php $this->end(); ?>
