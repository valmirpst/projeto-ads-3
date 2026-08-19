import { get } from "../client.js";

export interface Section {
  id: number;
  type: string;
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

export const sectionsService = {
  fetchSections,
};
