<form action="" method="post">
    <div class="container-calcul">
        <div class="titre-container">
            <h1 class="titre">Calculez votre chemin </h1>
            <div class="separateur"></div>
        </div>

            <input class="InputAddOn-field" type="text" value="" placeholder="Ville de départ ou position actuelle" name="nomCommuneDepart" id="nomCommuneDepart_id" required>

        <i id="arrow" class="fa-solid fa-arrow-down"></i>

            <input class="InputAddOn-field" type="text" value="" placeholder="Destination souhaitée" name="nomCommuneArrivee" id="nomCommuneArrivee_id" required>

        <input type="hidden" name="XDEBUG_TRIGGER">
            <input class="button-calcul" type="submit" value="C'est parti !" />

        <div class="titre-container">
            <h1 class="titre">Résultat du chemin le plus court</h1>
             <div class="separateur"></div>
        </div>

    </div>
</form>

<?php if (!empty($_POST)) { ?>
    <p>
        Le plus court chemin entre <?= $nomCommuneDepart ?> et <?= $nomCommuneArrivee ?> mesure <?= $distance ?>km.
    </p>
<?php } ?>