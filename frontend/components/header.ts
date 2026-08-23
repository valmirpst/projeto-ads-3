import { settingsService } from "../services/settings-service.js";

async function renderSettings() {
  const { data: settings } = await settingsService.fetchSettings();

  const elSiteName = document.getElementById("header_site-name");
  const elSiteLogo = document.getElementById("header_logo-image") as HTMLImageElement;

  if (elSiteName) elSiteName.textContent = settings?.site_name || "Sem Nome";

  if (settings?.logo_path && elSiteLogo) {
    elSiteLogo.src = "/projetos/projeto-ads-3/public/" + settings.logo_path;
  }

  if (settings?.favicon_path) {
    const elFavicon = document.querySelector('link[rel="icon"]');
    elFavicon?.setAttribute("href", "/projetos/projeto-ads-3/public/" + settings.favicon_path);
  }
}

async function main() {
  await renderSettings();
}

document.addEventListener("DOMContentLoaded", async () => {
  await main();
});
