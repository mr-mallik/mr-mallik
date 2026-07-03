import Image from "next/image";
import Link from "next/link";
import { SECTION_TITLES } from "@/app/constants";

import showcaseItems from "@/data/showcase.json";

type ShowcaseItem = {
  name: string;
  image: string;
  url?: string;
  description?: string;
};

const ACCENT_CLASSES = [
  "showcase-cell-blue",
  "showcase-cell-violet",
  "showcase-cell-emerald",
  "showcase-cell-amber",
] as const;

export function Showcase() {
  return (
    <section className="space-y-5">
      <div className="flex items-center justify-between gap-4">
        <h2 className="ui-section-title ">
          {SECTION_TITLES.showcase}
        </h2>
      </div>

      <div className="overflow-hidden rounded-sm">
        <div className="showcase-grid grid grid-cols-2 gap-px bg-slate-200 dark:bg-slate-800 sm:grid-cols-3 md:grid-cols-4">
          {(showcaseItems as ShowcaseItem[]).map((item, index) => {
            const accentClass = ACCENT_CLASSES[index % ACCENT_CLASSES.length];
            const cellClass = `showcase-cell section-enter ${accentClass}`;
            const delay = `${index * 40}ms`;

            const content = (
              <div
                className={`${cellClass} h-28 sm:h-32`}
                style={{ animationDelay: delay }}
              >
                <Image
                  title={item.description}
                  src={item.image}
                  alt={`${item.name} icon`}
                  width={160}
                  height={160}
                  className="h-auto max-h-[72%] w-auto max-w-full object-contain grayscale brightness-0 opacity-55 dark:invert dark:opacity-65"
                />
              </div>
            );

            if (!item.url) {
              return <div key={item.name}>{content}</div>;
            }

            return (
              <Link
                key={item.name}
                href={item.url}
                target="_blank"
                rel="noreferrer"
              >
                {content}
              </Link>
            );
          })}
        </div>
      </div>
    </section>
  );
}
