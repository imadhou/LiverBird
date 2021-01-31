<?php $this->start('head'); ?>

<script>
    $('document').ready(function (){
        $(".oneClickEdit").click(function (){
            var id = $(this).attr("data-id");
            var field = $(this).attr("data-field");
            var value = $(this).text();
            var inputType = $(this).attr("data-input");
            var prev_el = $(this).get(0);
            var newElement = '<input id = "'+id+'" class="oneClickEdit" value="'+value+'">';
            $(this).replaceWith(newElement);
            $('#'+id).focus();
            $('#'+id).blur(function (){
                var newVal = $(this).val().trim();
                if (newVal == ''){
                    newVal = value;
                }
                $.ajax({
                   type : "POST",
                   url : "/admin/autoupdate",
                   data : {id:id,field:field,value:newVal},
                   success: function (resp){
                       console.log(resp);
                   }
                });
                $(prev_el).text(newVal);
                $(this).html('<p id="'+id+'" class="oneClickEdit" data-id="'+id+'" data-field="'+field+'" data-input="input">'+value+'</p>');
                $('#'+id).oneClickEdit = null;
                $('#'+id).removeData();

            });
        });
    });

</script>

<?php $this->end(); ?>

<?php $this->start('body'); ?>
    <header>
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link" href="/admin/gestion">Nouveau compte</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/admin/update">Gestion des comptes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="/admin/logout" tabindex="-1" aria-disabled="true">Se déconnecter</a>
            </li>
        </ul>
    </header>
<div class="container">
    <table class="table table-striped table-hover" >
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nom</th>
            <th scope="col">Prenom</th>
            <th scope="col">Email</th>
            <th scope="col">Mot de Passe</th>
            <th scope="col">Date de Naissance</th>
            <th scope="col">Numero enseignant</th>
        </tr>
        </thead>
        <tbody>
<?php foreach ($this->ensarr as $enseignant) : ?>
            <tr>
                <td><p><?=$enseignant->id ?></p></td>
                <td><p class="oneClickEdit" data-id="<?=$enseignant->id?>" data-field="nom" data-input="input"><?=$enseignant->nom ?></p></td>
                <td><p class="oneClickEdit" data-id="<?=$enseignant->id?>" data-field="prenom" data-input="input"><?=$enseignant->prenom ?></p></td>
                <td><p class="oneClickEdit" data-id="<?=$enseignant->id?>" data-field="email" data-input="input"><?=$enseignant->email ?></p></td>
                <td><p class="oneClickEdit" data-id="<?=$enseignant->id?>" data-field="password" data-input="input"><?=$enseignant->password ?></p></td>
                <td><p class="oneClickEdit" data-id="<?=$enseignant->id?>" data-field="date_naissance" data-input="input"><?=$enseignant->date_naissance ?></p></td>
                <td><p class="oneClickEdit" data-id="<?=$enseignant->id?>" data-field="numero_enseignant" data-input="input"><?=$enseignant->numero_enseignant ?></p></td>
            </tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $this->end(); ?>