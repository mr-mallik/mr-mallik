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
  excerpt?: string;
  abstract: string;
  image?: string | null;
  doi?: string | null;
  status: string;
  domains?: string[];
};

export function PublicationsSection({
  limit,
  startFrom = 0,
  heading = true,
  showViewAllLink = false,
  compact = false,
}: {
  limit?: number;
  startFrom?: number;
  heading?: boolean;
  showViewAllLink?: boolean;
  compact?: boolean;
}) {
  const publications = publicationsItems as Publication[];
  const slicedPublications =
    typeof limit === "number"
      ? publications.slice(startFrom, startFrom + limit)
      : publications.slice(startFrom);

  return (
    <section className="space-y-5">
      {heading ? (
        <div className="flex items-center justify-between gap-4">
          <h2 className="ui-section-title ">
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
      ) : compact ? (
        <div className="space-y-5">
          {slicedPublications.map((publication, i) => (
            <article
              key={publication.title}
              className="section-enter"
              style={{ animationDelay: `${i * 70}ms` }}
            >
              {publication.domains && publication.domains.length > 0 ? (
                <div className="mb-2 flex flex-wrap gap-1.5">
                  {publication.domains.map((d) => (
                    <span key={d} className="research-tag">{d}</span>
                  ))}
                </div>
              ) : null}
              <p className="text-sm font-medium leading-snug text-[var(--ui-text-primary)]">
                {publication.title}
              </p>
              <p className="mt-1.5 text-xs text-[var(--ui-text-muted)]">
                {publication.status}
                {publication.doi ? (
                  <>
                    {" "}&bull;{" "}
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
            </article>
          ))}
        </div>
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
                      loading="eager"
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
                  {publication.domains && publication.domains.length > 0 ? (
                    <div className="mb-2 flex flex-wrap gap-1.5">
                      {publication.domains.map((d) => (
                        <span key={d} className="research-tag">{d}</span>
                      ))}
                    </div>
                  ) : null}
                  <p className="ui-item-title">{publication.title}</p>
                  {publication.excerpt ? (
                    <p className="ui-body-text mt-2 text-sm">{publication.excerpt}</p>
                  ) : (
                    <p className="ui-body-text mt-2 text-sm">{publication.abstract}</p>
                  )}
                  <p className="ui-meta-text mt-2">
                    {STATUS_LABELS.publicationStatusPrefix}{" "}
                    {publication.status.toLowerCase().includes("published") ? (
                      <span className="text-green-600 dark:text-green-400">{publication.status}</span>
                    ) : publication.status.toLowerCase().includes("submitted") ? (
                      <span className="text-yellow-600 dark:text-yellow-400">{publication.status}</span>
                    ) : publication.status.toLowerCase().includes("review") ? (
                      <span className="text-orange-600 dark:text-orange-400">{publication.status}</span>
                    ) : publication.status}
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
