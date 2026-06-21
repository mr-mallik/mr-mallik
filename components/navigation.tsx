"use client";

import { useEffect, useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { ThemeToggle } from "./theme-toggle";
import { ROUTES, SITE } from "@/app/constants";

const NAV_LINKS = [
  { label: "Blog", href: ROUTES.blogs },
  { label: "Projects", href: ROUTES.projects },
  { label: "Publications", href: ROUTES.publications },
  { label: "Resume", href: ROUTES.resume },
] as const;

export default function Navigation() {
  const [mobileOpen, setMobileOpen] = useState(false);
  const pathname = usePathname();

  useEffect(() => {
    document.body.style.overflow = mobileOpen ? "hidden" : "";
    return () => {
      document.body.style.overflow = "";
    };
  }, [mobileOpen]);

  const close = () => setMobileOpen(false);

  return (
    <>
      <nav className="sticky top-0 z-30 w-full border-b border-[var(--ui-border-subtle)] bg-background/90 px-4 backdrop-blur-sm sm:px-6 lg:px-8">
        <div className="mx-auto flex w-full max-w-6xl items-center justify-between py-3 sm:py-4">
          {/* Logo */}
          <Link
            href={ROUTES.home}
            className="ui-brand-link shrink-0 flex items-center gap-2 rounded-lg px-2 py-1 transition-colors duration-150 hover:bg-[var(--ui-border-subtle)]"
            onClick={close}
            aria-label="MR. MALLIK — home"
          >
            <Image
              src="/logo.png"
              alt="MR. MALLIK"
              width={36}
              height={36}
              className="h-9 w-9 sm:h-10 sm:w-10 dark:invert"
              priority
            />
            {/* <h1 className="ml-1 text-3xl font-bold">Dr. Mallik</h1> */}
          </Link>

          <div className="flex items-center gap-2 sm:gap-3">
            {/* Desktop nav links */}
            <div className="hidden items-center gap-4 sm:flex">
              {NAV_LINKS.map((link) => (
                <Link
                  key={link.href}
                  href={link.href}
                  className={`ui-nav-link${pathname.startsWith(link.href) ? " ui-nav-active" : ""}`}
                >
                  {link.label}
                </Link>
              ))}
            </div>

            {/* <ThemeToggle /> */}

            {/* Hamburger — mobile only */}
            <button
              type="button"
              onClick={() => setMobileOpen((open) => !open)}
              aria-expanded={mobileOpen}
              aria-label={mobileOpen ? "Close navigation menu" : "Open navigation menu"}
              className="ui-theme-toggle sm:hidden"
            >
              <svg
                width="18"
                height="18"
                viewBox="0 0 18 18"
                fill="none"
                stroke="currentColor"
                strokeWidth="1.8"
                strokeLinecap="round"
                aria-hidden="true"
              >
                <line x1="2" y1="5" x2="16" y2="5" />
                <line x1="2" y1="9" x2="16" y2="9" />
                <line x1="2" y1="13" x2="16" y2="13" />
              </svg>
            </button>
          </div>
        </div>
      </nav>

      {/* Backdrop */}
      <div
        className={`fixed inset-0 z-40 bg-black/30 backdrop-blur-[2px] transition-opacity duration-300 sm:hidden ${
          mobileOpen ? "opacity-100" : "pointer-events-none opacity-0"
        }`}
        onClick={close}
        aria-hidden="true"
      />

      {/* Right-side drawer */}
      <div
        className={`fixed right-0 top-0 z-50 flex h-full w-64 flex-col border-l border-[var(--ui-border-subtle)] bg-background shadow-2xl transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] sm:hidden ${
          mobileOpen ? "translate-x-0" : "translate-x-full"
        }`}
        aria-label="Navigation menu"
        role="dialog"
        aria-modal="true"
      >
        {/* Drawer header */}
        <div className="flex items-center justify-between border-b border-[var(--ui-border-subtle)] px-4 py-3">
          <span className="ui-meta-text font-medium uppercase tracking-widest">Menu</span>
          <button
            type="button"
            onClick={close}
            aria-label="Close navigation menu"
            className="ui-theme-toggle"
          >
            <svg
              width="18"
              height="18"
              viewBox="0 0 18 18"
              fill="none"
              stroke="currentColor"
              strokeWidth="1.8"
              strokeLinecap="round"
              aria-hidden="true"
            >
              <line x1="3" y1="3" x2="15" y2="15" />
              <line x1="15" y1="3" x2="3" y2="15" />
            </svg>
          </button>
        </div>

        {/* Drawer nav links */}
        <nav className="flex flex-col px-2 py-3">
          {NAV_LINKS.map((link) => (
            <Link
              key={link.href}
              href={link.href}
              onClick={close}
              className={`rounded-lg px-3 py-3 text-sm font-medium transition-colors duration-150 ${
                pathname.startsWith(link.href)
                  ? "bg-[var(--ui-border-subtle)] text-[var(--ui-text-primary)]"
                  : "text-[var(--ui-text-muted)] hover:bg-[var(--ui-border-subtle)] hover:text-[var(--ui-text-primary)]"
              }`}
            >
              {link.label}
            </Link>
          ))}
        </nav>
      </div>
    </>
  );
}
