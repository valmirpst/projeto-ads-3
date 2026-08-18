function buildUrl(path: string): string {
  const meta = document.querySelector<HTMLMetaElement>('meta[name="base-url"]');
  const base = meta?.content.replace(/\/$/, "") ?? "";
  return base + "/" + path.replace(/^\//, "");
}

export function url(path = ""): string {
  return buildUrl(path);
}

export async function get(
  path: string,
  options?: RequestInit,
): Promise<{ data: unknown; error: string | null; status: number }> {
  try {
    const response = await fetch(buildUrl(path), options);
    const data = await response.json();
    return { data, error: null, status: response.status };
  } catch (error) {
    console.error("Error in GET request:", error);
    return { data: null, error: error instanceof Error ? error.message : "Unknown error", status: 500 };
  }
}

export async function post(path: string, data: any) {
  const response = await fetch(buildUrl(path), {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  return response.json();
}

export async function put(path: string, data: any) {
  const response = await fetch(buildUrl(path), {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data),
  });
  return response.json();
}

export async function del(path: string) {
  const response = await fetch(buildUrl(path), {
    method: "DELETE",
  });
  return response.json();
}
