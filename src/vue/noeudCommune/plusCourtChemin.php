<section class="container_calcule">
<form id="formCalcule"  method="post">
        <div class="container-calcul">
            <div class="titre-container">
                <h1 class="titre">Calculez votre chemin </h1>
                <div class="separateur"></div>
            </div>

            <input class="InputAddOn-field" type="text" value="" placeholder="Ville de départ ou position actuelle" name="nomCommuneDepart" id="nomCommuneDepart_id" required>
            <img id="localisation" src="../ressources/img/my_location_FILL0_wght400_GRAD0_opsz48.png" alt="localisation">
            <div id="autocompletion"></div>

            <i id="arrow" class="fa-solid fa-arrow-down"></i>

            <input class="InputAddOn-field" type="text" value="" placeholder="Destination souhaitée" name="nomCommuneArrivee" id="nomCommuneArrivee_id" required>
            <div id="autocompletionArrivee"></div>

            <input type="hidden" name="XDEBUG_TRIGGER">
            <input class="button-calcul" type="submit" value="C'est parti !" />

            <div class="titre-container">
                <h1 class="titre">Résultat du chemin le plus court</h1>
                <div class="separateur"></div>
            </div>

        </div>
    </form>
<div id="mapid"></div>
</section>
<div id="loader"><img src="../ressources/img/loading.gif" alt="loader"></div>
<div id="distance"></div>
