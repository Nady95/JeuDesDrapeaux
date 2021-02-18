// On déclare les variables qui nous seront nécessaires
var attempts_remaining = 3,
	score = 0,
    selectedCountry,
    countriesArray,
    temp_id,
    btnArray = ['flag1-btn', 'flag2-btn', 'flag3-btn', 'flag4-btn', 'flag5-btn'],
    layer_list = new Array(),
    distance_list = new Array(),
    dataLayer = null,
    country_to_find = null;


$(document).ready(function(){
    // On récupère le bon quiz en fonction du paramètre de l'URL
    const quizChosen = "assets/json/" + $_GET("mode") + ".json";
    // On ne souhaite pas pouvoir intéragir avec la carte dès le début (il faut d'abord avoir sélectionné un drapeau)
    disableInteractionMap(map);
	// On lit le fichier geoJSON du quiz choisi, et on en place le contenu dans la varibale "quiz"
	$.getJSON(quizChosen,function(quiz){
        // Si on joue sur le monde entier, on tire 5 pays au hasard (dans un ordre quelconque) parmi une liste prédéfinie
        if($_GET("mode") === "monde") document.getElementById("instructions2").innerHTML = "Les drapeaux correspondent à des pays du monde entier";
        // Sinon on récupère le nom du continent sur lequel on joue, et on fait pareil qu'au-dessus
		else document.getElementById("nomContinent").innerHTML = quiz.continent;
        questions = getFiveRandomCountries(quiz.countries);
        assignFlags(questions);  
        countriesArray = questions;

        // On rend chacun des drapeaux cliquables
        btnArray.forEach(id => document.getElementById(id).addEventListener('click', toggleClickFlags));
        
        // On charge le fichier qui dessine les pays
		$.getJSON("geojson-world-master/countries-min.geojson",function(countries){
			dataLayer = L.geoJSON(countries, {
				onEachFeature: onEachFeature,
				style: default_style,
                interactive: false
			}).addTo(map);
		});
	});
});

/**
*
*
*/
function onEachFeature(feature, layer){
    layer.on('click', function (click_pos) {
        // Si on a pas sélectionné de drapeau d'un pays, on ne rentre jamais dans cette fonction
        if(!selectedCountry) return;
        
        // Quand on sélectionne un pays sur la carte, on récupère son code CCA2
        var cca2 = feature.properties.cca2;
        // Cela nous permet de vérifier si on avait déjà sélectionné ce pays, afin de ne pas faire varier le score et 
        // le nombre d'essais restants si on reclique dessus par mégarde
        if(!layer_list.includes(cca2)){
            // On met à jour le score et le nombre d'essais à chaque clic
            update_score();
            update_attempts();
            // Si on n'a pas trouvé le pays cherché, on le colore en rouge, et on met à jour le nombre d'essais restants
            if(feature.properties.cca2 !== selectedCountry.cca2){
                this.setStyle({ color: 'red' });
                attempts_remaining--;
                update_attempts();
                // On ajoute également le pays à la liste des pays déjà sélectionnés pour ne plus pouvoir intéragir avec
                layer_list.push(cca2);
                // On récupère la distance entre le clic et le pays pour le calcul du score
                var distance = getDistanceToCountry(click_pos, country_to_find);
                distance_list.push(distance);
            }
            
            // On vérifie si la manche est terminée
            if(isRoundFinished(cca2)){
                // On récupère l'iso3 du pays et on le dessine quoiqu'il arrive
                var iso3 = selectedCountry.iso3;
                $.getJSON("countries-master/data/"+iso3+".geo.json",function(data){
					var answer = L.geoJson(data);
                    var area_of_country = selectedCountry.superficie;
                    if(attempts_remaining === 0) answer.setStyle({ color: 'red'});
                    else answer.setStyle({color: 'blue'});
                    answer.addTo(map);
                    // Enfin on affiche le carrousel et la description      
                    $('#carousel-container').load("includes/carousel.html", function(){
                        document.getElementById('img1-carousel').src = selectedCountry.diaporama[0].url;
                        document.getElementById('img2-carousel').src = selectedCountry.diaporama[1].url;
                        document.getElementById('country_name').innerHTML = selectedCountry.name;
                        document.getElementById('country_name1').innerHTML = selectedCountry.name;
                        document.getElementById('country_name2').innerHTML = selectedCountry.name;
                        document.getElementById('country_description').innerHTML = selectedCountry.description;
                    });
                    
                    // On calcule le score, selon si on a trouvé le pays ou non, en combien de clics...
                    if(attempts_remaining === 0){
                        calculate_score(false, area_of_country, bestClick());
                    } else {
                        calculate_score(true, area_of_country, null);
                    }
                    
                    // On vide les listes layer_list et distance_list
                    layer_list.length = 0;
                    distance_list.length = 0;
                    // On efface toutes les intéractions précédentes avec la carte
                    dataLayer.eachLayer(function(l){
                        l.setStyle(default_style());
                    });
                    // On désactive temporairement toutes les intéractions avec la carte et on réinitialise le nombre d'essais
                    disableInteractionMap(map);
                    re_enable_buttons();
                    
                    // Si on a cherché les 5 drapeaux, on affiche le score au joueur et on lui propose de rejouer
                    if(btnArray.length === 0){
                        if(confirm('PARTIE TERMINEE !\nVous avez marqué un score de ' + score + ' pts !\nVoulez-vous rejouer ?'))
                            window.location.reload();
                        sendScoreToPHP();
                    }
                });
            }
        }
    });
}

