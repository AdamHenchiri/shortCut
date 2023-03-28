
// Initialisation de la carte
var mymap = L.map('mapid').setView([46.485935, 2.553603], 6);

// Ajout de la carte OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
}).addTo(mymap);

//Initialisation du tableau de coordonnées
var coords = [];

// Tracer un itinéraire à partir d'un tableau de coordonnées (c'est un exemple)
var routeCoords = [[51.505, -0.09], [51.507, -0.08], [51.509, -0.10]];
var route = L.polyline(routeCoords, {color: 'red'}).addTo(mymap);

//Fonction qui pour afficher les point sur la carte.
//prend en paramètre un tableau de coordonnees de la ville
function affichePoint(tableau){
    let latitude = tableau[0];
    let longitude = tableau[1];
    tabVille = [longitude, latitude];
    coords.push(tabVille);
    console.log(coords);
    JSON.stringify(coords);
    //coords = [[51.509, -0.10], [43.59917865, 3.894125217]];
    for (var i = 0; i < coords.length; i++) {
        L.marker(coords[i]).addTo(mymap);
    }

}

function afficheRoute(tableau){
    let latitude = tableau[0];
    let longitude = tableau[1];
    tabVille = [longitude, latitude];
    coords.push(tabVille);
    console.log(coords);
    JSON.stringify(coords);
    //coords = [[51.509, -0.10], [43.59917865, 3.894125217]];
    for (var i = 0; i < coords.length; i++) {
        L.marker(coords[i]).addTo(mymap);
    }

}

//Recupère les données (coordonnées) grâce à l'url et appelle la fonction affichePoint grâce aux coordonnées
//Methide GET
function maRequete(string){
    let url = "controleurFrontal.php?action=donneesCarte&controleur=noeudCommune&nomCommuneDepart=" + encodeURIComponent(string);
    let requete = new XMLHttpRequest();
    requete.open("GET", url, true);
    //requete.addEventListener("loadstart", action_debut)
    requete.addEventListener("load", function () {
        let tab = JSON.parse(requete.responseText);
        //console.log(JSON.parse(tab[0].st_asgeojson));
        tableau = JSON.parse(tab[0].st_asgeojson);
        //console.log(tableau.coordinates);
        affichePoint(tableau.coordinates);
    });
    requete.send(null);
}

//Une fois le calcule effectuer la ville de départ et la ville d'arrivé sont placés dans
//des balise span et puis récupérer ici pour avoir le nom des ville.
var nomDepart = document.getElementById("nomDepart");
var nomArrivee = document.getElementById("nomArrivee");

//Attend que la page soit charcé pour effectuer les requètes
document.addEventListener("DOMContentLoaded",  function() {
    console.log("La section spécifique de la page a fini de se charger !");
    if(nomDepart && nomArrivee ) {
        let stringDepart = nomDepart.textContent;
        let stringArrivee = nomArrivee.textContent;
        //Requète sur la ville de départ
        maRequete(stringArrivee);
        //Requète sur la ville d'arrivée
        maRequete(stringDepart);
    }


});

