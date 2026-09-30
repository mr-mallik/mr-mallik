"use client";

import { usePathname } from "next/navigation";

import { STANDALONE_ROUTES } from "@/app/constants";

// Hides site-wide chrome (navigation, footer, scroll helpers) on standalone
// pages such as the link-in-bio page.
export function SiteChrome({ children }: { children: React.ReactNode }) {
  const pathname = usePathname();
  const standalone = STANDALONE_ROUTES.some(
    (route) => pathname === route || pathname.startsWith(`${route}/`),
  );

  return standalone ? null : children;
}
