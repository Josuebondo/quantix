let formData = {};

console.log("Script signin.js chargé");
// Sauvegarder les données du formulaire (défensif si l'élément n'existe pas)
const infoFormEl = document.getElementById("info-form");
if (infoFormEl) {
  infoFormEl.addEventListener("change", function (e) {
    const form = infoFormEl;
    const inputs = form.querySelectorAll("input");
    inputs.forEach((input) => {
      if (input.name) {
        formData[input.name] = input.value;
      }
    });
  });
} else {
  // Si script est chargé sur une page sans formulaire, attendre le DOM ready pour éviter erreurs futures
  document.addEventListener("DOMContentLoaded", () => {
    const f = document.getElementById("info-form");
    if (f) {
      f.addEventListener("change", (e) => {
        const inputs = f.querySelectorAll("input");
        inputs.forEach((input) => {
          if (input.name) formData[input.name] = input.value;
        });
      });
    }
  });
}

function successMessage() {
  document.getElementById("mesage").innerHTML = "";
  let html = `
                    <div class="w-32 h-32 bg-primary/10 rounded-full flex items-center justify-center mb-12 ring-1 ring-primary/30 relative">
                        <div class="absolute inset-0 bg-primary/20 rounded-full blur-2xl opacity-50"></div>
                        <span class="material-symbols-outlined text-6xl text-primary relative z-10 font-thin">mail</span>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-6 font-headline-md tracking-tight">votre inscription a été un succès ! </h2>
                  <P class="text-white/70 text-lg font-body-md leading-relaxed mb-12 max-w-lg">
                    <br>
                    Un e-mail d'activation a été envoyé à votre adresse. Cliquez sur le lien pour finaliser la configuration de votre environnement et découvrir l'écosystème <span class="text-primary font-bold">Quantix</span>.
                    </P>
                    <div class="flex flex-col gap-8 w-full items-center">
                        <button id="resend-email" onclick="resendActivationEmail()" class="w-full sm:w-auto bg-primary text-midnight font-bold py-5 px-16 rounded-xl hover:bg-primary/90 active:scale-95 transition-all shadow-xl shadow-primary/20 text-sm tracking-widest uppercase">
                            Renvoyer l'e-mail
                        </button>
                        <a class="text-white/40 hover:text-primary text-xs font-bold tracking-[0.1em] uppercase transition-all border-b border-transparent hover:border-primary pb-1" href="/login">
                            Retour à la connexion
                        </a>    
                  
                        </div>`;

  document.getElementById("mesage").innerHTML = html;
}
function errorMessage(msg, code = null) {
  document.getElementById("mesage").innerHTML = "";
  const formattedMsg = String(msg).replace(/\n/g, "<br />");
  let html = `                    <div class="w-32 h-32 bg-red-600/10 rounded-full flex items-center justify-center mb-12 ring-1 ring-red-600/30 relative">
                        <div class="absolute inset-0 bg-red-600/20 rounded-full blur-2xl opacity-50"></div>
                        <span class="material-symbols-outlined text-6xl text-red-600 relative z-10 font-thin">error</span>
                    </div>
                    <h2 class="text-4xl font-bold text-white mb-6 font-headline-md tracking-tight">Une erreur est survenue</h2>
                  <P class="text-white/70 text-lg font-body-md leading-relaxed mb-12 max-w-lg">
                    <br>
                    ${formattedMsg}
                    </P>
                    <div class="flex flex-col gap-8 w-full items-center">
                        <button onclick="retry()" class="w-full sm:w-auto bg-primary text-midnight font-bold py-5 px-16 rounded-xl hover:bg-primary/90 active:scale-95 transition-all shadow-xl shadow-primary/20 text-sm tracking-widest uppercase">
                            Réessayer
                        </button>
                        <a class="text-white/40 hover:text-primary text-xs font-bold tracking-[0.1em] uppercase transition-all border-b border-transparent hover:border-primary pb-1" href="/login">
                            Retour à la connexion
                        </a>
                        </div>`;

  document.getElementById("mesage").innerHTML = html;
}
function showtoast(message, type = "success") {
  const toast = document.createElement("div");
  toast.className = `toast fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white font-bold shadow-lg transition-opacity duration-300 ${type === "success" ? "bg-green-600" : "bg-red-600"}`;
  toast.textContent = message;
  setTimeout(() => {
    toast.style.opacity = "0";
    setTimeout(() => {
      toast.remove();
    }, 300);
  }, 3000);
  document.body.appendChild(toast);
}

async function resendActivationEmail() {
  const btn = document.getElementById("resend-email");
  btn.textContent = "Envoi en cours...";
  let email = document.getElementById("admin_email").value;
  await sendActivationEmail(email);
  btn.textContent = "Renvoyer l'e-mail";
  console.log("E-mail de réactivation renvoyé à:", email);
}

