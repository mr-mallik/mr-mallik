import Link from "next/link";

type Experience = {
  company: string;
  role: string;
  period: string;
  url?: string;
};

const experiences: Experience[] = [
  {
    company: "University of Huddersfield",
    role: "Research Technician",
    period: "Mar 2026 - Present",
    url: "https://www.hud.ac.uk/",
  },
  {
    company: "University of Huddersfield",
    role: "Research Assistant in Applied AI (UKRI)",
    period: "Oct 2024 - Oct 2025",
    url: "https://www.hud.ac.uk/",
  },
  {
    company: "University of Huddersfield",
    role: "Research Technician (AKTP)",
    period: "Apr 2024 - Aug 2024",
    url: "https://www.hud.ac.uk/",
  },
  {
    company: "University of Huddersfield",
    role: "Research and Development Engineer",
    period: "Oct 2023 - Apr 2024",
    url: "https://www.hud.ac.uk/",
  },
  {
    company: "Trellissoft Inc.",
    role: "Software Engineer",
    period: "Mar 2022 - Aug 2022",
    url: "https://www.trellissoft.com/",
  },
  {
    company: "Teaminertia Technologies",
    role: "Software Engineer",
    period: "May 2019 - Mar 2022",
    url: "https://www.teaminertia.com/",
  },
];

export function ExperienceSection({
  limit,
  heading = true,
  showViewAllLink = false,
}: {
  limit?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
}) {
  const visibleExperiences =
    typeof limit === "number" ? experiences.slice(0, limit) : experiences;

  return (
    <section className="space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
            Work Experience
          </h2>
          {showViewAllLink ? (
            <Link
              href="/experience"
              className="text-sm font-medium text-slate-600 underline decoration-slate-300 underline-offset-4 transition hover:text-slate-900 hover:decoration-slate-700 dark:text-slate-400 dark:decoration-slate-600 dark:hover:text-slate-100 dark:hover:decoration-slate-300"
            >
              View all experience
            </Link>
          ) : null}
        </div>
      ) : null}

      <div className="">
        {visibleExperiences.map((item, index) => (
          <div
            key={`${item.company}-${item.role}-${item.period}`}
            className={`flex items-center justify-between gap-4 py-3 ${
              index !== visibleExperiences.length - 1
                ? "border-b border-slate-200 dark:border-slate-800"
                : ""
            }`}
          >
            <p className="text-base text-slate-800 dark:text-slate-100">
              {item.role}
            </p>
            <p className="text-right text-sm text-slate-500 dark:text-slate-400">
              {item.url ? (
                <a href={item.url} target="_blank" rel="noopener noreferrer">
                  {item.company}
                </a>
              ) : (
                item.company
              )}{" "}
              / {item.period}
            </p>
          </div>
        ))}
      </div>
    </section>
  );
}
