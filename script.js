document.addEventListener("DOMContentLoaded", function () {
  // Code exécuté lorsque le DOM est complètement chargé

  // ======= Mode sombre =======
  const toggleButton = document.getElementById("mode-toggle"); // Bouton pour activer/désactiver le mode sombre
  const isDark = localStorage.getItem("theme") === "dark"; // Récupération du thème sauvegardé dans le localStorage

  if (isDark) {
    // Si le thème enregistré est sombre, on applique la classe correspondante au body
    document.body.classList.add("dark-mode");
    toggleButton.textContent = "Light mode"; // Met à jour le texte du bouton
  }

  // Écouteur sur le bouton mode sombre
  toggleButton.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode"); // Active/désactive la classe dark-mode
    const isDarkMode = document.body.classList.contains("dark-mode");
    toggleButton.textContent = isDarkMode ? "Light mode" : "Dark mode"; // Change le texte selon le mode
    localStorage.setItem("theme", isDarkMode ? "dark" : "light"); // Sauvegarde la préférence dans localStorage
  });

  // ======= Navigation latérale =======
  const sidenav = document.getElementById("mySidenav"); // Menu latéral
  const openBtn = document.getElementById("openBtn"); // Bouton pour ouvrir le menu
  const closeBtn = document.getElementById("closeBtn"); // Bouton pour fermer le menu
  let menuOpen = false; // État du menu (ouvert ou fermé)

  // Vérification que tous les éléments sont présents dans le DOM
  if (openBtn && closeBtn && sidenav) {
    openBtn.onclick = openNav; // Assigne la fonction openNav au clic sur openBtn
    closeBtn.onclick = closeNav; // Assigne la fonction closeNav au clic sur closeBtn
  }

  // Fonction pour ouvrir le menu latéral
  function openNav() {
    sidenav.classList.add("active"); // Ajoute la classe active au menu (visible)
    openBtn.classList.add("rotate"); // Animation de rotation sur le bouton open
    setTimeout(() => {
      openBtn.style.display = "none"; // Cache le bouton open après 600ms (fin animation)
      openBtn.classList.remove("rotate");
    }, 600);
    closeBtn.style.display = "block"; // Affiche le bouton close
    closeBtn.classList.add("rotate"); // Animation de rotation sur le bouton close
    setTimeout(() => {
      closeBtn.classList.remove("rotate"); // Supprime l’animation après 600ms
    }, 600);
    menuOpen = true; // Met à jour l’état du menu à ouvert
  }

  // Fonction pour fermer le menu latéral
  function closeNav() {
    sidenav.classList.remove("active"); // Retire la classe active (cache le menu)
    closeBtn.classList.add("rotate"); // Animation de rotation sur le bouton close
    setTimeout(() => {
      closeBtn.style.display = "none"; // Cache le bouton close après 600ms
      closeBtn.classList.remove("rotate");
    }, 600);
    openBtn.style.display = "block"; // Affiche le bouton open
    openBtn.classList.add("rotate"); // Animation de rotation sur le bouton open
    setTimeout(() => {
      openBtn.classList.remove("rotate"); // Supprime l’animation après 600ms
    }, 600);
    menuOpen = false; // Met à jour l’état du menu à fermé
  }

  // Fonction pour gérer l’affichage des boutons selon la taille de l’écran
  function toggleItemDisplay() {
    if (window.innerWidth < 768 && menuOpen) {
      closeBtn.style.display = "block"; // Si petit écran et menu ouvert, affiche le bouton close
    } else {
      closeBtn.style.display = "none"; // Sinon, cache le bouton close
    }
  }

  toggleItemDisplay(); // Appel initial à l’ouverture de la page
  window.addEventListener("resize", toggleItemDisplay); // Mise à jour lors du redimensionnement

  // ======= Carrousel =======
  const carousels = document.querySelectorAll(".slideshow-container"); // Tous les carrousels sur la page

  // Pour chaque carrousel on initialise le fonctionnement
  carousels.forEach((carousel) => {
    let slideIndex = 0; // Index de la slide affichée
    const slides = carousel.querySelectorAll(".slides"); // Toutes les diapositives
    const dots = carousel.nextElementSibling.querySelectorAll(".dot"); // Points indicateurs
    const prev = carousel.querySelector(".prev"); // Bouton précédent
    const next = carousel.querySelector(".next"); // Bouton suivant

    // Fonction pour afficher la slide n
    function showSlides(n) {
      if (n >= slides.length) slideIndex = 0; // Si dépassement, revient à la première slide
      if (n < 0) slideIndex = slides.length - 1; // Si négatif, va à la dernière slide

      slides.forEach((slide) => (slide.style.display = "none")); // Cache toutes les slides
      dots.forEach((dot) => dot.classList.remove("active")); // Désactive tous les dots

      slides[slideIndex].style.display = "block"; // Affiche la slide courante
      dots[slideIndex].classList.add("active"); // Active le dot correspondant
    }

    showSlides(slideIndex); // Affiche la première slide au chargement

    // Gestion des clics sur boutons précédent et suivant
    if (prev) {
      prev.addEventListener("click", () => showSlides(--slideIndex));
    }
    if (next) {
      next.addEventListener("click", () => showSlides(++slideIndex));
    }

    // Gestion des clics sur les points indicateurs
    dots.forEach((dot, dotIndex) => {
      dot.addEventListener("click", () => {
        slideIndex = dotIndex;
        showSlides(slideIndex);
      });
    });
  });
});
