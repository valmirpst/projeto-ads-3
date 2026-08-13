import { post, url } from "../../client.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("login-form") as HTMLFormElement;
  const errorMsg = document.getElementById("error-msg") as HTMLParagraphElement;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const email = (document.getElementById("email") as HTMLInputElement).value;
    const password = (document.getElementById("password") as HTMLInputElement).value;

    errorMsg.style.display = "none";

    const data = await post("api/auth/login", { email, password });

    if (data.ok) {
      window.location.href = url("admin");
    } else {
      errorMsg.textContent = data.error || "Erro ao fazer login";
      errorMsg.style.display = "block";
    }
  });
});
