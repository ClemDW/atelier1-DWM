import {Panier} from "./panier.js";
const panier = new Panier();
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
      setupButtons();
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
                <label>Quantité</label>
                <button class="minus">-</button>
                <text class="quantity-input">0</text>
                <button class="plus">+</button>
                <p>Prix par jour: ${tool.prix} €</p>
                <label>Date de début</label>
                <input type="date" class="start-date">
                <label>Date de fin</label>
                <input type="date" class="end-date">
                <button class="add-to-cart">Ajouter au panier</button>
            `;
      toolsList.appendChild(toolCard);
    });
  }
    function setupButtons() {
        document.querySelectorAll('.tool-card').forEach((card, index) => {
            const minusBtn = card.querySelector('.minus');
            const plusBtn = card.querySelector('.plus');
            const addToCartBtn = card.querySelector('.add-to-cart');
            const quantityInput = card.querySelector('.quantity-input');
            const stock = allTools[index].stock;

            minusBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.textContent);
                if (currentValue > 0) {
                    quantityInput.textContent = currentValue - 1;
                }
            });

            plusBtn.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.textContent);
                if (currentValue < stock) {
                    quantityInput.textContent = currentValue + 1;
                }
            });

            addToCartBtn.addEventListener('click', () => {
                const startDate = card.querySelector('.start-date').value;
                const endDate = card.querySelector('.end-date').value;
                const quantity = parseInt(quantityInput.textContent);
                const tool = allTools[index];
                panier.ajouterOutil(tool, startDate, endDate, quantity);
            });

        });
    }
});
