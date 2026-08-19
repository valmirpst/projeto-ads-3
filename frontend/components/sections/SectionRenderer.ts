import { renderHeroSection } from "./hero.js";
import { Section } from "../../services/sections-service.js";

type SectionRendererFn = (config: any) => HTMLElement;

type SectionKeys = "hero";

export const sectionRenderers: Record<SectionKeys, SectionRendererFn> = {
  hero: renderHeroSection,
  // adicionar outras seções depois..
};

export function renderSection(section: Section): HTMLElement | null {
  const renderer = sectionRenderers[section.type];

  try {
    const element = renderer(section.config);
    return element;
  } catch (error) {
    console.error(`Error rendering section ${section.type}:`, error);
    return null;
  }
}
