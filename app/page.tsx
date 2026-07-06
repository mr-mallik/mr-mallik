import type { Metadata } from "next";
import Image from "next/image";
import Link from "next/link";
import { HugeiconsIcon } from "@hugeicons/react";
import { LinkedinIcon, Github01Icon, IdIcon, Email, ArrowUpRight01Icon } from "@hugeicons/core-free-icons";

import { ROUTES, PROFILE } from "@/app/constants";
import { createPageMetadata, SITE_DESCRIPTION } from "@/app/seo";

import { ProjectsSection } from "@/components/projects-section";
import { BlogsSection } from "@/components/blogs-section";
import { PublicationsSection } from "@/components/publications-section";

// data imports
import workItems from "@/data/work.json";
import achievements from "@/data/achievements.json";
import showcase from "@/data/showcase.json";
import services from "@/data/services.json";
import publications from "@/data/publications.json";

const publicationsCount = String(publications.length).padStart(2, "0");

export const metadata: Metadata = createPageMetadata({
  title: "AI Researcher & Software Engineer",
  description: SITE_DESCRIPTION,
  path: "/",
  keywords: ["Gulger Mallik", "mrmallik", "AI researcher", "software engineer", "portfolio"],
});

const HERO_SOCIALS = [
  { label: "LinkedIn", href: PROFILE.linkedInUrl, icon: LinkedinIcon, handle: "mrmallik" },
  { label: "GitHub", href: PROFILE.githubUrl, icon: Github01Icon, handle: "mr-mallik" },
  { label: "ORCiD", href: PROFILE.orcidUrl, icon: IdIcon, handle: "ORCiD" },
];

