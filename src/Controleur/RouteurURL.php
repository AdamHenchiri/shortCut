<?php

namespace App\PlusCourtChemin\Controleur;
use App\PlusCourtChemin\Lib\Conteneur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\UrlHelper;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGenerator;
use App\PlusCourtChemin\Controleur\ControleurUtilisateur;
use App\PlusCourtChemin\Controleur\ControleurNoeudCommune;


class RouteurURL
{
    public static function traiterRequete() {

        $requete = Request::createFromGlobals();

        $routes = new RouteCollection();

        // Route afficherListe Utilisateur
        $route = new Route("/", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurUtilisateur::afficherListe",
        ]);
        $routes->add("afficherListeUtilisateur", $route);


        // Route afficherListe noeudCommune
        $route = new Route("/commune", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurNoeudCommune::afficherListe",
        ]);
        $routes->add("afficherListeCommune", $route);


        // Route afficherFormulaireConnexion, controleur=utilisateur
        $route = new Route("/connexion", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurUtilisateur::afficherFormulaireConnexion",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("afficherFormulaireConnexion", $route);

        // Route afficherFormulaireConnexion, controleur=utilisateur
        $route = new Route("/connexion", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurUtilisateur::connecter",
        ]);
        $route->setMethods(["POST"]);
        $routes->add("connecter", $route);

        //Route plus court chemin, controleur ControleurNoeudCommune
        $route = new Route("/calcul", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurNoeudCommune::plusCourtChemin",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("plusCourtChemin", $route);

        //Route plus court chemin, controleur ControleurNoeudCommune
        $route = new Route("/calcul/{nomCommuneDepart}/{nomCommuneArrivee}", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurTronconRouteNoeuds::donneesRoute",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("calculPlusCourtChemin", $route);

        //Route creation, controleur ControleurUtilisateur
        $route = new Route("/creation", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurUtilisateur::afficherFormulaireCreation",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("afficherFormulaireCreation", $route);

        //Route creation, controleur ControleurUtilisateur
        $route = new Route("/creation", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurUtilisateur::creerDepuisFormulaire",
        ]);
        $route->setMethods(["POST"]);
        $routes->add("creation", $route);

        //Route autocompletion, controleur ControleurNoeudCommune
        $route = new Route("/autocompletion/{nomCommune}", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurNoeudCommune::autocompletion",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("autocompletion", $route);

        //Route donneesCarte, controleur ControleurNoeudCommune
        $route = new Route("/donneesCarte/{nomCommune}", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurNoeudCommune::donneesCarte",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("donneesCarte", $route);

        //Route villeExist, controleur ControleurNoeudCommune
        $route = new Route("/villeExist/{nomCommune}", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurNoeudCommune::villeExist",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("villeExist", $route);

        //Route afficherDetail, controleur ControleurNoeudCommune
        $route = new Route("/afficherDetail/{gidCommune}", [
            "_controller" => "\App\PlusCourtChemin\Controleur\ControleurNoeudCommune::afficherDetail",
        ]);
        $route->setMethods(["GET"]);
        $routes->add("afficherDetail", $route);


        $contexteRequete = (new RequestContext())->fromRequest($requete);

        $associateurUrl = new UrlMatcher($routes, $contexteRequete);
        $donneesRoute = $associateurUrl->match($requete->getPathInfo());


        $requete->attributes->add($donneesRoute);

        $resolveurDeControleur = new ControllerResolver();
        $controleur = $resolveurDeControleur->getController($requete);


        $assistantUrl = new UrlHelper(new RequestStack(), $contexteRequete);
        $generateurUrl = new UrlGenerator($routes, $contexteRequete);

        Conteneur::ajouterService("assistantUrl", $assistantUrl);
        Conteneur::ajouterService("generateurUrl", $generateurUrl);

        $resolveurDArguments = new ArgumentResolver();
        $arguments = $resolveurDArguments->getArguments($requete, $controleur);

        call_user_func_array($controleur, $arguments);
    }
}