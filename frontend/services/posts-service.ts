import { get } from "../client.js";

export interface Post {
  id: number;
  title: string;
  slug: string;
  content: string;
  cover_image: string | null;
  status: "published" | "draft";
  published_at: string | null;
  created_at: string;
  updated_at: string;
}

async function fetchAllPosts(): Promise<{ data: Post[] | null; error: string | null }> {
  return await get<Post[]>("api/posts");
}

export const postsService = {
  fetchAllPosts,
};
