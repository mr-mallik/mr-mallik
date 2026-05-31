import type { Metadata } from "next";

import { ExperienceSection } from "@/components/experience-section";
import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import { createPageMetadata, buildWebPageJsonLd, sanitizeJsonLd, DEFAULT_OG_IMAGE_PATH } from "@/app/seo";

export const metadata: Metadata = createPageMetadata({
  title: "Experience",
  description: PAGE_COPY.experiencePageDescription,
  path: ROUTES.resume,
  keywords: ["experience", "work experience", "Gulger Mallik", "mrmallik"],
});

export default function ExperiencePage() {
  return (
    <section className="mx-auto w-full max-w-2xl ">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: "Experience",
              description: PAGE_COPY.experiencePageDescription,
              path: ROUTES.resume,
              image: DEFAULT_OG_IMAGE_PATH,
            }),
          ),
        }}
      />
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
