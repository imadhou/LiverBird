<?php $this->start('head');?>

<?php $this->end();?>


<?php $this->start('body');?>
   <div class="container" >
       <h1 class="text-primary text-center">Inscrivez vous et rejoignez nous sur Eredlearning!</h1>
       <form  class="form" action="/register/register" method="post" id="signUpForm" name="signUpForm" style="padding-right: 10%; padding-left: 10%">
           <div class="form-errors"><?= $this->displayErrors ?></div>
           <div class="form-group">
               <label for="nom">Nom</label>
               <input type="text" class="form-control" id="nom" name="nom" >
           </div>
           <div class="form-group">
               <label for="Prenom">Prenom</label>
               <input type="text" class="form-control" id="Prenom" name="prenom" >
           </div>
           <div class="form-group">
               <label for="Date_naissance">Date de naissance</label>
               <input type="date" class="form-control" id="Date_naissance" name="date_naissance" >
           </div>

           <div class="form-group">
               <label for="Email">Email</label>
               <input type="email" class="form-control" id="Email" name="email" >
               <p class="text-danger" id="correction_email"> </p>
           </div>
           <div class="form-group">
               <label for="Mot_de_pass">Mot de passe</label>
               <input type="password" class="form-control" id="Mot_de_pass" name="password" >
               <p class="text-danger" id="correction_psw"> </p>
           </div>
           <div class="form-group">
               <label for="Confirmer">Confirmez votre mot de passe</label>
               <input type="password" class="form-control" id="Confirmer" name="confirmer" >
               <p  class="text-danger" id="correction_conf"> </p>
           </div>
           <div class="form-group">
               <label for="numero_etudiant">Saisissez votre numero etudiant</label>
               <input type="text" class="form-control" id="numero_etudiant" name="numero_etudiant" >
           </div>

           <button type="submit" class="btn btn-primary" id="okButton" name="okButton" >Creer un compte</button>
       </form>
   </div>

        <script>
        const signUpForm = document.getElementById('signUpForm');
        const emailField = document.getElementById('Email');
        const psw = document.getElementById('Mot_de_pass');
        const conf = document.getElementById('Confirmer');
        const okButton = document.getElementById('okButton');
        const co_email = document.getElementById('correction_email');
        const co_psw = document.getElementById('correction_psw');
        const co_conf = document.getElementById('correction_conf');
        
        
        
        
        
        
        
        
        
        
        emailField.addEventListener('keyup', function (event) {
          isValidEmail = emailField.checkValidity();
        if ( (isValidEmail) && (psw.value === conf.value) && (psw.value.match(/[a-z]+/)) &&
        (psw.value.match(/[A-Z]+/)) && (psw.value.match(/[0-9]+/)) && (psw.value.match(/[$@#&!]+/))) {
            okButton.disabled = false;  
          } else {
            okButton.disabled = true;   
          }
        if ( (isValidEmail) ){
                co_email.innerHTML = "";         
                }
                else {
                co_email.innerHTML = "Votre email est invlide";
                }
        // if ( psw.value === conf.value ){
        //         co_conf.innerHTML = "";
        //         }
        //         else {
        //         co_conf.innerHTML = "vos mots de passe ne sont pas identiques";
        //         }
        // if ( (psw.value.match(/[a-z]+/)) && (psw.value.match(/[A-Z]+/)) &&
        //         (psw.value.match(/[0-9]+/)) && (psw.value.match(/[$@#&!]+/)) ){
        //         co_psw.innerHTML = "";
        //         }
        //         else {
        //         co_psw.innerHTML = "le mdp doit contenir une lettre minuscule, une majuscule,un chiffre, et un des signaux : $@#&!";
        //         }
        });


        psw.addEventListener('keyup', function (event) {
          isValidEmail = emailField.checkValidity(); // instruction répétée inutilement
        if ( (isValidEmail) && (psw.value === conf.value) && (psw.value.match(/[a-z]+/)) &&
        (psw.value.match(/[A-Z]+/)) && (psw.value.match(/[0-9]+/)) && (psw.value.match(/[$@#&!]+/))) {
            okButton.disabled = false;  
          } else {
            okButton.disabled = true;   
          }
        if ( (isValidEmail) ){
                co_email.innerHTML = "";         
                }
                else {
                co_email.innerHTML = "Votre email est invlide";
                }
        if ( psw.value === conf.value ){
                co_conf.innerHTML = "";         
                }
                else {
                co_conf.innerHTML = "vos mots de passe ne sont pas identiques";
                }
        if ( (psw.value.match(/[a-z]+/)) && (psw.value.match(/[A-Z]+/)) &&
                (psw.value.match(/[0-9]+/)) && (psw.value.match(/[$@#&!]+/)) ){
                co_psw.innerHTML = "";         
                }
                else {
                co_psw.innerHTML = "le mdp doit contenir une lettre minuscule, une majuscule,un chiffre, et un des signaux : $@#&!";
                }
        });


        conf.addEventListener('keyup', function (event) {
          isValidEmail = emailField.checkValidity(); // idem
        if ( (isValidEmail) && (psw.value === conf.value) && (psw.value.match(/[a-z]+/)) &&
        (psw.value.match(/[A-Z]+/)) && (psw.value.match(/[0-9]+/)) && (psw.value.match(/[$@#&!]+/))) {
            okButton.disabled = false;  
          } else {
            okButton.disabled = true;   
          }
        if ( (isValidEmail) ){
                co_email.innerHTML = "";         
                }
                else {
                co_email.innerHTML = "Votre email est invlide";
                }
        if ( psw.value === conf.value ){
                co_conf.innerHTML = "";         
                }
                else {
                co_conf.innerHTML = "vos mots de passe ne sont pas identiques";
                }
        if ( (psw.value.match(/[a-z]+/)) && (psw.value.match(/[A-Z]+/)) &&
                (psw.value.match(/[0-9]+/)) && (psw.value.match(/[$@#&!]+/)) ){
                co_psw.innerHTML = "";         
                }
                else {
                co_psw.innerHTML = "le mdp doit contenir une lettre minuscule, une majuscule,un chiffre, et un des signaux : $@#&!";
                }
        });



        okButton.addEventListener('click', function (event) {
          signUpForm.submit();
        });



        </script>

<script>
    function ens() {
        if (document.getElementById('enseignant').checked){
            document.getElementById('numero_ens').style.display = 'block';
        }
    }
</script>
<?php $this->end();?>


