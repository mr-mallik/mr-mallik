import type { Metadata } from "next";
import Image from "next/image";
import { HugeiconsIcon } from "@hugeicons/react";
import { LinkedinIcon, Github01Icon, Mail01Icon } from "@hugeicons/core-free-icons";

import { PROFILE, SITE } from "@/app/constants";
import { createPageMetadata } from "@/app/seo";
import { ContactForm, type ServiceItem } from "@/components/contact-form";

import services from "@/data/services.json";

export const metadata: Metadata = createPageMetadata({
  title: "Contact",
  description:
    "Get in touch with Gulger Mallik about research, consulting, software development, or training and workshops.",
  path: "/contact",
  keywords: ["contact", "hire", "quote", "consultation"],
});

// Each service links here as /contact?type=<value>; derive that value back
// from the link so the dropdown stays in sync with data/services.json.
const SERVICE_ITEMS: ServiceItem[] = services.map((service) => ({
  label: service.name,
  value:
    new URL(service.link, "https://mrmallik.com").searchParams.get("type") ??
    service.name.toLowerCase(),
}));

const CONTACT_LINKS = [
  {
    label: PROFILE.primaryEmail,
    href: `mailto:${PROFILE.primaryEmail}`,
    icon: Mail01Icon,
    external: false,
  },
  {
    label: "linkedin.com/in/mrmallik",
    href: PROFILE.linkedInUrl,
    icon: LinkedinIcon,
    external: true,
  },
  {
    label: "github.com/mr-mallik",
    href: PROFILE.githubUrl,
    icon: Github01Icon,
    external: true,
  },
];

export default async function Page({
  searchParams,
}: {
  searchParams: Promise<{ [key: string]: string | string[] | undefined }>;
}) {
  const { type } = await searchParams;
  const requestedType = typeof type === "string" ? type : undefined;
  const initialType = SERVICE_ITEMS.some((item) => item.value === requestedType)
    ? (requestedType as string)
    : null;

  return (
    <div className="ui-container ui-container-narrow ui-section-py-sm">
      <div className="grid gap-10 md:grid-cols-[260px_1fr] lg:grid-cols-[300px_1fr] lg:gap-14">
        <aside className="flex flex-col gap-5 hidden md:flex">
          <Image
            src="/images/hero-image-v2.png"
            alt={PROFILE.profileImageAlt}
            width={600}
            height={600}
            className="object-cover"
            priority
          />
          <div className="flex flex-col gap-1">
            <h1 className="text-2xl font-semibold text-[var(--ui-text-primary)]">
              {SITE.ownerName}
            </h1>
            <p className="text-sm text-[var(--ui-text-secondary)]">
              Software Engineer &amp; AI Researcher
            </p>
          </div>
          <ul className="flex flex-col gap-3">
            {CONTACT_LINKS.map((link) => (
              <li key={link.label}>
                <a
                  href={link.href}
                  {...(link.external
                    ? { target: "_blank", rel: "noreferrer" }
                    : {})}
                  className="inline-flex items-center gap-2 text-sm text-[var(--ui-text-muted)] transition-colors hover:text-[var(--ui-text-primary)]"
                >
                  <HugeiconsIcon
                    icon={link.icon}
                    className="h-4 w-4 shrink-0"
                    aria-hidden="true"
                  />
                  {link.label}
                </a>
              </li>
            ))}
          </ul>
        </aside>

        <ContactForm services={SERVICE_ITEMS} initialType={initialType} />
      </div>
    </div>
  );
}