function goToStep(stepNumber) {
  const contents = document.querySelectorAll(".step-content");
  contents.forEach((s) => {
    s.classList.remove("active");
  });

  setTimeout(() => {
    const target = document.getElementById("step-" + stepNumber);
    target.classList.add("active");
  }, 50);

  const markers = [
    document.getElementById("marker-1"),
    document.getElementById("marker-2"),
    document.getElementById("marker-3"),
  ];
  const icons = [
    document.getElementById("icon-1"),
    document.getElementById("icon-2"),
    document.getElementById("icon-3"),
  ];
  const labels = [
    document.getElementById("label-1"),
    document.getElementById("label-2"),
    document.getElementById("label-3"),
  ];
  const progLine = document.getElementById("progress-line");

  const progress = ((stepNumber - 1) / 2) * 100;
  progLine.style.width = `calc(${progress}% - 2rem)`;
  if (stepNumber === 1) progLine.style.width = "0%";

  markers.forEach((m, i) => {
    m.className =
      "w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 bg-surface-container-highest text-on-surface-variant/40";
    m.style.boxShadow = "none";
    labels[i].className =
      "text-[10px] font-bold uppercase tracking-[0.2em] text-outline font-headline-md opacity-50";
  });
  icons[0].innerHTML = "person";
  icons[1].innerHTML = "business";
  icons[2].innerHTML = "verified";

  for (let i = 0; i < stepNumber; i++) {
    if (i < stepNumber - 1) {
      markers[i].className =
        "w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 bg-primary/20 text-primary";
      icons[i].innerHTML = "done";
      labels[i].className =
        "text-[10px] font-bold uppercase tracking-[0.2em] text-primary font-headline-md";
    } else {
      markers[i].className =
        "w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 bg-primary text-on-primary shadow-[0_0_15px_rgba(19,236,128,0.3)]";
      labels[i].className =
        "text-[10px] font-bold uppercase tracking-[0.2em] text-primary font-headline-md";
    }
  }

  // Si on va à l'étape 3, envoyer les données
  if (stepNumber === 3) {
    // console.log("Aller à l'étape 3");
    loading();
    submitCompanyRegistration();
  }

  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}
function loading() {
  const loadingContainer = document.getElementById("loading");

  loadingContainer.innerHTML = `
    <div class="loader-wrapper">
      <div class="spinner"></div>
      <p class="loader-text">Traitement en cours...</p>
    </div>
  `;
}
const csrfToken = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute("content");
// Soumettre l'enregistrement au backend
async function submitCompanyRegistration() {
  try {
    // Récupérer les données de tous les formulaires
    const forms = document.querySelectorAll(".info-form");

    const data = {};
    forms.forEach((form) => {
      const inputs = form.querySelectorAll("input");
      inputs.forEach((input) => {
        if (input.name) {
          data[input.name] = input.value;
        }
      });
    });
    console.log("Données envoyées:", data);

    // Validation du mot de passe
    if (data.admin_password !== data.admin_password_confirm) {
      errorMessage("Les mots de passe ne correspondent pas");

      await new Promise((r) => setTimeout(r, 2400));

      goToStep(1);
    }

    // Envoyer les données au backend
    const response = await fetch("/api/auth/register-company", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken,
      },
      body: JSON.stringify(data),
    });

    const result = await response.json();
    console.log("Réponse du serveur:", result);

    // return;
    if (!response.ok || !result.success) {
      console.error("Erreurs:", result.message || result.errors);
      let errorMsg = result.message || "Une erreur est survenue";

      if (result.errors && typeof result.errors === "object") {
        const fieldErrors = [];
        Object.values(result.errors).forEach((errorList) => {
          if (Array.isArray(errorList)) {
            fieldErrors.push(...errorList);
          } else if (typeof errorList === "string") {
            fieldErrors.push(errorList);
          }
        });
        if (fieldErrors.length > 0) {
          errorMsg = fieldErrors.join(" \n");
        }
      }

      errorMessage(errorMsg);
      await new Promise((r) => setTimeout(r, 2400));
      //   goToStep(1);
      return;
    }
    // Succès!
    sendActivationEmail(data.admin_email);
    showtoast("Inscription réussie! Redirection en cours...", "success");

    successMessage();

    // Sauvegarder les tokens
    if (result.data && result.data.tokens) {
      localStorage.setItem("access_token", result.data.tokens.access_token);
      localStorage.setItem("refresh_token", result.data.tokens.refresh_token);
    }
  } catch (error) {
    console.error("Erreur lors de l'inscription:", error);

    errorMessage("Impossible de contacter le serveur");
    await new Promise((r) => setTimeout(r, 2400));
    // goToStep(1);
  }
}
function retry() {
  goToStep(1);
}

async function sendActivationEmail(email) {
  const req = await fetch("/company/send-activation", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": csrfToken,
    },
    body: JSON.stringify({
      email: email,
    }),
  });
  const res = await req.json();
  console.log("Réponse de l'e-mail de réactivation:", res);

  if (req.ok) {
    showtoast("E-mail de réactivation envoyé!", "success");
  } else {
    showtoast("Erreur lors de l'envoi de l'e-mail", "error");
  }
}
