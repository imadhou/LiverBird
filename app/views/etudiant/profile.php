<?php $this->start('head'); ?>
<!--<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>-->
<!--<script>-->
<!--    $(document).ready(function (){-->
<!--        $('form').submit(function (e){-->
<!--            e.preventDefault();-->
<!--            $('li').remove();-->
<!---->
<!--            var formdata = {-->
<!--                pass1 : $('#pass1').val(),-->
<!--                pass2 : $('#pass2').val(),-->
<!--                pass3 : $('#pass3').val()-->
<!--            }-->
<!--            $.ajax({-->
<!--                type : 'POST',-->
<!--                url : '/etudiant/profile',-->
<!--                data : formdata,-->
<!--                success : function (data){-->
<!--                    console.log(data)-->
<!--                    $.each(data,function (i,v){-->
<!--                        if (Array.isArray(v)){-->
<!--                            $.each(v,function (ind,val){-->
<!--                                $('.form-errors').append('<li class="text-danger"><p>'+val[0]+'</p></li>');-->
<!--                                console.log(val[0])-->
<!--                            })-->
<!--                        }else {-->
<!--                            $('.form-errors').append('<li class="text-danger"><p>'+v+'</p></li>');-->
<!--                            console.log(v);-->
<!--                        }-->
<!--                        $('input').val('');-->
<!--                    })-->
<!--                }-->
<!--            })-->
<!---->
<!--        })-->
<!--    })-->
<!--</script>-->
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<div class="container">
    <div class="row">
        <div class="card col-sm" style="padding: 5%">
            <div class="card-body">
                <h5 class="card-title" style="margin-bottom: 8%">Vos informations sont ici!</h5>
                <table class="table">
                    <thead>
                    </thead>
                    <tbody>
                    <tr>
                        <td><p>Nom</p></td>
                        <td><p><?= $this->etudiant->nom ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Prenom</p></td>
                        <td><p><?= $this->etudiant->prenom ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Email</p></td>
                        <td><p><?= $this->etudiant->email ?></p></td>
                    </tr>
                    <tr>
                        <td><p>Numero étudiant</p></td>
                        <td><p><?= $this->etudiant->numero_etudiant ?></p></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card col-sm" style="padding: 5%">
            <div class="card-body">
                <h5 class="card-title">Reinitialiser votre mot de passe</h5>
                <form method="post" action="/etudiant/profile" >
                    <ul class="form-errors text-primary">
                        <?php foreach ($this->h as $value) :?>
                            <li><?=$value?></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="form-group" style="margin: 2%">
                        <label for="pass1">Votre mot de passe actuel:</label>
                        <input type="password" class="form-control" id="pass1" name="pass1" >
                        <p id="correction_psw"> </p>
                    </div>
                    <div class="form-group" style="margin: 2%">
                        <label for="pass2">Saisissez votre nouveau mot de passe:</label>
                        <input type="password" class="form-control" id="pass2" name="pass2" >
                        <p id="correction_conf"> </p>
                    </div>
                    <div class="form-group" style="margin: 2%">
                        <label for="pass3">Confirmez votre npuveau mot de passe:</label>
                        <input type="password" class="form-control" id="pass3" name="pass3" >
                        <p id="correction_conf"> </p>
                    </div>
                    <div class="form-group" style="margin: 2%">
                        <input type="submit" class="btn btn-primary" id="subm" name="subm" value="Reinitialiser" >
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php $this->end(); ?>
