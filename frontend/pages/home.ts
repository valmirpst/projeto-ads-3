import { settingsService } from "../services/settings-service.js";
import { sectionsService } from "../services/sections-service.js";
import { renderSection } from "../components/sections/SectionRenderer.js";

async function renderSections() {
  const { data: sections } = await sectionsService.fetchSections();
  const container = document.getElementById("sections-container");

  if (!sections || !container) return;

  container.innerHTML = "";

  for (const section of sections) {
    const sectionElement = renderSection(section);
    if (sectionElement) {
      container.appendChild(sectionElement);
    }
  }
}

async function renderSettings() {
  const { data: settings } = await settingsService.fetchSettings();

  if (!settings) return;

  const { site_name, site_description, contact_email, phone, instagram, facebook, linkedin } = settings;

  const elSiteName = document.getElementById("site-name");
  const elSiteDescription = document.getElementById("site-description");
  const elContactEmail = document.getElementById("contact-email");
  const elContactPhone = document.getElementById("contact-phone");

  if (elSiteName) elSiteName.textContent = site_name || "Sem Nome";
  if (elSiteDescription) elSiteDescription.textContent = site_description || "";
  if (elContactEmail) elContactEmail.textContent = contact_email || "-";
  if (elContactPhone) elContactPhone.textContent = phone || "-";

  const elInstagram = document.getElementById("link-instagram") as HTMLAnchorElement;
  if (instagram && instagram) {
    elInstagram.href = instagram;
    elInstagram.style.display = "inline";
  }

  const elFacebook = document.getElementById("link-facebook") as HTMLAnchorElement;
  if (facebook && facebook) {
    elFacebook.href = facebook;
    elFacebook.style.display = "inline";
  }

  const elLinkedin = document.getElementById("link-linkedin") as HTMLAnchorElement;
  if (linkedin && linkedin) {
    elLinkedin.href = linkedin;
    elLinkedin.style.display = "inline";
  }
}

async function main() {
  // Execute calls in parallel
  await Promise.all([renderSections(), renderSettings()]);
}

document.addEventListener("DOMContentLoaded", async () => {
  main();
});
