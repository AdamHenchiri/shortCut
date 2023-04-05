<div>
    <form method="<?= $method ?>" action="controleurFrontal.php">

        <div class="container-connexion">
            <h1 class="titre">Connexion</h1>
                <input class="InputAddOn-field" type="text" value="" placeholder="Identifiant" name="login" id="login_id" required>

                <input class="InputAddOn-field" type="password" value="" placeholder="Mot de passe" name="mdp" id="mdp_id" required>

            <input type='hidden' name='action' value='connecter'>
            <input type='hidden' name='controleur' value='utilisateur'>
            <p>
                <input class="button-connexion" type="submit" value="Envoyer"/>
            </p>

                <a class="lien-creer-compte" href="controleurFrontal.php?action=afficherFormulaireCreation&controleur=utilisateur">Créer un compte</a>

        </div>
    </form>
</div>