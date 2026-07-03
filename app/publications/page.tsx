import type { Metadata } from "next";

import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import Header from "@/components/header";
import { PublicationsSection } from "@/components/publications-section";
import { createPageMetadata, buildWebPageJsonLd, sanitizeJsonLd, DEFAULT_OG_IMAGE_PATH } from "@/app/seo";

export const metadata: Metadata = createPageMetadata({
  title: "Publications",
  description: PAGE_COPY.publicationsPageDescription,
  path: ROUTES.publications,
  keywords: ["publications", "research", "Gulger Mallik", "mrmallik", "explainable AI"],
});

export default function PublicationsPage() {
  return (
    <section className="w-full ui-container ui-container-narrow py-4 sm:py-8 lg:py-12">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: "Publications",
              description: PAGE_COPY.publicationsPageDescription,
              path: ROUTES.publications,
              image: DEFAULT_OG_IMAGE_PATH,
            }),
          ),
        }}
      />
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
