<div class="container">
<form id="formCalcule"  method="post">
        <div class="container-calcul">
            <div class="titre-container">
                <h1 class="titre">Calculez votre chemin </h1>
                <div class="separateur"></div>
            </div>
            <div class="input">
            <div class="localisation">
                <input class="InputAddOn-field" type="text" value="" placeholder="Ville de départ ou position actuelle" name="nomCommuneDepart" id="nomCommuneDepart_id" required>
                <i id="localisation" class="fa-solid fa-location-crosshairs"></i>
            </div>
            <div id="autocompletion"></div>

            <i id="arrow" class="fa-solid fa-arrow-down"></i>

            <div class="localisation">
                <input class="InputAddOn-field" type="text" value="" placeholder="Destination souhaitée" name="nomCommuneArrivee" id="nomCommuneArrivee_id" required>
            </div>
            <div id="autocompletionArrivee"></div>
            </div>
            <input type="hidden" name="XDEBUG_TRIGGER">
            <input class="button-calcul" type="submit" value="C'est parti !" />

            <div class="titre-container">
                <div id="distance" class="titre"></div>
                <h1 class="titre">Résultat </h1>
                <div class="separateur"></div>
            </div>
            <div id="mapid"></div>
            <div id="loader" class="loader"></div>
        </div>
    </form>
</div>
