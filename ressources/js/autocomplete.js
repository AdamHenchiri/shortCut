//Récupère les div qui servent à l'autocompletion
    var liste_ville = document.getElementById("autocompletion");
    var auto2 = document.getElementById("autocompletionArrivee");

    //Fonction pour afficher le nom des ville dans la div
    //5 villes affichees (voir la requete sql)
    //tableau -> nom des ville, divComplete -> indique l'autocompletion pour ville de départ ou d'arrivée
    function afficheVilles(tableau, divComplete) {
        //console.log(tableau);
        videVilles(divComplete);
        for (let i = 0; i < tableau.length; i++) {
            let ville = document.createElement("p");
            ville.classList.add("ma-classe");
            ville.textContent = tableau[i].nom_comm;
            divComplete.appendChild(ville);
        }
        divComplete.style.borderWidth = `${tableau.length > 0 ? 1 : 0}px`
    }

    //Méthode pour vider la div d'autocompletion
    //divComplete -> indique l'autocompletion pour ville de départ ou d'arrivée
    function videVilles(divComplete) {
        let child = divComplete.lastElementChild;
        while (child) {
            divComplete.removeChild(child);
            child = divComplete.lastElementChild;
        }

    }

    //Pas utiliser mais permet l'affichage d'un gif
    function actionDebut() {
        loading.style.visibility = "visible";
    }
    //Pas utiliser mais permet d'enlever l'affichage d'un gif
    function actionFin() {
        loading.style.visibility = "hidden";
    }

    //Fais une requête pour récupérer les données et appelle le callback mis en paramètre
    function requeteAJAX(stringVille, callback, action_debut, action_fin) {
        let url = "controleurFrontal.php?action=autocompletion&controleur=noeudCommune&nomCommuneDepart=" + encodeURIComponent(stringVille);
        let requete = new XMLHttpRequest();
        requete.open("GET", url, true);
        //requete.addEventListener("loadstart", action_debut)
        requete.addEventListener("load", function () {
            callback(requete);
            //action_fin();
        });
        requete.send();
    }

    //Appelle requeteAJAX avec ces parametres
    function maRequeteAJAX(string) {
        //mettre tout le temps la première lettre en majuscule au cas ou il est en minuscule et mettre les autres lettres en minuscules
        string = string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        requeteAJAX(string, callback_4, actionDebut, actionFin);
    }

    //Met la requete en Json et appelle l'affichage des villes en fonction de l'input
    function callback_4(req) {
        //tab = tab.map(e => e.name);
        //console.log(tab);
        document.addEventListener('input', function(event) {
            let tab = JSON.parse(req.responseText);
            if (event.target.id === 'nomCommuneDepart_id') {
                afficheVilles(tab, liste_ville);
            }
            if (event.target.id === 'nomCommuneArrivee_id') {
                afficheVilles(tab, auto2);
            }
        });


    }

    //recupère le input de départ
    var nomCommuneDepart = document.getElementById("nomCommuneDepart_id");

    var city = "";
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function (position){
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            fetch(`https://api-adresse.data.gouv.fr/reverse/?lon=${longitude}&lat=${latitude}`)
                .then(response => response.json())
                .then(data => {
                    city = data.features[0].properties.city;
                    console.log(`La ville est ${city}`);
                    verifierVille(city);
                })
                .catch(error => console.log(error));
            console.log("latitude : " + latitude + " longitude : " + longitude);

        });
    }else {
        console.log("pas géolocalisation");
    }

    var iconLocalisation = document.getElementById("localisation");
    function verifierVille(ville){
        fetch(`controleurFrontal.php?action=villeExist&controleur=noeudCommune&ville=${ville}`)
            .then(response => response.json())
            .then(data => {
                if(data.count === 1){
                    console.log("la ville exist");
                    iconLocalisation.style.visibility = "visibible";
                    iconLocalisation.style.cursor = "pointor";

                    iconLocalisation.addEventListener("click", function (){
                        nomCommuneDepart.value = ville;
                        videVilles(liste_ville);
                    })
                }
                else{
                    console.log("la ville n'exist pas");
                    iconLocalisation.style.visibility = "hidden";
                }
            } )
            .catch(error => console.log(error));
    }


    //Apelle maRequete lorsque l'input est utilisé
    //Le vide ville ne fonctionne pas ici
    nomCommuneDepart.addEventListener("input", function () {
        //console.log("chargement terminé !!!");
        let stringVille = nomCommuneDepart.value;
        console.log(stringVille);
        console.log(stringVille.length);

        if(stringVille.length === 0 ){
            console.log('avant');
            console.log(liste_ville);
            videVilles(liste_ville);
            console.log("après");
            console.log(liste_ville);


        }
        else {
            console.log("requete");
            maRequeteAJAX(stringVille)
        }


    });

    //recupère le input d'arrivée
    var nomCommuneArrivee = document.getElementById("nomCommuneArrivee_id");
    //Apelle maRequete lorsque l'input est utilisé
    //Le vide ville ne fonctionne pas ici

    nomCommuneArrivee.addEventListener("input", function () {
        //console.log("chargement terminé !!!");
        let stringVille = nomCommuneArrivee.value;
        console.log(stringVille);
        console.log(stringVille.length);
        maRequeteAJAX(stringVille);
        if (stringVille.length <= 0) {
            videVilles(auto2);
            auto2.style.borderWidth = "0px";

        }

    });

    //vide la liste des villes dans l'autocompletion lorsque l'on click sur une ville
