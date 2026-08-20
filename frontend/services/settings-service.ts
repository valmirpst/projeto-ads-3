import { get, put } from "../client.js";

export type Settings = {
  id: number;
  site_name: string;
  site_description?: string;
  logo_image?: string;
  favicon_image?: string;
  contact_email?: string;
  phone?: string;
  instagram?: string;
  facebook?: string;
  linkedin?: string;
  created_at: string;
  updated_at: string;
};

async function fetchSettings() {
  const res = await get("api/settings");
  return { ...res, data: res.data as Settings | null };
}

async function updateSettings(data: Partial<Settings>) {
  return put("api/settings", data);
}

export const settingsService = {
  fetchSettings,
  updateSettings,
};
