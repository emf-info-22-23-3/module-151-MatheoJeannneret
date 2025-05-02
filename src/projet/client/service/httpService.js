class HttpService {
  constructor() {
    this.endpoint =
      "https://jeanneretm.emf-informatique.ch/151/projet/server/server.php";
  }

  centraliserErreurHttp(callback) {
    $.ajaxSetup({
      error: function (xhr, exception) {
        callback(
          `[${xhr.status}] ${
            xhr.responseText &&
            xhr.getResponseHeader("Content-Type")?.includes("application/json")
              ? JSON.parse(xhr.responseText).message
              : xhr.responseText || "Erreur non identifiée"
          }`
        );
      },
    });
  }

  connecterUser(successCallback, nom, password) {
    console.log("test");
    let body = {
      action: "login",
      nom: nom,
      password: password,
    };
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: this.endpoint,
      data: JSON.stringify(body),
      contentType: "application/json",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  disconnectUser(successCallback) {
    let body = {
      action: "logout",
    };
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: this.endpoint,
      data: JSON.stringify(body),
      contentType: "application/json",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  getAllHoraires(successCallback) {
    $.ajax({
      type: "GET",
      dataType: "JSON",
      url: this.endpoint + "?action=getAllHoraires",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  getAllTypes(successCallback) {
    $.ajax({
      type: "GET",
      dataType: "JSON",
      url: this.endpoint + "?action=getAllTypes",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  getAllLocalites(successCallback) {
    $.ajax({
      type: "GET",
      dataType: "JSON",
      url: this.endpoint + "?action=getAllLocalites",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  createHoraire(
    successCallback,
    dateDepart,
    localiteDepart,
    localiteDestination,
    typeTrain
  ) {
    let body = {
      action: "createHoraire",
      dateDepart: dateDepart,
      localiteDepart: localiteDepart,
      localiteDestination: localiteDestination,
      typeTrain: typeTrain,
    };
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: this.endpoint,
      data: JSON.stringify(body),
      contentType: "application/json",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  deleteHoraire(successCallback, pkHoraire) {
    let body = {
      action: "deleteHoraire",
      pkHoraire: pkHoraire,
    };

    $.ajax({
      type: "DELETE",
      dataType: "JSON",
      url: this.endpoint,
      data: JSON.stringify(body),
      contentType: "application/json", // important pour DELETE avec body JSON
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }

  updateHoraire(
    successCallback,
    pkHoraire,
    dateDepart,
    localiteDepart,
    localiteDestination,
    typeTrain
  ) {
    let body = {
      action: "updateHoraire",
      pkHoraire: pkHoraire,
      dateDepart: dateDepart,
      localiteDepart: localiteDepart,
      localiteDestination: localiteDestination,
      typeTrain: typeTrain,
    };

    $.ajax({
      type: "PUT",
      dataType: "JSON",
      url: this.endpoint,
      data: JSON.stringify(body),
      contentType: "application/json",
      xhrFields: {
        withCredentials: true,
      },
      success: successCallback,
    });
  }
}
