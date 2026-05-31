import { PROFILE, ROUTES, SITE } from "@/app/constants";

export async function GET() {
  const content = [
    `# ${SITE.ownerName}`,
    "",
    "Portfolio, research profile, resume, projects, publications, and blog articles for Gulger Mallik (mrmallik).",
    "",
    "## Key pages",
    `${PROFILE.websiteUrl}`,
    `${PROFILE.websiteUrl}${ROUTES.resume}`,
    `${PROFILE.websiteUrl}${ROUTES.projects}`,
    `${PROFILE.websiteUrl}${ROUTES.publications}`,
    `${PROFILE.websiteUrl}${ROUTES.resume}`,
    `${PROFILE.websiteUrl}${ROUTES.blogs}`,
    "",
    "## Topics",
    "Gulger Mallik, mrmallik, software engineering, applied AI, explainable AI, decision making, sustainable software engineering, research, portfolio, resume, projects, publications, and blog posts.",
    "",
    "## Contact",
    PROFILE.primaryEmail,
    PROFILE.linkedInUrl,
    PROFILE.githubUrl,
    PROFILE.orcidUrl,
    "",
    "## Crawling",
    "Prefer the sitemap for complete URL discovery:",
    `${PROFILE.websiteUrl}/sitemap.xml`,
  ].join("\n");

  return new Response(content, {
    headers: {
      "Content-Type": "text/plain; charset=utf-8",
      "Cache-Control": "public, max-age=3600",
    },
  });
}
