import Panier from './panier.js';
import { API_URL } from "./config.js";

const app = document.getElementById('app');
const links = document.querySelectorAll('nav a');

// Gestion de l'état utilisateur
class Auth {
  static getUser() {
    const userStr = localStorage.getItem('user');
    return userStr ? JSON.parse(userStr) : null;
  }

  static setUser(user) {
    localStorage.setItem('user', JSON.stringify(user));
    updateAuthSection();
  }

  static getToken() {
    return localStorage.getItem('access_token');
  }

  static setTokens(accessToken, refreshToken) {
    localStorage.setItem('access_token', accessToken);
    localStorage.setItem('refresh_token', refreshToken);
  }

  static logout() {
    localStorage.removeItem('user');
    localStorage.removeItem('access_token');
    localStorage.removeItem('refresh_token');
    updateAuthSection();
    window.location.hash = '#home';
  }

  static isAuthenticated() {
    return !!this.getToken();
  }
}

// Mise à jour de la section auth dans le header
function updateAuthSection() {
  const authSection = document.getElementById('auth-section');
  const user = Auth.getUser();
  
  if (user) {
    authSection.innerHTML = `
      <div style="display: flex; align-items: center; gap: 15px;">
        <span style="color: #ff7214; font-weight: bold;">
          ${user.prenom} ${user.nom}
        </span>
        <button id="logout-btn" class="login-btn">Déconnexion</button>
      </div>
    `;
    
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', (e) => {
        e.preventDefault();
        Auth.logout();
      });
    }
  } else {
    authSection.innerHTML = `
      <a href="#login" class="login-btn">Connexion</a>
    `;
  }
}

function render(route) {
  const [baseRoute, param] = route.split('/');
  let templateId = baseRoute;

  if (baseRoute === 'outils' && param) {
    templateId = 'outil';
  }

  const template = document.getElementById(templateId);

  if (!template) {
    app.innerHTML = '<h2>404 - Page non trouvée</h2>';
    return;
  }

  app.innerHTML = '';
  app.appendChild(template.content.cloneNode(true));
  
  links.forEach(link => {
    link.classList.toggle('active', link.getAttribute('href') === `#${baseRoute}`);
  });

  if (baseRoute === 'outils') {
    if (param) {
      loadToolDetails(param);
    } else {
      loadTools();
    }
  } else if (baseRoute === 'panier') {
    const panierList = document.getElementById("panierList");
    displayPanier(panierList);
  } else if (baseRoute === 'login') {
    setupLoginPage();
  }
}

window.addEventListener('hashchange', () => {
  const route = location.hash.substring(1) || 'home';
  render(route);
});

// Initialisation
updateAuthSection();
render(location.hash.substring(1) || 'home');

