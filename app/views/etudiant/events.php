<?php $this->start('head'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php $this->end();?>
<?php $this->start('body');?>

    <div class="card text-center">
        <div class="card-header">
            <h1 class="text-primary">Mes devoirs et évennements</h1>
        </div>
        <div class="card-body">
            <h4 class="card-title">Vous trouverez ici la listes des evenements auquels vous avez repondu et ceux qui vous attendent</h4>
            <h5 class="card-text">Sélectionner un module dans cette la liste ci-dessous et voir si votre travaille est évalué ou pas</h5>
            <h5 class="card-text"> Vous allez aussi voir les évenements auquels vous devez répondre prochaineent</h5>
            <p><h4 class="text-danger">Attention</h4> <h5 class="text-danger">une fois votre travail et remis vous ne pouvez plus le changer</h5></p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
        </div>
        <div class="card-footer text-muted">
            2 days ago
        </div>
    </div>
    <form style="padding: 1%" action="/etudiant/events" method="post">
        <div class="form-group">
            <select class="form-select form-select-lg " name="module" id="select1" required>
                <option value="">Selectionner un de vos cours</option>
                <?php foreach ($this->modules as $cours) : ?>
                    <option name="module" value="<?=$cours->id?>"><?=$cours->nom?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Voir les devoirs">
        </div>
    </form>
<?php if (isset($this->events)) :?>
<div class="card text-center" style="padding: 5%">
    <div class="card-header">
        <h3 class="text-primary">Voici les evenements qui vous attendent</h3>
    </div>
    <div class="card-body">
        <?php foreach ($this->events as  $event): ?>
            <div class="card text-center " style="margin: 5%">
                <div class="card-header">
                    <h4 class="text-secondary"><?=$event->intitule?></h4>
                    <h5><?= $event->description?></h5>
                </div>
                <div class="card-body">
                    <form action="/etudiant/events" method="post" enctype="multipart/form-data">
                        <div class="form-errors">
                            <?php if (isset($this->error)): ?>
                            <?php foreach ($this->error as $err) :?>
                            <p class="text-secondary">
                                <?=$err?>
                            </p>
                            <?php endforeach ; ?>
                            <?php endif;?>
                        </div>
                        <div class="form-group">
                            <label for="fichier">Selectionner votre fichier</label>
                            <input type="file" class="form-control" id="fichier" placeholder="Password" name="fichier" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="ok" class="btn btn-primary" value="<?=$event->id?>">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<?php endif; ?>

    <div class="card text-center">
        <div class="card-header">
            <h5 class="card-title text-primary">Vos réponses et notes</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th scope="col">Evenement</th>
                    <th scope="col">Module</th>
                    <th scope="col">Enseignant</th>
                    <th scope="col">Reponse</th>
                    <th scope="col">Note</th>
                </tr>
                </thead>
                <tbody>
                <?php if (isset($this->notes)) :?>
                <?php foreach ($this->notes as $note) : ?>
                    <tr>
                        <td><?=$note->intitule?></td>
                        <td><?=$note->module?></td>
                        <td><?=$note->prenom?> <?=$note->nom?></td>
                        <?php if ($note->lien_fichier !="") :?>
                            <td><a href="/cours/etudiant/<?=$this->etudiant->id?>/<?=$note->lien_fichier?>"><?=$note->lien_fichier?></a></td>
                        <?php else: ?>
                            <td>Vous n'avez pas encore remis votre travail</td>
                        <?php endif; ?>
                        <?php if ($note->note !="") :?>
                            <td><?=$note->note?></td>
                        <?php else: ?>
                            <td>Votre travail n'est pas encore évalué</td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach;?>
                <?php else: ?>
                <tr>
                    <td colspan="4">Vous n'avez remis aucune réponse</td>
                </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>





<?php $this->end(); ?>