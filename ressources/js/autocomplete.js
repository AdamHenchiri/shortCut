//document.addEventListener('DOMContentLoaded', function () {

    var liste_ville = document.getElementById("autocompletion");
    var auto2 = document.getElementById("autocompletionArrivee");
    var  longueurListe = 5;

    function afficheVilles(tableau, divComplete) {
        // à compléter
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

    function videVilles(divComplete) {
        let child = divComplete.lastElementChild;
        while (child) {
            divComplete.removeChild(child);
            child = divComplete.lastElementChild;
        }

    }

    function actionDebut() {

        loading.style.visibility = "visible";
    }

    function actionFin() {
        loading.style.visibility = "hidden";
    }

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

    function maRequeteAJAX(string) {
        //mettre tout le temps la première lettre en majuscule au cas ou il est en minuscule et mettre les autres lettres en minuscules
        string = string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        requeteAJAX(string, callback_4, actionDebut, actionFin);
    }

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

    var nomCommuneDepart = document.getElementById("nomCommuneDepart_id");

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

    var nomCommuneArrivee = document.getElementById("nomCommuneArrivee_id");

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

document.addEventListener("click", function(event){
    if(event.target.className === "ma-classe") {
        var targetElement = event.target;
        nomCommuneDepart.value = targetElement.textContent;
        videVilles(liste_ville);
    }
});

//--------------------------------------------------------------


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

