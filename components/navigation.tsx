"use client";

import { useEffect, useState } from "react";
import Image from "next/image";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { AnimatePresence, motion } from "motion/react";
import { ROUTES } from "@/app/constants";

const NAV_LINKS = [
  { label: "Home", href: ROUTES.home },
  { label: "About Me", href: ROUTES.about },
  { label: "Blog", href: ROUTES.blogs },
  { label: "Projects", href: ROUTES.projects },
  { label: "Publications", href: ROUTES.publications },
  { label: "Resume", href: ROUTES.resume },
  { label: "Contact", href: ROUTES.contact },
] as const;

const EASE_SPRING = [0.16, 1, 0.3, 1] as const;

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

  const isActive = (href: string) => (href === "/" ? pathname === "/" : pathname.startsWith(href));

  return (
    <>
      <nav className="sticky top-0 z-30 border-b border-[var(--ui-border-subtle)] bg-background/90 backdrop-blur-sm">
        <div className="mx-auto max-w-7xl flex items-center justify-between py-2 sm:py-2 md:py-3 lg:py-4 px-6 md:px-10 lg:px-14">
          <motion.div whileHover={{ scale: 1.04 }} whileTap={{ scale: 0.96 }}>
            <Link
              href={ROUTES.home}
              className="ui-brand-link shrink-0 flex items-center gap-2 rounded-lg px-2 py-1 transition-colors duration-150 hover:bg-[var(--ui-border-subtle)]"
              onClick={close}
              aria-label="MR. MALLIK - home"
            >
              <Image
                src="/logo.png"
                alt="MR. MALLIK"
                width={36}
                height={36}
                className="h-6 w-6 sm:h-7 sm:w-7 lg:h-8 lg:w-8 rounded-full"
                priority
              />

              <span className="ui-brand-text text-lg lg:text-2xl font-bold tracking-widest uppercase whitespace-nowrap">
                Gulger <span style={{ color: "var(--ui-accent)" }}>Mallik</span>
              </span>
            </Link>
          </motion.div>

          <div className="flex items-center gap-2 sm:gap-3">
            {/* Desktop nav links */}
            <div className="hidden items-center gap-2.5 md:flex lg:gap-4">
              {NAV_LINKS.map((link) => {
                const active = isActive(link.href);
                return (
                  <Link
                    key={link.href}
                    href={link.href}
                    className={`ui-nav-link relative whitespace-nowrap ${active ? "ui-nav-active" : ""}`}
                  >
                    {link.label}
                    {active ? (
                      <motion.span
                        layoutId="nav-active-indicator"
                        className="absolute inset-x-0 -bottom-1 h-[2px] rounded-full"
                        style={{ backgroundColor: "var(--ui-accent)" }}
                        transition={{ type: "spring", stiffness: 380, damping: 32 }}
                      />
                    ) : null}
                  </Link>
                );
              })}
            </div>

            {/* <ThemeToggle /> */}

            <button
              type="button"
              onClick={() => setMobileOpen((open) => !open)}
              aria-expanded={mobileOpen}
              aria-label={mobileOpen ? "Close navigation menu" : "Open navigation menu"}
              className="ui-theme-toggle md:hidden"
            >
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true">
                <motion.line
                  x1="2" y1="5" x2="16" y2="5"
                  stroke="currentColor" strokeWidth="1.8" strokeLinecap="round"
                  initial={false}
                  animate={mobileOpen ? { x1: 3, y1: 3, x2: 15, y2: 15 } : { x1: 2, y1: 5, x2: 16, y2: 5 }}
                  transition={{ duration: 0.25, ease: EASE_SPRING }}
                />
                <motion.line
                  x1="2" y1="9" x2="16" y2="9"
                  stroke="currentColor" strokeWidth="1.8" strokeLinecap="round"
                  animate={{ opacity: mobileOpen ? 0 : 1 }}
                  transition={{ duration: 0.15 }}
                />
                <motion.line
                  x1="2" y1="13" x2="16" y2="13"
                  stroke="currentColor" strokeWidth="1.8" strokeLinecap="round"
                  initial={false}
                  animate={mobileOpen ? { x1: 3, y1: 15, x2: 15, y2: 3 } : { x1: 2, y1: 13, x2: 16, y2: 13 }}
                  transition={{ duration: 0.25, ease: EASE_SPRING }}
                />
              </svg>
            </button>
          </div>
        </div>
      </nav>

      <AnimatePresence>
        {mobileOpen ? (
          <>
            {/* Backdrop */}
            <motion.div
              className="fixed inset-0 z-40 bg-black/30 backdrop-blur-[2px] md:hidden"
              onClick={close}
              aria-hidden="true"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              transition={{ duration: 0.25 }}
            />

            {/* Right-side drawer */}
            <motion.div
              className="fixed right-0 top-0 z-50 flex h-full w-64 flex-col border-l border-[var(--ui-border-subtle)] bg-background shadow-2xl md:hidden"
              aria-label="Navigation menu"
              role="dialog"
              aria-modal="true"
              initial={{ x: "100%" }}
              animate={{ x: 0 }}
              exit={{ x: "100%" }}
              transition={{ duration: 0.35, ease: EASE_SPRING }}
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
                {NAV_LINKS.map((link, index) => {
                  const active = isActive(link.href);
                  return (
                    <motion.div
                      key={link.href}
                      initial={{ opacity: 0, x: 16 }}
                      animate={{ opacity: 1, x: 0 }}
                      transition={{ duration: 0.3, delay: index * 0.04, ease: EASE_SPRING }}
                    >
                      <Link
                        href={link.href}
                        onClick={close}
                        className={`block rounded-lg px-3 py-3 text-sm font-medium transition-colors duration-150 ${
                          active
                            ? "bg-[var(--ui-border-subtle)] text-[var(--ui-text-primary)]"
                            : "text-[var(--ui-text-muted)] hover:bg-[var(--ui-border-subtle)] hover:text-[var(--ui-text-primary)]"
                        }`}
                      >
                        {link.label}
                      </Link>
                    </motion.div>
                  );
                })}
              </nav>
            </motion.div>
          </>
        ) : null}
      </AnimatePresence>
    </>
  );
}
