<?php $this->start('head'); ?>
<?php $this->end();

?>

<?php $this->start('body');
?>


    <div class="container" style="padding-top: 4%; padding-bottom: 4%" >
        <?php if (!empty($this->les_sections)) : ?>
        <?php foreach ($this->les_sections as $sec) : $x = 1;?>
        <?php foreach ($sec as $k=>$v) :?>
                <div class="card text-center" style="margin: 2%">
                    <div class="card-header">
                      <h3 class="text-primary">Section:  <?=$k?> </h3>
                        <h5>Description : <?=$v[0]?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php if (!empty($v[1])): ?>
                            <div class="col-sm">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <h5 class="card-title text-info"><?= $v[1][0]->intitule?></h5>
                                        Vueillez à repondre à cet evenement dans le délai
                                    </div>
                                    <div class="card-body">
                                        <?php $d = date('Y-m-d'); if($d < $v[1][0]->date_limite) : ?>
                                            <p class="card-text"><h4 class="text-danger">N'oubliez pas! le délai est pour le <?= $v[1][0]->date_limite?> </h4></p>
                                            <p class="card-text"><?= $v[1][0]->description?></p>
                                            <a href="/etudiant/events" class="btn btn-primary">Repondre maintenant</a>
                                        <?php else: ?>
                                            <p class="card-text"><h4 class="text-secondary">Evenement déja passé!</h4></p>
                                            <p class="card-text"><?= $v[1][0]->description?></p>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($v[3])): ?>
                            <div class="col-sm" style="margin: auto">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <h4 class="card-title text-info">Vous trouvez ici les fichiers joints à cette section</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul>
                                        <?php foreach ($v[3] as $item) :?>
                                        <a href="/cours/enseignant/<?=$this->ens?>/<?=$item->lien?>"><?=$item->lien?></a>
                                        <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($v[2])): ?>
                                <div class="col-sm" style="margin: auto">
                                    <div class="card text-center">
                                        <div class="card-header ">
                                            <?php $j= -1; $i =0;$y = 0; if ($j == -1) $j = $y;?>
                                            <?php foreach ( $v[2] as $m) :
                                                $a = 1;?>
                                                <button type="button" id="vid" class="btn btn-primary" value="<?=$a?> <?= $m->lien ?>" onclick="vid(this)">Video<?= $i?></button>
                                                <?php $i++; $y++ ;$a++?>
                                            <?php endforeach; ?>
                                        </div>

                                        <div class="card-body">
                                            <div class="ratio ratio-16x9" id="cont_ytb<?=$x?>">
                                                <iframe id="ytVideo<?=$x?>" width="360" height="180" src="https://www.youtube.com/embed/<?= $v[2][0]->lien;?>" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        </div>

                                        <div class="card-footer text-muted">
                                            <h6 class="card-title text-info">Vous trouvez ici les videos jointes à cette section</h6>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
        <?php $x++;endforeach; ?>
        <?php endforeach; ?>
        <?php else: ?>
            <div class="card text-center">
                <div class="card-header text-primary">
                    <h3>Apparement votre prof n'a pas publié encore des sections!</h3>
                </div>
                <div class="card-body">
                    <h4 class="card-title text-success">Dés que votre enseignant ajoute des sections, vous les trouverez ici</h4>
                    <h5>
                        <p class="card-text">Vous pouvez vous inscrire dans plusieurs cours dans le meme module</p>
                        <p>et cela afin d'ameliorer votre vision</p>
                        <p>en voyant plusieurs methodes pour faire la meme chose!</p>
                        <p>Take it on the other side!</p>
                    </h5>
                    <a href="/etudiant/index" class="btn btn-primary">Voir d'autre vours</a>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <script>

        function vid(par){
            //console.log(par)
            var a = par.value;
            a = a.split(' ');
            //console.log(a);
            var b = "https://www.youtube.com/embed/";
            var c = b+a[1];
            //console.log(c);
            var ytbvideo = '#ytVideo'+a[0];
            //console.log($)
            //undefined
            //console.log(ytbvideo);
            console.log($(ytbvideo));
            //console.log($('#ytVideo1').attr('src'));
            //console.log(ytbvideo);
            // le selecteur marche peut etre

            $(ytbvideo).attr('src', c);
            //console.log($(ytbvideo));
            //$("#cont_ytb").html("");

            //par.closest('iframe').src = c;

        }
    </script>

<?php $this->end(); ?>