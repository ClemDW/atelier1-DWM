import Panier from "./panier.js";
import { API_URL } from "./config.js";
const app = document.getElementById("app");
const links = document.querySelectorAll("nav a");

function render(route) {
  const [baseRoute, param] = route.split("/");
  let templateId = baseRoute;

  if (baseRoute === "outils" && param) {
    templateId = "outil";
  }

  const template = document.getElementById(templateId);

  if (!template) {
    app.innerHTML = "<h2>404 - Page non trouvée</h2>";
    return;
  }

  app.innerHTML = "";
  app.appendChild(template.content.cloneNode(true));
  links.forEach((link) => {
    link.classList.toggle(
      "active",
      link.getAttribute("href") === `#${baseRoute}`
    );
  });

  if (baseRoute === "outils") {
    if (param) {
      loadToolDetails(param);
    } else {
      loadTools();
    }
  } else if (baseRoute === "panier") {
    const panierList = document.getElementById("panierList");
    displayPanier(panierList);
  } else if (baseRoute === "reservations") {
    loadReservations();
  }
}

window.addEventListener("hashchange", () => {
  const route = location.hash.substring(1) || "home";
  render(route);
});

render(location.hash.substring(1) || "home");

function loadTools() {
  const toolsList = document.getElementById("toolsList");
  const apiUrl = `${API_URL}/outillages`;

  fetch(apiUrl)
    .then((response) => {
      if (!response.ok)
        throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then((data) => displayTools(data, toolsList))
    .catch((error) => {
      console.error("Error fetching tools:", error);
      toolsList.innerHTML =
        "<p>Impossible de charger les outils. Vérifiez que l'API est bien en cours d'exécution.</p>";
    });
}

function displayTools(tools, container) {
  container.innerHTML = "";
  tools.forEach((tool) => {
    const toolCard = document.createElement("div");
    toolCard.classList.add("tool-card");
    toolCard.innerHTML = `
      <a href="#outils/${tool.id}">
        <img src="${tool.image || "assets/images/default-tool.svg"}" alt="${
      tool.nom
    }">
        <h3>${tool.nom}</h3>
        <p>Stock: ${tool.stock}</p>
      </a>
    `;
    container.appendChild(toolCard);
  });
}

function loadToolDetails(id) {
  const detailContainer = document.getElementById("outilDetail");
  const apiUrl = `${API_URL}/outillages/${id}`;
  fetch(apiUrl)
    .then((response) => {
      if (!response.ok)
        throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then((tool) => {
      detailContainer.innerHTML = `
        <div class="tool-detail-card">
          <img src="${tool.image}" alt="${tool.nom_outillage}">
          <h2>${tool.nom_outillage}</h2>
          <p><strong>Description:</strong> ${tool.description}</p>
          <p><strong>Prix:</strong> ${tool.prix} €/jour</p>
          <button class="plus">+</button>
          <text class="quantity">1</text>
          <button class="minus">-</button>
          <input type="date" class="date-debut">
          <input type="date" class="date-fin">
          <button class="ajout-panier">Ajouter au panier</button>
          <a href="#outils" class="btn">Retour</a>
        </div>
      `;
      buttonListenerPanier(tool);
      buttonListener(tool);
    })
    .catch((error) => {
      console.error("Erreur lors du chargement de l'outil :", error);
      detailContainer.innerHTML = `<p>Impossible de charger les détails de l'outil.</p>`;
    });
}

function buttonListener(tool) {
  const ajoutPanier = document.querySelector(".ajout-panier");
  const quantity = document.querySelector(".quantity");
  const dateDebut = document.querySelector(".date-debut");
  const dateFin = document.querySelector(".date-fin");
  const plus = document.querySelector(".plus");
  const minus = document.querySelector(".minus");
  let quantite = parseInt(quantity.textContent);

  ajoutPanier.addEventListener("click", () => {
    const outil = {
      id: tool.id_categorie,
      nom: tool.nom_outillage,
      image: tool.image,
      prix: tool.prix,
    };
    Panier.ajouterOutil(outil, dateDebut.value, dateFin.value, quantite);
  });

  plus.addEventListener("click", () => {
    console.log(quantite);
    if (quantite < tool.stock) {
      quantite = quantite + 1;
      quantity.innerHTML = parseInt(quantity.textContent) + 1;
    }
  });
}

function displayPanier(container) {
  const panierList = document.getElementById("panierList");
  const cookie = getCookie("panier");
  const data = parseCookie(cookie);
  const items = data?.items || null;

  if (items != null) {
  } else {
    panierList.innerHTML = "<h2>Panier vide</h2>";
  }

  items.forEach((item) => {
    const toolCard = document.createElement("div");
    toolCard.classList.add("panier-card");
    toolCard.innerHTML = `
      <div class="item-container">
        <a href="#outils/${item.id}">
          <img class="item-icon" src="${
            item.image || "assets/images/default-tool.svg"
          }" alt="${item.nom}">
          <h2 class="item-name">${item.nom}</h2>
        </a>
        <h3 class="item-price">${item.prix}€/jour</h3>
        <h4 class="item-dates">du ${item.date_debut} au ${item.date_fin}</h4>
        <input type="number" class="item-quantity" value="${
          item.quantite
        }" min="1" max="10">
        <button id="delete" class="btn-action">Supprimer</button>
      </div>
    `;
    toolCard.querySelector(".btn-action").addEventListener("click", () => {
      removeItemFromPanier(item.id);
    });
    container.appendChild(toolCard);
  });
}

function loadReservations() {
  const container = document.getElementById("historiqueList");
  const token = localStorage.getItem("access_token");
  if (!token) {
    container.innerHTML =
      '<p>Vous devez être connecté pour voir votre historique. <a href="#login">Se connecter</a></p>';
    return;
  }

  fetch(`${API_URL}/historique`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  })
    .then((response) => {
      if (response.status === 401) throw new Error("Non authentifié");
      if (!response.ok)
        throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then((data) => renderHistorique(data, container))
    .catch((err) => {
      console.error("Erreur chargement historique:", err);
      container.innerHTML = "<p>Impossible de charger l'historique.</p>";
    });
}

function renderHistorique(items, container) {
  if (!items || items.length === 0) {
    container.innerHTML = "<p>Aucune réservation terminée trouvée.</p>";
    return;
  }
  container.innerHTML = "";
  items.forEach((r) => {
    const card = document.createElement("div");
    card.classList.add("reservation-card");
    card.innerHTML = `
      <h3>Reservation ${r.id}</h3>
      <p><strong>Période:</strong> ${r.date_debut} → ${r.date_fin}</p>
      <p><strong>Prix total:</strong> ${r.prix_total} €</p>
      <p><strong>Statut:</strong> ${r.statut}</p>
      <div><strong>Outils:</strong>
        <ul>
          ${(r.outils || [])
            .map(
              (o) => `<li>Outil ${o.id_outil} (quantité: ${o.quantite})</li>`
            )
            .join("")}
        </ul>
      </div>
    `;
    container.appendChild(card);
  });
}

function removeItemFromPanier(id) {
  const cookie = getCookie("panier");
  const data = parseCookie(cookie);

  if (!data) return;
  data.items = data.items.filter((item) => item.id !== id);

  setCookie("panier", JSON.stringify(data));

  window.location.reload();
}

function setCookie(name, value, days = 7) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${encodeURIComponent(
    value
  )};expires=${expires.toUTCString()};path=/`;
}

function getCookie(name) {
  const cookies = document.cookie.split(";");
  for (let cookie of cookies) {
    const [key, value] = cookie.trim().split("=");
    if (key === name) return decodeURIComponent(value);
  }
  return null;
}

function parseCookie(cookieValue) {
  if (!cookieValue) return null;
  try {
    return JSON.parse(cookieValue);
  } catch (e) {
    console.error("Erreur lors du parsing du cookie :", e);
    return null;
  }
}

function loadLoginPage() {
  const loginContainer = document.getElementById("loginContainer");
  if (!loginContainer) {
    console.log("Erreur dans le chargement de la balise HTML");
  }

  loginContainer.innerHTML = `
      <section id="page-login" class="page-login">
        <h2>Connexion</h2>
        <form id="loginForm" class="login-form">
          <label for="email">Email :</label>
          <input type="email" id="email" name="email" required>
    
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" required>
    
          <button type="submit" class="btn">Se connecter</button>
        </form>
    
        <p id="loginMessage" class="login-message"></p>
      </section>
    `;
}
