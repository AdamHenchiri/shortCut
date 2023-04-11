<?php

echo <<<HTML
<div class="container-commune-titre">
<a class="button-lien-calcul" href="./calcul">Calculer un plus court chemin</a>

<h1 class="titre1">Liste des noeuds communes :</h1>
</div>
HTML;
echo '<div class="container-commune">';
foreach ($noeudsCommunes as $noeudCommune) {
    echo '<li>';
    require __DIR__ . "/detail.php";

    echo '</li>';
}

echo '</div>';