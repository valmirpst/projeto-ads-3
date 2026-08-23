import { settingsService } from "../../services/settings-service.js";
import { mediaService } from "../../services/media-service.js";

function showAlert(message: string, type: "success" | "danger") {
  const el = document.getElementById("settings-alert") as HTMLDivElement;
  el.className = `alert alert-${type}`;
  el.textContent = message;
  el.classList.remove("d-none");
  setTimeout(() => el.classList.add("d-none"), 4000);
}

document.addEventListener("DOMContentLoaded", async () => {
  const form = document.getElementById("settings-form") as HTMLFormElement;

  const { data, error } = await settingsService.fetchSettings();
  if (error || !data) {
    showAlert(error || "Erro ao carregar as configurações.", "danger");
    return;
  }

  for (const [key, value] of Object.entries(data)) {
    const el = form.elements.namedItem(key) as HTMLInputElement | HTMLTextAreaElement | null;
    if (el && el.type !== "file") el.value = String(value ?? "");
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const btn = document.getElementById("settings-submit-btn") as HTMLButtonElement;
    btn.disabled = true;
    btn.textContent = "Saving…";

    const logoInput = document.getElementById("logo_image") as HTMLInputElement;
    const faviconInput = document.getElementById("favicon_image") as HTMLInputElement;

    // Logo
    if (logoInput.files && logoInput.files.length > 0) {
      const res = await mediaService.uploadFile(logoInput.files[0]);
      if (res.media_id) {
        (document.getElementById("logo_media_id") as HTMLInputElement).value = String(res.media_id);
      }
    }

    // Favicon
    if (faviconInput.files && faviconInput.files.length > 0) {
      const res = await mediaService.uploadFile(faviconInput.files[0]);
      if (res.media_id) {
        (document.getElementById("favicon_media_id") as HTMLInputElement).value = String(res.media_id);
      }
    }

    const formData = Object.fromEntries(new FormData(form).entries());
    // Remover campos de file, deixar apenas os campos que vão pro JSON final
    delete formData[""];

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
