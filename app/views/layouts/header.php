<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_menu" aria-controls="main_menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/"><img src="/images/logo.png" height="75" width="100" alt=""/></a>
<?php
$menuEns = Router::getMenu('menuEnseignant');
$menuEtu = Router::getMenu('menuEtudiant');
$menuPr = Router::getMenu('menu');
$menu = array_merge($menuEtu,$menuEns);
$coursesarray = [];
$tab_cours = [];
if ($ens = Enseignant::currentLoggedInTeacher()){
    $tab_cours = '/enseignant/profile';
    $db = DB::getInstance();
    if ($db->requete("select module.nom from module join cours on module.id = cours.id_module where cours.id_enseignant = ?",[$ens->id])->count()){
        $courses = $db->requete("select module.nom from module join cours on module.id = cours.id_module where cours.id_enseignant = ?",[$ens->id])->result();
        foreach ($courses as $cours){
            $liencour = explode(' ',strtolower($cours->nom));
            $liencour = implode('_',$liencour);
            $coursesarray[$cours->nom] = '/enseignant/mescours/'.$liencour;
        }
    }

}
if ($etu = Etudiant::currentLoggedInStudent()){
    $tab_cours = '/etudiant/profile';
    $db = DB::getInstance();
    if ($courses = $db->requete("select suivre.id_enseignant,suivre.id_etudiant, suivre.id_module ,module.nom as module, enseignant.nom, enseignant.prenom FROM module JOIN suivre ON module.id = suivre.id_module JOIN enseignant ON enseignant.id = suivre.id_enseignant WHERE suivre.id_etudiant = ?",[$etu->id])->result()){
        foreach ($courses as $cours){
            $lien = $cours->id_enseignant.'_'.$cours->id_etudiant.'_'.$cours->id_module;
            $coursesarray[$cours->module.' de '.$cours->prenom.' '.$cours->nom] = '/etudiant/mescours/'.$lien;
        }
    }
}
if (!empty($coursesarray)){
    $menu['Mes cours'] = $coursesarray;
}
if (!empty($tab_cours)){
    $menuPr['Mon profile'] = $tab_cours;
}

$currentPage =Router::currentPage();?>
    <div class="collapse navbar-collapse" id="main_menu">
        <ul class="navbar-nav mr-auto">
            <?php foreach($menu as $key => $val):
                $active = '';
                if(is_array($val)): ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$key?></a>
                        <div class="dropdown-menu ">
                            <?php foreach($val as $k => $v):
                                $active = ($v == $currentPage)? 'active':''; ?>
                                <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$k?></a>
                            <?php endforeach; ?>
                        </div>
                    </li>
                <?php else: $active = ($val == $currentPage)? 'active':''; ?>
                    <li class="nav-item"><a class="nav-link <?=$active?>" href="<?=$val?>"><?=$key?></a></li>
                <?php endif; ?>
            <?php endforeach;?>
        </ul>
        <ul class="navbar-nav mr-2">
            <?php
            foreach($menuPr as $key => $val):
            $active = '';
            if(is_array($val)): ?>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$key?></a>
                <div class="dropdown-menu "dropdown-menu-right"">
                    <?php foreach($val as $k => $v):
                        $active = ($v == $currentPage)? 'active':''; ?>
                        <a class="dropdown-item <?=$active?>" href="<?=$v?>"><?=$k?></a>
                    <?php endforeach; ?>
                </div>
            </li>
            <?php else:
            $active = ($val == $currentPage)? 'active':''; ?>
            <li class="nav-item"><a class="nav-link <?=$active?>" href="<?=$val?>"><?=$key?></a></li>
            <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>