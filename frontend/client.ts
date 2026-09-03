function buildUrl(path: string): string {
  const meta = document.querySelector<HTMLMetaElement>('meta[name="base-url"]');
  const base = meta?.content.replace(/\/$/, "") ?? "";
  return base + "/" + path.replace(/^\//, "");
}

export async function get<T>(
  path: string,
  options?: RequestInit,
): Promise<{ data: T | null; error: string | null; status: number }> {
  try {
    const response = await fetch(buildUrl(path), options);
    const data = await response.json();

    if (!response.ok) {
      return { data: null, error: data.error || data.message || "Request failed", status: response.status };
    }

    return { data, error: null, status: response.status };
  } catch (error) {
    console.error("Error in GET request:", error);
    return { data: null, error: error instanceof Error ? error.message : "Unknown error", status: 500 };
  }
}

export async function post<T>(
  path: string,
  data: Record<string, unknown>,
): Promise<{ data: T | null; error: string | null; status: number }> {
  try {
    const response = await fetch(buildUrl(path), {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    const responseData = await response.json();
    if (!response.ok) return { data: null, error: responseData.error || "Request failed", status: response.status };
    return { data: responseData, error: null, status: response.status };
  } catch (error) {
    return { data: null, error: error instanceof Error ? error.message : "Unknown error", status: 500 };
  }
}

export async function put(path: string, data: Record<string, unknown>) {
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
