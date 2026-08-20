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

async function main() {
  await renderSections();
}

document.addEventListener("DOMContentLoaded", async () => {
  main();
});
