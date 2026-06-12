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

    const data = await Qtix.post("/auth/login", {
      email,
      password,
    });

    if (data.success) {
      Qtix.setState("user", data.user || data.data);

      showSuccess("Connexion réussie, redirection...");

      setTimeout(() => {
        Qtix.navigate(data.redirect_url || "/dashboard");
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
