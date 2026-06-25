const loginBtn = document.getElementById("loginBtn");
const loginMessage = document.getElementById("loginMessage");
const btnText = document.getElementById("btnText");
// const btnLoader = document.getElementById("btnLoader");

loginBtn.addEventListener("click", async (e) => {
  e.preventDefault();
  Qtix.iniLoading("btnLoader");

  //   loginBtn.disabled = true;
  const comfirm = document.getElementById("comfirm-password").value.trim();
  const password = document.getElementById("password").value.trim();
  const token = document.getElementById("token").value.trim();
  //   console.log(password, comfirm);
  //   return;
  if (!comfirm || !password) {
    Qtix.stopLoading();
    return showError("Veuillez remplir tous les champs");
  }
  //   if (comfirm !== password) {
  //     return showError(
  //       "le mot de passe n'est pas idantique avec la comfirmations",
  //     );
  //   }

  try {
    const data = await Qtix.post("/accept-invitation", {
      password: password,
      comfirm: comfirm,
      token: token,
    });
    // console.log("Login response:", data);
    Qtix.startLoading();
    btnText.innerText = "Initialisation...";
    // return;
    if (data.success === true) {
      // Qtix.setState("user", data.user || data.data);
      showSuccess("Initialisation réussie, auto connexion...");
      btnText.innerText = "Connexion...";
      //   showSuccess("Connexion réussie, redirection...");
      const login = await Qtix.login(data.email, password);
      if (login.success) {
        // Qtix.setState("user", data.user || data.data);

        showSuccess("Connexion réussie, redirection...");

        await Qtix.delay(2700);
        btnText.innerText = "Se connecter";
        window.location.href = login.redirectUrl || "/app";
      } else {
        Qtix.stopLoading();
        showError(login.message || "Erreur d'auto connexion");
      }
    } else {
      Qtix.stopLoading();
      showError(data.message || "erreur d'initialisation");
    }
  } catch (err) {
    console.error(err);
    showError("Impossible de contacter le serveur");
    Qtix.stopLoading();
  } finally {
    Qtix.stopLoading();
  }
});
function setLoading(isLoading) {
  if (isLoading) {
    btnText.innerText = "Connexion...";
    btnLoader.innerText = "autorenew";
    btnLoader.classList.add("spin");
    loginBtn.disabled = true;
  } else {
    btnText.innerText = "Se connecter";
    btnLoader.innerText = "login";
    btnLoader.classList.remove("spin");

    loginBtn.disabled = false;
  }
}

function showError(message) {
  loginMessage.textContent = message;
  loginMessage.classList.remove("text-green-500");
  loginMessage.classList.add("text-red-500");
}

function showSuccess(message) {
  loginMessage.textContent = message;
  loginMessage.classList.remove("text-red-500");
  loginMessage.classList.add("text-green-500");
}
