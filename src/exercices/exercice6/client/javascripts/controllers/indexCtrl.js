/*
 * Contrôleur de la vue "index.html"
 *
 * @author Olivier Neuhaus
 * @version 1.0 / 20-SEP-2013
 */

/**
 * Méthode appelée lors du retour avec succès du résultat des équipes
 * @param {type} data
 * @param {type} text
 * @param {type} jqXHR
 */
function chargerTeamSuccess(data, text, jqXHR) {
    // appelé lorsque l'on reçoit les données de la part du PHP
    var tblContent = $("#tableContent");
    var txt = '';
    var id = 1;

    $(data).find("equipes").each(function () {
        txt = "<tr><td>" + id++ + "</td><td>" + $(this).text() + "</td></tr>";
        $(txt).appendTo(tblContent);
    })
}

/**
 * Méthode appelée en cas d'erreur lors de la lecture du webservice
 * @param {type} data
 * @param {type} text
 * @param {type} jqXHR
 */
function chargerTeamError(request, status, error) {
    alert("erreur : " + error + ", request: " + request + ", status: " + status);
}

/**
 * Méthode "start" appelée après le chargement complet de la page
 */
$(document).ready(function () {
    $.getScript("javascripts/services/servicesHttp.js", function () {
        console.log("servicesHttp.js chargé !");
        chargerTeam(chargerTeamSuccess, chargerTeamError);
    });
});