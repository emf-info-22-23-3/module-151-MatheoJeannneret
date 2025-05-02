class HorairesCtrl {
  constructor() {
    this.initEvents();
    this.afficherHoraires();
  }

  initEvents() {
    //écouteur de déconnexion
    $("#deconnexion").on("click", (event) => this.onLogoutClick(event));

    //écouteur pour créer l'horaire
    $("#create-horaire").on("click", (event) => this.createHoraire(event));

    //écouteur pour update l'horaire
    $("#update-horaire").on("click", (event) => this.updateHoraire(event));

    //chargement des paramètres pour l'ajout/modification d'un horaire (uniquement si admin)
    if (sessionStorage.getItem("isAdmin") === "1") {
      http.getAllLocalites((localites) => {
        const localitesDepart = document.getElementById("depart");
        const localitesDestination = document.getElementById("arrivee");

        const editLocalitesDepart = document.getElementById("edit-depart");
        const editLocalitesDestination =
          document.getElementById("edit-arrivee");

        localitesDepart.innerHTML = "";
        localitesDestination.innerHTML = "";
        editLocalitesDepart.innerHTML = "";
        editLocalitesDestination.innerHTML = "";

        localites.forEach((localite) => {
          const option1 = document.createElement("option");
          option1.value = localite.id;
          option1.textContent = localite.nom;

          const option2 = document.createElement("option");
          option2.value = localite.id;
          option2.textContent = localite.nom;

          const option3 = document.createElement("option");
          option3.value = localite.id;
          option3.textContent = localite.nom;

          const option4 = document.createElement("option");
          option4.value = localite.id;
          option4.textContent = localite.nom;

          localitesDepart.appendChild(option1);
          localitesDestination.appendChild(option2);
          editLocalitesDepart.appendChild(option3);
          editLocalitesDestination.appendChild(option4);
        });
      });

      http.getAllTypes((types) => {
        const selectTypes = document.getElementById("typeTrain");
        const editTypes = document.getElementById("edit-typeTrain");

        types.forEach((type) => {
          const option1 = document.createElement("option");
          option1.value = type.id;
          option1.textContent = type.abreviation + " - " + type.nom;

          const option2 = document.createElement("option");
          option2.value = type.id;
          option2.textContent = type.abreviation + " - " + type.nom;

          selectTypes.appendChild(option1);
          editTypes.appendChild(option2);
        });
      });
    } else {
      const bouton = document.getElementById("createHoraire");
      bouton.disabled = true;
      bouton.style.opacity = "0.5";
      bouton.style.pointerEvents = "none";
    }
  }

  //partie de déconnexion (appeler dans l'initialisation)
  onLogoutClick(event) {
    event.preventDefault();
    const confirmQuestion = confirm("Voulez-vous vraiment vous déconnecter ?");
    if (confirmQuestion) {
      http.disconnectUser(() => {
        alert("Vous êtes deconnecté avec succès");
        sessionStorage.clear();
        indexCtrl.loadIfConnected();
      });
    }
  }

  //partie de création de l'horaire (appeler dans l'initialisation)
  createHoraire(event) {
    const dateValue = document.getElementById("date").value;
    const localiteDepartValue = document.getElementById("depart").value;
    const localiteDestinationValue = document.getElementById("arrivee").value;
    const typeTrainValue = document.getElementById("typeTrain").value;
    if (dateValue !== null && dateValue.trim() !== "") {
      http.createHoraire(
        (data) => {
          alert("horaire cree avec succes !");
          this.afficherHoraires();
        },
        dateValue,
        localiteDepartValue,
        localiteDestinationValue,
        typeTrainValue
      );
    }
  }

  //partie pour afficher les horaires
  afficherHoraires() {
    http.getAllHoraires((horaires) => {
      const container = document.getElementById("horaires-container");
      container.innerHTML = "";

      horaires.forEach((horaire) => {
        const dateHoraire = new Date(horaire.dateDepart);
        const formattedDate = dateHoraire.toLocaleDateString("fr-FR", {
          day: "2-digit",
          month: "2-digit",
          year: "numeric",
        });

        // Carte principale
        const card = document.createElement("div");
        card.className = "mb-4";

        // Contenu de la carte
        const cardHTML = `
          <div class="card horaire-card">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title mb-0">${formattedDate}</h5>
            </div>
            <div class="card-body">
              <p class="train-type ${horaire.typeTrain.toLowerCase()}">${
          horaire.typeTrain
        }</p>
              <div class="trajet">
                <p><strong>Départ:</strong> ${horaire.localiteDepart}</p>
                <div class="trajet-arrovéew"><i class="bi bi-arrow-down"></i></div>
                <p><strong>Arri:</strong> ${horaire.localiteDestination}</p>
              </div>
            </div>
          </div>
        `;

        // Injection du HTML
        card.innerHTML = cardHTML;

        // Ajout des boutons si admin
        if (sessionStorage.getItem("isAdmin") === "1") {
          const btnGroup = document.createElement("div");
          btnGroup.className = "btn-group w-100 mt-3";

          // Bouton Modifier
          const btnEdit = document.createElement("button");
          btnEdit.type = "button";
          btnEdit.className = "btn btn-outline-primary";
          btnEdit.innerHTML = `<i class="bi bi-pencil"></i> Modifier`;
          btnEdit.setAttribute("data-bs-toggle", "modal");
          btnEdit.setAttribute("data-bs-target", "#editHoraireModal");
          btnEdit.addEventListener("click", () => {
            //pour l'id
            const selectId = document.getElementById("horaire-id");
            selectId.textContent = horaire.id;

            //pour la date
            const dateDepart = new Date(horaire.dateDepart);
            const formatted = dateDepart.toISOString().split("T")[0];
            document.getElementById("edit-date").value = formatted;

            //pour localite départ
            const selectDepart = document.getElementById("edit-depart");
            for (let option of selectDepart.options) {
              if (option.textContent === horaire.localiteDepart) {
                selectDepart.value = option.value;
                break;
              }
            }

            // pour localite arrivee
            const selectArrivee = document.getElementById("edit-arrivee");
            for (let option of selectArrivee.options) {
              if (option.textContent === horaire.localiteDestination) {
                selectArrivee.value = option.value;
                break;
              }
            }

            // pour type de train
            const selectTypeTrain = document.getElementById("edit-typeTrain");
            for (let option of selectTypeTrain.options) {
              if (option.textContent.split(" ")[0] === horaire.typeTrain) {
                selectTypeTrain.value = option.value;
                break;
              }
            }
          });

          // Bouton Supprimer
          const btnDelete = document.createElement("button");
          btnDelete.type = "button";
          btnDelete.className = "btn btn-outline-danger";
          btnDelete.innerHTML = `<i class="bi bi-trash"></i> Supprimer`;
          btnDelete.addEventListener("click", () =>
            this.supprimerHoraire(horaire.id)
          );

          btnGroup.appendChild(btnEdit);
          btnGroup.appendChild(btnDelete);

          // Ajout dans la carte
          card.querySelector(".card-body").appendChild(btnGroup);
        }

        // Ajout final dans le container
        container.appendChild(card);
      });
    });
  }

  supprimerHoraire(horaireId) {
    http.deleteHoraire((data) => {
      alert("horaire cree avec succes !");
      this.afficherHoraires();
    }, horaireId);
  }

  updateHoraire(event) {
    const IDValue = document.getElementById("horaire-id").textContent;
    const dateValue = document.getElementById("edit-date").value;
    const localiteDepartValue = document.getElementById("edit-depart").value;
    const localiteDestinationValue =
      document.getElementById("edit-arrivee").value;
    const typeTrainValue = document.getElementById("edit-typeTrain").value;
    if (dateValue !== null && dateValue.trim() !== "") {
      http.updateHoraire(
        (data) => {
          alert("horaire update avec succes !");
          this.afficherHoraires();
        },
        IDValue,
        dateValue,
        localiteDepartValue,
        localiteDestinationValue,
        typeTrainValue
      );
    }
  }
}
