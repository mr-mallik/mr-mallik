import Link from "next/link";
import workItems from "@/data/work.json";
import { LINK_LABELS, ROUTES, SECTION_TITLES } from "@/app/constants";

type Experience = {
  company: string;
  role: string;
  period: string;
  url?: string;
};

export function ExperienceSection({
  limit,
  heading = true,
  showViewAllLink = false,
}: {
  limit?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
}) {
  const experiences = workItems as Experience[];
  const visibleExperiences =
    typeof limit === "number" ? experiences.slice(0, limit) : experiences;

  return (
    <section className="space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="ui-section-title tracking-tight">
            {SECTION_TITLES.workExperience}
          </h2>
          {showViewAllLink ? (
            <Link
              href={ROUTES.resume}
              className="ui-link-subtle text-sm font-medium"
            >
              {LINK_LABELS.resume}
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
            <p className="ui-item-title text-base">
              {item.role}
            </p>
            <p className="ui-control-text text-right text-sm">
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
