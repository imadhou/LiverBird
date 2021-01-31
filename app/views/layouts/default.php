 <!doctype html>
 <html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="eredlearning" href="/"/>
        <meta name="google-site-verification" content="r0dr4rkk-n4q4p2G7No3E-hQIlwci69pxw08s_vQt0A" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

        <!-- Optional theme -->

        <!-- Latest compiled and minified JavaScript -->

        <?= $this->content('head'); ?>
        <title><?= $this->site_title(); ?>EredLearning vous aide pendant le confinement à suivre vos cours</title>
        <link rel="eredlearning" href="/favicon.ico" type="image/gif">
        <meta name="description" content="Platforme d'etude en ligne regroupe des etudiants et des enseignants et met à leurs disposition un outil de suivi et de consultation">
        <meta name="keywords" content="elearning, etudes, covid19, distanciel, examens, cours, enseignant, module, etudiants, maths">
        <meta name="author" content="mourtdad houari/ kasmi ghilas">
    </head>
    <body >
         <header >
            <?php include_once('header.php') ;?>
         </header>
         <div class="container">
            <?=$this->content('body');?>
         </div>
             <?php include_once('footer.php');?>
         <!-- Go to www.addthis.com/dashboard to customize your tools -->
         <script  src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5fe53836dbe3866b"></script>

    </body>
 </html>