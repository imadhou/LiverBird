<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="card text-center" >
    <div class="card-header">
        <h1 class="text-primary">C'est ici que vont vos cours!</h1>
        <h5 class="card-title text-secondary" >Vous trouverez ici les modules dans lesquels vous avez donné des cours</h5>
    </div>
</div>
<?php if (!empty($this->cours)) : ?>
<?php foreach ($this->cours as $cour) : $nom = strtolower($cour->nom); $l = explode(' ',$nom); $nom = implode('_',$l)?>
<div class="card text-center">
    <div class="card-header">
        <img src="/images/<?= $cour->lien?>" class="card-img" alt="<?= $cour->nom?>" height="300px">
        <h3 class="card-title class text-info"><?= $cour->nom?></h3>
    </div>
    <div class="card-body">
        <div class="card border border-primary">
            <p>
            <h4>Objectif de votre cour: </h4> <p class="card-body"><?= $cour->objectif?></p>
            <h4>Prerequis : </h4><p class="card-body" ><?= $cour->prerequis?></p>
            <h4 class="card-title">Un mot par vous : </h4><p class="card-body"><?= $cour->description?></p>
            </p>
        </div>
        <a href="/enseignant/mescours/<?=$nom?>" class="btn btn-primary" style="margin-top: 10px;">Voir le cour</a>
    </div>
</div>
<?php endforeach; ?>
<?php else: ?>
    <div class="card text-center" style="margin: 5%">
        <div class="card-header">
            <h3 class="card-title">Vous n'avez aucun cour pour le moment</h3>
        </div>
        <div class="card-body">

            <p class="card-text"><h5>Dès que vous inscriviez dans un cour vous le trouverez ici</h5></p>

            <a href="/enseignant/index" class="btn btn-primary">Voir les modules</a>
        </div>
    </div>
<?php endif ;?>
<?php $this->end(); ?>

