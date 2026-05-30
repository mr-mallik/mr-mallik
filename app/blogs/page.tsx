import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import BlogListClient from "@/app/blogs/blog-list-client";
import type { ArticlesResponse } from "@/app/blogs/types";
import { cmsApi } from "@/services/cms";
import { ApiError } from "@/services/api";

// ─── Data fetching ────────────────────────────────────────────────────────────

type BlogPageSearchParams = {
  tag?: string | string[];
};

type BlogPageProps = {
  searchParams?: Promise<BlogPageSearchParams> | BlogPageSearchParams;
};

async function fetchArticles(page = 1, limit = 10, tag?: string): Promise<{
  articles: ArticlesResponse["data"];
  meta?: ArticlesResponse["meta"];
  error?: string;
}> {
  try {
    const res = await cmsApi.get<ArticlesResponse>("/articles", {
      query: { category: "blog", sort: "latest", page, limit, tag },
      next: { revalidate: 3600 },
    } as Parameters<typeof cmsApi.get>[1] & { next?: { revalidate: number } });
    return { articles: res.data ?? [], meta: res.meta };
  } catch (err) {
    const message =
      err instanceof ApiError
        ? `Failed to load posts (${err.status})`
        : "Something went wrong while loading posts.";
    return { articles: [], error: message };
  }
}

// ─── Page ─────────────────────────────────────────────────────────────────────

export default async function BlogPage({ searchParams }: BlogPageProps) {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const rawTag = Array.isArray(resolvedSearchParams.tag)
    ? resolvedSearchParams.tag[0]
    : resolvedSearchParams.tag;
  const activeTag = rawTag?.trim() ? rawTag.trim() : undefined;

  const { articles, meta, error } = await fetchArticles(1, 10, activeTag);

  return (
    <section className="mx-auto w-full max-w-2xl py-2 sm:py-8">
      <div className="space-y-5 sm:space-y-7">
        <Header
          link={ROUTES.home}
          title={SECTION_TITLES.blog}
          description={PAGE_COPY.blogsPageDescription}
        />

        <BlogListClient
          initialArticles={articles}
          initialMeta={meta}
          initialError={error}
          initialTag={activeTag}
        />
      </div>
    </section>
  );
}
