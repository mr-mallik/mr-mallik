import Link from "next/link";
import Image from "next/image";
import defaultSvg from "../public/default-project.svg";

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
          <h2 className="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
            Projects
          </h2>
          {showViewAllLink ? (
            <Link
              href="/projects"
              className="text-sm font-medium text-slate-600 underline decoration-slate-300 underline-offset-4 transition hover:text-slate-900 hover:decoration-slate-700 dark:text-slate-400 dark:decoration-slate-600 dark:hover:text-slate-100 dark:hover:decoration-slate-300"
            >
              View all projects
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
                <h3 className="text-lg tracking-tight text-slate-900 dark:text-slate-100">
                  {project.name}
                </h3>
                <p className="mt-2 leading-relaxed text-slate-600 dark:text-slate-400">
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
