import Image from "next/image";
import Link from "next/link";

import defaultSvg from "../public/default-project.svg";
import type { Article } from "@/app/blogs/types";
import { getTagColorClass } from "@/lib/tag-colors";

type ProjectCardProps = {
  project: Article;
  index: number;
  activeTag?: string;
  onTagClick?: (tag: string) => void;
};

export function ProjectCard({ project, index, activeTag, onTagClick }: ProjectCardProps) {
  return (
    <div
      className="group ui-project-card section-enter min-w-0"
      style={{ animationDelay: `${index * 60}ms`, aspectRatio: "auto" }}
    >
      <div className="flex h-full flex-col rounded-xl border border-[var(--ui-border-subtle)] bg-background p-4 sm:p-5">
        <Link href={`/projects/${project.slug}`} className="contents">
          <div className="relative w-full aspect-video overflow-hidden rounded-lg ui-bg-elevated">
            {project.featuredImage ? (
              <Image
                src={project.featuredImage}
                alt={project.featuredImageAlt || `${project.title} project image`}
                fill
                sizes="(max-width: 768px) 100vw, 33vw"
                className="object-contain p-4"
              />
            ) : (
              <Image
                src={defaultSvg}
                alt=""
                fill
                className="object-contain p-8 opacity-25"
              />
            )}
          </div>
          <div className="min-w-0 pt-3 space-y-2">
            <h3 className="ui-item-title line-clamp-2 text-base  [overflow-wrap:anywhere]">
              {project.title}
            </h3>
            {project.excerpt ? (
              <p className="ui-body-text mt-1.5 text-sm leading-relaxed line-clamp-4 [overflow-wrap:anywhere]">
                {project.excerpt}
              </p>
            ) : null}
          </div>
        </Link>

        {project.tags && project.tags.length > 0 ? (
          <div className="flex min-w-0 flex-wrap gap-1.5 mt-2">
            {project.tags.slice(0, 3).map((tag) =>
              onTagClick ? (
                <button
                  key={tag}
                  type="button"
                  onClick={() => onTagClick(tag)}
                  className={`inline-flex max-w-full items-center truncate rounded-full border px-2 py-0.5 text-[11px] font-medium transition-colors duration-150 ${
                    activeTag === tag
                      ? "border-[var(--ui-text-link)] bg-transparent text-[var(--ui-text-link)]"
                      : getTagColorClass(tag)
                  }`}
                >
                  {tag}
                </button>
              ) : (
                <span
                  key={tag}
                  className={`inline-flex max-w-full items-center truncate rounded-full border px-2 py-0.5 text-[11px] font-medium ${getTagColorClass(tag)}`}
                >
                  {tag}
                </span>
              ),
            )}
          </div>
        ) : null}
      </div>
    </div>
  );
}
