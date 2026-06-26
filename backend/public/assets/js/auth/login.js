const loginBtn = document.getElementById("loginBtn");
const loginMessage = document.getElementById("loginMessage");
const btnText = document.getElementById("btnText");
const btnLoader = document.getElementById("btnLoader");

loginBtn.addEventListener("click", async (e) => {
  e.preventDefault();
  Qtix.iniLoading("loginBtn");
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();

  if (!email || !password) {
    return showError("Veuillez remplir tous les champs");
  }

  try {
    const data = await Qtix.login(email, password);
    console.log("Login response:", data);
    Qtix.startLoading();
    // return;
    if (data.success) {
      // Qtix.setState("user", data.user || data.data);

      showSuccess("Connexion réussie, redirection...");

      await Qtix.delay(2700);
      window.location.href = data.redirectUrl || "/app";
    } else {
      showError(data.message || "Identifiants incorrects");
    }
  } catch (err) {
    console.error(err);
    showError("Impossible de contacter le serveur");
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
