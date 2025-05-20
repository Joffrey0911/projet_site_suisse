const display = document.getElementById('display');
const buttons = document.querySelectorAll('#calc button[data-value]');
const clearBtn = document.getElementById('clear');
const equalBtn = document.getElementById('equal');

let expression = ''; // stocke ce que l'utilisateur tape

let activeSectionId = null; // variable globale pour mémoriser la section active

function showSection(id) {
  if (activeSectionId === id) {
    // Si on reclique sur la même section, on la cache
    document.getElementById(id).classList.add('hidden');
    activeSectionId = null; // aucune section active
  } else {
    // Sinon on cache toutes les sections
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => section.classList.add('hidden'));

    // Puis on affiche la nouvelle section
    const active = document.getElementById(id);
    if (active) {
      active.classList.remove('hidden');
      activeSectionId = id; // mémoriser la section active
    }
  }
}

// Met à jour l'affichage dans l'input
function updateDisplay() {
  display.value = expression;
}

// Clic sur un bouton (chiffre ou opérateur)
buttons.forEach(button => {
  button.addEventListener('click', () => {
    const value = button.getAttribute('data-value');
    expression += value;
    updateDisplay();
  });
});

// Bouton "C" : reset
clearBtn.addEventListener('click', () => {
  expression = '';
  updateDisplay();
});

// Bouton "=" : calcul
equalBtn.addEventListener('click', () => {
  try {
    expression = eval(expression).toString(); // ⚠️ eval à utiliser avec précaution
  } catch (error) {
    expression = 'Erreur';
  }
  updateDisplay();
});

// Touche clavier
document.addEventListener('keydown', (e) => {
  const key = e.key;

  // Chiffres, opérateurs, point
  if (/[\d\+\-\*\/\.]/.test(key)) {
    expression += key;
    updateDisplay();
  }

  // Entrée = calcul
  if (key === 'Enter') {
    try {
      expression = eval(expression).toString();
    } catch {
      expression = 'Erreur';
    }
    updateDisplay();
  }

  // Retour arrière = suppression du dernier caractère
  if (key === 'Backspace') {
    expression = expression.slice(0, -1);
    updateDisplay();
  }

  // Échap = reset
  if (key === 'Escape') {
    expression = '';
    updateDisplay();
  }
});

//JS pour le trajet //




function showSection(sectionId) {
  // Cacher toutes les sections (avec la classe 'section')
  document.querySelectorAll('.section').forEach(section => {
    section.classList.add('hidden');
  });

  // Afficher la section ciblée
  document.getElementById(sectionId).classList.remove('hidden');
}




  const startInput = document.getElementById('start');
  const endInput = document.getElementById('end');
  const resultDiv = document.getElementById('result'); 

  document.getElementById('distanceForm').addEventListener('input', function(e) {
      if (startInput.value.trim().length > 0) {
    startInput.style.border = "2px solid green";
   


  } else {
    startInput.style.border = "2px solid red";
    
  }

  if (endInput.value.trim().length > 0) {
    endInput.style.border = '2px solid green';
  } else {
    endInput.style.border = '2px solid red';
  
  }
});
  
    

  document.getElementById('distanceForm').addEventListener('submit', function(e) {
    e.preventDefault();
     

  

    const start = startInput.value.trim();
    const end = endInput.value.trim();

    let valid = true;
    resultDiv.innerHTML = ''; // Réinitialise le contenu
   
    
  
  
  if (startInput.value.trim().length > 0) {
    startInput.style.border = "2px solid green";
  } else {
    startInput.style.border = "2px solid red";
    valid = false;
  }
  
  
  
   

  
  if (endInput.value.trim().length > 0) {
    endInput.style.border = '2px solid green';
  } else {
    endInput.style.border = '2px solid red';
    valid = false;
  }
  
  

    // Si un champ est vide, afficher une erreur et arrêter
    if (!valid) {
        resultDiv.innerHTML = '<p style="color: red;">Veuillez remplir tous les champs avant de soumettre.</p>';
        setTimeout(() => {
            resultDiv.innerHTML = '';
            startInput.value = '';
            endInput.value = '';
            startInput.style.border = '';
            endInput.style.border = '';
          }, 5000);
          return;
        }


        


  

    resultDiv.innerHTML = '<p>Calcul en cours...</p>';
    
    

    fetch('calculate.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `start=${encodeURIComponent(start)}&end=${encodeURIComponent(end)}`
    })
    .then(response => response.json())
    .then(data => {
      if(data.error){
        document.getElementById('result').innerText = 'Erreur : ' + data.error;
        

   


        
      } else {
        document.getElementById('result').innerHTML = `
          <p>La distance entre <strong>${start}</strong> et <strong>${end}</strong> est de : ${data.distance_text}</p>
          <p>Durée estimée : ${data.duration_text}</p>
        `;
          setTimeout(() => {
            resultDiv.innerHTML = '';
            startInput.value = '';
            endInput.value = '';
            startInput.style.border = '';
            endInput.style.border = '';
          }, 5000);




      }
    })
    .catch(err => {
      document.getElementById('result').innerText = 'Erreur réseau ou serveur';
      setTimeout(() => {
            resultDiv.innerHTML = '';
            startInput.value = '';
            endInput.value = '';
            startInput.style.border = '';
            endInput.style.border = '';
          }, 5000);
    });
  });


  //Jeu des ampoules //

 const ampoules = [
  document.getElementById('amp1'),
  document.getElementById('amp2'),
  document.getElementById('amp3')
];
const btnEssayer = document.getElementById('essayerBtn');
const btnReset = document.getElementById('resetBtn');
const message = document.getElementById('message');
const scoreAffichage = document.getElementById('score');
const essaisContainer = document.getElementById('essais');

