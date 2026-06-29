import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { HugeiconsIcon } from "@hugeicons/react";
import { LinkedinIcon, Github01Icon } from "@hugeicons/core-free-icons";

import { ROUTES, PROFILE } from "@/app/constants";
import { createPageMetadata, SITE_DESCRIPTION } from "@/app/seo";

import { HomeProjectsSection } from "@/components/home-projects-section";
import { BlogsSection } from "@/components/blogs-section";
import { PublicationsSection } from "@/components/publications-section";

// data imports
import workItems from "@/data/work.json";
import achievements from "@/data/achievements.json";
import showcase from "@/data/showcase.json";
import services from "@/data/services.json";
import publications from "@/data/publications.json";

const publicationsCount = publications.length;

export const metadata: Metadata = createPageMetadata({
  title: "AI Researcher & Software Engineer",
  description: SITE_DESCRIPTION,
  path: "/",
  keywords: ["Gulger Mallik", "mrmallik", "AI researcher", "software engineer", "portfolio"],
});

const SERVICE_ICONS: Record<string, string> = {
  "rnd": "🔬",
  "consulting": "💬",
  "software-development": "⚙️",
  "training-and-workshops": "🎓",
};

const HERO_SOCIALS = [
  { label: "LinkedIn", href: PROFILE.linkedInUrl, icon: LinkedinIcon, handle: "mrmallik" },
  { label: "GitHub", href: PROFILE.githubUrl, icon: Github01Icon, handle: "mr-mallik" },
];

