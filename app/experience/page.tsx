import { ExperienceSection } from "@/components/experience-section";
import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";

export default function ExperiencePage() {
  return (
    <section className="mx-auto w-full max-w-2xl ">
      <div className="space-y-5 sm:space-y-7">
        <Header
          link={ROUTES.home}
          title={SECTION_TITLES.experience}
          description={PAGE_COPY.experiencePageDescription}
        />
        <ExperienceSection heading={false} />
      </div>
    </section>
  );
}
