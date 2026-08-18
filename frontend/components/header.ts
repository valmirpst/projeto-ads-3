import { settingsService } from "../services/settings-service.js";

async function renderSettings() {
  const { data: settings } = await settingsService.fetchSettings();

  if (!settings) return;

  const elSiteName = document.getElementById("header_site-name");
  const elSiteLogo = document.getElementById("header_logo-image") as HTMLImageElement;

  if (elSiteName) elSiteName.textContent = settings.site_name || "Sem Nome";
  if (elSiteLogo) elSiteLogo.src = settings.logo_image || "assets/images/no-image.jpg";
}

async function main() {
  await renderSettings();
}

document.addEventListener("DOMContentLoaded", async () => {
  main();
});
