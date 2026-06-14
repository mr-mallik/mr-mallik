"use client";

import { useState } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { ThemeToggle } from "./theme-toggle";
import { ROUTES, SITE } from "@/app/constants";
import { brittanySignature } from "@/lib/fonts";

const NAV_LINKS = [
  { label: "Blog", href: ROUTES.blogs },
  { label: "Projects", href: ROUTES.projects },
  { label: "Publications", href: ROUTES.publications },
  { label: "Resume", href: ROUTES.resume },
] as const;

export default function Navigation() {
  const [mobileOpen, setMobileOpen] = useState(false);
  const pathname = usePathname();

  return (
    <nav className="w-full px-4 sm:px-6 lg:px-8">
      <div className="mx-auto flex w-full max-w-2xl flex-col py-2 sm:py-3">
        {/* Top bar — always visible */}
        <div className="flex items-center justify-between">
          <Link
            href={ROUTES.home}
            className={`${brittanySignature.className} ui-brand-link ui-text-muted text-2xl leading-none sm:text-4xl`}
            onClick={() => setMobileOpen(false)}
          >
            {SITE.brandName}
          </Link>

          <div className="flex items-center gap-2 sm:gap-3">
            {/* Desktop nav links */}
            <div className="hidden items-center gap-4 sm:flex">
              {NAV_LINKS.map((link) => (
                <Link
                  key={link.href}
                  href={link.href}
                  className={`ui-nav-link${pathname.startsWith(link.href) ? " text-[var(--ui-text-primary)]" : ""}`}
                >
                  {link.label}
                </Link>
              ))}
            </div>

            <ThemeToggle />

            {/* Mobile hamburger */}
            <button
              type="button"
              onClick={() => setMobileOpen((open) => !open)}
              aria-expanded={mobileOpen}
              aria-label={mobileOpen ? "Close navigation menu" : "Open navigation menu"}
              className="ui-theme-toggle sm:hidden"
            >
              {mobileOpen ? (
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" aria-hidden="true">
                  <line x1="3" y1="3" x2="15" y2="15" />
                  <line x1="15" y1="3" x2="3" y2="15" />
                </svg>
              ) : (
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" aria-hidden="true">
                  <line x1="2" y1="5" x2="16" y2="5" />
                  <line x1="2" y1="9" x2="16" y2="9" />
                  <line x1="2" y1="13" x2="16" y2="13" />
                </svg>
              )}
            </button>
          </div>
        </div>

        {/* Mobile dropdown — slides in below top bar */}
        {mobileOpen && (
          <div className="mt-1 flex flex-col border-t border-[var(--ui-border-subtle)] pt-1 sm:hidden">
            {NAV_LINKS.map((link) => (
              <Link
                key={link.href}
                href={link.href}
                onClick={() => setMobileOpen(false)}
                className={`ui-nav-link py-2.5 text-sm${pathname.startsWith(link.href) ? " text-[var(--ui-text-primary)]" : ""}`}
              >
                {link.label}
              </Link>
            ))}
          </div>
        )}
      </div>
    </nav>
  );
}
