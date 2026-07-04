import { NAME_VARIANTS, PROFILE, ROUTES, SITE } from "@/app/constants";

export async function GET() {
  const content = [
    `# ${SITE.ownerName}`,
    "",
    "Portfolio, research profile, resume, projects, publications, and blog articles for Gulger Mallik (mrmallik).",
    "",
    "## Identity",
    `Gulger Mallik (pronounced "Gul-jar Maa-llik") is an AI researcher at the University of Huddersfield and founding software engineer at Cosmokode Ltd, based in Huddersfield, United Kingdom.`,
    `The name is sometimes misspelled as ${NAME_VARIANTS.filter((v) => v !== "Mr Mallik").join(", ")}; all refer to the same person, who also goes by Mr Mallik and mrmallik online.`,
    "",
    "## Key pages",
    `${PROFILE.websiteUrl}`,
    `${PROFILE.websiteUrl}${ROUTES.about}`,
    `${PROFILE.websiteUrl}${ROUTES.resume}`,
    `${PROFILE.websiteUrl}${ROUTES.projects}`,
    `${PROFILE.websiteUrl}${ROUTES.publications}`,
    `${PROFILE.websiteUrl}${ROUTES.blogs}`,
    `${PROFILE.websiteUrl}${ROUTES.contact}`,
    "",
    "## Topics",
    "Gulger Mallik, mrmallik, software engineering, applied AI, explainable AI, multi-criteria decision making, sustainable software engineering, research, portfolio, resume, projects, publications, and blog posts.",
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