document.addEventListener("click", function(event){
    if(event.target.className === "ma-classe") {
        var targetElement = event.target;
        nomCommuneDepart.value = targetElement.textContent;
        videVilles(liste_ville);
    }
});

//--------------------------------------------------------------
//Le reste permet l'utilisation des flèches pour descendre
// et monter et la touche entrer pour selectionner une ville

//Met à jour l'index qui permet de savoir où on se situ dans la liste
function updateSelectedIndex(l, selectedIndex) {
    for (let i = 0; i < l.length; i++) {
        l[i].classList.remove("selected");
        l[i].style.background = "white"
    }
    // Ajoute la sélection sur l'élément correspondant à l'indice sélectionné
    if (selectedIndex >= 0 && selectedIndex < l.length) {
        l[selectedIndex].classList.add("selected");
        l[selectedIndex].style.background = "grey";

    }
}


document.addEventListener('input', function(event) {

    if (event.target.id === 'nomCommuneDepart_id') {
        let selectedIndex1 = -1; // Le premier élément sélectionné est -1 (aucun)

        const liste = liste_ville.getElementsByTagName("p");
        // Fonction pour mettre à jour la sélection visuelle de la liste des suggestions
        updateSelectedIndex(liste,selectedIndex1);

        // Gestionnaire d'événements pour la touche haut
        nomCommuneDepart.addEventListener("keydown", function(event) {
            if (event.keyCode === 38) { // 38 est le code de la touche haut
                console.log("38");
                event.preventDefault(); // Empêche le défilement de la page
                if(selectedIndex1 -1 >= 0 ) {
                    selectedIndex1--;
                    updateSelectedIndex(liste, selectedIndex1);
                }
            }
        });

        // Gestionnaire d'événements pour la touche bas
        nomCommuneDepart.addEventListener("keydown", function(event) {
            if (event.keyCode === 40) { // 40 est le code de la touche bas
                event.preventDefault(); // Empêche le défilement de la page
                if(selectedIndex1 +1 < liste.length) {
                    selectedIndex1++;
                    updateSelectedIndex(liste, selectedIndex1);
                }
            }
        });

        // Gestionnaire d'événements pour la touche Entrée
        nomCommuneDepart.addEventListener("keydown", function(event) {
            if (event.keyCode === 13) { // 13 est le code de la touche Entrée
                event.preventDefault(); // Empêche le défilement de la page
                if (selectedIndex1 >= 0 && selectedIndex1 < liste.length) {
                    // Sélectionne l'élément correspondant à l'indice sélectionné
                    const selectedSuggestion = liste[selectedIndex1];
                    console.log(selectedSuggestion);
                    // Met à jour le champ texte avec la suggestion sélectionnée
                    nomCommuneDepart.value = selectedSuggestion.textContent;
                    // Efface la liste des suggestions
                    videVilles(liste_ville);
                    // Réinitialise l'indice de sélection
                    selectedIndex1 = -1;
                }
            }
        });
    }




    if (event.target.id === 'nomCommuneArrivee_id') {
        let selectedIndex2 = -1;
        const liste2 = auto2.getElementsByTagName("p");
        updateSelectedIndex(liste2, selectedIndex2);

        nomCommuneArrivee.addEventListener("keydown", function(event) {
            if (event.keyCode === 38) {
                event.preventDefault();
                if(selectedIndex2 -1 >= 0 ) {
                    selectedIndex2--;
                    updateSelectedIndex(liste2, selectedIndex2);
                }
            }
        });

        nomCommuneArrivee.addEventListener("keydown", function(event) {
            if (event.keyCode === 40 ) {
                event.preventDefault();
                if(selectedIndex2 +1 < liste2.length){
                    selectedIndex2++;
                    updateSelectedIndex(liste2, selectedIndex2);
                }

            }
        });

        nomCommuneArrivee.addEventListener("keydown", function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                if (selectedIndex2 >= 0 && selectedIndex2 < liste2.length) {
                    const selectedSuggestion = liste2[selectedIndex2];
                    nomCommuneArrivee.value = selectedSuggestion.textContent;
                    videVilles(auto2);
                    selectedIndex2 = -1;
                }
            }
        });
    }
});







//});

