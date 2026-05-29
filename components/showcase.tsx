import { ImagePlayIcon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Image from "next/image";

type ShowcaseItem = {
  name: string;
  image?: string;
  url?: string;
};

const showcaseItems: ShowcaseItem[] = [
  { name: "Tierrasphere", url: "https://www.tierrasphere.com/" },
  { name: "Crowther", url: "https://www.crowther.co.uk/" },
  { name: "MuscleMindStories", url: "https://www.crowther.co.uk/" },
  { name: "Interview Prep AI", url: "https://www.crowther.co.uk/" },
  { name: "AI Job Tracker", url: "https://www.crowther.co.uk/" },
  { name: "University of Huddersfield", url: "https://www.crowther.co.uk/" },
  { name: "Cosmokode Ltd", url: "https://www.crowther.co.uk/" },
  { name: "Trellissoft Inc.", url: "https://www.crowther.co.uk/" },
  { name: "Teaminertia Technologies", url: "https://www.crowther.co.uk/" },
  { name: "Centre for Precision Technologies", url: "https://www.crowther.co.uk/" },
  { name: "UKRI KTP", url: "https://www.crowther.co.uk/" },
  { name: "AKTP", url: "https://www.crowther.co.uk/" },
];

export function Showcase() {
  return (
    <section className="space-y-5">
      <div className="flex items-center justify-between gap-4">
        <h2 className="text-xl font-semibold tracking-tight text-slate-900 dark:text-slate-100">
          Showcase
        </h2>
      </div>

      <div className="overflow-hidden">
        <div className="grid grid-cols-2 gap-px bg-slate-200 dark:bg-slate-800 sm:grid-cols-3 md:grid-cols-4">
          {showcaseItems.map((item) => (
            <div
              key={item.name}
              className="flex h-28 flex-col items-center justify-center bg-background px-3 text-center sm:h-32"
            >
              {item.image ? (
                <Image
                  src={item.image}
                  alt={`${item.name} icon`}
                  height={36}
                />
              ) : (
                <HugeiconsIcon icon={ImagePlayIcon} />
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
