import Link from "next/link";
import localFont from "next/font/local";
import { ThemeToggle } from "./theme-toggle";

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
            href="/"
            className={`${brittanySignature.className} text-2xl leading-none text-gray-400 sm:text-4xl dark:text-slate-500`}
          >
            mr mallik
          </Link>
        </div>
        <div className="flex flex-wrap items-center gap-3 text-sm sm:gap-5">
          <Link
            href="/"
            className="text-gray-500 transition hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100"
          >
            Home
          </Link>
          <ThemeToggle />
        </div>
      </div>
    </nav>
  );
}