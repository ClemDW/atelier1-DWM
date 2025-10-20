document.addEventListener("DOMContentLoaded", () => {
  const toolsList = document.getElementById("toolsList");
  const apiUrl = "http://localhost:6080/outils";
  let allTools = [];

  fetch(apiUrl)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then((data) => {
      allTools = data;
      displayTools(allTools);
    })
    .catch((error) => {
      console.error("Error fetching tools:", error);
      toolsList.innerHTML =
        "<p>Impossible de charger les outils. Vérifiez que l'API est bien en cours d'exécution.</p>";
    });

  function displayTools(tools) {
    toolsList.innerHTML = "";
    tools.forEach((tool) => {
      const toolCard = document.createElement("div");
      toolCard.classList.add("tool-card");
      toolCard.innerHTML = `
                <img src="${
                  tool.image || "assets/images/default-tool.svg"
                }" alt="${tool.nom}">
                <h3>${tool.nom}</h3>
                <p>Stock: ${tool.stock}</p>
            `;
      toolsList.appendChild(toolCard);
    });
  }
});
