<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="card text-center">
    <div class="card-header">
        <p ><h1 class="text-primary">Mes cours: Vous trouvez ici vos cours</h1></p>
    </div>
    <?php if (!empty($this->res)) : ?>
    <div class="card-body">
        <?php foreach ($this->res as $cour) : $nom = strtolower($cour->nom); $l = explode(' ',$nom); $nom = implode('_',$l)?>
        <div class="card text-center" style="margin: 2%">
            <div class="card-header">
                <h4 class="card-title"><?= $cour->nom_module.'  :  '.$cour->nom.'  '.$cour->prenom;?></h4>
            </div>
            <div class="card-body">
                <p>Description : </p>
                <p class="card-body"><?= $cour->description?></p>
            </div>
            <div class="card-footer text-muted">
                <a href="/etudiant/mescours/<?=$cour->id_enseignant.'_'.$this->id_etu.'_'.$cour->id_module?>" class="btn btn-primary" style="margin-top: 10px;">Voir le cour</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <div class="card text-center" style="margin: 5%">
            <div class="card-header">
                <h3 class="card-title">Vous n'êtes inscrits dans aucun cours</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title">Dès que vous commencez à suivre des cours vous les retrouverez ici !</h5>
                <a href="/etudiant/index" class="btn btn-primary">Voir les cours</a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $this->end(); ?>

