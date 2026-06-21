import { Book04Icon } from "@hugeicons/core-free-icons";
import { HugeiconsIcon } from "@hugeicons/react";
import Image from "next/image";
import Link from "next/link";

import {
  LINK_LABELS,
  ROUTES,
  SECTION_TITLES,
  STATUS_LABELS,
} from "@/app/constants";
import publicationsItems from "@/data/publications.json";

type Publication = {
  title: string;
  abstract: string;
  image?: string | null;
  doi?: string | null;
  status: string;
};

export function PublicationsSection({
  limit,
  startFrom = 0,
  heading = true,
  showViewAllLink = false,
}: {
  limit?: number;
  startFrom?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
}) {
  const publications = publicationsItems as Publication[];
  const slicedPublications =
    typeof limit === "number"
      ? publications.slice(startFrom, startFrom + limit)
      : publications.slice(startFrom);

  return (
    <section className="mx-auto max-w-7xl px-6 md:px-10 py-8 lg:px-14 space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="ui-section-title tracking-tight">
            {SECTION_TITLES.publications}
          </h2>
          {showViewAllLink ? (
            <Link
              href={ROUTES.publications}
              className="ui-view-all-link"
            >
              {LINK_LABELS.viewAllPublications}
            </Link>
          ) : null}
        </div>
      ) : null}

      {slicedPublications.length === 0 ? (
        <p className="ui-meta-text">No additional publications to show yet.</p>
      ) : (
        <div className="space-y-4">
          {slicedPublications.map((publication) => (
            <article
              key={publication.title}
              className="ui-card section-enter"
              style={{ animationDelay: `${slicedPublications.indexOf(publication) * 70}ms` }}
            >
              <div className="flex items-start gap-3">
                <div className="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-md border border-slate-200 bg-background dark:border-slate-700">
                  {publication.image ? (
                    <Image
                      src={publication.image}
                      alt={`${publication.title} publication image`}
                      width={24}
                      height={24}
                      className="h-6 w-6 object-contain"
                    />
                  ) : (
                    <HugeiconsIcon
                      icon={Book04Icon}
                      className="h-5 w-5 text-slate-500 dark:text-slate-300"
                    />
                  )}
                </div>

                <div className="min-w-0 flex-1">
                  <p className="ui-item-title">{publication.title}</p>
                  <p className="ui-body-text mt-2 text-sm">{publication.abstract}</p>
                  <p className="ui-meta-text mt-2">
                    {STATUS_LABELS.publicationStatusPrefix} {publication.status}
                    {publication.doi ? (
                      <>
                        {" "}&bull;{" "}{STATUS_LABELS.publicationDoiPrefix}{" "}
                        <Link
                          href={`https://doi.org/${publication.doi}`}
                          target="_blank"
                          rel="noreferrer"
                          className="ui-link"
                        >
                          {publication.doi}
                        </Link>
                      </>
                    ) : null}
                  </p>
                </div>
              </div>
            </article>
          ))}
        </div>
      )}
    </section>
  );
}
