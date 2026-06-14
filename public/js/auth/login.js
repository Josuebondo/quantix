const loginBtn = document.getElementById("loginBtn");
const loginMessage = document.getElementById("loginMessage");
const btnText = document.getElementById("btnText");
const btnLoader = document.getElementById("btnLoader");

loginBtn.addEventListener("click", async (e) => {
  e.preventDefault();

  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();

  if (!email || !password) {
    return showError("Veuillez remplir tous les champs");
  }

  try {
    setLoading(true);

    const data = await Qtix.login(email, password);
    console.log("Login response:", data);
    // return;
    if (data.success) {
      // Qtix.setState("user", data.user || data.data);

      showSuccess("Connexion réussie, redirection...");

      setTimeout(() => {
        window.location.href = data.redirectUrl || "/app";
      }, 400);
    } else {
      showError(data.message || "Identifiants incorrects");
    }
  } catch (err) {
    console.error(err);
    showError("Impossible de contacter le serveur");
  } finally {
    setLoading(false);
  }
});
function setLoading(isLoading) {
  if (isLoading) {
    btnText.style.display = "none";
    btnLoader.style.display = "block";
    loginBtn.disabled = true;
  } else {
    btnText.style.display = "block";
    btnLoader.style.display = "none";
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
