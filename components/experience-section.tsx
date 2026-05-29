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
              className="ui-view-all-link"
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
            className={`ui-experience-row section-enter ${
              index !== visibleExperiences.length - 1
                ? "border-b border-[var(--ui-border-subtle)]"
                : ""
            }`}
            style={{ animationDelay: `${index * 55}ms` }}
          >
            <p className="ui-item-title text-sm sm:text-base">
              {item.role}
            </p>
            <p className="ui-control-text text-right text-xs sm:text-sm shrink-0">
              {item.url ? (
                <a href={item.url} target="_blank" rel="noopener noreferrer" className=" font-medium">
                  {item.company}
                </a>
              ) : (
                item.company
              )}{" "}
              &bull; {item.period}
            </p>
          </div>
        ))}
      </div>
    </section>
  );
}
