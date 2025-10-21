const app = document.getElementById('app');
const links = document.querySelectorAll('nav a');

function render(route) {
  const template = document.getElementById(route);
  if (template) {
    app.innerHTML = '';
    app.appendChild(template.content.cloneNode(true));
    links.forEach(link => {
      link.classList.toggle('active', link.getAttribute('href') === `#${route}`);
    });

    if (route === 'outils') {
      loadTools();
    }

  } else {
    app.innerHTML = '<h2>404 - Page non trouvée</h2>';
  }
}

window.addEventListener('hashchange', () => {
  const route = location.hash.substring(1) || 'home';
  render(route);
});

render(location.hash.substring(1) || 'home');


function loadTools() {
  const toolsList = document.getElementById("toolsList");
  const apiUrl = "http://localhost:6080/outils";

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
      <img src="${tool.image || "assets/images/default-tool.svg"}" alt="${tool.nom}">
      <h3>${tool.nom}</h3>
      <p>Stock: ${tool.stock}</p>
    `;
    container.appendChild(toolCard);
  });
}
