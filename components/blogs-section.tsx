import Image from "next/image";
import Link from "next/link";

import { LINK_LABELS, ROUTES, SECTION_TITLES } from "@/app/constants";
import { getArticlesList } from "@/services/articles";
import { getTagColorClass } from "@/lib/tag-colors";

function formatDate(iso: string): string {
  const date = new Date(iso);
  if (Number.isNaN(date.getTime())) return iso;
  return date.toLocaleDateString("en-GB", {
    day: "numeric",
    month: "short",
    year: "numeric",
  });
}

export async function BlogsSection({
  limit = 3,
  heading = true,
  showViewAllLink = false,
}: {
  limit?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
}) {
  const { articles, error } = await getArticlesList({
    category: "blog",
    page: 1,
    limit,
  });

  return (
    <section className="space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="ui-section-title ">
            {SECTION_TITLES.blog}
          </h2>
          {showViewAllLink ? (
            <Link href={ROUTES.blogs} className="ui-view-all-link">
              View all {LINK_LABELS.blogs}
            </Link>
          ) : null}
        </div>
      ) : null}

      {error ? (
        <p className="ui-meta-text">{error}</p>
      ) : articles.length === 0 ? (
        <p className="ui-meta-text">No posts published yet - check back soon.</p>
      ) : (
        <div className="divide-y divide-[var(--ui-border-subtle)]">
          {articles.map((article, index) => (
            <article
              key={article.id}
              className="section-enter py-5 first:pt-0 last:pb-0"
              style={{ animationDelay: `${index * 60}ms` }}
            >
              <Link href={`/blogs/${article.slug}`} className="group flex items-start gap-3 sm:gap-4">
                <div className="min-w-0 flex-1 space-y-2">
                  <h3 className="ui-item-title leading-snug transition-colors group-hover:text-[var(--ui-text-link)]">
                    {article.title}
                  </h3>

                  {article.excerpt ? (
                    <p className="ui-body-text line-clamp-2 text-sm">{article.excerpt}</p>
                  ) : null}

                  <div className="flex flex-wrap items-center gap-x-2 gap-y-1 pt-0.5">
                    <span className="ui-meta-text">{formatDate(article.publishedAt)}</span>
                    {article.tags && article.tags.length > 0 ? (
                      <>
                        <span className="ui-meta-text opacity-40">&bull;</span>
                        <div className="flex flex-wrap gap-1.5">
                          {article.tags.slice(0, 2).map((tag) => (
                            <span
                              key={tag}
                              className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium ${getTagColorClass(tag)}`}
                            >
                              {tag}
                            </span>
                          ))}
                        </div>
                      </>
                    ) : null}
                  </div>
                </div>

                {article.featuredImage ? (
                  <div className="relative shrink-0 overflow-hidden rounded-lg shadow-sm">
                    <Image
                      src={article.featuredImage}
                      alt={article.featuredImageAlt || article.title}
                      width={100}
                      height={66}
                      className="h-[60px] w-[84px] object-cover transition duration-300 group-hover:scale-[1.05] group-hover:opacity-90 sm:h-[66px] sm:w-[100px]"
                    />
                  </div>
                ) : null}
              </Link>
            </article>
          ))}
        </div>
      )}
    </section>
  );
}