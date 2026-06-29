import Image from "next/image";
import Link from "next/link";

import defaultSvg from "../public/default-project.svg";
import { ROUTES } from "@/app/constants";
import { cmsApi } from "@/services/cms";
import { ApiError } from "@/services/api";
import type { ArticlesResponse, Article } from "@/app/blogs/types";

async function fetchFeaturedProjects(limit = 3): Promise<Article[]> {
  try {
    const res = await cmsApi.get<ArticlesResponse>("/articles", {
      query: { category: "project", sort: "latest", page: 1, limit },
      next: { revalidate: 3600 },
    } as Parameters<typeof cmsApi.get>[1] & { next?: { revalidate: number } });
    return res.data ?? [];
  } catch (err) {
    if (err instanceof ApiError) {
      console.error("Failed to load featured projects:", err.status);
    }
    return [];
  }
}

function formatYear(dateStr: string): string {
  return new Date(dateStr).getFullYear().toString();
}

export async function HomeProjectsSection() {
  const projects = await fetchFeaturedProjects(3);

  return (
    <section className="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-14">
      {/* Header */}
      <div className="mb-10 flex items-start justify-between gap-8">
        <h2 className="max-w-2xl text-3xl font-semibold leading-tight tracking-tight text-[var(--ui-text-primary)] sm:text-4xl lg:text-5xl">
          Building things that work at scale.{" "}
          <span className="text-[var(--ui-text-muted)] font-normal">
            A few that say the most.
          </span>
        </h2>
        <Link href={ROUTES.projects} className="mt-1 shrink-0 ui-view-all-link whitespace-nowrap">
          View all work
        </Link>
      </div>

      {/* Project grid */}
      {projects.length > 0 ? (
        <div className="grid grid-cols-1 gap-8 md:grid-cols-3">
          {projects.map((project, index) => (
            <Link
              key={project.id}
              href={`/projects/${project.slug}`}
              className="group flex flex-col gap-4"
            >
              {/* Image */}
              <div className="relative w-full aspect-[4/3] overflow-hidden rounded-xl bg-stone-100 dark:bg-stone-900/30">
                {project.featuredImage ? (
                  <Image
                    src={project.featuredImage}
                    alt={project.featuredImageAlt || project.title}
                    fill
                    sizes="(max-width: 768px) 100vw, 33vw"
                    className="object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                  />
                ) : (
                  <Image
                    src={defaultSvg}
                    alt=""
                    fill
                    className="object-contain p-10 opacity-20"
                  />
                )}
              </div>

              {/* Meta row */}
              <div className="flex items-center justify-between gap-2">
                <p className="text-[11px] font-semibold tracking-widest uppercase text-[var(--ui-text-muted)]">
                  <span className="text-[var(--ui-text-secondary)]">
                    {String(index + 1).padStart(2, "0")}
                  </span>
                  {" · "}
                  {project.tags?.[0] ?? "Project"}
                </p>
                <p className="text-[11px] tracking-wide text-[var(--ui-text-muted)]">
                  {formatYear(project.publishedAt)}
                </p>
              </div>

              {/* Title */}
              <h3 className="text-lg font-semibold leading-snug text-[var(--ui-text-primary)] group-hover:text-[var(--ui-text-link)] transition-colors">
                {project.title}
              </h3>

              {/* Excerpt */}
              {project.excerpt ? (
                <p className="text-sm leading-relaxed text-[var(--ui-text-muted)] line-clamp-3">
                  {project.excerpt}
                </p>
              ) : null}

              {/* Tags */}
              {project.tags && project.tags.length > 0 ? (
                <div className="flex flex-wrap gap-1.5">
                  {project.tags.slice(0, 3).map((tag) => (
                    <span
                      key={tag}
                      className="inline-flex items-center rounded border border-[var(--ui-border-soft)] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider text-[var(--ui-text-muted)]"
                    >
                      {tag}
                    </span>
                  ))}
                </div>
              ) : null}
            </Link>
          ))}
        </div>
      ) : (
        <p className="ui-meta-text">No projects published yet — check back soon.</p>
      )}
    </section>
  );
}
