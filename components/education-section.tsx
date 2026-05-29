import educationItems from "@/data/education.json";
import { SECTION_TITLES, STATUS_LABELS } from "@/app/constants";

type EducationItem = {
  degree: string;
  institution: string;
  location: string;
  grade?: string;
  duration: string;
};

export function EducationSection() {
  const items = educationItems as EducationItem[];
  const itemCount = items.length;
  const lastCompletedIndex = items.reduce(
    (lastIndex, item, index) => (item.grade ? index : lastIndex),
    -1
  );
  const progressRatio =
    itemCount > 1 && lastCompletedIndex >= 0
      ? lastCompletedIndex / (itemCount - 1)
      : 0;

  return (
    <section className="space-y-5">
      <div className="flex items-center justify-between gap-4">
        <h2 className="ui-section-title tracking-tight">
          {SECTION_TITLES.education}
        </h2>
      </div>

      <div className="relative">
        <div
          aria-hidden="true"
          className="absolute bottom-2 left-[0.7rem] top-2 w-px bg-slate-200 dark:bg-slate-800 md:hidden"
        />
        <div
          aria-hidden="true"
          className="absolute bottom-2 left-[0.7rem] top-2 w-px origin-top bg-slate-500 transition-transform duration-500 dark:bg-slate-300 md:hidden"
          style={{ transform: `scaleY(${progressRatio})` }}
        />
        <div
          aria-hidden="true"
          className="absolute left-12 right-12 top-2 hidden h-px bg-slate-200 dark:bg-slate-800 md:block"
        />
        <div
          aria-hidden="true"
          className="absolute left-12 right-12 top-2 hidden h-px origin-left bg-slate-500 transition-transform duration-500 dark:bg-slate-300 md:block"
          style={{ transform: `scaleX(${progressRatio})` }}
        />

        <div className="flex flex-col gap-4 md:grid md:grid-cols-3 md:gap-4">
          {items.map((item, index) => {
            const isCompleted = Boolean(item.grade);

            return (
              <div
                key={`${item.degree}-${item.duration}`}
                className="timeline-item relative pl-7 md:pl-0 md:pt-6"
                style={{ animationDelay: `${index * 90}ms` }}
              >
              <span
                aria-hidden="true"
                className={`absolute left-0 top-1.5 h-3.5 w-3.5 rounded-full border shadow-sm md:left-1/2 md:-translate-x-1/2 md:top-0 ${
                  isCompleted
                    ? "timeline-dot-complete border-slate-700 bg-slate-700 dark:border-slate-200 dark:bg-slate-200"
                    : "border-slate-300 bg-background dark:border-slate-600"
                }`}
              />

              <article className="rounded-xl border border-slate-200 bg-background p-4 transition-transform duration-200 hover:-translate-y-0.5 dark:border-slate-800">
                <p className="ui-meta-text uppercase tracking-[0.08em]">
                  {item.duration}
                </p>
                <h3 className="ui-item-title mt-2 font-semibold leading-tight text-base">
                  {item.degree}
                </h3>
                <p className="ui-body-text mt-2 text-sm">
                  {item.institution}
                </p>
                <p className="ui-control-text text-sm">
                  {item.location}
                </p>
                {item.grade ? (
                  <p className="ui-control-text mt-2 text-sm">
                    {STATUS_LABELS.educationGradePrefix} {item.grade}
                  </p>
                ) : null}
              </article>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
}