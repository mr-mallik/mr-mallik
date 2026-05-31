import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import Header from "@/components/header";
import { PublicationsSection } from "@/components/publications-section";

export default function PublicationsPage() {
  return (
    <section className="mx-auto w-full max-w-2xl ">
      <div className="space-y-5 sm:space-y-7">
        <Header
          link={ROUTES.home}
          title={SECTION_TITLES.publications}
          description={PAGE_COPY.publicationsPageDescription}
        />
        <PublicationsSection heading={false} startFrom={0} />
      </div>
    </section>
  );
}
