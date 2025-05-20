<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="style.css" />
  <script type="module" src="https://unpkg.com/ionicons@7.2.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.2.2/dist/ionicons/ionicons.js"></script>
  <title>Mon site suisse</title>
</head>
<body>
  <header class="container_header d-flex justify-content-center align-items-center">
    <h1 class="d-flex justify-content-center align-items-center">Mon site suisse</h1>
  </header>

  <main>
    <!-- Section menu -->
    <section>
      <div class="container-icons d-flex justify-content-around align-items-center gap-2 my-5" id="btn_calculate">
        <ion-icon name="calculator-outline" class="menu" onclick='showSection("calc")' id="btn_calcul"></ion-icon>
        <ion-icon name="navigate-circle-outline" class="menu" onclick='showSection("trajet")' id="btn_map"></ion-icon>
        <ion-icon name="game-controller-outline" class="menu" onclick='showSection("jeu")' id="btn_game"></ion-icon>
      </div>
    </section>

      <!-- Section calculatrice -->
      <div id="calc" class="section hidden">
        <div class="calculator">
          <input type="text" id="display" disabled />
          <div class="buttons">
            <button data-value="7">7</button>
            <button data-value="8">8</button>
            <button data-value="9">9</button>
            <button data-value="/">÷</button>

            <button data-value="4">4</button>
            <button data-value="5">5</button>
            <button data-value="6">6</button>
            <button data-value="*">x</button>

            <button data-value="1">1</button>
            <button data-value="2">2</button>
            <button data-value="3">3</button>
            <button data-value="-">-</button>

            <button data-value="0">0</button>
            <button data-value=".">.</button>
            <button id="clear">C</button>
            <button data-value="+">+</button>

            <button id="equal" style="width: 100%;">=</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Section trajet -->
    <section>
      <div id="trajet" class="section hidden">
        <div id="formContainer" class="d-flex justify-content-center w-100">
          <form id="distanceForm" class="w-100">
            <div class="mb-3">
              <label for="start" class="form-label">Lieu de départ :</label>
              <input type="text" class="form-control" id="start" aria-describedby="startcity" />
            </div>
            <div class="mb-3">
              <label for="end" class="form-label">Lieu d'arrivée :</label>
              <input type="text" class="form-control" id="end" />
            </div>
            <button type="submit" class="btn btn-primary">Calculer distance et temps</button>
          </form>
          <div id="result" style="margin-top:15px;"></div>
        </div>
      </div>
    </section>

    <!-- Section jeu -->
    <section>
      <div id="jeu" class="section hidden">
        <div class="jeu-wrapper">
          <div class="game-container">
            <div class="col-12 col-lg-6 text-center">
              <ion-icon name="bulb-outline" class="ampoule" id="amp1"></ion-icon>
              <ion-icon name="bulb-outline" class="ampoule" id="amp2"></ion-icon>
              <ion-icon name="bulb-outline" class="ampoule" id="amp3"></ion-icon>
            </div>
            <div id="essais"></div>
            <p id="message"></p>
            <p id="score"></p>
            <button id="essayerBtn">Essayer</button>
            <button id="resetBtn" style="display:none;">Rejouer</button>
          </div>

          <div class="regle-container">
            <p>
              <strong>Jeu des ampoules !</strong><br /><br />
              La règle du jeu est simple :<br /><br />
              Cliquez sur "Essayer" et l'ordinateur obtient aléatoirement un nombre entre 1 et 20.
              Si le nombre est supérieur à 10, une ampoule s'allume. Sinon elle reste éteinte.
              Vous avez 4 essais avant de rester dans le noir définitivement&nbsp;!
            </p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Scripts -->
  <script src="script.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
    crossorigin="anonymous"
  ></script>
</body>
</html>
