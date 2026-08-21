const API_URL = "/projetos/projeto-ads-3/public/api/upload";

export type Media = {
  id: number;
  file_name: string;
  file_path: string;
  file_type: string;
  created_at: string;
  updated_at: string;
};

async function uploadFile(file: File): Promise<{ media_id?: number; path?: string; url?: string; error?: string }> {
  const formData = new FormData();
  formData.append("file", file);

  try {
    const response = await fetch(API_URL, {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      return { error: "Failed to upload file." };
    }

    return await response.json();
  } catch (err: any) {
    return { error: err.message };
  }
}

export const mediaService = {
  uploadFile,
};
