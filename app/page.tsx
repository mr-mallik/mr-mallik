import Image from "next/image";
import Link from "next/link";
import { ROUTES, PROFILE } from "@/app/constants";

// data imports
import workItems from "@/data/work.json";
import { ProjectsSection } from "@/components/projects-section";
import TestimonialsSection from "@/components/testimonials-section";
import { BlogsSection } from "@/components/blogs-section";
import { Showcase } from "@/components/showcase";
import { PublicationsSection } from "@/components/publications-section";

const awards = [
  {
    badge: "IEEE",
    title: "XAI in Multi-Criteria Decision Making",
    date: "March 2024",
  },
  {
    badge: "UoH",
    title: "Best Engineering Research Project",
    date: "June 2023",
  },
  {
    badge: "OSS",
    title: "Open Source Excellence Award",
    date: "December 2022",
  },
];

const stats = [
  { value: "10+", label: "Projects Built", icon: "⚙️" },
  { value: "3+", label: "Publications", icon: "🌐" },
  { value: "50+", label: "Happy Clients", icon: "😊" },
  { value: "4+", label: "Years Experience", icon: "🎯" },
];

const projects = [
  {
    image: "/images/showcase/cosmokode.png",
    name: "Cosmokode",
    category: "SaaS Platform",
    date: "August 2024",
    description:
      "A next-generation developer platform for building and deploying AI-powered web applications at scale.",
  },
  {
    image: "/images/showcase/TierraSphere.png",
    name: "TierraSphere",
    category: "Environmental Tech Platform",
    date: "June 2023",
    description:
      "A data-driven environmental monitoring platform connecting sustainability metrics with actionable insights.",
  },
  {
    image: "/images/showcase/fitplanex.png",
    name: "FitPlanEx",
    category: "Health & Fitness App",
    date: "March 2023",
    description:
      "An AI-powered fitness planning application delivering personalised workout and nutrition recommendations.",
  },
  {
    image: "/images/showcase/jobapplicationtracker.png",
    name: "Job Application Tracker",
    category: "Productivity Tool",
    date: "November 2022",
    description:
      "A streamlined tool for managing job applications, interviews, and follow-ups in one organised dashboard.",
  },
];

const services = [
  {
    emoji: "🖥️",
    title: "Full-Stack Web Development",
    description:
      "Crafting performant, scalable web applications end-to-end — from database architecture to polished user interfaces.",
    images: ["/images/showcase/cosmokode.png", "/images/showcase/fitplanex.png"],
  },
  {
    emoji: "🤖",
    title: "AI & Machine Learning Solutions",
    description:
      "Designing and integrating explainable AI systems that empower teams to make smarter, data-driven decisions.",
    images: null,
  },
  {
    emoji: "📄",
    title: "Research & Technical Consultation",
    description:
      "Publishing rigorous research in Explainable AI, multi-criteria decision making, and sustainable software engineering.",
    images: null,
  },
];

export default function Page() {
  return (
    <div className="flex flex-col gap-16 md:gap-24">
      
      <section className="pt-2">
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
            <h1 className="text-6xl font-medium text-primary">
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

      <section className="rounded-2xl bg-stone-100 p-6 shadow dark:bg-stone-900/30 md:p-10">
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
              {awards.map((award) => (
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
      </section>

      <section>
        <div className="mb-8 flex items-center justify-between">
          <h2 className="ui-section-title tracking-tight">
            I can help you with
          </h2>
        </div>

        <div className="divide-y divide-[var(--ui-border-subtle)]">
        </div>
      </section>
      
      <ProjectsSection limit={4} showViewAllLink />

      <Showcase />      

      <BlogsSection limit={6} showViewAllLink />

      <PublicationsSection limit={3} showViewAllLink />

      <section className="pb-6 text-center">
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
