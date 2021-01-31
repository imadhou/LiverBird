
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
<div class="card text-center">
    <div class="card-header">
        <h1 class="text-primary">Inscrivez vous dans des cours et soyez à jour avec vos enseignants</h1>
    </div>
    <div class="card-body">
        <div class="row">
        <?php foreach ($this->modules as $module) : $lien = strtolower($module->nom);$l = explode(' ',$lien); $lien = implode('_',$l);?>
            <div class="card col-sm-6" style="padding: 1%">
                <img src="/images/<?=$module->lien?>" class="card-img-top" alt="<?= $module->nom ?>" height="150px">
                <div class="card-body">
                    <h5 class="card-title"><?=$module->nom?></h5>
                    <p class="card-text"><?=$module->description?></p>
                    <a href="/etudiant/index/<?=$lien?>" class="btn btn-primary">Voir les cours</a>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>

<?php $this->end();?>
