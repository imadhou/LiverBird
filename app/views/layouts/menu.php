
<?php
$menuEns = Router::getMenu('menuEnseignant');
$menuEtu = Router::getMenu('menuEtudiant');
$menuPr = Router::getMenu('menu');
$menu = array_merge($menuPr,$menuEtu,$menuEns);
$currentPage =Router::currentPage();
?>
<ul class="nav">
<?php
foreach($menu as $key => $val):
    if(is_array($val)): ?>
        <li class="nav-item ">
            <a href="#" class="nav-link "  role="button" aria-haspopup="true" aria-expanded="false"><?=$key?></a>
            <div class="dropdown-menu ">
                <?php foreach($val as $k => $v):
                    $active = ($v == $currentPage)? 'active':''; ?>
                    <a class="nav-link active href="<?=$v?>"><?=$k?></a>
                <?php endforeach; ?>
            </div>
        </li>
    <?php else:
        $active = ($val == $currentPage)? 'active':''; ?>
        <li class="nav-item"><a class="nav-link <?=$active?>" href="<?=$val?>"><?=$key?></a></li>
    <?php endif;
    endforeach;?>
</ul>
