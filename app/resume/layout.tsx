import type { Metadata } from "next";

import { ROUTES, SITE } from "@/app/constants";
import {
  buildWebPageJsonLd,
  createPageMetadata,
  sanitizeJsonLd,
} from "@/app/seo";

export const metadata: Metadata = createPageMetadata({
  title: "Resume",
  description:
    "Resume and CV for Gulger Mallik (mrmallik), covering research, software engineering, and applied AI experience.",
  path: ROUTES.resume,
  keywords: ["resume", "CV", "Gulger Mallik", "mrmallik", "software engineer", "AI researcher"],
});

export default function ResumeLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <section>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: `${SITE.ownerName} Resume`,
              description:
                "Resume and CV for Gulger Mallik (mrmallik), covering research, software engineering, and applied AI experience.",
              path: ROUTES.resume,
              type: "ProfilePage",
            }),
          ),
        }}
      />
      {children}
    </section>
  );
}
