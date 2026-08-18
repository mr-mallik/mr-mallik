import { readFileSync } from "node:fs";
import path from "node:path";

import { LinkedinIcon, Github01Icon, Mail, IdIcon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Link from "next/link";

import {
  EXTERNAL_LINKS,
  MAIL,
  PAGE_COPY,
  PROFILE,
  ROUTES,
  SITE,
} from "@/app/constants";
import { FlipAvatar } from "@/components/flip-avatar";
import { Pronunciation } from "@/components/pronunciation";
import { Reveal } from "@/components/motion/reveal";
import { Parallax } from "@/components/motion/parallax";
import { MotionLink } from "@/components/motion/motion-link";
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

// Contact card served from public/cards/gulger.vcf; its content is embedded in the
// QR code on the flipped avatar so phones offer to save the contact directly on scan.
const contactVcard = readFileSync(
  path.join(process.cwd(), "public", "cards", "gulger.vcf"),
  "utf8",
);

const socialLinks = [
  { name: "LinkedIn", href: PROFILE.linkedInUrl, icon: LinkedinIcon },
  { name: "GitHub", href: PROFILE.githubUrl, icon: Github01Icon },
  { name: "Email", href: mailtoLink, icon: Mail },
  { name: "ORCiD", href: PROFILE.orcidUrl, icon: IdIcon },
];

export default function AboutPage() {
  return (
    <section className="relative w-full ui-container py-4 sm:py-8 lg:py-12">
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

      <div className="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
        {/* Profile card over beige backdrop */}
        <Reveal index={0} direction="left" className="relative flex justify-center py-10 sm:py-14">
          <Parallax
            offset={16}
            className="absolute inset-y-0 inset-x-0 bg-[#eadfd2] sm:right-16 dark:bg-[#2a2420]"
            aria-hidden="true"
          />
          <div className="relative w-[280px] bg-[#f7f2ec] shadow-xl sm:w-[320px] sm:translate-x-6 dark:bg-[#1f1b18]">
            <div className="flex flex-col items-center px-8 pb-9 pt-10 text-center">
              <FlipAvatar
                src="/images/hero-image.png"
                alt={PROFILE.profileImageAlt}
                vcard={contactVcard}
              />
              <h1 className="mt-8 text-xl font-bold tracking-tight text-[var(--ui-text-primary)]">
                Mr. {SITE.ownerName}
              </h1>
              <Pronunciation />
              <div className="mt-5 h-px w-10 bg-[var(--ui-text-primary)]" aria-hidden="true" />
              <p className="mt-5 text-sm uppercase tracking-[0.18em] text-[var(--ui-text-secondary)]">
                Researcher :{" "}
                <Link
                  href={PROFILE.affiliationUrl}
                  target="_blank"
                  rel="noreferrer"
                  className="transition-colors hover:text-[var(--ui-text-primary)]"
                >
                  {PROFILE.affiliationName}
                </Link>
              </p>
            </div>
            <div className="flex items-center justify-center gap-9 bg-white py-4 dark:bg-[#171310]">
              {socialLinks.map((link) => (
                <Link
                  key={link.name}
                  href={link.href}
                  target="_blank"
                  rel="noreferrer"
                  aria-label={link.name}
                  className="text-[var(--ui-text-primary)] transition-opacity hover:opacity-60"
                >
                  <HugeiconsIcon icon={link.icon} className="h-5 w-5" aria-hidden="true" />
                </Link>
              ))}
            </div>
          </div>
        </Reveal>

        {/* Greeting + narrative */}
        <div className="space-y-5">
          <Reveal as="p" index={1} className="font-serif text-6xl text-[var(--ui-text-primary)] sm:text-7xl">
            Hello
          </Reveal>
          <Reveal as="div" index={2} className="pt-2">
            <h2 className="text-2xl font-medium text-[var(--ui-text-primary)]">
              A Bit About Me
            </h2>
          </Reveal>

          <Reveal as="p" index={3} className="ui-body-text">
            I am <strong className="text-[var(--ui-text-primary)]">{SITE.ownerName}</strong>,{" "}
            {PAGE_COPY.homeIntroCompanyPrefix.replace("I'm ", "")}{" "}
            <Link
              href={EXTERNAL_LINKS.cosmokode}
              target="_blank"
              rel="noreferrer"
              className="hero-inline-link"
            >
              Cosmokode Ltd
            </Link>{" "}
            {PAGE_COPY.homeIntroCompanySuffix}
          </Reveal>

          <Reveal as="p" index={4} className="ui-body-text">
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
            and write about software, AI, and building things responsibly on my{" "}
            <Link href={ROUTES.blogs} className="hero-inline-link">
              blog
            </Link>
            .
          </Reveal>

          <Reveal index={5} className="flex flex-wrap items-center gap-4 pt-3">
            <MotionLink
              href={ROUTES.resume}
              className="flex items-center rounded-full bg-[var(--ui-text-primary)] px-8 py-3 text-sm font-medium text-background transition-opacity hover:opacity-80"
              whileHover={{ scale: 1.04 }}
              whileTap={{ scale: 0.97 }}
            >
              Resume
            </MotionLink>
            <MotionLink
              href={ROUTES.projects}
              className="flex items-center rounded-full border border-[var(--ui-border-soft)] px-8 py-3 text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:border-[var(--ui-text-muted)] hover:text-[var(--ui-text-primary)]"
              whileHover={{ scale: 1.04 }}
              whileTap={{ scale: 0.97 }}
            >
              Projects
            </MotionLink>
          </Reveal>
        </div>
      </div>
    </section>
  );
}
