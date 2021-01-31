<?php $this->start('head');?>
<?php $this->end();?>


<?php $this->start('body');?>
<h1 class="text-primary">Connectez vous afin de vous acceder a votre éspace Eredlearning</h1>

    <form action="/register/login" method="post">

        <div class="form-errors"><?=$this->displayErrors?></div>
        <div class="form-group">
            <label for="email">Nom d'utilisateur / E-mail</label>
            <input type="text" class="form-control" name="email" id="email">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <p>Vous êtes: </p>
        <div class="form-group">
            <input type="radio" id="enseignant" name="usertype" value="Enseignant">
            <label for="enseignant">Enseignant</label>
            <input type="radio" id="etudiant" name="usertype" value="Etudiant">
            <label for="etudiant"> Etudiant</label>
        </div>
        <div class="form-group">
            <input type="checkbox" name="se_souvenir_de_moi" id="se_souvenir_de_moi" value="se_souvenir">
            <label for="se_souvenir_de_moi">Se souvenir de moi</label>
        </div>
        <div class="form-group">
            <input type="submit" value="Connecter" class="btn btn-large btn-primary"/>
        </div>

    </form>



<?php $this->end();?>
