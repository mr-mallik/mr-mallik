import Link from "next/link";
import { LINK_LABELS, ROUTES, SECTION_TITLES } from "@/app/constants";
import type { ArticlesResponse } from "@/app/blogs/types";
import { ApiError } from "@/services/api";
import { cmsApi } from "@/services/cms";
import { ProjectsListClient } from "@/components/projects-list-client";

async function fetchProjects(page = 1, limit = 10, tag?: string, category?: string): Promise<{
  projects: ArticlesResponse["data"];
  meta?: ArticlesResponse["meta"];
  error?: string;
}> {
  try {
    const res = await cmsApi.get<ArticlesResponse>("/articles", {
      query: { type: "project", sort: "latest", page, limit, tag, category },
      next: { revalidate: 3600 },
    } as Parameters<typeof cmsApi.get>[1] & { next?: { revalidate: number } });

    return { projects: res.data ?? [], meta: res.meta };
  } catch (err) {
    const message =
      err instanceof ApiError
        ? `Failed to load projects (${err.status})`
        : "Something went wrong while loading projects.";

    return { projects: [], error: message };
  }
}

export async function ProjectsSection({
  limit,
  heading = true,
  showViewAllLink = false,
  initialTag,
  initialCategory,
  columns = 2,
  desktopLimit,
}: {
  limit?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
  initialTag?: string;
  initialCategory?: string;
  columns?: 2 | 3;
  /** Hide items beyond this count on desktop (lg+) screens. */
  desktopLimit?: number;
}) {
  const pageLimit = typeof limit === "number" ? limit : 10;
  const { projects, meta, error } = await fetchProjects(1, pageLimit, initialTag, initialCategory);
  const canLoadMore = typeof limit !== "number";

  return (
    <section className="space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="ui-section-title">
            {SECTION_TITLES.projects}
          </h2>
          {showViewAllLink ? (
            <Link
              href={ROUTES.projects}
              className="ui-view-all-link"
            >
              {LINK_LABELS.viewAllProjects}
            </Link>
          ) : null}
        </div>
      ) : null}
      <ProjectsListClient
        initialProjects={projects}
        initialMeta={meta}
        initialError={error}
        initialTag={canLoadMore ? initialTag : undefined}
        initialCategory={canLoadMore ? initialCategory : undefined}
        canLoadMore={canLoadMore}
        columns={columns}
        desktopLimit={desktopLimit}
      />
    </section>
  );
}
