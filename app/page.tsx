import { Github01Icon, LinkedinIcon, Mail } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Image from "next/image";
import Link from "next/link";

import { Showcase } from "@/components/showcase";
import { BlogsSection } from "@/components/blogs-section";
import { EducationSection } from "@/components/education-section";
import { ExperienceSection } from "@/components/experience-section";
import { ProjectsSection } from "@/components/projects-section";
import { PublicationsSection } from "@/components/publications-section";
import {
  EXTERNAL_LINKS,
  LINK_LABELS,
  MAIL,
  PAGE_COPY,
  PROFILE,
  ROUTES,
  SITE,
  SOCIAL_HANDLES,
} from "@/app/constants";
import { buildWebPageJsonLd, createPageMetadata, sanitizeJsonLd, SITE_DESCRIPTION, DEFAULT_OG_IMAGE_PATH } from "@/app/seo";

export const metadata = createPageMetadata({
  title: "AI Researcher, Software Engineer & Product Builder",
  description: SITE_DESCRIPTION,
  path: "/",
  keywords: ["Gulger Mallik", "mrmallik", "AI researcher", "software engineer", "portfolio"],
});

const mailtoQuery = new URLSearchParams({
  subject: MAIL.subject,
  body: MAIL.bodyLines.join("\n"),
}).toString().replace(/\+/g, "%20");

const mailtoLink = `mailto:${PROFILE.primaryEmail}?${mailtoQuery}`;

const socialLinks = [
  {
    name: "LinkedIn",
    handle: SOCIAL_HANDLES.linkedIn,
    href: PROFILE.linkedInUrl,
    icon: LinkedinIcon,
  },
  {
    name: "GitHub",
    handle: SOCIAL_HANDLES.github,
    href: PROFILE.githubUrl,
    icon: Github01Icon,
  },
  {
    name: "Mail",
    handle: PROFILE.primaryEmail,
    href: mailtoLink,
    icon: Mail,
  }
]

export default function Home() {
  return (
    <section className="relative mx-auto w-full max-w-2xl py-4">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: "AI Researcher, Software Engineer & Product Builder",
              description: SITE_DESCRIPTION,
              path: "/",
              image: DEFAULT_OG_IMAGE_PATH,
            }),
          ),
        }}
      />
      <div className="space-y-10 sm:space-y-14">
        <header className="space-y-6">
          {/* Avatar + identity block */}
          <div className="hero-fade-in flex items-center gap-5" style={{ animationDelay: "0ms" }}>
            <div className="relative shrink-0 group cursor-default">
              {/* Ambient glow on hover */}
              <div className="absolute inset-0 scale-125 rounded-full bg-blue-300/30 blur-lg opacity-0 transition-opacity duration-500 group-hover:opacity-100 dark:bg-blue-500/20" />
              {/* Photo with ring */}
              <div className="relative h-[72px] w-[72px] overflow-hidden rounded-full shadow-md ring-2 ring-blue-200/60 ring-offset-2 ring-offset-background transition-all duration-300 group-hover:ring-blue-300/90 group-hover:shadow-blue-100/60 dark:ring-blue-800/50 dark:ring-offset-background dark:group-hover:ring-blue-600/70">
                <Image
                  src="/images/gulger-mallik@1x1.png"
                  alt={PROFILE.profileImageAlt}
                  width={72}
                  height={72}
                  className="rounded-full transition-transform duration-500 group-hover:scale-[1.06]"
                  priority
                />
              </div>
            </div>
            <div>
              <h1 className="hero-name">
                {SITE.ownerName}
              </h1>
              <p className="hero-role mt-1">
                {PAGE_COPY.homepageRolePrefix}{" "}
                <Link href={PROFILE.affiliationUrl} target="_blank" rel="noreferrer" className="hero-affiliation">
                  {PROFILE.affiliationName}
                </Link>
              </p>
            </div>
          </div>

          {/* Founding engineer intro — higher visual weight */}
          <p className="hero-intro hero-fade-in" style={{ animationDelay: "90ms" }}>
            {PAGE_COPY.homeIntroCompanyPrefix}{" "}
            <Link
              href={EXTERNAL_LINKS.cosmokode}
              target="_blank"
              rel="noreferrer"
              className="hero-inline-link"
            >
              Cosmokode Ltd
            </Link>{" "}
            {PAGE_COPY.homeIntroCompanySuffix}
          </p>

          <p className="ui-body-text text-sm sm:text-base hero-fade-in" style={{ animationDelay: "180ms" }}>
            {PAGE_COPY.homePreviousPrefix}{" "}
            <Link
              href={PROFILE.linkedInUrl}
              target="_blank"
              rel="noreferrer"
              className="hero-inline-link"
            >
              product teams
            </Link>{" "}
            {PAGE_COPY.homePreviousSuffix}{" "}
            <Link
              href={mailtoLink}
              className="hero-inline-icon-link"
            >
              <HugeiconsIcon icon={Mail} className="h-4 w-4 shrink-0" aria-hidden="true" /> email
            </Link>{" "}
            {PAGE_COPY.homeCodePrefix}{" "}
            <Link
              href={PROFILE.githubUrl}
              target="_blank"
              rel="noreferrer"
              className="hero-inline-icon-link"
            >
              <HugeiconsIcon icon={Github01Icon} className="h-4 w-4 shrink-0" aria-hidden="true" /> GitHub
            </Link>
            .
            {" "}{PAGE_COPY.homeResumePrefix}{" "}
            <Link
              href={ROUTES.resume}
              className="hero-inline-link"
            >
              {LINK_LABELS.pdfFormat}
            </Link>
            {" "}{PAGE_COPY.homeResumeSuffix}.
          </p>

          <p className="ui-body-text text-sm sm:text-base hero-fade-in" style={{ animationDelay: "250ms" }}>
            {PAGE_COPY.homeResearchPrefix}{" "}
            <Link
              href={PROFILE.orcidUrl}
              target="_blank"
              rel="noreferrer"
              className="hero-inline-link"
            >
              ORCiD
            </Link>
            .
          </p>

          <p className="ui-body-text text-sm sm:text-base hero-fade-in" style={{ animationDelay: "320ms" }}>
            {PAGE_COPY.homeBlogPrefix}{" "}
            <Link
              href={ROUTES.blogs}
              className="hero-inline-link"
            >
              {LINK_LABELS.blogs}
            </Link>
            {PAGE_COPY.homeBlogSuffix}
          </p>

        </header>

        <ProjectsSection limit={2} showViewAllLink />

        <ExperienceSection showViewAllLink />

        <EducationSection />

        <PublicationsSection limit={3} showViewAllLink />

        <Showcase />

        <BlogsSection limit={3} showViewAllLink />

        <section className="space-y-5">
          <p className="ui-body-text text-sm sm:text-base">
            {PAGE_COPY.homeSocialParagraph}
          </p>

          <div className="flex items-center gap-6 flex-wrap">
            {socialLinks.map((link) => (
              <Link
                key={link.name}
                href={link.href}
                target="_blank"
                rel="noreferrer"
                className="ui-link-subtle inline-flex items-center gap-1 align-middle"
              >
                <HugeiconsIcon icon={link.icon} className="h-4 w-4 shrink-0" aria-hidden="true" /> {link.handle}
              </Link>
            ))}
          </div>
        </section>
      </div>
    </section>
  );
}
