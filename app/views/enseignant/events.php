<?php $this->start('head'); ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function (){
        $('#select1').change(function (){
            var module = $('#select1').find(":selected").val();
            $.ajax({
                type : 'POST',
                url : '/enseignant/listev',
                data : {
                    module : module
                },
                success : function (data){

                    if (data.length != 0){
                        $('#sel2').empty();
                        $('#sel2').append('<option value="">Selectionner un evenement/ devoir</option>');
                        $('#opt0').text("Selectionner votre evenement");
                        $.each(data, function (key, value){
                            $('#sel2').append('<option value="'+value.id+'">'+value.even+' ,'+value.secti+'</option>');
                        })
                    }else {
                        $('#sel2').empty();
                        $('#sel2').append('<option value="">Vous n\'avez aucun devoir/event</option>');
                    }

                }
            })
        });








        $(".oneClickEdit").on("click",function (){
            console.log("hhh");
            var id = $(this).attr("data-id");
            var field = $(this).attr("data-field");
            var value = $(this).text();
            var ev = $(this).attr("data-ev");
            var inputType = $(this).attr("data-input");
            var prev_el = $(this).get(0);
            var newElement = '<input id = "'+id+'" class="oneClickEdit" value="'+value+'">';
            $(this).replaceWith(newElement);
            $('#'+id).focus();
            $('#'+id).on("blur",function (){
                var newVal = $(this).val().trim();
                if (newVal == ''){
                    newVal = value;
                }
                $.ajax({
                    type : "POST",
                    url : "/enseignant/noter",
                    data : {id:id,field:field,value:newVal, evn : ev},
                    success: function (resp){
                        console.log(resp);
                    }
                });
                $(prev_el).text(newVal);
                $('.oneClickEdit').html('<p class="oneClickEdit" data-id="'+id+'" data-ev = "'+ev+'" data-field="note" data-input="input">'+newVal+'</p>');
                console.log(this)
            });

        });
    });
</script>

<?php $this->end(); ?>
<?php $this->start('body'); ?>
<div class="card text-center">
    <div class="card-header">
        <h1 class="text-primary">Faites le suivi de vos étudiants</h1>
    </div>
    <div class="card-body">
        <h5 class="card-title text-secondary" >Vous attendez des livrables de vos étudiants?</h5>
        <p class="card-text">Vous n'avez qu'à slectionner un module et voir les évenements qui y sont liés.</p>
    </div>
</div>
<div class="container" style="padding: 1%">
    <form style="padding: 1%" action="/enseignant/events" method="post">
        <div class="form-group">
            <select class="form-select form-select-lg mb-3" name="module" id="select1" required>
                <option value="">Selectionner un de vos cours</option>
<?php foreach ($this->courses as $cours) : ?>
                <option name="module" value="<?=$cours->id?>"><?=$cours->nom?></option>
<?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <select id="sel2" class="form-select form-select-sm" aria-label=".form-select-sm example" name="event" required>
                <option id="opt0" value=""></option>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Voir les devoirs">
        </div>
    </form>
</div>

<div class="container">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th colspan="5"><h5>Repérez un étudiant et clickez sur sa case de note et introduisez une note</h5></th>
        </tr>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Numero d'etudiant</th>
            <th scope="col">Travil</th>
            <th scope="col">Note</th>
        </tr>
        </thead>
        <tbody>
<?php if (!empty($this->responses)) : ?>
<?php foreach ($this->responses as $respons) : ?>
        <tr>
            <td><p><?=$respons->nom?></p></td>
            <td><p><?=$respons->prenom?></p></td>
            <td><p><?=$respons->numero_etudiant?></p></td>
            <td><a href="/cours/etudiant/<?=$respons->id?>/<?=$respons->lien_fichier?>"><?=$respons->lien_fichier?></a></td>
            <td><p class="oneClickEdit" data-id="<?=$respons->id?>" data-ev = "<?=$this->resevent ?>" data-field="note" data-input="input"><?=$respons->note?></p></td>
        </tr>
<?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5">Aucun etudiant n'a encore soumet son travail</td>
    </tr>
<?php endif; ?>
        </tbody>
    </table>
</div>
<?php $this->end(); ?>
