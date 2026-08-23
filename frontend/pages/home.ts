import { sectionsService } from "../services/sections-service.js";
import { visitsService } from "../services/visits-service.js";
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

async function main() {
  await renderSections();
}

document.addEventListener("DOMContentLoaded", async () => {
  main();

  setTimeout(async () => {
    try {
      let sessionId = sessionStorage.getItem("cms_session");
      if (!sessionId) {
        sessionId = "sess_" + Date.now() + Math.random().toString(36).substr(2, 9);
        sessionStorage.setItem("cms_session", sessionId);
      }

      await visitsService.trackVisit(sessionId, window.location.pathname);
    } catch (e) {
      console.error("Erro ao registrar analytics:", e);
    }
  }, 1000);
});
