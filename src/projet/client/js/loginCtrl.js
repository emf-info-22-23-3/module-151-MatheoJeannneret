class LoginCtrl {
  constructor() {
    this.btnConnect = $("#connect");
    this.initEvents();
  }

  connectSuccess(data, text, jqXHR) {
    if (jqXHR.status === 200) {
      sessionStorage.setItem("isConnected", "1");
      sessionStorage.setItem("username", data.nom);
      sessionStorage.setItem("isAdmin", data.isAdmin);
      sessionStorage.setItem("userId", data.id);

      alert("Connexion avec succès !");
      indexCtrl.loadIfConnected();
    }
  }

  initEvents() {
    this.btnConnect.on("click", (event) => this.onLoginClick(event));
  }

  async onLoginClick(event) {
    event.preventDefault();

    const nom = $("#nom").val();
    const password = $("#password").val();

    http.connecterUser(
      (data, text, jqXHR) => {
        this.connectSuccess(data, text, jqXHR);
      },
      nom,
      password
    );
  }
}
