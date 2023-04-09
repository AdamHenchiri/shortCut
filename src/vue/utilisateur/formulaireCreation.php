<div>
    <form method="<?= $method ?>" action="controleurFrontal.php">
        <div class="container-inscription">
            <h1 class="titre">Inscription</h1>
                <input class="InputAddOn-field" type="text" value="" placeholder="Login" name="login" id="login_id" required>

                <input class="InputAddOn-field" type="text" value="" placeholder="Prénom" name="prenom" id="prenom_id" required>

                <input class="InputAddOn-field" type="text" value="" placeholder="Nom" name="nom" id="nom_id" required>

                <input class="InputAddOn-field" type="email" value="" placeholder="Email" name="email" id="email_id" required>

                <input class="InputAddOn-field" type="password" value="" placeholder="Mot de passe" name="mdp" id="mdp_id" required>

                <input class="InputAddOn-field" type="password" value="" placeholder="Vérification Mot de passe" name="mdp2" id="mdp2_id" required>

            <?php

            use App\PlusCourtChemin\Lib\ConnexionUtilisateur;

            if (ConnexionUtilisateur::estAdministrateur()) {
            ?>
                <p class="InputAddOn">
                    <label class="InputAddOn-item" for="estAdmin_id">Administrateur</label>
                    <input class="InputAddOn-field" type="checkbox" placeholder="" name="estAdmin" id="estAdmin_id">
                </p>
            <?php } ?>
            <input type='hidden' name='action' value='creerDepuisFormulaire'>
            <input type='hidden' name='controleur' value='utilisateur'>
            <p class="InputAddOn">
                <input class="button-connexion" type="submit" value="S'inscrire" />
            </p>
            <a class="lien-creer-compte" href="./connexion">Déjà inscrit ?</a>
    </form>
</div>