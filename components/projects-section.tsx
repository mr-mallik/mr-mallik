import Link from "next/link";
import Image from "next/image";
import defaultSvg from "../public/default-project.svg";
import { LINK_LABELS, ROUTES, SECTION_TITLES } from "@/app/constants";

type Project = {
  name: string;
  description: string;
  href: string;
};

const projects: Project[] = [
  {
    name: "Project 1",
    description: "This is project 1 description.",
    href: "#",
  },
  {
    name: "Project 2",
    description: "This is project 2 description.",
    href: "#",
  },
  {
    name: "Project 3",
    description: "This is project 3 description.",
    href: "#",
  },
  {
    name: "Project 4",
    description: "This is project 4 description.",
    href: "#",
  },
  {
    name: "Project 5",
    description: "This is project 5 description.",
    href: "#",
  },
  {
    name: "Project 6",
    description: "This is project 6 description.",
    href: "#",
  },
];

export function ProjectsSection({
  limit,
  heading = true,
  showViewAllLink = false,
}: {
  limit?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
}) {
  const visibleProjects = typeof limit === "number" ? projects.slice(0, limit) : projects;

  return (
    <section className="space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="ui-section-title tracking-tight">
            {SECTION_TITLES.projects}
          </h2>
          {showViewAllLink ? (
            <Link
              href={ROUTES.projects}
              className="ui-link-subtle text-sm font-medium"
            >
              {LINK_LABELS.viewAllProjects}
            </Link>
          ) : null}
        </div>
      ) : null}
      <div className="grid gap-4 sm:grid-cols-2">
        {visibleProjects.map((project) => (
          <Link
            key={project.name}
            href={project.href}
            className="group flex aspect-[5/3] flex-col rounded-2xl border border-slate-200 bg-background p-1 shadow-sm transition hover:border-slate-300 hover:shadow-md dark:border-slate-800 dark:hover:border-slate-700"
          >
            <div className="flex h-full flex-col rounded-xl border border-slate-200 bg-background p-4 sm:p-5 dark:border-slate-800">
              <div className="flex flex-[1.7] items-center justify-center">
                <Image
                  src={defaultSvg}
                  alt={`${project.name} project image`}
                  className="h-16 w-16 object-contain opacity-50 group-hover:opacity-75"
                />
              </div>
              <div className="mt-auto pt-3">
                <h3 className="ui-text-primary text-lg tracking-tight">
                  {project.name}
                </h3>
                <p className="ui-text-secondary mt-2 leading-relaxed">
                  {project.description}
                </p>
              </div>
            </div>
          </Link>
        ))}
      </div>
    </section>
  );
}
