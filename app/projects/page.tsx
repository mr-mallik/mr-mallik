import type { Metadata } from "next";

import { ProjectsSection } from "@/components/projects-section";
import Header from "@/components/header";
import { PAGE_COPY, ROUTES, SECTION_TITLES } from "@/app/constants";
import { createPageMetadata, buildWebPageJsonLd, sanitizeJsonLd, DEFAULT_OG_IMAGE_PATH } from "@/app/seo";

type ProjectsPageSearchParams = {
  tag?: string | string[];
  category?: string | string[];
};

type ProjectsPageProps = {
  searchParams?: Promise<ProjectsPageSearchParams> | ProjectsPageSearchParams;
};

function firstParam(value?: string | string[]): string | undefined {
  const raw = Array.isArray(value) ? value[0] : value;
  return raw?.trim() ? raw.trim() : undefined;
}

export async function generateMetadata({ searchParams }: ProjectsPageProps): Promise<Metadata> {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const activeTag = firstParam(resolvedSearchParams.tag);
  const activeCategory = firstParam(resolvedSearchParams.category);
  const activeFilter = activeTag ?? activeCategory;

  return createPageMetadata({
    title: activeTag
      ? `Projects tagged ${activeTag}`
      : activeCategory
        ? `Projects in ${activeCategory}`
        : "Projects",
    description: activeFilter
      ? `Projects about ${activeFilter} from Gulger Mallik's portfolio.`
      : PAGE_COPY.projectsPageDescription,
    path: ROUTES.projects,
    keywords: activeFilter ? [activeFilter] : ["projects", "portfolio", "software engineering", "applied AI"],
    noIndex: Boolean(activeFilter),
  });
}

export default async function ProjectsPage({ searchParams }: ProjectsPageProps) {
  const resolvedSearchParams = await Promise.resolve(searchParams ?? {});
  const activeTag = firstParam(resolvedSearchParams.tag);
  const activeCategory = firstParam(resolvedSearchParams.category);

  return (
    <section className="w-full ui-container ui-container-narrow py-4 sm:py-8 lg:py-12">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: "Projects",
              description: PAGE_COPY.projectsPageDescription,
              path: ROUTES.projects,
              image: DEFAULT_OG_IMAGE_PATH,
            }),
          ),
        }}
      />
      <div className="space-y-5 sm:space-y-7">
        <Header
          link={ROUTES.home}
          title={SECTION_TITLES.projects}
          description={PAGE_COPY.projectsPageDescription}
        />
        <ProjectsSection heading={false} initialTag={activeTag} initialCategory={activeCategory} />
      </div>
    </section>
  );
}