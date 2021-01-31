<?php $this->start('head'); ?>

<?php $this->end(); ?>

<?php $this->start('body'); ?>

<div class="contenaire">
    <form action="/home/contacts" method="post">
        <div><?=$this->passer?></div>
        <div class="form-group">
            <label for="exampleInputEmail2">Votre email</label>
            <input type="email" class="form-control" id="exampleInputEmail2" name="mail" required>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Sujet du message</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="subject" required>
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Message à envoyer</label>
            <textarea style="height: 200px;" class="form-control" id="exampleInputPassword1" name="text" required rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php $this->end(); ?>
