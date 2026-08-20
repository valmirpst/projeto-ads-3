import { settingsService } from "../../services/settings-service.js";

function showAlert(message: string, type: "success" | "danger") {
  const el = document.getElementById("settings-alert") as HTMLDivElement;
  el.className = `alert alert-${type}`;
  el.textContent = message;
  el.classList.remove("d-none");
  setTimeout(() => el.classList.add("d-none"), 4000);
}

document.addEventListener("DOMContentLoaded", async () => {
  const form = document.getElementById("settings-form") as HTMLFormElement;

  // Preenche o formulário com os dados atuais
  const { data, error } = await settingsService.fetchSettings();
  if (error || !data) {
    showAlert("Erro ao carregar as configurações.", "danger");
    return;
  }

  for (const [key, value] of Object.entries(data)) {
    const el = form.elements.namedItem(key) as HTMLInputElement | HTMLTextAreaElement | null;
    if (el) el.value = String(value ?? "");
  }

  // Submissão
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const btn = document.getElementById("settings-submit-btn") as HTMLButtonElement;
    btn.disabled = true;
    btn.textContent = "Saving…";

    const formData = Object.fromEntries(new FormData(form).entries());
    const result = await settingsService.updateSettings(formData);

    btn.disabled = false;
    btn.textContent = "Save Settings";

    if (result && (result as any).error) {
      showAlert((result as any).error, "danger");
    } else {
      showAlert("Settings saved successfully!", "success");
    }
  });
});
