import Link from "next/link";
import localFont from "next/font/local";

import { ROUTES, SITE } from "@/app/constants";
import {ThemeToggle} from "@/components/theme-toggle";

const brittanySignature = localFont({
  src: "../public/fonts/BrittanySignature.ttf",
  fallback: ["cursive"],
  display: "swap",
});

export function Footer() {
  return (
    <footer className="w-full px-4 pb-6 sm:px-6 lg:px-8">
      <div className="ui-footer ui-control-text mx-auto flex w-full max-w-2xl flex-row justify-between py-4 text-sm">
        <Link
          href={ROUTES.home}
          className={`${brittanySignature.className} ui-brand-link ui-text-muted text-2xl`}
        >
          {SITE.brandName}
        </Link>
        <div className="inline-flex items-center gap-2">
          <span>Theme:</span>
          
          <div className="">
            <ThemeToggle />
          </div>
          
          <span>&copy; {new Date().getFullYear()} {SITE.ownerName}. {SITE.copyrightSuffix}</span>
        </div>
      </div>
    </footer>
  );
}
