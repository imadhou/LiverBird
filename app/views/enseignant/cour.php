<?php $this->start('head'); ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){

                var API_KEY = "AIzaSyCReyUL7ppH1z2IdG0vdbaCklpNKxZ6EWQ"

                var video =''
                var hid =''
                var chk = []

                $("#search").keyup(function(event){
                    event.preventDefault()

                    var search = $("#search").val()
                    videoSearch(API_KEY,search,6)
                })

                function videoSearch(key,search,maxResults){
                    $.get("https://www.googleapis.com/youtube/v3/search?key="+key+
                        "&type=video&part=snippet&maxResults="+maxResults+"&q="+ search,function(data){
                        console.log(data)
                        // il ne reste plus qu'à decomposer les valeurs retournées
                        $("#videos").html("");
                        var  i =0;
                        data.items.forEach(item => {
                            if(chk.indexOf(item.id.videoId)==-1)
                            {
                                video =  '<div class=" col-sm form-check"><label for="vid" class="form-check-label"><iframe width="200" height="150" src="https://www.youtube.com/embed/'+item.id.videoId+'" frameborder="0" allowfullscreen></iframe></label><input type="checkbox" value='+item.id.videoId+' class="form-check-input" name="vid'+i+'" id="vid'+i+'"></div>'

                            }
                            else
                            {
                                video =  '<div class=" col-sm form-check"><label for="vid" class="form-check-label"><iframe width="200" height="150" src="https://www.youtube.com/embed/'+item.id.videoId+'" frameborder="0" allowfullscreen></iframe></label><input type="checkbox" value='+item.id.videoId+' class="form-check-input" name="vid'+i+'" id="vid'+i+'" checked></div>'
                            }
                            $("#videos").append(video)

                            i++
                        })
                    })
                }

                $(document).on('change', '.form-check-input', function() {

                    if(this.checked){
                        chk.push(this.value);
                        //console.log(this.value);
                    }
                    else
                    {

                        chk.splice(chk.indexOf(this.value),1);
                    }
                    console.log($('#tab'))//.val(chk);
                    //$("#tab").val(JSON.stringify(chk));
                    //$("#tab").attr("value",chk);
                    //console.log($('#tab').val());
                    console.log(chk);

                });

                $('#sb').submit(
                    function(event) {
                        event.preventDefault();
                        var j = 1;
                        chk.forEach(function(y){
                            hid = '<input type="hidden" id="tab'+j+'"  name="tab'+j+'" value="'+y+'" >'
                            $("#videos_hidden").append(hid)
                            j++;

                        })
                        $("#videos").html("");
                        this.submit();
                        /*
                        le probleme vient du submit : en le desactivant et en inspectant l'element on voit que le nombre de balises hidden crées
                        correspond bien au tableau, cependant apres submit ça part en couille :: il repete la derniere valeur deux fois
                        il se peut aussi que le probleme vient du tableau en lui meme vu l'indexe "tab" de la derniere case du tabeau
                        dans le cas ou on prends des valeurs de differentes recherches il semblerait que seul la derniere recherche soit prise
                        en compte
                        à essayer : vider le div des checkbox avant de submit
                        EDIT : le formulaire n'a jamais envoyé les hidden : juste les checkbox
                        peut etre leur position les empeche d'etre envoyés ? ou alors la maniere avec laquelle on les crée ? ou alors submit est une
                        fonction qui envoie les element généré au chargement de la page(DOM) ? probablement pas ... à confirmer
                        */
                    })

            $('#vid').click(function (){
                console.log(hh);
            })


            });




        //})
    </script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $mod = explode('_',$this->module);
