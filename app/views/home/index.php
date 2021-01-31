<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="container" style="margin: 2%">
    <h1 class="text-primary">#Eredlearning! le distantiel d'une manière différente
        !</h1>
</div>

<div id="carouselExampleCaptions" class="carousel carousel-dark carousel slide" data-ride="carousel"
     style="padding: 1%;">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/images/02.jpg" class="img-fluid d-block w-100" alt="Optez pour le e-earning">
            <div class="carousel-caption d-none d-md-block">
                <h3 class=" text-body fw-bold">Optez pour le e-learning</h3>
                <h4 class="text-primary fw-bold">Restez en sécurité et etudiez à distance</h4>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/images/03.png" class="img-fluid d-block w-100" alt="Suivez vos cours à distance">
            <div class="carousel-caption d-none d-md-block">
                <h3 class=" text-body fw-bold">Suivez vos cours à distance</h3>
                <h4 class="text-primary fw-bold">Ne ratez plus vos cours! suivez-les à distance</h4>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/images/01.jpg" class="img-fluid d-block w-100" alt="Réussir grace à l'apprentissage à distance">
            <div class="carousel-caption d-none d-md-block">
                <h3 class=" text-body fw-bold">Réussir grace à l'apprentissage à distance</h3>
                <h4 class="text-primary fw-bold">La réussite ne tardera pas à frappez votre porte</h4>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div class="card text-center">
    <div class="card-header">
        <h3 class="text-secondary">Bienvenue sur la plateforme E-redlearning là où un tas de savoir vous attend!</h3>
        <h4>La plateforme d’enseignement E-redlearning soutient l'enseignement et l'apprentissage en ligne.</h4>

        <p>Elle permet aux étudiant-e-s d'accéder aux supports de cours ainsi qu'aux activités mis en ligne par leurs
            enseignant-e-s.</p>
        <h5>Vous trouverez sur cette plateforme :</h5>
        <ul style="list-style-type: none;">
            <li>Des cours au format texte ( directement sur le site/fichiers à télécharger )</li>
            <li>Des cours vidéos</li>
            <li>Et n'oublions pas les devoirs</li>

        </ul>
    </div>

    <div class="card-body">
        <div class="row">
            <?php foreach ($this->modules as $module) : ?>
                <div class="col-sm-6" style="padding: 1%">
                    <div class="card">
                        <img src="/images/<?= $module->lien ?>" class="rounded float-end" alt="<?= $module->nom ?>"
                             height="150">
                        <div class="card-body">
                            <h3 class="card-title"><?= $module->nom ?></h3>
                            <p class="card-text"><?= $module->description ?></p>
                            <a href="/register/register" class="btn btn-primary">Voir plus</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php $this->end(); ?>
