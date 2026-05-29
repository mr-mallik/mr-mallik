import { Github01Icon, LinkedinIcon, Mail } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Image from "next/image";
import Link from "next/link";

import { Showcase } from "@/components/showcase";
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
    <section className="mx-auto w-full max-w-2xl py-4">
      <div className="space-y-10 sm:space-y-14">
        <header className="space-y-6">
          <div className="flex items-center gap-4">
            <div className="h-12 w-12 rounded-full bg-gradient-to-br from-slate-200 to-slate-400 shadow-sm dark:from-slate-600 dark:to-slate-800">
              <Image
                src="/images/gulger-mallik@1x1.webp"
                alt={PROFILE.profileImageAlt}
                width={48}
                height={48}
                className="rounded-full"
              />
            </div>
            <div>
              <h1 className="ui-item-title text-base sm:text-lg">
                {SITE.ownerName}
              </h1>
              <p className="ui-control-text sm:text-base">
                {PAGE_COPY.homepageRolePrefix}{" "}
                <Link href={PROFILE.affiliationUrl} target="_blank" rel="noreferrer">
                  {PROFILE.affiliationName}
                </Link>
              </p>
            </div>
          </div>

          <p className="ui-body-text text-sm sm:text-base">
            {PAGE_COPY.homeIntroCompanyPrefix}{" "}
            <Link
              href={EXTERNAL_LINKS.cosmokode}
              target="_blank"
              rel="noreferrer"
              className="ui-link-subtle"
            >
              Cosmokode Ltd
            </Link>{" "}
            {PAGE_COPY.homeIntroCompanySuffix}
          </p>

          <p className="ui-body-text text-sm sm:text-base">
            {PAGE_COPY.homePreviousPrefix}{" "}
            <Link 
              href={PROFILE.linkedInUrl}
              target="_blank"
              rel="noreferrer"
              className="ui-link-subtle"
              >
              product teams
            </Link>{" "}
            {PAGE_COPY.homePreviousSuffix}{" "}
            <Link
              href={mailtoLink}
              className="ui-link-subtle inline-flex items-center gap-1 align-middle"
            >
              <HugeiconsIcon icon={Mail} className="h-4 w-4 shrink-0" aria-hidden="true" /> email
            </Link>{" "}
            {PAGE_COPY.homeCodePrefix}{" "}
            <Link
              href={PROFILE.githubUrl}
              target="_blank"
              rel="noreferrer"
              className="ui-link-subtle inline-flex items-center gap-1 align-middle"
            >
              <HugeiconsIcon icon={Github01Icon} className="h-4 w-4 shrink-0" aria-hidden="true" /> GitHub
            </Link>
            .
            {" "}{PAGE_COPY.homeResumePrefix}{" "}
            <Link
              href={ROUTES.resume}
              className="ui-link-subtle inline-flex items-center gap-1 align-middle"
            >
              {LINK_LABELS.pdfFormat}
            </Link>
            .
          </p>

          <p className="ui-body-text text-sm sm:text-base">
            {PAGE_COPY.homeResearchPrefix}{" "}
            <Link
              href={PROFILE.orcidUrl}
              target="_blank"
              rel="noreferrer"
              className="ui-link-subtle"
            >
              ORCiD
            </Link>
            .
          </p>

          <p className="ui-body-text text-sm sm:text-base">
            {PAGE_COPY.homeBlogPrefix}{" "}
            <Link
              href={ROUTES.blogs}
              target="_blank"
              rel="noreferrer"
              className="ui-link-subtle"
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
