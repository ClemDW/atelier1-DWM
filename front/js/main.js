import { API_URL } from "./config.js";
const app = document.getElementById('app');
const links = document.querySelectorAll('nav a');

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
    }
}

window.addEventListener('hashchange', () => {
  const route = location.hash.substring(1) || 'home';
  render(route);
});

render(location.hash.substring(1) || 'home');


function loadTools() {
  const toolsList = document.getElementById("toolsList");
  const apiUrl = `${API_URL}/outils`;

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
  const apiUrl = `${API_URL}/outils/${id}`;

  fetch(apiUrl)
      .then(response => {
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        return response.json();
      })
      .then(tool => {
        detailContainer.innerHTML = `
        <div class="tool-detail-card">
          <img src="${tool.image}" alt="${tool.nom}">
          <h2>${tool.nom}</h2>
          <p><strong>Description:</strong> ${tool.description}</p>
          <p><strong>Catégorie:</strong> ${tool.categorie}</p>
          <p><strong>Prix:</strong> ${tool.prix} €/jour</p>
          <a href="#outils" class="btn">Retour</a>
        </div>
      `;
      })
      .catch(error => {
        console.error("Erreur lors du chargement de l'outil :", error);
        detailContainer.innerHTML = `<p>Impossible de charger les détails de l'outil.</p>`;
      });
}

