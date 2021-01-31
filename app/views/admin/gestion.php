<?php $this->start('head'); ?>

<script>
    function testAjax(){
        $.post("/admin/test",{id :13},function (data,status){
            console.log(data);
        });
    }
</script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>
<header>
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a class="nav-link active" href="/admin/gestion">Nouveau compte</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/update">Gestion des comptes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="/admin/logout" tabindex="-1" aria-disabled="true">Se déconnecter</a>
        </li>
    </ul>
</header>
<div class="container">
            <h1 class="text-primary text-center">Remplir ce formulaire avec les données de l'enseignant</h1>
            <form  class="form" action="" method="post" id="signUpForm" name="signUpForm">
                <div class="form-errors"><?= $this->displayErrors ?></div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" >
                </div>
                <div class="form-group">
                    <label for="Prenom">Prenom</label>
                    <input type="text" class="form-control" id="Prenom" name="prenom" >
                </div>
                <div class="form-group">
                    <label for="Date_naissance">Date de naissance</label>
                    <input type="date" class="form-control" id="Date_naissance" name="date_naissance" >
                </div>

                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control" id="Email" name="email" >
                    <p id="correction_email"> </p>
                </div>
                <div class="form-group">
                    <label for="Mot_de_passe">Mot de passe</label>
                    <input type="password" class="form-control" id="Mot_de_pass" name="password" >
                    <p id="correction_psw"> </p>
                </div>
                <div class="form-group">
                    <label for="Confirmer">Confirmez le mot de passe</label>
                    <input type="password" class="form-control" id="Confirmer" name="confirmer" >
                    <p id="correction_conf"> </p>
                </div>
                <div class="form-group">
                    <label for="numero_etudiant">Saisissez le numero d'enseignant</label>
                    <input type="password" class="form-control" id="numero_enseignant" name="numero_enseignant" >
                </div>

                <button type="submit" class="btn btn-primary" id="okButton" name="okButton" >Creer un compte</button>
            </form>
</div>
<?php $this->end(); ?>
