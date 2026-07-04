"use client";

import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import { usePathname } from "next/navigation";

import type { Article, ArticlesResponse } from "@/app/blogs/types";
import { getTagColorClass } from "@/lib/tag-colors";
import { ProjectCard } from "@/components/project-card";

const PAGE_SIZE = 10;

const GRID_COLUMN_CLASSES: Record<2 | 3, string> = {
  2: "md:grid-cols-2 lg:grid-cols-2",
  3: "md:grid-cols-2 lg:grid-cols-3",
};

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

type ProjectsListClientProps = {
  initialProjects: Article[];
  initialMeta?: ArticlesResponse["meta"];
  initialError?: string;
  initialTag?: string;
  initialCategory?: string;
  canLoadMore: boolean;
  columns?: 2 | 3;
  /** Hide items beyond this count on desktop (lg+) screens. */
  desktopLimit?: number;
};

export function ProjectsListClient({
  initialProjects,
  initialMeta,
  initialError,
  initialTag,
  initialCategory,
  canLoadMore,
  columns = 2,
  desktopLimit,
}: ProjectsListClientProps) {
  const pathname = usePathname();
  const [projects, setProjects] = useState<Article[]>(initialProjects);
  const [meta, setMeta] = useState<ArticlesResponse["meta"]>(initialMeta);
  const [currentPage, setCurrentPage] = useState<number>(initialMeta?.page ?? 1);
  const [isLoadingMore, setIsLoadingMore] = useState(false);
  const [error, setError] = useState<string | undefined>(initialError);
  const [activeTag, setActiveTag] = useState<string | undefined>(initialTag);
  const [activeCategory, setActiveCategory] = useState<string | undefined>(initialCategory);
  const observerRef = useRef<HTMLDivElement | null>(null);

  const hasMore = useMemo(() => {
    if (!canLoadMore) {
      return false;
    }
    return getHasMore(meta, projects.length);
  }, [canLoadMore, meta, projects.length]);

  const setParamInUrl = useCallback(
    (key: "tag" | "category", value?: string) => {
      const params = new URLSearchParams(window.location.search);
      if (value) {
        params.set(key, value);
      } else {
        params.delete(key);
      }

      const queryString = params.toString();
      const nextUrl = queryString ? `${pathname}?${queryString}` : pathname;
      window.history.replaceState(null, "", nextUrl);
    },
    [pathname],
  );

  const fetchPage = useCallback(async (page: number, tag?: string, category?: string) => {
    const query = new URLSearchParams({
      type: "project",
      sort: "latest",
      page: String(page),
      limit: String(PAGE_SIZE),
    });

    if (tag) {
      query.set("tag", tag);
    }

    if (category) {
      query.set("category", category);
    }

    const response = await fetch(`/api/articles?${query.toString()}`);

    if (!response.ok) {
      throw new Error(`Failed to load projects (${response.status})`);
    }

    return (await response.json()) as ArticlesResponse;
  }, []);

  const loadMore = useCallback(async () => {
    if (!canLoadMore || isLoadingMore || !hasMore || error) {
      return;
    }

    const nextPage = currentPage + 1;
    setIsLoadingMore(true);

    try {
      const payload = await fetchPage(nextPage, activeTag, activeCategory);
      const nextItems = payload.data ?? [];

      setProjects((prev) => {
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
      const message = err instanceof Error ? err.message : "Something went wrong while loading projects.";
      setError(message);
    } finally {
      setIsLoadingMore(false);
    }
  }, [activeCategory, activeTag, canLoadMore, currentPage, error, fetchPage, hasMore, isLoadingMore]);

  const applyFilters = useCallback(
    async (tag?: string, category?: string) => {
      if (!canLoadMore) {
        return;
      }

      setActiveTag(tag);
      setActiveCategory(category);
      setParamInUrl("tag", tag);
      setParamInUrl("category", category);
      setError(undefined);
      setIsLoadingMore(true);

      try {
        const payload = await fetchPage(1, tag, category);
        setProjects(payload.data ?? []);
        setMeta(payload.meta);
        setCurrentPage(payload.meta?.page ?? 1);
      } catch (err) {
        const message = err instanceof Error ? err.message : "Something went wrong while loading projects.";
        setError(message);
        setProjects([]);
        setMeta(undefined);
        setCurrentPage(1);
      } finally {
        setIsLoadingMore(false);
      }
    },
    [canLoadMore, fetchPage, setParamInUrl],
  );

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
      {canLoadMore && (activeTag || activeCategory) ? (
        <div className="flex flex-wrap items-center gap-2 rounded-md border border-[var(--ui-border-soft)] ui-bg-elevated p-2">
          {activeTag ? (
            <>
              <span className="ui-meta-text">Active tag:</span>
              <span className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium ${getTagColorClass(activeTag)}`}>
                {activeTag}
              </span>
            </>
          ) : null}
          {activeCategory ? (
            <>
              <span className="ui-meta-text">Category:</span>
              <span className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium ${getTagColorClass(activeCategory)}`}>
                {activeCategory}
              </span>
            </>
          ) : null}
          <button
            type="button"
            onClick={() => {
              void applyFilters(undefined, undefined);
            }}
            className="ui-meta-text underline underline-offset-2"
          >
            Clear
          </button>
        </div>
      ) : null}

      {projects.length > 0 ? (
        <div className={`grid grid-cols-1 gap-6 ${GRID_COLUMN_CLASSES[columns]}`}>
          {projects.map((project, index) => {
            const card = (
              <ProjectCard
                key={project.id}
                project={project}
                index={index}
                activeTag={activeTag}
                onTagClick={
                  canLoadMore
                    ? (tag) => {
                        if (activeTag === tag) {
                          return;
                        }
                        void applyFilters(tag, activeCategory);
                      }
                    : undefined
                }
              />
            );

            if (typeof desktopLimit === "number" && index >= desktopLimit) {
              return (
                <div key={project.id} className="h-full lg:hidden">
                  {card}
                </div>
              );
            }

            return card;
          })}
        </div>
      ) : (
        <p className="ui-meta-text">
          {canLoadMore && (activeTag || activeCategory)
            ? "No projects found for this filter."
            : "No projects published yet - check back soon."}
        </p>
      )}

      {error ? <p className="ui-meta-text">{error}</p> : null}

      {canLoadMore ? <div ref={observerRef} className="h-6" aria-hidden="true" /> : null}

      {canLoadMore && isLoadingMore ? (
        <p className="ui-meta-text">Loading more projects...</p>
      ) : null}

      {canLoadMore && !hasMore && projects.length > 0 ? (
        <p className="ui-meta-text">You have reached the end.</p>
      ) : null}
    </div>
  );
}