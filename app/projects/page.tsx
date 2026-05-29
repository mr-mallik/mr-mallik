import { ProjectsSection } from "@/components/projects-section";
import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";

export default function ProjectsPage() {
  return (
    <section className="mx-auto w-full max-w-2xl py-2 sm:py-8">
      <div className="space-y-5 sm:space-y-7">
        <Header
          link={ROUTES.home}
          title={SECTION_TITLES.projects}
          description={PAGE_COPY.projectsPageDescription}
        />
        <ProjectsSection heading={false} />
      </div>
    </section>
  );
}