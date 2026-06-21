import Link from "next/link";

import { ROUTES, SITE } from "@/app/constants";
import { ThemeToggle } from "@/components/theme-toggle";
import { brittanySignature } from "@/lib/fonts";

export function Footer() {
  return (
    <footer className="w-full px-4 pb-6 sm:px-6 lg:px-8">
      <div className="ui-footer ui-control-text mx-auto flex w-full max-w-6xl flex-col items-center gap-3 py-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-left">
        <Link
          href={ROUTES.home}
          className={`${brittanySignature.className} ui-brand-link ui-text-muted text-4xl`}
        >
          {SITE.brandName}
        </Link>
        <div className="flex flex-col items-center gap-2 sm:items-end">
          <div className="flex items-center gap-2">
            <span className="hidden sm:inline">Theme:</span>
            <ThemeToggle />
          </div>
          <span className="text-center sm:text-right">
            &copy; {new Date().getFullYear()} {SITE.ownerName}. {SITE.copyrightSuffix}
          </span>
        </div>
      </div>
    </footer>
  );
}
