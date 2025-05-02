$(document).ready(function () {
  http = new HttpService();
  indexCtrl = new IndexCtrl();
  http.centraliserErreurHttp(indexCtrl.afficherErreurHttp);
});

class IndexCtrl {
  constructor() {
    this.vue = new VueService();
    this.loadIfConnected();
  }

  afficherErreurHttp(msg) {
    alert(msg);
  }

  loadIfConnected() {
    if (sessionStorage.getItem("isConnected") === "1") {
      this.loadHoraires();
    } else {
      this.loadLogin();
    }
  }

  loadLogin() {
    this.vue.chargerVue("login", () => new LoginCtrl());
    $("title").text("Login");
  }

  loadHoraires() {
    this.vue.chargerVue("horaires", () => new HorairesCtrl());
    $("title").text("Horaires des trains");
  }
}
