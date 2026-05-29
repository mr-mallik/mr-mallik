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

export function Showcase() {
  return (
    <section className="space-y-5">
      <div className="flex items-center justify-between gap-4">
        <h2 className="ui-section-title tracking-tight">
          {SECTION_TITLES.showcase}
        </h2>
      </div>

      <div className="overflow-hidden">
        <div className="grid grid-cols-2 gap-px bg-slate-200 dark:bg-slate-800 sm:grid-cols-3 md:grid-cols-4">
          {(showcaseItems as ShowcaseItem[]).map((item) => {
            const content = (
              <div className="flex h-28 flex-col items-center justify-center bg-background px-3 text-center sm:h-32">
                <Image
                  title={`${item.description}`}
                  src={item.image}
                  alt={`${item.name} icon`}
                  width={160}
                  height={36}
                  className="max-h-10 w-auto object-contain grayscale brightness-0 opacity-60 dark:invert dark:opacity-70 sm:max-h-12"
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
                className="transition hover:bg-slate-50 dark:hover:bg-slate-950/40"
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
