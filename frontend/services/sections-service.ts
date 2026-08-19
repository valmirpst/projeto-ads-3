import { get } from "../client.js";
import { sectionRenderers } from "../components/sections/SectionRenderer.js";

export interface Section {
  id: number;
  type: keyof typeof sectionRenderers;
  position: number;
  enabled: boolean;
  config: any;
  created_at?: string;
  updated_at?: string;
}

async function fetchSections() {
  const res = await get("api/sections");
  return { ...res, data: res.data as Section[] | null };
}

async function fetchAllSections() {
  const res = await get("api/sections?all=true");
  return { ...res, data: res.data as Section[] | null };
}

export const sectionsService = {
  fetchSections,
  fetchAllSections,
};
