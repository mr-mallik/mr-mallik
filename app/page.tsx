import { Github01Icon, Mail } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Image from "next/image";
import Link from "next/link";

import { ProjectsSection } from "@/components/projects-section";

export default function Home() {
  return (
    <section className="mx-auto w-full max-w-2xl py-4">
      <div className="space-y-10 sm:space-y-14">
        <header className="space-y-6">
          <div className="flex items-center gap-4">
            <div className="h-12 w-12 rounded-full bg-gradient-to-br from-slate-200 to-slate-400 shadow-sm dark:from-slate-600 dark:to-slate-800">
              <Image
                src="/images/gulger-mallik@1x1.webp"
                alt="Profile picture of Gulger Mallik"
                width={48}
                height={48}
                className="rounded-full"
              />
            </div>
            <div>
              <h1 className="text-lg text-slate-900 dark:text-slate-100">
                Gulger Mallik
              </h1>
              <p className="text-sm text-gray-500 dark:text-slate-400 sm:text-base">
                Researcher at The <Link href="https://hud.ac.uk" target="_blank" rel="noreferrer">University of Huddersfield</Link>
              </p>
            </div>
          </div>

          <p className="text-sm leading-relaxed text-gray-700 sm:text-base sm:leading-relaxed dark:text-slate-300">
            I am a founding software engineer at{" "}
            <Link
              href="https://cosmokode.com"
              target="_blank"
              rel="noreferrer"
              className="font-semibold text-slate-900 underline decoration-slate-300 underline-offset-4 transition hover:decoration-slate-700 dark:text-slate-100 dark:decoration-slate-500 dark:hover:decoration-slate-200"
            >
              Cosmokode Ltd
            </Link>{" "}
            building thoughtful tools for the
            next layer of the web. I like to build systems that accelerate businesses and bring confidence in the era of Artificial Intelligence.
          </p>

          <p className="text-sm leading-relaxed text-gray-700 sm:text-base sm:leading-relaxed dark:text-slate-300">
            Previously, I worked with{" "}
            <Link 
              href="https://www.linkedin.com/in/mrmallik/"
              target="_blank"
              rel="noreferrer"
              className="font-semibold text-slate-900 underline decoration-slate-300 underline-offset-4 transition hover:decoration-slate-700 dark:text-slate-100 dark:decoration-slate-500 dark:hover:decoration-slate-200"
              >
              product teams
            </Link>{" "}
            across research and
            engineering. You can reach me via{" "}
            <Link
              href="mailto:gulgermallik@gmail.com"
              className="inline-flex items-center gap-1 align-middle font-semibold text-slate-900 underline decoration-slate-300 underline-offset-4 transition hover:decoration-slate-700 dark:text-slate-100 dark:decoration-slate-500 dark:hover:decoration-slate-200"
            >
              <HugeiconsIcon icon={Mail} className="h-4 w-4 shrink-0" aria-hidden="true" /> email
            </Link>{" "}
            or see my code on{" "}
            <Link
              href="https://github.com/mr-mallik"
              target="_blank"
              rel="noreferrer"
              className="inline-flex items-center gap-1 align-middle font-semibold text-slate-900 underline decoration-slate-300 underline-offset-4 transition hover:decoration-slate-700 dark:text-slate-100 dark:decoration-slate-500 dark:hover:decoration-slate-200"
            >
              <HugeiconsIcon icon={Github01Icon} className="h-4 w-4 shrink-0" aria-hidden="true" /> GitHub
            </Link>
            .
          </p>

          <p className="text-sm leading-relaxed text-gray-700 sm:text-base sm:leading-relaxed dark:text-slate-300">
            My research focuses on Explainable AI, Multi-critera Decision Making, and Sustainable Software Engineering, read my publications on{" "}
            <Link
              href="https://orcid.org/0009-0002-5110-8575"
              target="_blank"
              rel="noreferrer"
              className="font-semibold text-slate-900 underline decoration-slate-300 underline-offset-4 transition hover:decoration-slate-700 dark:text-slate-100 dark:decoration-slate-500 dark:hover:decoration-slate-200"
            >
              ORCiD
            </Link>
            .
          </p>

        </header>

        <ProjectsSection limit={2} showViewAllLink />
      </div>
    </section>
  );
}
