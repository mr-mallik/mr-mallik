import type { Metadata } from "next";

import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import BlogListClient from "@/app/blogs/blog-list-client";
import { getArticlesList } from "@/services/articles";
import { buildCollectionPageJsonLd, createPageMetadata, sanitizeJsonLd } from "@/app/seo";

// ─── Data fetching ────────────────────────────────────────────────────────────

type BlogPageSearchParams = {
  tag?: string | string[];
  category?: string | string[];
};

type BlogPageProps = {
  searchParams?: Promise<BlogPageSearchParams> | BlogPageSearchParams;
};

function firstParam(value?: string | string[]): string | undefined {
  const raw = Array.isArray(value) ? value[0] : value;
  return raw?.trim() ? raw.trim() : undefined;
}

export async function generateMetadata({ searchParams }: BlogPageProps): Promise<Metadata> {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const activeTag = firstParam(resolvedSearchParams.tag);
  const activeCategory = firstParam(resolvedSearchParams.category);
  const activeFilter = activeTag ?? activeCategory;

  return createPageMetadata({
    title: activeTag
      ? `Blogs tagged ${activeTag}`
      : activeCategory
        ? `Blogs in ${activeCategory}`
        : "Blogs",
    description: activeFilter
      ? `Posts about ${activeFilter} from Gulger Mallik's blog on software engineering, applied AI, and research.`
      : PAGE_COPY.blogsPageDescription,
    path: ROUTES.blogs,
    keywords: activeFilter ? [activeFilter] : ["blogs", "software engineering blog", "applied AI", "research notes"],
    noIndex: Boolean(activeFilter),
  });
}

// ─── Page ─────────────────────────────────────────────────────────────────────

export default async function BlogPage({ searchParams }: BlogPageProps) {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const activeTag = firstParam(resolvedSearchParams.tag);
  const activeCategory = firstParam(resolvedSearchParams.category);

  const { articles, meta, error } = await getArticlesList({
    type: "blog",
    page: 1,
    limit: 10,
    tag: activeTag,
    category: activeCategory,
  });

  return (
    <section className="w-full ui-container ui-container-narrow py-4 sm:py-8 lg:py-12">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildCollectionPageJsonLd({
              title: "Blogs",
              description: PAGE_COPY.blogsPageDescription,
              path: ROUTES.blogs,
              items: articles.map((article) => ({
                name: article.title,
                path: `/blogs/${article.slug}`,
                description: article.excerpt,
                image: article.featuredImage,
              })),
            }),
          ),
        }}
      />
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
          initialCategory={activeCategory}
        />
      </div>
    </section>
  );
}
