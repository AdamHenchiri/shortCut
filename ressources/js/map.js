function requeteAJAX(stringVille, callback) {
    let url = "controleurFrontal.php?action=donneesCarte&controleur=noeudCommune&nomCommuneDepart=" + encodeURIComponent(stringVille);
    let requete = new XMLHttpRequest();
    requete.open("GET", url, true);
    //requete.addEventListener("loadstart", action_debut)
    requete.addEventListener("load", function () {
        callback(requete);
        //action_fin();
    });
    requete.send();
}

function maRequeteAJAX(string) {
    //mettre tout le temps la première lettre en majuscule au cas ou il est en minuscule et mettre les autres lettres en minuscules
    string = string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    requeteAJAX(string, callback_4);
}






// Initialisation de la carte
var mymap = L.map('mapid').setView([46.850947, 2.395394], 6);

// Ajout de la carte OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
}).addTo(mymap);

function callback_4(req) {
// Ajout des marqueurs pour les coordonnées spécifiées
    console.log(req);
    var coords = [[51.505, -0.09], [51.507, -0.08], [51.509, -0.10]];
    for (var i = 0; i < coords.length; i++) {
        L.marker(coords[i]).addTo(mymap);
    }
}



// Tracer un itinéraire à partir d'un tableau de coordonnées
var routeCoords = [[51.505, -0.09], [51.507, -0.08], [51.509, -0.10]];
var route = L.polyline(routeCoords, {color: 'red'}).addTo(mymap);