/**
*   Retourne le style par défaut avec lequel on dessine tous les pays
*   sur le fond de carte
*/
function default_style() {
    return {
        weight: 1,
        opacity: 1,
        color: 'grey',
        dashArray: '3',
    };
}

/**
*   Désactive les intéractions avec la carte
*/
function disableInteractionMap(map){
    map.dragging.disable();
    map.touchZoom.disable();
    map.doubleClickZoom.disable();
    map.scrollWheelZoom.disable();
    map.boxZoom.disable();
    map.keyboard.disable();
    if (map.tap) map.tap.disable();
    document.getElementById('map').style.cursor = 'default';
    if(dataLayer) dataLayer.setInteractive(false);
}

/**
*   Active les intéractions avec la carte
*/
function enableInteractionMap(map){
    map.dragging.enable();
    map.touchZoom.enable();
    map.doubleClickZoom.enable();
    map.scrollWheelZoom.enable();
    map.boxZoom.enable();
    map.keyboard.enable();
    if (map.tap) map.tap.enable();
    document.getElementById('map').style.cursor = 'crosshair';
    if(dataLayer) dataLayer.setInteractive(true);
}

/**
*   Retourne les coordonnées du centre d'un pays
*/
function getCenter(country){
	return country.getBounds().getCenter();
}

/**
*   Retourne la distance entre le clic de la souris et le centre d'un pays (en km)
*/
function getDistanceToCountry(click, country){
	return map.distance(click.latlng, getCenter(country))/1000;
}

/**
*   Retourne le meilleur des trois clics si le joueur n'a pas trouvé la réponse 
*   (càd la plus faible distance entre le clic et le pays cherché)
*/
function bestClick(){
    Array.prototype.min = function() {
        return Math.min.apply(null, this);
	};
	return distance_list.min();
}

/**
*   Calcule le score réalisé par le joueur
*/
function calculate_score(isAnswerCorrect, countryArea, distance){
    if(isAnswerCorrect){
        score += 9000;
        // On applique un malus au score si on n'a pas trouvé du premier coup
        var wrong_attempts = 3 - attempts_remaining;
        score -= wrong_attempts * 3000;
        // En fonction de la superficie du pays (en km²), on attribue +- de points
		if(countryArea < 100)			score += 1000;
		else if(countryArea < 300)		score += 900;
		else if(countryArea < 500)		score += 850;
		else if(countryArea < 1000)		score += 800;
		else if(countryArea < 3000)		score += 700;
		else if(countryArea < 10000)	score += 600;
		else if(countryArea < 25000)	score += 550;
		else if(countryArea < 50000)	score += 500;
		else if(countryArea < 100000)	score += 400;
		else if(countryArea < 300000)	score += 300;
		else if(countryArea < 500000)	score += 250;
		else if(countryArea < 1000000)	score += 200;
		else if(countryArea < 50000000)	score += 100;
		else 							score += 50;
    }
    else{
    	// Suivant la distance on donne plus ou moins de points
		if (distance <= 100) score += 800;
		else if (distance <= 200 && distance > 100) score += 700;
		else if (distance <= 300 && distance > 200) score += 600;
		else if (distance <= 400 && distance > 300) score += 500;
		else if (distance <= 500 && distance > 400) score += 400;
		else if (distance <= 600 && distance > 500) score += 300;
		else if (distance <= 700 && distance > 600) score += 200;
		else if (distance <= 800 && distance > 700) score += 100;
		else score += 1; // Sinon on donne 1 pt pour la participation
    }
    update_score();
}

/**
*   Met à jour l'affichage du score
*/
function update_score(){
    document.getElementById("score").innerHTML = score;
}

/**
*   Met à jour l'affichage du nombre d'essais restants
*/
function update_attempts(){
    document.getElementById("attempts_remaining").innerHTML = attempts_remaining;
}

