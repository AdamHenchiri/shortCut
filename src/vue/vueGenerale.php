<?php
use App\PlusCourtChemin\Lib\Conteneur;
use App\PlusCourtChemin\Lib\ConnexionUtilisateur;

/** @var UrlGenerator $generateurUrl */
$generateurUrl = Conteneur::recupererService("generateurUrl");
/** @var UrlHelper $assistantUrl */
$assistantUrl = Conteneur::recupererService("assistantUrl");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $pagetitle ?></title>
    <link rel="stylesheet" href=<?=rawurldecode($assistantUrl->getAbsoluteUrl("../ressources/css/navstyle.css")) ?>>
    <link rel="stylesheet" href=<?= rawurldecode($assistantUrl->getAbsoluteUrl("../ressources/css/completion.css")) ?>>
    <link rel="stylesheet" href=<?= rawurldecode($assistantUrl->getAbsoluteUrl("../ressources/css/carte.css")) ?>>
    <link rel="stylesheet" href=<?= rawurldecode($assistantUrl->getAbsoluteUrl("../ressources/css/connexion.css")) ?>>
    <link rel="stylesheet" href="../ressources/css/inscription.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>

    <script src="../ressources/js/autocomplete.js" defer></script>
    <script src="../ressources/js/map.js" defer></script>

    <link rel="stylesheet" href="../ressources/css/menu.css">
    <link rel="stylesheet" href="../ressources/css/calcul.css">
    <link rel="shortcut icon" type="image/png" href="../ressources/img/logo_Sae04.ico"/>
    <script src="https://kit.fontawesome.com/26e0d024d1.js" crossorigin="anonymous" defer></script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href=<?= $generateurUrl->generate("afficherListeUtilisateur") ?>>Utilisateurs</a>
                </li>
                <li>
                    <a href=<?= $generateurUrl->generate("afficherListeCommune") ?>>Communes</a>
                </li>
                <?php
                if (!ConnexionUtilisateur::estConnecte()) {
                    echo "
                    <li> 
                        <a href=
                    " . ($generateurUrl->generate("afficherFormulaireConnexion")) .
                     " >
                            Connexion
                        </a>
                    </li>
                   ";
                } else {
                    $loginHTML = htmlspecialchars(ConnexionUtilisateur::getLoginUtilisateurConnecte());
                    $loginURL = rawurlencode(ConnexionUtilisateur::getLoginUtilisateurConnecte());
                    echo <<<HTML
                    <li>
                        <a href="controleurFrontal.php?action=afficherDetail&controleur=utilisateur&login=$loginURL">
                            <img alt="user" src="../ressources/img/user.png" width="18">
                            $loginHTML
                        </a>
                    </li>
                    <li>
                        <a href="controleurFrontal.php?action=deconnecter&controleur=utilisateur">
                            <img alt="logout" src="../ressources/img/logout.png" width="18">
                        </a>
                    </li>
                    HTML;
                }
                ?>
            </ul>
        </nav>
        <div>
            <?php
            foreach (["success", "info", "warning", "danger"] as $type) {
                foreach ($messagesFlash[$type] as $messageFlash) {
                    echo <<<HTML
                    <div class="alert alert-$type">
                        $messageFlash
                    </div>
                    HTML;
                }
            }
            ?>
        </div>
    </header>
    <main>
        <?php
        /**
         * @var string $cheminVueBody
         */
        require __DIR__ . "/{$cheminVueBody}";
        ?>
    </main>
    <footer>
        <p>
            Site crée par : Bettinger Sarah, Breton Nathan, Harribaud Kim, Hencheri Adam, Rathier Sylia
        </p>
    </footer>
</body>

</html>