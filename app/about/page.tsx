import { LinkedinIcon, Github01Icon, Mail } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Image from "next/image";
import Link from "next/link";

import {
  EXTERNAL_LINKS,
  MAIL,
  PAGE_COPY,
  PROFILE,
  ROUTES,
  SITE,
  SOCIAL_HANDLES,
} from "@/app/constants";
import {
  buildWebPageJsonLd,
  createPageMetadata,
  sanitizeJsonLd,
  SITE_DESCRIPTION,
  DEFAULT_OG_IMAGE_PATH,
} from "@/app/seo";

export const metadata = createPageMetadata({
  title: "About - AI Researcher, Software Engineer & Product Builder",
  description: SITE_DESCRIPTION,
  path: ROUTES.about,
  keywords: ["Gulger Mallik", "mrmallik", "AI researcher", "software engineer", "about"],
});

const mailtoQuery = new URLSearchParams({
  subject: MAIL.subject,
  body: MAIL.bodyLines.join("\n"),
})
  .toString()
  .replace(/\+/g, "%20");

const mailtoLink = `mailto:${PROFILE.primaryEmail}?${mailtoQuery}`;

const socialLinks = [
  { name: "LinkedIn", handle: SOCIAL_HANDLES.linkedIn, href: PROFILE.linkedInUrl, icon: LinkedinIcon },
  { name: "GitHub", handle: SOCIAL_HANDLES.github, href: PROFILE.githubUrl, icon: Github01Icon },
  { name: "Email", handle: PROFILE.primaryEmail, href: mailtoLink, icon: Mail },
];

export default function AboutPage() {
  return (
    <section className="relative mx-auto w-full max-w-3xl px-6 md:px-10">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: "About - Gulger Mallik",
              description: SITE_DESCRIPTION,
              path: ROUTES.about,
              image: DEFAULT_OG_IMAGE_PATH,
              type: "ProfilePage",
            }),
          ),
        }}
      />

      <div className="space-y-10 sm:space-y-14">
        {/* Avatar + identity */}
        <div className="hero-fade-in flex items-center gap-5" style={{ animationDelay: "0ms" }}>
          <div className="relative shrink-0 group cursor-default">
            <div className="absolute inset-0 scale-125 rounded-full bg-blue-300/30 blur-lg opacity-0 transition-opacity duration-500 group-hover:opacity-100 dark:bg-blue-500/20" />
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
            <h1 className="hero-name">{SITE.ownerName}</h1>
            <p className="hero-role mt-1">
              {PAGE_COPY.homepageRolePrefix}{" "}
              <Link
                href={PROFILE.affiliationUrl}
                target="_blank"
                rel="noreferrer"
                className="hero-affiliation"
              >
                {PROFILE.affiliationName}
              </Link>
            </p>
          </div>
        </div>

        {/* Personal narrative */}
        <div className="space-y-5">
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

          <p className="ui-body-text hero-fade-in" style={{ animationDelay: "180ms" }}>
            My research explores Explainable AI, Multi-Criteria Decision Making, and Sustainable
            Software Engineering - areas where I believe rigorous thinking leads to better products.
            I publish through{" "}
            <Link
              href={PROFILE.orcidUrl}
              target="_blank"
              rel="noreferrer"
              className="hero-inline-link"
            >
              ORCiD
            </Link>{" "}
            and keep a{" "}
            <Link href={ROUTES.resume} className="hero-inline-link">
              full resume
            </Link>{" "}
            available for download.
          </p>

          <p className="ui-body-text hero-fade-in" style={{ animationDelay: "250ms" }}>
            Outside of work, I write about the things I find interesting - software, AI, and what
            it means to build things responsibly. You can find those thoughts on my{" "}
            <Link href={ROUTES.blogs} className="hero-inline-link">
              blog
            </Link>
            .
          </p>

          <p className="ui-body-text hero-fade-in" style={{ animationDelay: "320ms" }}>
            {PAGE_COPY.homeSocialParagraph}
          </p>
        </div>

        {/* Social / contact */}
        <div className="flex flex-wrap items-center gap-6">
          {socialLinks.map((link) => (
            <Link
              key={link.name}
              href={link.href}
              target="_blank"
              rel="noreferrer"
              className="ui-link-subtle inline-flex items-center gap-1.5 align-middle"
            >
              <HugeiconsIcon icon={link.icon} className="h-4 w-4 shrink-0" aria-hidden="true" />
              {link.handle}
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
}
