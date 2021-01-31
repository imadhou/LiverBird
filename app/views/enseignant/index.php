<?php $this->start('head'); ?>
<script>
    $('document').ready(function (){
        $(".btn-primary").click(function (){
            if($(this).closest(".card-body").children(".l1").css('display') == 'none'){
                $(this).closest(".card-body").children(".l1").show();
            }else {
                $(this).closest(".card-body").children(".l1").hide();
            }
        });


    });
</script>
<?php $this->end(); ?>

<?php $this->start('body');?>
<div class="row">
         <div class="card text-center">
             <div class="card-header">
                 <h1 class="text-primary">Bienvenu sur votre éspace mr <?=$this->ens->prenom?> <?=$this->ens->nom?> </h1>
             </div>
             <div class="card-body">
                 <h5 class="text-dark">Vous trouvez ici la liste des modules disponibles dans notre platforme</h5>
                 <p class="text-dark">
                     Vous pouvez choisir un module, et commencer à donner des cours, choisissez votre module et clickez sur <i>Donner des cours</i>
                     ensuite vous n'avez qu'à remplir le petit formulaire qui va vous apparaitre
                 </p>
             </div>
         </div>
     <div class="row">
         <?php foreach ($this->res as $key) : $lien = strtolower($key->nom);$l = explode(' ',$lien); $lien = implode('_',$l);?>
             <div class="col-sm-6" style="margin-top: 20px;">
                 <div class="card" >
                     <img src="/images/<?= $key->lien?>" class="rounded float-end" alt="<?= $key->nom ?>" height="150px">
                     <div class="card-body">
                         <h5 class="card-title"><?= $key->nom ?></h5>
                         <p class="card-text"><?= $key->description ?></p>
                         <p class="btn-primary btn">Donner des cours</p>
                         <div class="l1 card card-body" style="display: none">
                             <form method="post" action="/enseignant/index/">
                                 <div class="form-group row">
                                     <label for="objectif"> Objectif :</label>
                                     <input type="text" name="objectif" class="form-control">
                                 </div>
                                 <div class="form-group row">
                                     <label for="prerequis"> Prérequis: :</label>
                                     <input type="text" name="prerequis" class="form-control">
                                 </div>
                                 <div class="form-group row">
                                     <label for="description"> Description :</label>
                                     <textarea type="text" name="description" class="form-control"></textarea>
                                 </div>
                                 <input type="hidden" name="lien" value="<?= $lien?>">
                                 <div class="form-group">
                                     <button type="submit" class="btn btn-primary" name="enregistrer" value="<?=$key->id?>">Enregistrer</button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
         <?php endforeach; ?>
     </div>
 </div>
<?php $this->end();?>