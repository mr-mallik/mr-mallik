import Image from "next/image";
import Link from "next/link";
import { ROUTES, PROFILE, SOCIAL_LINKS } from "@/app/constants";

import { ProjectsSection } from "@/components/projects-section";
import { BlogsSection } from "@/components/blogs-section";
import { PublicationsSection } from "@/components/publications-section";

// data imports
import workItems from "@/data/work.json";
import achievements from "@/data/achievements.json";
import showcase from "@/data/showcase.json";
import services from "@/data/services.json";

export default function Page() {
  return (
    <div className="flex flex-col gap-16 md:gap-24">
      
      <section className="pt-16 mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <div className="flex flex-row gap-8 items-center">
          <div className="flex flex-col gap-6 w-full md:w-1/2 sm:grid sm:grid-cols-2 md:flex md:flex-col">
            <div className="flex items-center">
              <Image
                src="/images/gulger-mallik@1x1.png"
                alt="Gulger Mallik"
                width={52}
                height={52}
                className="rounded-full object-cover"
                priority
              />
            </div>
            <h1 className="text-7xl font-medium text-primary">
              Hello! I&apos;m
              <br />
              Gulger Mallik
            </h1>
          </div>

          <div className="flex flex-col gap-8 w-full md:w-1/2 sm:grid sm:grid-cols-2 md:flex md:flex-col">
            <h2 className="text-xl font-medium leading-snug text-[var(--ui-text-primary)] sm:text-2xl">
              A Software Engineer &amp; AI Researcher based in Huddersfield, United Kingdom.
            </h2>
            <p className="text-sm text-[var(--ui-text-muted)]">
              Passionate about building thoughtful digital products and advancing AI research for
              real-world impact.
            </p>
            <div className="flex flex-wrap items-center gap-4">
              <a
                href={`mailto:${PROFILE.primaryEmail}`}
                className="rounded-full bg-[var(--ui-text-primary)] px-5 py-2.5 text-sm font-medium text-background transition-opacity hover:opacity-80"
              >
                Get in touch
              </a>
              <Link
                href={ROUTES.projects}
                className="text-sm font-medium text-[var(--ui-text-secondary)] transition-colors hover:text-[var(--ui-text-primary)]"
              >
                See my work
              </Link>
            </div>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <div className="flex flex-row gap-6">
          {showcase.map((item) => (
            <div key={item.name} className="grid place-items-center w-1/4 lg:w-1/6">
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

      <section className="py-16 bg-stone-100 dark:bg-stone-900/30">
        <div className="mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
          <div className="grid gap-6 md:grid-cols-2">
            <div>
              <h3 className="mb-6 text-lg font-semibold text-[var(--ui-text-primary)]">
                Working experience
              </h3>
              <ul className="divide-y divide-[var(--ui-border-subtle)]">
                {workItems.map((exp) => (
                  <li key={exp.company} className="ui-experience-row">
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
                {achievements.map((award) => (
                  <li key={award.title} className="ui-experience-row">
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

      <section className="py-8 mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <div className="mb-8 flex items-center justify-between">
          <h2 className="ui-section-title tracking-tight">
            I can help you with
          </h2>
        </div>

        <div className="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
          {services.map((service) => (
            <div key={service.name} className="border border-[var(--ui-border-subtle)] rounded-lg flex flex-col gap-2">
              <div className="w-full pb-2 rounded-t-lg h-64 bg-stone-100 dark:bg-stone-900/30 flex items-center justify-center">
                <h3 
                  className="text-2xl p-4 font-semibold items-center text-center text-[var(--ui-text-primary)]">
                    {service.name}
                </h3>
              </div>
              <p className="p-4 text-sm text-[var(--ui-text-muted)]">{service.description}</p>
            </div>
          ))}
        </div>
      </section>

      <section className="py-8 mx-auto max-w-7xl px-6 md:px-10 lg:px-14">
        <div className="flex flex-row gap-4">
          <div className="w-1/4 flex flex-col gap-6">
            <h2 className="ui-section-title tracking-tight">
              Selected Work
            </h2>
            <a
                href={`mailto:${PROFILE.primaryEmail}`}
                className="w-fit rounded-full bg-[var(--ui-text-primary)] px-5 py-2.5 text-sm font-medium text-background transition-opacity hover:opacity-80"
              >
              See All
            </a>
          </div>
          <div className="w-3/4">
              <ProjectsSection heading={false} limit={4} showViewAllLink />
          </div>
        </div>
      </section>
      
      <BlogsSection limit={6} showViewAllLink />

      <PublicationsSection limit={3} showViewAllLink />

      <section className="mx-auto max-w-7xl pb-16 px-6 md:px-10 lg:px-14 text-center">
        <p className="text-sm text-[var(--ui-text-muted)]">Have a project?</p>
        <h2 className="mt-2 text-4xl font-bold tracking-tight text-[var(--ui-text-primary)] md:text-5xl">
          Let&apos;s work together
        </h2>
        <a
          href={`mailto:${PROFILE.primaryEmail}`}
          className="mt-6 inline-block rounded-full bg-[var(--ui-text-primary)] px-8 py-3 text-sm font-medium text-background transition-opacity hover:opacity-80"
        >
          Get in touch
        </a>
      </section>
    </div>
  );
}
