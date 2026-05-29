import { ProjectsSection } from "@/components/projects-section";

export default function ProjectsPage() {
  return (
    <section className="mx-auto w-full max-w-2xl py-2 sm:py-8">
      <div className="space-y-5 sm:space-y-7">
        <header className="space-y-1">
          <h1 className="text-2xl font-semibold tracking-tight text-slate-900 dark:text-slate-100 sm:text-3xl">
            Projects
          </h1>
          <p className="max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400 sm:text-lg">
            A complete list of selected projects and experiments.
          </p>
        </header>

        <ProjectsSection heading={false} />
      </div>
    </section>
  );
}