<?php $this->start('head'); ?>
<?php $this->end(); ?>


<?php $this->start('body');?>
<div class="card text-center">
    <div class="card-header">
        <h1 class="text-primary"><?=$this->module_name ?></h1>
    </div>
    <div class="card-body">
        <div class="row">

            <?php if (!empty($this->cours)) : ?>

            <?php foreach ($this->cours as $cour) :?>
                <div class="card text-center col-sm">
                    <div class="card-header">
                        <h3 class="card-title">Enseignant: <?=$cour->nom?> <?=$cour->prenom?></h3>
                    </div>
                    <div class="card-body">
                        <h4 class="card-text">Objectif du cour:</h4>
                        <p class="card-text"><?=$cour->objectif?></p>
                        <h4 class="card-text">Description:</h4>
                        <p class="card-text"><?=$cour->description?></p>
                    </div>
                    <div class="card-footer text-muted">
                        <form action="/etudiant/inscrire" method="post">
                            <div class="form group">
                                <button type="submit" name="ok" class="btn btn-primary" value="<?=$cour->id_enseignant?>_<?=$cour->id_module?>">S'inscrire</button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php endforeach; ?>
            <?php else: ?>
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Apparement aucun enseignant ne donne encore des cours dans ce module</h3>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Revenez prochainement dans cette cection et dés qu'un prof enregistre un cours vous allez le trouver ici !</h4>
                        <p class="card-text">Mettez vous à l'aise et allez chercher d'autres modules!</p>

                    </div>
                    <div class="card-footer text-muted">
                        <a href="/etudiant/index" class="btn btn-primary">Voir les autres modules</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->end(); ?>