export default function Page() {
  return (
    <div className="flex flex-col gap-8">
      <div className="flex flex-col gap-8">
        <section className="w-full bg-[var(--ui-bg-elevated)]">
          <div className="ui-container py-16 md:py-24 lg:py-10 xl:py-14">
            <div className="grid grid-cols-1 gap-12 md:grid-cols-2 md:gap-8 md:items-center lg:gap-12 lg:items-end">

              <div className="flex flex-col gap-6">
                <div className="relative w-full max-w-sm overflow-hidden rounded-2xl lg:max-w-[280px] xl:max-w-sm flex flex-col items-center justify-center">
                  <Image
                    src="/images/hero-image-v2.png"
                    alt="Gulger Mallik"
                    width={480}
                    height={600}
                    className="w-full object-cover"
                    priority
                  />
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
              </div>

              <div className="flex flex-col gap-8 lg:pb-2">
                <div className="flex flex-col gap-4">
                  <h1 className="text-4xl font-semibold leading-tight text-[var(--ui-text-primary)] sm:text-5xl md:text-4xl lg:text-5xl xl:text-6xl">
                    Software Engineer
                    <br />
                    <span style={{ color: "var(--ui-accent)" }}>&amp; AI Researcher</span>
                  </h1>
                  <p className="max-w-md text-base leading-relaxed text-[var(--ui-text-secondary)]">
                    I&apos;m <strong className="font-medium text-[var(--ui-text-primary)]">Gulger Mallik</strong> — crafting
                    intelligent digital products and advancing applied AI research for
                    real-world impact. Based in Huddersfield, United Kingdom.
                  </p>
                </div>

                <div className="flex gap-6">
                  <div className="flex flex-col gap-0.5">
                    <span className="text-4xl font-bold  text-[var(--ui-text-primary)]">
                      {String(new Date().getFullYear() - 2019).padStart(2, "0")}
                      {/* <span style={{ color: "var(--ui-accent)" }}>+</span> */}
                    </span>
                    <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                      Years
                    </span>
                  </div>
                  <div className="w-px self-stretch bg-[var(--ui-border-subtle)]" />
                  <div className="flex flex-col gap-0.5">
                    <span className="text-4xl font-bold  text-[var(--ui-text-primary)]">
                      100<span style={{ color: "var(--ui-accent)" }}>+</span>
                    </span>
                    <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                      Projects
                    </span>
                  </div>
                  <div className="w-px self-stretch bg-[var(--ui-border-subtle)]" />
                  <div className="flex flex-col gap-0.5">
                    <span className="text-4xl font-bold  text-[var(--ui-text-primary)] gap-2 flex items-center ">
                      {publicationsCount} 
                      <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                        Academic
                      </span>
                    </span>
                    <span className="text-xs font-medium uppercase tracking-widest text-[var(--ui-text-muted)]">
                      Publications
                    </span>
                  </div>
                </div>

                <div className="flex flex-wrap items-center gap-4">
                  <a
                    href={`mailto:${PROFILE.primaryEmail}`}
                    className="flex items-center rounded-full bg-[var(--ui-text-primary)] px-6 py-2.5 text-sm font-medium text-background transition-opacity hover:opacity-80"
                  >
                    <HugeiconsIcon icon={Email} className="mr-2 h-4 w-4" aria-hidden="true" />
                    Get in touch
                  </a>
                  <Link
                    href={ROUTES.projects}
                    className="text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:text-[var(--ui-text-primary)]"
                  >
                    See my work &nbsp;
                    <HugeiconsIcon icon={ArrowUpRight01Icon} className="inline-block h-4 w-4" aria-hidden="true" />
                  </Link>
                </div>
              </div>

            </div>
          </div>
        </section>
        <section className="w-full ui-container">
          <div className="grid grid-cols-3 items-center gap-6 lg:grid-cols-6">
            {showcase.map((item) => (
              <div
                key={item.name}
                className="grid place-items-center"
              >
                <Image
                  src={item.image}
                  alt={item.name}
                  width={160}
                  height={160}
                  className="h-auto max-h-16 w-auto max-w-full object-contain grayscale brightness-0 opacity-80 dark:invert"
                />
              </div>
            ))}
          </div>
        </section>
      </div>
      <section className="ui-section-py-md ui-bg-elevated">
        <div className="ui-container">
          <div className="grid gap-6 md:grid-cols-2">
            <div>
              <h3 className="ui-resume-title mb-6">
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
              <h3 className="ui-resume-title mb-6">
                Leadership &amp; Recognition
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

      <section className="ui-section-py-sm ui-container">
        <div className="mb-12 flex items-center justify-between">
          <h2 className="ui-section-title">
            I can help you with
          </h2>
        </div>

        <div className="grid grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-8 sm:gap-x-8 md:gap-x-10 lg:gap-12">
          {services.map((service) => (
            <div
              key={service.name}
              className="group flex min-w-0 flex-col gap-4 pb-6 lg:pb-0 border-b lg:border-b-0 lg:border-r lg:border-[var(--ui-border-subtle)] lg:pr-8 last:border-r-0
              hover:scale-105 transition-all ease-in-out duration-300
              cursor-pointer
              "
            >
              <div className="flex flex-col gap-3 flex-1">
                <h3 className="flex min-h-[2.75em] items-center break-words text-[clamp(1rem,0.55rem_+_1.5vw,1.875rem)] leading-snug uppercase font-bold text-[var(--ui-accent)]">
                  {service.name}
                </h3>
                <p className="text-sm md:text-base text-[var(--ui-text-secondary)] leading-relaxed">
                  {service.description}
                </p>
              </div>
              <div className="flex items-center gap-2">
                <div
                  className="mt-2 flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-[var(--ui-accent)] text-[var(--ui-text-muted)] hover:border-[var(--ui-text-muted)] hover:text-[var(--ui-text-primary)] transition-all self-start sm:h-10 sm:w-10">
                  <HugeiconsIcon icon={ArrowUpRight01Icon} className="h-4 w-4 shrink-0" aria-hidden="true" />
                </div>
                <Link
                  href={service.link}
                  className="min-w-0 text-sm font-medium text-[var(--ui-text-muted)] hover:text-[var(--ui-text-primary)] transition-colors"
                >
                  {service.text}
                </Link>
              </div>
            </div>
          ))}
        </div>
      </section>

      <section className="ui-container ui-section-py-sm">
        <ProjectsSection limit={4} showViewAllLink columns={3} desktopLimit={3} />
      </section>

      <section className="ui-section-py-sm ui-bg-elevated">
        <div className="ui-container">
          <BlogsSection limit={6} showViewAllLink />
        </div>
      </section>

      <section className="ui-container ui-section-py-sm">
        <PublicationsSection limit={3} showViewAllLink />
      </section>

      <section className="ui-container text-center pb-8 sm:pb-12 lg:pb-16">
        <p className="text-sm text-[var(--ui-text-muted)]">Have a project in mind?</p>
        <h2 className="mt-2 ui-section-title text-4xl md:text-5xl">
          Let&apos;s work together
        </h2>
        <div className="mt-6 flex flex-wrap items-center justify-center gap-4">
          <a
            href={`mailto:${PROFILE.primaryEmail}`}
            className="flex items-center rounded-full bg-[var(--ui-text-primary)] px-8 py-3 text-sm font-medium text-background transition-opacity hover:opacity-80"
          >
            <HugeiconsIcon icon={Email} className="mr-2 h-4 w-4" aria-hidden="true" />
            Get in touch
          </a>
          <a
            href={PROFILE.linkedInUrl}
            target="_blank"
            rel="noreferrer"
            className="flex items-center rounded-full border border-[var(--ui-border-soft)] px-8 py-3 text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:border-[var(--ui-text-muted)] hover:text-[var(--ui-text-primary)]"
          >
            <HugeiconsIcon icon={LinkedinIcon} className="mr-2 h-4 w-4" aria-hidden="true" />
            Connect on LinkedIn
          </a>
        </div>
      </section>
    </div>
  );
}
