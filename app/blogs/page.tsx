import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import BlogListClient from "@/app/blogs/blog-list-client";
import { getArticlesList } from "@/services/articles";

// ─── Data fetching ────────────────────────────────────────────────────────────

type BlogPageSearchParams = {
  tag?: string | string[];
};

type BlogPageProps = {
  searchParams?: Promise<BlogPageSearchParams> | BlogPageSearchParams;
};

// ─── Page ─────────────────────────────────────────────────────────────────────

export default async function BlogPage({ searchParams }: BlogPageProps) {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const rawTag = Array.isArray(resolvedSearchParams.tag)
    ? resolvedSearchParams.tag[0]
    : resolvedSearchParams.tag;
  const activeTag = rawTag?.trim() ? rawTag.trim() : undefined;

  const { articles, meta, error } = await getArticlesList({
    category: "blog",
    page: 1,
    limit: 10,
    tag: activeTag,
  });

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