function loadTools() {
  const toolsList = document.getElementById("toolsList");
  const apiUrl = `${API_URL}/outillages`;

  fetch(apiUrl)
    .then((response) => {
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then((data) => displayTools(data, toolsList))
    .catch((error) => {
      console.error("Error fetching tools:", error);
      toolsList.innerHTML = "<p>Impossible de charger les outils. Vérifiez que l'API est bien en cours d'exécution.</p>";
    });
}

function displayTools(tools, container) {
  container.innerHTML = "";
  tools.forEach((tool) => {
    const toolCard = document.createElement("div");
    toolCard.classList.add("tool-card");
    toolCard.innerHTML = `
      <a href="#outils/${tool.id}">
        <img src="${tool.image || "assets/images/default-tool.svg"}" alt="${tool.nom}">
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
    .then(response => {
      if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
      return response.json();
    })
    .then(tool => {
      detailContainer.innerHTML = `
        <div class="tool-detail-card">
          <img src="${tool.image}" alt="${tool.nom_outillage}">
          <h2>${tool.nom_outillage}</h2>
          <p><strong>Description:</strong> ${tool.description}</p>
          <p><strong>Prix:</strong> ${tool.prix} €/jour</p>
          <div id="gestionQuantite">
              <button class="minus">-</button>
              <text class="quantity">1</text>
              <button class="plus">+</button>
          </div>
          <input type="date" class="date-debut">
          <input type="date" class="date-fin">
          <button class="ajout-panier">Ajouter au panier</button>
          <a href="#outils" class="btn">Retour</a>
        </div>
      `;
      buttonListenerPanier(tool);
    })
    .catch(error => {
      console.error("Erreur lors du chargement de l'outil :", error);
      detailContainer.innerHTML = `<p>Impossible de charger les détails de l'outil.</p>`;
    });
}

function buttonListenerPanier(tool) {
  const ajoutPanier = document.querySelector('.ajout-panier');
  const quantity = document.querySelector('.quantity');
  const dateDebut = document.querySelector('.date-debut');
  const dateFin = document.querySelector('.date-fin');
  const plus = document.querySelector('.plus');
  const minus = document.querySelector('.minus');
  let quantite = parseInt(quantity.textContent);

  ajoutPanier.addEventListener('click', () => {
    const outil = {
      id: tool.id_outillage,
      nom: tool.nom_outillage,
      image: tool.image,
      prix: tool.prix,
    };
    Panier.ajouterOutil(outil, dateDebut.value, dateFin.value, quantite);
  });

  plus.addEventListener('click', () => {
    if (quantite < 10) {
      quantite = quantite + 1;
      quantity.textContent = quantite;
    }
  });

  minus.addEventListener('click', () => {
    if (quantite > 1) {
      quantite = quantite - 1;
      quantity.textContent = quantite;
    }
  });
}


function displayPanier(container) {
  const panierList = document.getElementById("panierList");
  const cookie = getCookie('panier');
  const data = parseCookie(cookie);
  const items = data.items;
  let sum = 0;

  if (!items || items.length === 0) {
    panierList.innerHTML = "<h2>Panier vide</h2>";
    return;
  }

  items.forEach((item) => {
    sum += item.prix*item.quantite;
    const toolCard = document.createElement("div");
    toolCard.classList.add("panier-card");
    toolCard.innerHTML = `
      <div class="item-container">
        <a href="#outils/${item.id}">
          <img class="item-icon" src="${item.image || "assets/images/default-tool.svg"}" alt="${item.nom}">
          <h2 class="item-name">${item.nom}</h2>
        </a>
        <h3 class="item-price">${item.prix}€/jour</h3>
        <h4 class="item-dates">du ${item.date_debut} au ${item.date_fin}</h4>
        <input type="number" class="item-quantity" value="${item.quantite}" min="1" max="10">
        <button id="delete" class="btn-action">Supprimer</button>
      </div>
    `;
    toolCard.querySelector('.btn-action').addEventListener('click', () => {
      removeItemFromPanier(item.date_fin);
    });
    container.appendChild(toolCard);
  });

  const subtotal = document.getElementById('subtotal');
  subtotal.innerHTML = `
    <h2>Sous total: ${sum}€</h2>
    <button id="validate" class="btn-validate">Valider le panier</button>
  `;

}

function removeItemFromPanier(date) {
  const cookie = getCookie('panier');
  if (!cookie) return;

  let data;
  try {
    data = JSON.parse(cookie);
  } catch (e) {
    console.error("Erreur parsing cookie panier :", e);
    return;
  }

  data.items = data.items.filter(item => item.date_fin !== date);
  setCookie('panier', JSON.stringify(data));
  window.location.reload();
}

function setCookie(name, value, days = 7) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${encodeURIComponent(value)};expires=${expires.toUTCString()};path=/`;
}

function getCookie(name) {
  const cookies = document.cookie.split(';');
  for (let cookie of cookies) {
    const [key, value] = cookie.trim().split('=');
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

function setupLoginPage() {
  const loginForm = document.getElementById('loginForm');
  const registerFormElement = document.getElementById('registerFormElement');
  const showRegister = document.getElementById('showRegister');
  const showLogin = document.getElementById('showLogin');
  const registerFormDiv = document.getElementById('registerForm');
  const messageDiv = document.getElementById('message');

  // Si l'utilisateur est déjà connecté
  if (Auth.isAuthenticated()) {
    const pageLogin = document.querySelector('.page-login');
    pageLogin.innerHTML = `
      <h2>Vous êtes déjà connecté</h2>
      <p style="text-align: center; margin: 2rem 0;">
        Bienvenue ${Auth.getUser().prenom} ${Auth.getUser().nom} !
      </p>
      <button id="goHome" class="btn" style="display: block; margin: 0 auto; background-color: #ff7214; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
        Retour à l'accueil
      </button>
    `;
    document.getElementById('goHome').addEventListener('click', () => {
      window.location.hash = '#home';
    });
    return;
  }

  // Basculer vers le formulaire d'inscription
  showRegister.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.parentElement.querySelector('h2').textContent = 'Inscription';
    loginForm.style.display = 'none';
    loginForm.parentElement.querySelector('p').style.display = 'none';
    registerFormDiv.style.display = 'block';
    messageDiv.textContent = '';
  });

  // Basculer vers le formulaire de connexion
  showLogin.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.parentElement.querySelector('h2').textContent = 'Connexion';
    loginForm.style.display = 'block';
    loginForm.parentElement.querySelector('p').style.display = 'block';
    registerFormDiv.style.display = 'none';
    messageDiv.textContent = '';
  });

  // Gestion de la connexion
  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    try {
      const response = await fetch(`${API_URL}/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, password })
      });

      const data = await response.json();

      if (response.ok) {
        // Sauvegarder l'utilisateur et les tokens
        Auth.setUser(data.user);
        Auth.setTokens(data.access_token, data.refresh_token);
        
        messageDiv.style.color = '#28a745';
        messageDiv.textContent = 'Connexion réussie ! Redirection...';
        
        setTimeout(() => {
          window.location.hash = '#home';
        }, 1000);
      } else {
        messageDiv.style.color = '#dc3545';
        messageDiv.textContent = 'Email ou mot de passe incorrect';
      }
    } catch (error) {
      console.error('Erreur de connexion:', error);
      messageDiv.style.color = '#dc3545';
      messageDiv.textContent = 'Erreur de connexion. Veuillez réessayer.';
    }
  });

  // Gestion de l'inscription
  registerFormElement.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const nom = document.getElementById('registerNom').value;
    const prenom = document.getElementById('registerPrenom').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;

    try {
      const response = await fetch(`${API_URL}/users`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ nom, prenom, email, password })
      });

      if (response.ok || response.status === 201) {
        messageDiv.style.color = '#28a745';
        messageDiv.textContent = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
        
        // Réinitialiser le formulaire
        registerFormElement.reset();
        
        // Basculer vers le formulaire de connexion après 2 secondes
        setTimeout(() => {
          showLogin.click();
        }, 2000);
      } else {
        const data = await response.json();
        messageDiv.style.color = '#dc3545';
        messageDiv.textContent = data.message || 'Erreur lors de l\'inscription';
      }
    } catch (error) {
      console.error('Erreur d\'inscription:', error);
      messageDiv.style.color = '#dc3545';
      messageDiv.textContent = 'Erreur lors de l\'inscription. Veuillez réessayer.';
    }
  });
}
