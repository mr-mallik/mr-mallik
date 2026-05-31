"use client";

import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";

import type { Article, ArticlesResponse } from "@/app/blogs/types";

const PAGE_SIZE = 10;

function formatDate(iso: string): string {
  const date = new Date(iso);
  if (Number.isNaN(date.getTime())) return iso;
  return date.toLocaleDateString("en-GB", {
    day: "numeric",
    month: "short",
    year: "numeric",
  });
}

function getHasMore(meta: ArticlesResponse["meta"], loaded: number): boolean {
  if (!meta) {
    return loaded > 0 && loaded % PAGE_SIZE === 0;
  }

  if (typeof meta.totalPages === "number") {
    return meta.page < meta.totalPages;
  }

  if (typeof meta.total === "number") {
    return loaded < meta.total;
  }

  return loaded > 0 && loaded % (meta.limit || PAGE_SIZE) === 0;
}

type BlogListClientProps = {
  initialArticles: Article[];
  initialMeta?: ArticlesResponse["meta"];
  initialError?: string;
  initialTag?: string;
};

export default function BlogListClient({
  initialArticles,
  initialMeta,
  initialError,
  initialTag,
}: BlogListClientProps) {
  const pathname = usePathname();
  const [articles, setArticles] = useState<Article[]>(initialArticles);
  const [meta, setMeta] = useState<ArticlesResponse["meta"]>(initialMeta);
  const [currentPage, setCurrentPage] = useState<number>(initialMeta?.page ?? 1);
  const [isLoadingMore, setIsLoadingMore] = useState(false);
  const [error, setError] = useState<string | undefined>(initialError);
  const [activeTag, setActiveTag] = useState<string | undefined>(initialTag);
  const observerRef = useRef<HTMLDivElement | null>(null);

  const hasMore = useMemo(
    () => getHasMore(meta, articles.length),
    [meta, articles.length],
  );

  const setTagInUrl = useCallback((tag?: string) => {
    const params = new URLSearchParams(window.location.search);
    if (tag) {
      params.set("tag", tag);
    } else {
      params.delete("tag");
    }

    const queryString = params.toString();
    const nextUrl = queryString ? `${pathname}?${queryString}` : pathname;
    window.history.replaceState(null, "", nextUrl);
  }, [pathname]);

  const fetchPage = useCallback(async (page: number, tag?: string) => {
    const query = new URLSearchParams({
      category: "blog",
      sort: "latest",
      page: String(page),
      limit: String(PAGE_SIZE),
    });

    if (tag) {
      query.set("tag", tag);
    }

    const response = await fetch(`/api/articles?${query.toString()}`);

    if (!response.ok) {
      throw new Error(`Failed to load posts (${response.status})`);
    }

    return (await response.json()) as ArticlesResponse;
  }, []);

  const loadMore = useCallback(async () => {
    if (isLoadingMore || !hasMore || error) {
      return;
    }

    const nextPage = currentPage + 1;
    setIsLoadingMore(true);

    try {
      const payload = await fetchPage(nextPage, activeTag);
      const nextItems = payload.data ?? [];

      setArticles((prev) => {
        const existingIds = new Set(prev.map((item) => item.id));
        const merged = [...prev];

        for (const item of nextItems) {
          if (!existingIds.has(item.id)) {
            merged.push(item);
          }
        }

        return merged;
      });

      setMeta(payload.meta);
      setCurrentPage(payload.meta?.page ?? nextPage);
    } catch (err) {
      const message = err instanceof Error ? err.message : "Something went wrong while loading posts.";
      setError(message);
    } finally {
      setIsLoadingMore(false);
    }
  }, [activeTag, currentPage, error, fetchPage, hasMore, isLoadingMore]);

  const applyTagFilter = useCallback(async (tag?: string) => {
    setActiveTag(tag);
    setTagInUrl(tag);
    setError(undefined);
    setIsLoadingMore(true);

    try {
      const payload = await fetchPage(1, tag);
      setArticles(payload.data ?? []);
      setMeta(payload.meta);
      setCurrentPage(payload.meta?.page ?? 1);
    } catch (err) {
      const message = err instanceof Error ? err.message : "Something went wrong while loading posts.";
      setError(message);
      setArticles([]);
      setMeta(undefined);
      setCurrentPage(1);
    } finally {
      setIsLoadingMore(false);
    }
  }, [fetchPage, setTagInUrl]);

  useEffect(() => {
    const target = observerRef.current;
    if (!target || !hasMore || error) {
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        const [entry] = entries;
        if (entry?.isIntersecting) {
          void loadMore();
        }
      },
      { rootMargin: "320px 0px" },
    );

    observer.observe(target);
    return () => observer.disconnect();
  }, [error, hasMore, loadMore]);

  return (
    <div className="space-y-4">
      {activeTag ? (
        <div className="flex items-center gap-2 rounded-md border border-[var(--ui-border-soft)] bg-[var(--ui-bg-elevated)] p-2">
          <span className="ui-meta-text">Active tag:</span>
          <span className="inline-flex items-center rounded-full border border-[var(--ui-border-soft)] px-2 py-0.5 text-[11px] font-medium text-[var(--ui-text-muted)]">
            {activeTag}
          </span>
          <button
            type="button"
            onClick={() => {
              void applyTagFilter(undefined);
            }}
            className="ui-meta-text underline underline-offset-2"
          >
            Clear
          </button>
        </div>
      ) : null}

      {articles.length > 0 ? (
        <div className="divide-y divide-[var(--ui-border-subtle)]">
          {articles.map((article, index) => (
            <article
              key={article.id}
              className="section-enter rounded-xl px-3 py-6 transition-colors odd:bg-transparent even:bg-[color-mix(in_srgb,var(--ui-border-subtle)_22%,transparent)] first:pt-0 last:pb-0 dark:even:bg-[color-mix(in_srgb,var(--ui-border-subtle)_30%,transparent)] sm:px-4"
              style={{ animationDelay: `${index * 60}ms` }}
            >
              <Link
                href={`/blogs/${article.slug}`}
                className="group flex items-start gap-3 sm:gap-5"
              >
                <div className="min-w-0 flex-1 space-y-2">
                  <h2 className="ui-item-title text-[15px] font-semibold leading-snug transition-colors group-hover:text-[var(--ui-text-link)]">
                    {article.title}
                  </h2>

                  {article.excerpt ? (
                    <p className="ui-body-text line-clamp-2 text-sm">{article.excerpt}</p>
                  ) : null}

                  <div className="flex flex-wrap items-center gap-x-3 gap-y-1 pt-1">
                    <span className="ui-meta-text">{formatDate(article.publishedAt)}</span>
                    {article.tags && article.tags.length > 0 ? (
                      <>
                        <span className="ui-meta-text opacity-40">&bull;</span>
                        <div className="flex flex-wrap gap-1.5">
                          {article.tags.slice(0, 3).map((tag) => (
                            <button
                              key={tag}
                              type="button"
                              onClick={(event) => {
                                event.preventDefault();
                                event.stopPropagation();

                                if (activeTag === tag) {
                                  return;
                                }

                                void applyTagFilter(tag);
                              }}
                              className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium ${
                                activeTag === tag
                                  ? "border-[var(--ui-text-link)] text-[var(--ui-text-link)]"
                                  : "border-[var(--ui-border-soft)] text-[var(--ui-text-muted)]"
                              }`}
                            >
                              {tag}
                            </button>
                          ))}
                        </div>
                      </>
                    ) : null}
                  </div>
                </div>

                {article.featuredImage ? (
                  <div className="relative shrink-0">
                    <Image
                      src={article.featuredImage}
                      alt={article.featuredImageAlt || article.title}
                      width={112}
                      height={75}
                      className="h-[60px] w-[84px] rounded-md object-cover transition-opacity duration-200 group-hover:opacity-90 sm:h-[75px] sm:w-[112px]"
                    />
                  </div>
                ) : null}
              </Link>
            </article>
          ))}
        </div>
      ) : (
        <p className="ui-meta-text">
          {activeTag ? "No posts found for this filter." : "No posts published yet - check back soon."}
        </p>
      )}

      {error ? <p className="ui-meta-text">{error}</p> : null}

      <div ref={observerRef} className="h-6" aria-hidden="true" />

      {isLoadingMore ? (
        <p className="ui-meta-text">Loading more posts...</p>
      ) : null}

      {!hasMore && articles.length > 0 ? (
        <p className="ui-meta-text">You have reached the end.</p>
      ) : null}
    </div>
  );
}