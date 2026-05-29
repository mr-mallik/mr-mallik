import Link from "next/link";
import localFont from "next/font/local";

import { ROUTES, SITE } from "@/app/constants";

const brittanySignature = localFont({
  src: "../public/fonts/BrittanySignature.ttf",
  fallback: ["cursive"],
  display: "swap",
});

export function Footer() {
  return (
    <footer className="w-full px-4 pb-6 sm:px-6 lg:px-8">
      <div className="ui-control-text mx-auto flex w-full max-w-2xl flex-row justify-between py-4 text-sm">
        <Link
          href={ROUTES.home}
          className={`${brittanySignature.className} ui-text-muted text-2xl`}
        >
          {SITE.brandName}
        </Link>
        <div>
          &copy; {new Date().getFullYear()} {SITE.ownerName}. {SITE.copyrightSuffix}
        </div>
      </div>
    </footer>
  );
}