$module = '';
foreach ($mod as $m){
    $module .= ucfirst($m).' ';
}
$module = trim($module); ?>
    <div class="card text-center">
        <div class="card-header">
            <h1 class="text-primary"><?= $module?></h1>
        </div>
        <div class="card-body">
            <h5 class="card-title text-secondary" >Ajoutez des sections dans votre cour</h5>
            <p class="card-text" style="font-size: 25px">Chaque cour est composé de plusieurs sections, qui peuvent avoir des évenemets,
             Selectionnez les fichier que vous voulez joindre à votre section, les vidéos youtubes que vous voyez utiles,
             créez un evenement et postez le pour vos etudiants</p>
        </div>
        <div class="card-footer text-muted">
            Les section de votre cour s'affichent en bas !
        </div>
    </div>
    <div class="card" style="margin-top: 2%">
        <h5 class="card-header">Completez les champs de ce formulaire pour créer une section</h5>
        <div class="card-body">
            <form action="/enseignant/mescours/<?=$this->module?>" method="post" enctype="multipart/form-data" id="sb">
                <ul class="form-errors">
                    <?php foreach ($this->error as $err) : ?>
                    <li class="text-danger"><p><?=$err?></p></li>
                    <?php endforeach;?>
                </ul>
                <div class="container">

                <div class="form-group">
                    <label for="sect-name">Intitulé de section</label>
                    <input type="text" class="form-control" name="sect-name" id="sect-name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" rows="3" name="description" ></textarea>
                </div>
                    <div class="row">
                        <div class="col-sm-6">

                            <div class="card text-center">
                                <div class="card-header" style="margin-bottom: 1%">
                                    Sélectionnez les fichiers que vous voulez joindre
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="fichier">Selectionner des fichiers à joindre</label>
                                        <input type="file" class="form-control-file" id="fichier" name="fichier[]" multiple="multiple">
                                    </div>
                                </div>
                            </div>

                            <div class="card text-center">
                                <div class="card-header">
                                    Ajoutez un evenement
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="event-name">Intitué d'évenement</label>
                                        <input type="text" class="form-control" name="event-name" id="event-name">
                                    </div>
                                    <div class="form-group">
                                        <label for="event-date">Date limite d'évenement</label>
                                        <input type="date" class="form-control" name="event-date" id="event-date">
                                    </div>
                                    <div class="form-group">
                                        <label for="event-desc">Description d'évenement</label>
                                        <textarea class="form-control" name="event-desc" id="event-desc"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-sm-6 text-center">
                            <div class="card-header">
                                Ajoutez les vidéos qui sont relatives à votre section!
                            </div>
                            <div class="card-body">
                                <h4>Tapez un mot clé et choisissez vos vidéos</h4>
                                <div id="form">
                                    <label for="search"></label>
                                    <input type="text" id="search">
                                </div>
                                <div class="container-fluid">
                                    <div class="row" id="videos">

                                    </div>
                                    <div class="row" id="videos_hidden">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="module" value="<?=$this->module?>">
                <div class="form-group">
                    <input type="submit" value="ok">
                </div>
            </form>
        </div>
    </div>



<?php
$x = 1;
foreach ($this->sections as $section) : ?>
    <div class="card">
        <h4 class="card-header"><?= $section->intitule?></h4>
        <div class="card-body">
            <h5 class="card-title"><?=$section->texte?></h5>
            <div class="row">
                <div class="col-sm"><ul class="list-group"><p>Files : </p>
                        <?php foreach ($section->fichiers as $file) :?>
                            <a href="/cours/enseignant/<?=$this->ens.'/'.$file->lien ?>"><?= $file->lien ?></a>
                        <?php endforeach ;?>
                    </ul></div>
                <div class="col-sm">
                    <?php
                    $j= -1; $i =0;$y = 0;
                    foreach ($section->youtubes as $youtube) :
                        if ($section->id == $youtube->id_section){
                        if ($j == -1){
                        $j = $y;
                        }
                        ?>
                        <button type="button" id="vid" class="btn btn-primary" value="<?= $x.' '.$youtube->lien ?>" onclick="vid(this)">Video<?= $i ?></button>
                        <?php $i++ ?>
                        <?php
                    }
                        $y++;
                        //var_dump($j);
                    endforeach;
                    if ($j != -1){
                    //var_dump($this->youtubes[$j]->lien);
                    ?>
                    <div class="ratio ratio-16x9" id="cont_ytb<?=$x?>">
                        <iframe id="ytVideo<?=$x?>" width="350" height="200" src="https://www.youtube.com/embed/<?=$section->youtubes[$j]->lien?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <?php }
                    $i = 1 ?>
                </div>
                <div class="col-sm"><ul class="list-group">
                        <?php foreach ($section->events as $event) : ?>
                            <li class="list-group-item">Intitulé d'evenement : <?=$event->intitule?></li>
                            <li class="list-group-item">Description D'evenement : <?=$event->description?></li>
                            <li class="list-group-item">Date limite : <?=$event->date_limite?></li>
                        <?php endforeach;?>
                    </ul></div>
            </div>
        </div>
    </div>
<?php $x++;
endforeach; ?>
    <script>

        function vid(par){
            console.log(par)
            var a = par.value;
            a = a.split(' ');
            //console.log(a);
            var b = "https://www.youtube.com/embed/";
            var c = b+a[1];
            //console.log(c);
            var ytbvideo = '#ytVideo'+a[0]
            //undefined
            //console.log($('#ytVideo1'));
            //console.log($('#ytVideo1').attr('src'));
            //console.log(ytbvideo);
            // le selecteur marche peut etre pas
            $(ytbvideo).attr('src', c);
            console.log($(ytbvideo));
            $("#cont_ytb").html("");

            //par.closest('iframe').src = c;

        }
    </script>
<?php $this->end(); ?>