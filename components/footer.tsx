import Link from "next/link";
import { HugeiconsIcon } from "@hugeicons/react";
import { LinkedinIcon, Github01Icon } from "@hugeicons/core-free-icons";

import { PROFILE, ROUTES, SITE } from "@/app/constants";
import { ThemeToggle } from "@/components/theme-toggle";
import { brittanySignature } from "@/lib/fonts";

const NAV_LINKS = [
  { label: "About Me", href: ROUTES.about },
  { label: "Projects", href: ROUTES.projects },
  { label: "Blog", href: ROUTES.blogs },
  { label: "Publications", href: ROUTES.publications },
  { label: "Resume", href: ROUTES.resume },
];

const SOCIAL_LINKS = [
  { label: "LinkedIn", href: PROFILE.linkedInUrl, icon: LinkedinIcon },
  { label: "GitHub", href: PROFILE.githubUrl, icon: Github01Icon },
];

export function Footer() {
  return (
    <footer className="ui-footer w-full">
      <div className="px-6 md:px-10 lg:px-14 max-w-7xl mx-auto ui-control-text py-5 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        {/* Brand */}
        <Link
          href={ROUTES.home}
          className={`${brittanySignature.className} ui-brand-link ui-text-muted text-4xl shrink-0`}
        >
          {SITE.brandName}
        </Link>

        {/* Right column */}
        <div className="flex flex-col gap-2 sm:items-end">
          {/* Theme + social icons */}
          <div className="flex items-center gap-3">
            <span className="hidden sm:inline text-[var(--ui-text-muted)]">Theme:</span>
            <ThemeToggle />
            <span className="text-[var(--ui-border-soft)]">|</span>
            {SOCIAL_LINKS.map((s) => (
              <a
                key={s.label}
                href={s.href}
                target="_blank"
                rel="noreferrer"
                aria-label={s.label}
                className="text-[var(--ui-text-muted)] transition-colors hover:text-[var(--ui-text-primary)]"
              >
                <HugeiconsIcon icon={s.icon} className="h-4 w-4" />
              </a>
            ))}
          </div>

          {/* Nav links */}
          <div className="flex flex-wrap items-center gap-x-2 gap-y-1">
            {NAV_LINKS.map((link, i) => (
              <span key={link.href} className="flex items-center gap-2">
                {i > 0 && <span className="text-[var(--ui-border-soft)]">&bull;</span>}
                <Link
                  href={link.href}
                  className="text-[var(--ui-text-muted)] transition-colors hover:text-[var(--ui-text-primary)]"
                >
                  {link.label}
                </Link>
              </span>
            ))}
          </div>

          {/* Copyright */}
          <span className="text-[var(--ui-text-muted)] sm:text-right">
            &copy; {new Date().getFullYear()} {SITE.ownerName}. {SITE.copyrightSuffix}
          </span>
        </div>
      </div>
    </footer>
  );
}