export default function Page() {
  return (
    <div className="flex flex-col gap-16 md:gap-24">

      {/* ── Hero ── */}
      <section style={{ background: "#fbf9fa" }} className="w-full dark:bg-stone-900/40">
        <div className="mx-auto max-w-7xl px-6 py-16 md:px-10 md:py-24 lg:px-14">
          <div className="grid grid-cols-1 gap-12 md:grid-cols-2 md:items-end">

            {/* Left — portrait + socials */}
            <div className="flex flex-col gap-6">
              <div className="relative w-full max-w-sm overflow-hidden rounded-2xl">
                <Image
                  src="/images/hero-image-v2.png"
                  alt="Gulger Mallik"
                  width={480}
                  height={600}
                  className="w-full object-cover"
                  priority
                />
              </div>
              <div className="flex items-center gap-5">
                {HERO_SOCIALS.map((s) => (
                  <a
                    key={s.label}
                    href={s.href}
                    target="_blank"
                    rel="noreferrer"
                    className="inline-flex items-center gap-1.5 text-sm text-[var(--ui-text-muted)] transition-colors hover:text-[var(--ui-text-primary)]"
                  >
                    <HugeiconsIcon icon={s.icon} className="h-4 w-4 shrink-0" aria-hidden="true" />
                    {s.handle}
                  </a>
                ))}
              </div>
            </div>

            {/* Right — headline, description, stats */}
            <div className="flex flex-col gap-8 md:pb-2">
              <div className="flex flex-col gap-4">
                <h1 className="text-4xl font-semibold leading-tight tracking-tight text-[var(--ui-text-primary)] sm:text-5xl lg:text-6xl">
                  Software Engineer
                  <br />
                  <span style={{ color: "#d9ad90" }}>&amp; AI Researcher</span>
                </h1>
                <p className="max-w-md text-base leading-relaxed text-[var(--ui-text-secondary)]">
                  Crafting intelligent digital products and advancing applied AI research for
                  real-world impact. Based in Huddersfield, United Kingdom.
                </p>
              </div>

              <div className="flex flex-wrap gap-6">
                <div className="flex flex-col gap-0.5">
                  <span className="text-4xl font-bold tracking-tight text-[var(--ui-text-primary)]">
                    {String(new Date().getFullYear() - 2019).padStart(2, "0")}
                    <span style={{ color: "#d9ad90" }}>+</span>
                  </span>
                  <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                    Years
                  </span>
                </div>
                <div className="w-px self-stretch bg-[var(--ui-border-subtle)]" />
                <div className="flex flex-col gap-0.5">
                  <span className="text-4xl font-bold tracking-tight text-[var(--ui-text-primary)]">
                    100<span style={{ color: "#d9ad90" }}>+</span>
                  </span>
                  <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                    Projects
                  </span>
                </div>
                <div className="w-px self-stretch bg-[var(--ui-border-subtle)]" />
                <div className="flex flex-col gap-0.5">
                  <span className="text-4xl font-bold tracking-tight text-[var(--ui-text-primary)]">
                    {publicationsCount}
                  </span>
                  <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                    Publications
                  </span>
                </div>
              </div>

              <div className="flex flex-wrap items-center gap-4">
                <a
                  href={`mailto:${PROFILE.primaryEmail}`}
                  className="rounded-full bg-[var(--ui-text-primary)] px-6 py-2.5 text-sm font-medium text-background transition-opacity hover:opacity-80"
                >
                  Get in touch
                </a>
                <Link
                  href={ROUTES.projects}
                  className="text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:text-[var(--ui-text-primary)]"
                >
                  See my work →
                </Link>
              </div>
            </div>

          </div>
        </div>
      </section>

      {/* ── Showcase ── */}
      <section className="mx-auto w-full max-w-7xl px-6 md:px-10 lg:px-14">
        <div className="flex flex-wrap gap-6">
          {showcase.map((item) => (
            <div
              key={item.name}
              className="grid place-items-center w-[calc(25%-18px)] min-w-[80px] max-w-[160px] lg:w-[calc(16.666%-20px)]"
            >
              <Image
                src={item.image}
                alt={item.name}
                width={160}
                height={160}
                className="max-h-[80%] w-auto max-w-full object-contain grayscale brightness-0 opacity-80 dark:invert"
              />
            </div>
          ))}
        </div>
      </section>

      {/* ── Experience & Awards ── */}
      <section className="py-16 bg-stone-100 dark:bg-stone-900/30">
        <div className="mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
          <div className="grid gap-6 md:grid-cols-2">
            <div>
              <h3 className="mb-6 text-lg font-semibold text-[var(--ui-text-primary)]">
                Working experience
              </h3>
              <ul className="divide-y divide-[var(--ui-border-subtle)]">
                {workItems.map((exp, index) => (
                  <li key={`work-item-${index}`} className="ui-experience-row">
                    <div className="flex items-center gap-3">
                      <div className="flex h-9 w-9 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-[var(--ui-border-soft)] bg-background">
                        {exp.logo ? (
                          <Image
                            src={exp.logo}
                            alt={exp.company}
                            width={28}
                            height={28}
                            className="h-full w-full object-cover"
                          />
                        ) : null}
                      </div>
                      <div>
                        <p className="text-sm text-[var(--ui-text-primary)]">
                          <span className="font-semibold">{exp.role}</span> at{" "}
                          <Link href={exp.url} className="font-light">{exp.company}</Link>
                        </p>
                        <p className="text-xs text-[var(--ui-text-muted)]">{exp.period}</p>
                      </div>
                    </div>
                  </li>
                ))}
              </ul>
            </div>

            <div>
              <h3 className="mb-6 text-lg font-semibold text-[var(--ui-text-primary)]">
                Awards &amp; Recognition
              </h3>
              <ul className="divide-y divide-[var(--ui-border-subtle)]">
                {achievements.map((award, index) => (
                  <li key={`award-item-${index}`} className="ui-experience-row">
                    <div className="flex items-center gap-3">
                      <div className="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[var(--ui-text-primary)] text-[10px] font-bold text-background">
                        {award.badge}
                      </div>
                      <div>
                        <p className="text-sm font-semibold text-[var(--ui-text-primary)]">
                          {award.title}
                        </p>
                        <p className="text-xs text-[var(--ui-text-muted)]">{award.date}</p>
                      </div>
                    </div>
                    <svg
                      className="h-4 w-4 shrink-0 text-[var(--ui-text-muted)]"
                      viewBox="0 0 16 16"
                      fill="none"
                      stroke="currentColor"
                      strokeWidth="1.5"
                    >
                      <path
                        d="M3 13L13 3M13 3H7M13 3V9"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                      />
                    </svg>
                  </li>
                ))}
              </ul>
            </div>
          </div>
        </div>
      </section>

      {/* ── Services ── */}
      <section className="py-8 mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <div className="mb-8 flex items-center justify-between">
          <h2 className="ui-section-title tracking-tight">I can help you with</h2>
        </div>

        <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {services.map((service) => (
            <div
              key={service.name}
              className="group border border-[var(--ui-border-subtle)] rounded-xl flex flex-col overflow-hidden transition-all duration-200 hover:border-[var(--ui-border-soft)] hover:shadow-sm"
            >
              <div className="relative w-full aspect-[4/3] bg-stone-100 dark:bg-stone-900/30 flex flex-col items-center justify-center gap-3 p-6">
                <span className="text-4xl select-none" aria-hidden>
                  {SERVICE_ICONS[service.icon] ?? "📌"}
                </span>
                <h3 className="text-base font-semibold text-center text-[var(--ui-text-primary)] leading-snug">
                  {service.name}
                </h3>
              </div>
              <p className="p-4 text-sm leading-relaxed text-[var(--ui-text-muted)]">
                {service.description}
              </p>
            </div>
          ))}
        </div>
      </section>

      {/* ── Selected Work ── */}
      <HomeProjectsSection />

      {/* ── Blog ── */}
      <section className="mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <BlogsSection limit={6} showViewAllLink />
      </section>

      {/* ── Publications ── */}
      <section className="mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <PublicationsSection limit={3} showViewAllLink />
      </section>

      {/* ── CTA ── */}
      <section className="mx-auto max-w-7xl px-6 md:px-10 lg:px-14 text-center">
        <p className="text-sm text-[var(--ui-text-muted)]">Have a project in mind?</p>
        <h2 className="mt-2 ui-section-title text-4xl md:text-5xl">
          Let&apos;s work together
        </h2>
        <div className="mt-6 flex flex-wrap items-center justify-center gap-4">
          <a
            href={`mailto:${PROFILE.primaryEmail}`}
            className="rounded-full bg-[var(--ui-text-primary)] px-8 py-3 text-sm font-medium text-background transition-opacity hover:opacity-80"
          >
            Get in touch
          </a>
          <a
            href={PROFILE.linkedInUrl}
            target="_blank"
            rel="noreferrer"
            className="rounded-full border border-[var(--ui-border-soft)] px-8 py-3 text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:border-[var(--ui-text-muted)] hover:text-[var(--ui-text-primary)]"
          >
            Connect on LinkedIn
          </a>
        </div>
      </section>
    </div>
  );
}
