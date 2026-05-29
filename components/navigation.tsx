import Link from "next/link";
import localFont from "next/font/local";
import { ThemeToggle } from "./theme-toggle";
import { LINK_LABELS, ROUTES, SITE } from "@/app/constants";

const brittanySignature = localFont({
  src: "../public/fonts/BrittanySignature.ttf",
  fallback: ["cursive"],
  display: "swap",
});


export default function Navigation() {
  return (
    <nav className="hidden mb-4 w-full sm:block sm:mb-0">
      <div className="mx-auto flex w-full max-w-2xl flex-col gap-2 py-2 sm:flex-row sm:items-center sm:justify-between sm:py-3">
        <div className="flex min-w-0 items-center py-2">
          <Link
            href={ROUTES.home}
            className={`${brittanySignature.className} ui-brand-link ui-text-muted text-2xl leading-none sm:text-4xl`}
          >
            {SITE.brandName}
          </Link>
        </div>
        <div className="flex flex-wrap items-center gap-3 text-sm sm:gap-5">
          <Link
            href={ROUTES.home}
            className="ui-nav-link"
          >
            {LINK_LABELS.home}
          </Link>
          <ThemeToggle />
        </div>
      </div>
    </nav>
  );
}