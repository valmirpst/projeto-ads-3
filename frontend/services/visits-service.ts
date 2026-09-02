import { get, post } from "../client.js";

export interface Visit {
  id: number;
  session_id: string;
  page_url: string;
  created_at: string;
}

async function fetchRecentVisits(): Promise<{ data: Visit[] | null; error: string | null; status: number }> {
  const res = await get("api/analytics");
  return { ...res, data: res.data as Visit[] | null };
}

async function trackVisit(
  sessionId: string,
  pageUrl: string,
): Promise<{ data: Visit | null; error: string | null; status: number }> {
  const res = await post("api/analytics", {
    session_id: sessionId,
    page_url: pageUrl,
  });
  return res;
}

export const visitsService = {
  fetchRecentVisits,
  trackVisit,
};
