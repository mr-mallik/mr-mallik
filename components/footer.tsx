import Link from "next/link";
import { HugeiconsIcon } from "@hugeicons/react";
import { LinkedinIcon, Github01Icon } from "@hugeicons/core-free-icons";

import { PROFILE, ROUTES, SITE } from "@/app/constants";
import { brittanySignature } from "@/lib/fonts";

const SOCIAL_LINKS = [
  { label: "LinkedIn", href: PROFILE.linkedInUrl, icon: LinkedinIcon },
  { label: "GitHub", href: PROFILE.githubUrl, icon: Github01Icon },
];

export function Footer() {
  return (
    <footer className="ui-footer w-full">
      <div className="ui-container ui-control-text py-5 flex flex-col items-center gap-4 text-center sm:flex-row sm:items-start sm:justify-between sm:text-left">
        <Link
          href={ROUTES.home}
          className={`${brittanySignature.className} ui-brand-link ui-text-muted text-4xl shrink-0`}
        >
          {SITE.brandName}
        </Link>

        {/* Right column */}
        <div className="flex flex-col items-center gap-2 sm:items-end">
          {/* Theme + social icons */}
          <div className="flex flex-wrap items-center justify-center gap-3 sm:justify-end">
            <span className="text-[var(--ui-text-muted)]">
              &copy; {new Date().getFullYear()} {SITE.ownerName}. {SITE.copyrightSuffix}
            </span>
            <span className="hidden sm:inline text-[var(--ui-border-soft)]">|</span>
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

        </div>
      </div>
    </footer>
  );
}
