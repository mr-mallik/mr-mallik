import { ProjectsSection } from "@/components/projects-section";
import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";

type ProjectsPageSearchParams = {
  tag?: string | string[];
};

type ProjectsPageProps = {
  searchParams?: Promise<ProjectsPageSearchParams> | ProjectsPageSearchParams;
};

export default async function ProjectsPage({ searchParams }: ProjectsPageProps) {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const rawTag = Array.isArray(resolvedSearchParams.tag)
    ? resolvedSearchParams.tag[0]
    : resolvedSearchParams.tag;
  const activeTag = rawTag?.trim() ? rawTag.trim() : undefined;

  return (
    <section className="mx-auto w-full max-w-2xl ">
      <div className="space-y-5 sm:space-y-7">
        <Header
          link={ROUTES.home}
          title={SECTION_TITLES.projects}
          description={PAGE_COPY.projectsPageDescription}
        />
        <ProjectsSection heading={false} initialTag={activeTag} />
      </div>
    </section>
  );
}