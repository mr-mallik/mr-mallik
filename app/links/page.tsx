import {
  ArrowUpRight01Icon,
  Briefcase01Icon,
  Globe02Icon,
  LinkedinIcon,
  Mail01Icon,
  UserAdd01Icon,
  YoutubeIcon,
} from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Link from "next/link";

import { MAIL, PAGE_COPY, PROFILE, ROUTES, SITE } from "@/app/constants";
import { FlipAvatar } from "@/components/flip-avatar";
import { Pronunciation } from "@/components/pronunciation";
import { Reveal } from "@/components/motion/reveal";
import { MotionAnchor } from "@/components/motion/motion-link";
import { brittanySignature } from "@/lib/fonts";
import {
  buildWebPageJsonLd,
  createPageMetadata,
  sanitizeJsonLd,
  DEFAULT_OG_IMAGE_PATH,
} from "@/app/seo";
import { buildContactVcard } from "@/lib/vcard";

const PAGE_DESCRIPTION = `Contact details and links for ${SITE.ownerName} - email, LinkedIn, YouTube, and website.`;

export const metadata = createPageMetadata({
  title: "Links",
  description: PAGE_DESCRIPTION,
  path: ROUTES.links,
  keywords: ["Gulger Mallik links", "mrmallik", "contact", "link in bio"],
});

const mailtoQuery = new URLSearchParams({
  subject: MAIL.subject,
  body: MAIL.bodyLines.join("\n"),
})
  .toString()
  .replace(/\+/g, "%20");

// Embedded in the flipped avatar's QR code so phone cameras offer to save the contact on scan.
const qrVcard = buildContactVcard({ compact: true });

const links = [
  {
    label: "Email",
    detail: PROFILE.primaryEmail,
    href: `mailto:${PROFILE.primaryEmail}?${mailtoQuery}`,
    icon: Mail01Icon,
    external: false,
  },
  {
    label: "Work Email",
    detail: PROFILE.workEmail,
    href: `mailto:${PROFILE.workEmail}?${mailtoQuery}`,
    icon: Briefcase01Icon,
    external: false,
  },
  {
    label: "LinkedIn",
    detail: PROFILE.linkedInDisplay,
    href: PROFILE.linkedInUrl,
    icon: LinkedinIcon,
    external: true,
  },
  {
    label: "Website",
    detail: PROFILE.websiteLabel,
    href: ROUTES.home,
    icon: Globe02Icon,
    external: false,
  },
  {
    label: "YouTube",
    detail: PROFILE.youtubeDisplay,
    href: PROFILE.youTubeUrl,
    icon: YoutubeIcon,
    external: true,
  },
];

export default function LinksPage() {
  return (
    <section className="relative flex min-h-dvh w-full justify-center overflow-hidden px-5 py-12 sm:py-16">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: `Links - ${SITE.ownerName}`,
              description: PAGE_DESCRIPTION,
              path: ROUTES.links,
              image: DEFAULT_OG_IMAGE_PATH,
              type: "ProfilePage",
            }),
          ),
        }}
      />

      {/* Beige backdrop echoing the about page card */}
      <div
        className="absolute inset-x-0 top-0 h-32 bg-[#eadfd2] sm:h-40 dark:bg-[#2a2420]"
        aria-hidden="true"
      />

      <div className="relative flex w-full max-w-md flex-col items-center">
        {/* Profile */}
        <Reveal index={0} scale className="flex flex-col items-center text-center">
          {/* Tap to flip to a contact QR code; ring uses the Cosmokode logo gradient */}
          <FlipAvatar
            src="/images/hero-image.png"
            alt={PROFILE.profileImageAlt}
            vcard={qrVcard}
            ringClassName="bg-linear-to-b from-[#f9a11b] via-[#e0457b] to-[#8b1ea8]"
          />
          <h1 className="mt-6 text-2xl font-bold tracking-tight text-[var(--ui-text-primary)]">
            {SITE.ownerName}
          </h1>
          <Pronunciation />
          <div className="mt-4 h-px w-10 bg-[var(--ui-accent)]" aria-hidden="true" />
          <p className="mt-4 text-xs uppercase tracking-[0.18em] text-[var(--ui-text-secondary)]">
            {PAGE_COPY.homepageRolePrefix} {PROFILE.affiliationName}
          </p>
        </Reveal>

        {/* Save contact - primary action */}
        <Reveal index={1} className="mt-9 w-full">
          <MotionAnchor
            href={ROUTES.contactCard}
            className="flex w-full items-center justify-center gap-2.5 rounded-full bg-[var(--ui-text-primary)] px-6 py-3.5 text-sm font-medium text-background transition-opacity hover:opacity-85"
            whileHover={{ scale: 1.02 }}
            whileTap={{ scale: 0.98 }}
          >
            <HugeiconsIcon icon={UserAdd01Icon} className="h-4.5 w-4.5" aria-hidden="true" />
            Save Contact
          </MotionAnchor>
        </Reveal>

        {/* Links */}
        <ul className="mt-4 flex w-full flex-col gap-3">
          {links.map((link, index) => (
            <Reveal key={link.label} as="li" index={index + 2}>
              <MotionAnchor
                href={link.href}
                {...(link.external ? { target: "_blank", rel: "noreferrer" } : {})}
                className="group flex items-center gap-4 rounded-2xl border border-[var(--ui-border-soft)] bg-background px-4 py-3.5 transition-colors hover:border-[var(--ui-accent)] hover:bg-[var(--ui-accent-muted)]"
                whileHover={{ y: -2 }}
                whileTap={{ scale: 0.98 }}
              >
                <span className="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[var(--ui-bg-elevated)] text-[var(--ui-text-primary)] transition-colors group-hover:text-[var(--ui-accent)]">
                  <HugeiconsIcon icon={link.icon} className="h-5 w-5" aria-hidden="true" />
                </span>
                <span className="flex min-w-0 flex-1 flex-col">
                  <span className="text-sm font-medium text-[var(--ui-text-primary)]">
                    {link.label}
                  </span>
                  <span className="truncate text-xs text-[var(--ui-text-muted)]">
                    {link.detail}
                  </span>
                </span>
                <HugeiconsIcon
                  icon={ArrowUpRight01Icon}
                  className="h-4 w-4 shrink-0 text-[var(--ui-text-muted)] transition-transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 group-hover:text-[var(--ui-accent)]"
                  aria-hidden="true"
                />
              </MotionAnchor>
            </Reveal>
          ))}
        </ul>

        {/* Signature */}
        <Reveal index={links.length + 2} className="mt-12">
          <Link
            href={ROUTES.home}
            className={`${brittanySignature.className} ui-brand-link text-4xl text-[var(--ui-text-muted)] transition-colors hover:text-[var(--ui-text-primary)]`}
          >
            {SITE.brandName}
          </Link>
        </Reveal>
      </div>
    </section>
  );
}
