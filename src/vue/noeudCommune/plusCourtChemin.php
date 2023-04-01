<section class="container_calcule">
<form id="formCalcule"  method="post">
    <fieldset>
        <legend>Plus court chemin </legend>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomCommuneDepart_id">Nom de la commune de départ</label>
            <input class="InputAddOn-field" type="text" value="" placeholder="Ex : Menton" name="nomCommuneDepart" id="nomCommuneDepart_id" required>
            <img id="localisation" src="../../../ressources/img/my_location_FILL0_wght400_GRAD0_opsz48.png" alt="localisation">
                <div id="autocompletion"></div>


        </p>
        <p class="InputAddOn">
            <label class="InputAddOn-item" for="nomCommuneArrivee_id">Nom de la commune d'arrivée </label>
            <input class="InputAddOn-field" type="text" value="" placeholder="Ex : Menton" name="nomCommuneArrivee" id="nomCommuneArrivee_id" required>
            <div id="autocompletionArrivee"></div>

        </p>
        <input type="hidden" name="XDEBUG_TRIGGER">
        <p>
            <input id="calculSubmit" class="InputAddOn-field" type="submit" value="Calculer" />
        </p>
    </fieldset>
</form>

<div id="mapid"></div>
</section>
<div id="loader"><img src="../ressources/img/loading.gif" alt="loader"></div>
<div id="distance"></div>