let essaisRestants;
let scoreOrdinateur;

function initGame() {
  essaisRestants = 4;
  scoreOrdinateur = [];
  ampoules.forEach(a => {
    a.classList.remove('allumee', 'perdue');
    a.style.color = 'grey';
  });

  essaisContainer.innerHTML = '';
  btnEssayer.disabled = false;
  btnReset.style.display = 'none';
  message.textContent = `Essais restants : ${essaisRestants}`;
  scoreAffichage.textContent = '';
}

btnEssayer.addEventListener('click', () => {
  if (essaisRestants === 0) return;

  const random = Math.floor(Math.random() * 21); // 0 à 20
  scoreOrdinateur.push(random);

  if (random > 10) {
    const index = ampoules.findIndex(a => !a.classList.contains('allumee'));
    if (index !== -1) {
      ampoules[index].classList.add('allumee');
      ampoules[index].style.color = 'gold';
    }
  } else {
    const skull = document.createElement('ion-icon');
    skull.setAttribute('name', 'skull-outline');
    skull.style.fontSize = '2rem';
    skull.style.color = 'red';
    essaisContainer.appendChild(skull);
  }

  essaisRestants--;

  scoreAffichage.textContent = `Score de l'ordinateur : ${scoreOrdinateur.join(', ')}`;

  const toutesAllumees = ampoules.every(a => a.classList.contains('allumee'));

  if (toutesAllumees) {
    message.textContent = '🎉 Bravo, vous avez gagné !';
    btnEssayer.disabled = true;
    btnReset.style.display = 'inline-block';
    return; // ⛔ Interrompt le jeu dès que gagné
  }

  if (essaisRestants === 0 && !toutesAllumees) {
    message.textContent = '💀 Perdu, toutes les ampoules sont grillées.';
    ampoules.forEach(a => {
      a.classList.remove('allumee');
      a.classList.add('perdue');
      a.style.color = 'black'; // toutes les ampoules deviennent noires
    });
    btnEssayer.disabled = true;
    btnReset.style.display = 'inline-block';
  } else {
    message.textContent = `Essais restants : ${essaisRestants}`;
  }
});

btnReset.addEventListener('click', initGame);

// reset automatiquement quand la section s'affiche
function showSection(id) {
  document.querySelectorAll('.section').forEach(sec => {
    sec.classList.add('hidden');
  });
  document.getElementById(id).classList.remove('hidden');

  if (id === 'jeu') {
    initGame();
  }
}
