"use client";

import { useCallback, useEffect, useMemo, useRef, useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";

import defaultSvg from "../public/default-project.svg";
import type { Article, ArticlesResponse } from "@/app/blogs/types";
import { getTagColorClass } from "@/lib/tag-colors";

const PAGE_SIZE = 10;

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
};

export function ProjectsListClient({
  initialProjects,
  initialMeta,
  initialError,
  initialTag,
  canLoadMore,
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
        <div className="flex items-center gap-2 rounded-md border border-[var(--ui-border-soft)] bg-[var(--ui-bg-elevated)] p-2">
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
        <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
          {projects.map((project, index) => (
            <Link
              key={project.id}
              href={`/projects/${project.slug}`}
              className="group ui-project-card section-enter min-w-0 min-h-[18rem]"
              style={{ animationDelay: `${index * 60}ms`, aspectRatio: "auto" }}
            >
              <div className="flex h-full flex-col rounded-xl border border-[var(--ui-border-subtle)] bg-background p-4 sm:p-5">
                <div className="w-full pb-2 rounded-t-lg h-64 bg-stone-100 dark:bg-stone-900/30 flex items-center justify-center">
                  {project.featuredImage ? (
                    <Image
                      src={project.featuredImage}
                      alt={project.featuredImageAlt || `${project.title} project image`}
                      width={160}
                      height={160}
                      className="max-h-[80%] w-auto max-w-full object-contain"
                    />
                  ) : (
                    <Image
                      src={defaultSvg}
                      alt={`${project.title} project image`}
                      className="max-h-[80%] w-auto max-w-full object-contain"
                    />
                  )}
                </div>
                <div className="min-w-0 pt-3 space-y-2">
                  <h3 className="ui-item-title line-clamp-2 text-base tracking-tight [overflow-wrap:anywhere]">
                    {project.title}
                  </h3>
                  {project.excerpt ? (
                    <p className="ui-body-text mt-1.5 text-sm leading-relaxed line-clamp-4 [overflow-wrap:anywhere]">
                      {project.excerpt}
                    </p>
                  ) : null}

                  {project.tags && project.tags.length > 0 ? (
                    <div className="flex flex-wrap gap-1.5 pt-1">
                      {project.tags.slice(0, 3).map((tag) => (
                        <button
                          key={tag}
                          type="button"
                          onClick={(event) => {
                            event.preventDefault();
                            event.stopPropagation();

                            if (!canLoadMore || activeTag === tag) {
                              return;
                            }

                            void applyTagFilter(tag);
                          }}
                          className={`inline-flex max-w-full items-center truncate rounded-full border px-2 py-0.5 text-[11px] font-medium transition-colors duration-150 ${
                            activeTag === tag
                              ? "border-[var(--ui-text-link)] bg-transparent text-[var(--ui-text-link)]"
                              : getTagColorClass(tag)
                          }`}
                        >
                          {tag}
                        </button>
                      ))}
                    </div>
                  ) : null}
                </div>
              </div>
            </Link>
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