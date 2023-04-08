// Initialisation de la carte
var mymap = L.map('mapid').setView([46.485935, 2.553603], 6);

//Initialisation du tableau de coordonnées
var coords = [];
//Initialisation du tableau de marker sur la map
var marker = [];
//Initialisation du tableau de route sur la map
var polyline = [];

var divDistance = document.getElementById("distance");


//Une fois le calcule effectuer la ville de départ et la ville d'arrivé sont placés dans
//des balise span et puis récupérer ici pour avoir le nom des ville.
var nomDepart = document.getElementById("nomCommuneDepart_id");
var nomArrivee = document.getElementById("nomCommuneArrivee_id");

// Ajout de la carte OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
}).addTo(mymap);

//Lors du click sur le bouton submit du formulaire,
// nous utilisons la méthode "preventDefault()" pour empêcher la soumission du formulaire
// et appelons ensuite notre fonction "RqCalculChemin" avec les noms des villes saisie dans les inputs
document.querySelector('form').addEventListener('submit', async function (event) {
    event.preventDefault();
    if (await verifierVille(nomDepart.value) && await verifierVille(nomArrivee.value)) {
        console.log("Calcul en cours ...");
        showLoader();
        if (nomDepart && nomArrivee) {
            let stringDepart = nomDepart.value;
            let stringArrivee = nomArrivee.value;
            await RqCalculChemin(stringDepart, stringArrivee);
        }
    } else {
        alert("Un ou des champs ne sont pas valide");
        event.preventDefault();
    }
});

//verifie dans un premier temps l'existence de point ou de route sur la map et les effacent si elles existent
//puis envoie une requete avec les noms des villes à l'action donneesRoute du controller TronconRouteNoeuds&nomCommuneDepart avec le nom des villes
//cette requete renvoie un tableau avec geom(les coordonnees de chaque troncon) et agg_cost (la longeure de chaque troncon)
async function RqCalculChemin(string1, string2) {
    init();
    let req =  await fetch(`./calcul/${string1}/${string2}`)
    let data = await req.json();
    let tableau = [];
    for (let i = 0; i < data.length; i++) {
        tableau.push(JSON.parse(data[i].geom));
    }
    divDistance.innerText = ("Le plus court chemin entre " + string1 + " et " + string2 + " mesure " + parseFloat(data[data.length - 1].agg_cost).toFixed(3) + " km.")
    await afficheRoute(tableau, string1, string2);
}

//parcours le tableau et affiche chaque troncon sur la map
//puis appele maRequete avec la ville de depart et la ville d'arrivee
//@tableau = [[51.509, -0.10], [43.59917865, 3.894125217]];
async function afficheRoute(tableau, string1, string2) {
    var tabRoute = [];
    for (var i = 0; i < tableau.length - 1; i++) {
        var tabTroncon = [];
        for (let j = 0; j < tableau[i].coordinates.length; j++) {
            tabTroncon.push((tableau[i].coordinates[j]).reverse());
        }
        polyline.push(new L.polyline(tabTroncon, {color: 'red'}));
        mymap.addLayer(polyline[polyline.length - 1]);
    }
    await RqMarker(string1);//Requète sur la ville de départ
    await RqMarker(string2);//Requète sur la ville d'arrivée
    adaptZoom();
    hideLoader();
}


//Recupère les données (coordonnées) grâce à l'url et appelle la fonction affichePoint grâce aux coordonnées
//Methide GET
async function RqMarker(string) {
    try {
        let req =  await fetch(`./donneesCarte/${string}`)
        let data = await req.json();
        let tab = data[0].st_asgeojson;
        tab = (JSON.parse(tab));
        affichePoint(tab.coordinates);
    } catch (error) {
        console.log(error);
    }
}

//Fonction qui pour afficher les point sur la carte.
//prend en paramètre un tableau de coordonnees de la ville
function affichePoint(tableau) {
    coords = [];
    let latitude = tableau[0];
    let longitude = tableau[1];
    tabVille = [longitude, latitude];
    console.log(tabVille);
    coords.push(tabVille);
    JSON.stringify(coords); //coords = [[51.509, -0.10]];
    for (var i = 0; i < coords.length; i++) {
        marker.push(new L.Marker(coords[i]));
        mymap.addLayer(marker[marker.length - 1]);
    }
}

async function verifierVille(nomCommune){
    try {
        let req =  await fetch(`./villeExist/${nomCommune}`)
        let data = await req.json();
        return (data.count >= 1);
    } catch (error) {
        console.log(error);
    }
}

//pour ajouter la class css show qui affiche le loader
//pour ajouter la class css blur qui floute la carte
function showLoader() {
    document.getElementById("loader").classList.add("show");
    document.getElementById("mapid").classList.add("blur");
}

//pour supprimer la class css show qui affiche le loader
//pour supprimer la class css blur qui floute la carte
function hideLoader() {
    document.getElementById("loader").classList.remove("show");
    document.getElementById("mapid").classList.remove("blur");
}

function adaptZoom (){

    // Création d'un objet LatLngBounds à partir des marqueurs et de la polyline
    var bounds = L.latLngBounds([marker[0].getLatLng(), marker[1].getLatLng()]);
    //bounds.extend(polyline.getBounds());

    // Zoom sur les limites
    mymap.fitBounds(bounds,{
        duration: 2, // Durée du zoom en secondes
        padding: [10, 10] // Marge autour des bords de la carte
    });
}

function init(){
    if (marker.length > 0) {
        marker.forEach(m => mymap.removeLayer(m));
        marker = [];
        console.log(marker.length);
    }
    if (polyline.length > 0) {
        polyline.forEach(p => mymap.removeLayer(p))
        polyline = [];
        console.log(polyline.length);
    }
    mymap.setView([46.485935, 2.553603], 6);
}