/**
*   Active les drapeaux pour les rendre cliquables
*/
function toggleClickFlags(){
    // On désactive la sélection de tous les drapeaux tant que la manche n'est pas terminée
    btnArray.forEach(id => document.getElementById(id).setAttribute('disabled','disabled'));
    // On n'oublie pas non plus de retirer le bouton de sélection de ce drapeau de la liste (on ne souhaite pas pouvoir rejouer une manche)
    btnArray = btnArray.filter(btn => btn !== this.id);
    // On récupère également toutes les infos sur le pays sélectionné
    if(this.id === 'flag1-btn')      selectedCountry = countriesArray[0];
    else if(this.id === 'flag2-btn') selectedCountry = countriesArray[1];
    else if(this.id === 'flag3-btn') selectedCountry = countriesArray[2];
    else if(this.id === 'flag4-btn') selectedCountry = countriesArray[3];
    else if(this.id === 'flag5-btn') selectedCountry = countriesArray[4];
    
    // On floute les drapeaux non sélectionnés
    btnArray.forEach(id => document.getElementById(id).style.opacity = "10%");
    
    // On active l'intéraction avec la carte
    enableInteractionMap(map);
    
    // On modifie l'instruction
    document.getElementById('instructions').innerHTML = "Identifiez, sur la carte ci-dessous, le pays correspondant au drapeau sélectionné.";
    
    // On récupère l'id du drapeau joué (pour pouvoir le désactiver complètement après)
    temp_id = this.id;
    
    // On donne trois essais au joueur
    attempts_remaining = 3;
    update_attempts();
    
            
    // On récupère le pays à trouver
    var iso3 = selectedCountry.iso3;
    $.getJSON("countries-master/data/"+iso3+".geo.json",function(country){
        country_to_find = L.geoJson(country);
    });
}

/**
*   Permet de réactiver les boutons permettant de sélectionner un drapeau ainsi 
*   que l'affichage des effets
*/
function re_enable_buttons(){
    btnArray.forEach(id => document.getElementById(id).removeAttribute('disabled'));
    btnArray.forEach(id => document.getElementById(id).style.opacity = "100%");
    document.getElementById(temp_id).style.filter = "grayscale(1)";
    document.getElementById('instructions').innerHTML = "Cliquez sur le drapeau souhaité et identifiez le pays correspondant sur la carte suivante";
}

/**
*   Retourne 5 pays au hasard parmi une liste
*/
function getFiveRandomCountries(array){
    const shuffled = array.sort(() => 0.5 - Math.random());
    return shuffled.slice(0,5);
}

/**
*   Dessine les drapeaux de 5 pays choisis
*/
function assignFlags(array){
    const folderLink = "country-flags-master/png100px/";
    document.getElementById("flag1").src = folderLink + array[0].cca2 + ".png";
    document.getElementById("flag2").src = folderLink + array[1].cca2 + ".png";
    document.getElementById("flag3").src = folderLink + array[2].cca2 + ".png";
    document.getElementById("flag4").src = folderLink + array[3].cca2 + ".png";
    document.getElementById("flag5").src = folderLink + array[4].cca2 + ".png";
}

/**
*   Retourne vrai si la manche est terminée (soit le joueur a trouvé le pays en question, 
*   soit il a utilisé tous ses essais)
*   Désactive également les intéractions avec la carte si c'est le cas.
*   Retourne faux sinon.
*/
function isRoundFinished(cca2){
	if(attempts_remaining === 0 || cca2 === selectedCountry.cca2){
        disableInteractionMap(map);
        return true;
    }
	return false;
}

/**
*   Permet d'activer ou de désactiver les intéractions avec une layer dans Leaflet
*   (dans notre cas, active/désactive le clic sur les différents pays)
*/
L.Layer.prototype.setInteractive = function (interactive) {
    if (this.getLayers) {
        this.getLayers().forEach(layer => {
            layer.setInteractive(interactive);
        });
        return;
    }
    if (!this._path) {
        return;
    }

    this.options.interactive = interactive;

    if (interactive) {
        L.DomUtil.addClass(this._path, 'leaflet-interactive');
    } else {
        L.DomUtil.removeClass(this._path, 'leaflet-interactive');
    }
};

/**
*   Récupère un paramètre GET dans l'URL
*/
function $_GET(param) {
    var curr_url = new URL(window.location.href);
    return curr_url.searchParams.get(param);
}

/**
*   Envoie le score à une page PHP pour mettre à jour la base de données
*/
function sendScoreToPHP(){
    $.ajax({
        type: "POST",
        url: "assets/updateBDD.php",
        data: { score: score,
                nomQuiz: $_GET("mode")
              },
        success: function(r){
            content.html(r);
        }
    });
}