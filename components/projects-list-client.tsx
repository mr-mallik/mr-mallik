"use client";

import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import { usePathname } from "next/navigation";

import type { Article, ArticlesResponse } from "@/app/blogs/types";
import { getTagColorClass } from "@/lib/tag-colors";
import { ProjectCard } from "@/components/project-card";

const PAGE_SIZE = 10;

const GRID_COLUMN_CLASSES: Record<2 | 3, string> = {
  2: "md:grid-cols-2 lg:grid-cols-2",
  3: "md:grid-cols-3 lg:grid-cols-3",
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
  canLoadMore: boolean;
  columns?: 2 | 3;
};

export function ProjectsListClient({
  initialProjects,
  initialMeta,
  initialError,
  initialTag,
  canLoadMore,
  columns = 2,
}: ProjectsListClientProps) {
  const pathname = usePathname();
  const [projects, setProjects] = useState<Article[]>(initialProjects);
  const [meta, setMeta] = useState<ArticlesResponse["meta"]>(initialMeta);
  const [currentPage, setCurrentPage] = useState<number>(initialMeta?.page ?? 1);
  const [isLoadingMore, setIsLoadingMore] = useState(false);
  const [error, setError] = useState<string | undefined>(initialError);
  const [activeTag, setActiveTag] = useState<string | undefined>(initialTag);
  const observerRef = useRef<HTMLDivElement | null>(null);

  const hasMore = useMemo(() => {
    if (!canLoadMore) {
      return false;
    }
    return getHasMore(meta, projects.length);
  }, [canLoadMore, meta, projects.length]);

  const setTagInUrl = useCallback(
    (tag?: string) => {
      const params = new URLSearchParams(window.location.search);
      if (tag) {
        params.set("tag", tag);
      } else {
        params.delete("tag");
      }

      const queryString = params.toString();
      const nextUrl = queryString ? `${pathname}?${queryString}` : pathname;
      window.history.replaceState(null, "", nextUrl);
    },
    [pathname],
  );

  const fetchPage = useCallback(async (page: number, tag?: string) => {
    const query = new URLSearchParams({
      category: "project",
      sort: "latest",
      page: String(page),
      limit: String(PAGE_SIZE),
    });

    if (tag) {
      query.set("tag", tag);
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
      const payload = await fetchPage(nextPage, activeTag);
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
  }, [activeTag, canLoadMore, currentPage, error, fetchPage, hasMore, isLoadingMore]);

  const applyTagFilter = useCallback(
    async (tag?: string) => {
      if (!canLoadMore) {
        return;
      }

      setActiveTag(tag);
      setTagInUrl(tag);
      setError(undefined);
      setIsLoadingMore(true);

      try {
        const payload = await fetchPage(1, tag);
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
    [canLoadMore, fetchPage, setTagInUrl],
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
      {canLoadMore && activeTag ? (
        <div className="flex items-center gap-2 rounded-md border border-[var(--ui-border-soft)] ui-bg-elevated p-2">
          <span className="ui-meta-text">Active tag:</span>
          <span className={`inline-flex items-center rounded-full border px-2 py-0.5 text-[11px] font-medium ${getTagColorClass(activeTag)}`}>
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

      {projects.length > 0 ? (
        <div className={`grid grid-cols-1 gap-6 ${GRID_COLUMN_CLASSES[columns]}`}>
          {projects.map((project, index) => (
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
                      void applyTagFilter(tag);
                    }
                  : undefined
              }
            />
          ))}
        </div>
      ) : (
        <p className="ui-meta-text">
          {canLoadMore && activeTag
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