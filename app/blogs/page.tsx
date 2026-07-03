import type { Metadata } from "next";

import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import BlogListClient from "@/app/blogs/blog-list-client";
import { getArticlesList } from "@/services/articles";
import { buildCollectionPageJsonLd, createPageMetadata, sanitizeJsonLd } from "@/app/seo";

// ─── Data fetching ────────────────────────────────────────────────────────────

type BlogPageSearchParams = {
  tag?: string | string[];
};

type BlogPageProps = {
  searchParams?: Promise<BlogPageSearchParams> | BlogPageSearchParams;
};

export async function generateMetadata({ searchParams }: BlogPageProps): Promise<Metadata> {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const rawTag = Array.isArray(resolvedSearchParams.tag)
    ? resolvedSearchParams.tag[0]
    : resolvedSearchParams.tag;
  const activeTag = rawTag?.trim() ? rawTag.trim() : undefined;

  return createPageMetadata({
    title: activeTag ? `Blogs tagged ${activeTag}` : "Blogs",
    description: activeTag
      ? `Posts tagged ${activeTag} from Gulger Mallik's blog on software engineering, applied AI, and research.`
      : PAGE_COPY.blogsPageDescription,
    path: ROUTES.blogs,
    keywords: activeTag ? [activeTag] : ["blogs", "software engineering blog", "applied AI", "research notes"],
    noIndex: Boolean(activeTag),
  });
}

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
        />
      </div>
    </section>
  );
}
