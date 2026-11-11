/**
 * /incident-report: index of published incident reports, grouped by year and
 * sorted newest first. Entries come from app/incident-report/incidents.ts.
 */
import type { Metadata } from "next";
import Link from "next/link";
import { HugeiconsIcon } from "@hugeicons/react";
import { ArrowRight01Icon } from "@hugeicons/core-free-icons";

import { ROUTES } from "@/app/constants";
import Header from "@/components/header";
import {
  buildWebPageJsonLd,
  createPageMetadata,
  DEFAULT_OG_IMAGE_PATH,
  sanitizeJsonLd,
} from "@/app/seo";
import {
  getIncidents,
  incidentHref,
  INCIDENTS_INDEXABLE,
  type Incident,
  type IncidentSeverity,
  type IncidentStatus,
} from "@/app/incident-report/incidents";

const TITLE = "Incident Reports";
const DESCRIPTION =
  "Public post-incident reports for security and reliability incidents affecting my projects. Each one covers what happened, the timeline, the root cause, what was done and what has changed since.";

export const metadata: Metadata = createPageMetadata({
  title: TITLE,
  description: DESCRIPTION,
  path: ROUTES.incidentReports,
  keywords: ["incident reports", "post-mortems", "security"],
  noIndex: !INCIDENTS_INDEXABLE,
});

const SEVERITY_COLOUR: Record<IncidentSeverity, string> = {
  Low: "var(--ui-text-muted)",
  Medium: "var(--ui-accent-strong)",
  High: "var(--ui-danger)",
  Critical: "var(--ui-danger)",
};

const STATUS_COLOUR: Record<IncidentStatus, string> = {
  Investigating: "var(--ui-danger)",
  Monitoring: "var(--ui-accent-strong)",
  Resolved: "var(--ui-success)",
};

function Pill({ label, colour }: { label: string; colour: string }) {
  return (
    <span
      className="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-[length:var(--ui-fs-xs)] font-medium"
      style={{ color: colour, borderColor: `color-mix(in srgb, ${colour} 35%, transparent)` }}
    >
      <span className="h-1.5 w-1.5 rounded-full" style={{ background: colour }} aria-hidden="true" />
      {label}
    </span>
  );
}

function IncidentCard({ incident }: { incident: Incident }) {
  return (
    <li>
      <Link
        href={incidentHref(incident.slug)}
        className="group grid gap-3 rounded-xl border border-[var(--ui-border-soft)] p-5 transition-colors hover:border-[var(--ui-text-muted)] sm:grid-cols-[8rem_minmax(0,1fr)_auto] sm:items-start sm:gap-6"
      >
        <time dateTime={incident.date} className="font-mono text-[length:var(--ui-fs-sm)] font-semibold ui-text-primary">
          {incident.displayDate}
        </time>

        <div className="min-w-0 space-y-2">
          <h3 className="ui-item-title group-hover:text-[var(--ui-text-link)]">{incident.title}</h3>
          <p className="ui-body-text">{incident.summary}</p>
          <div className="flex flex-wrap items-center gap-2 pt-1">
            <Pill label={incident.status} colour={STATUS_COLOUR[incident.status]} />
            <Pill label={`${incident.severity} severity`} colour={SEVERITY_COLOUR[incident.severity]} />
            <span className="ui-meta-text">Active {incident.window}</span>
          </div>
        </div>

        <span className="hidden items-center gap-1 ui-meta-text group-hover:text-[var(--ui-text-link)] sm:inline-flex">
          Read report
          <HugeiconsIcon icon={ArrowRight01Icon} className="h-3.5 w-3.5" />
        </span>
      </Link>
    </li>
  );
}

export default function IncidentReportsPage() {
  const incidents = getIncidents();

  // Group by year, keeping newest-first order.
  const byYear = incidents.reduce<Map<string, Incident[]>>((map, incident) => {
    const year = incident.date.slice(0, 4);
    map.set(year, [...(map.get(year) ?? []), incident]);
    return map;
  }, new Map());

  return (
    <section className="w-full ui-container ui-container-narrow py-4 sm:py-8 lg:py-12">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: TITLE,
              description: DESCRIPTION,
              path: ROUTES.incidentReports,
              image: DEFAULT_OG_IMAGE_PATH,
            }),
          ),
        }}
      />

      <div className="space-y-10 sm:space-y-12">
        <Header link={ROUTES.home} title={TITLE} description={DESCRIPTION} />

        {incidents.length === 0 ? (
          <p className="ui-body-text">No incidents have been reported.</p>
        ) : (
          [...byYear.entries()].map(([year, items]) => (
            <section key={year} aria-labelledby={`year-${year}`} className="space-y-4">
              <div className="flex items-baseline justify-between gap-4 border-b border-[var(--ui-border-subtle)] pb-2">
                <h2 id={`year-${year}`} className="ui-section-title">
                  {year}
                </h2>
                <span className="ui-meta-text">
                  {items.length} {items.length === 1 ? "report" : "reports"}
                </span>
              </div>
              <ol className="space-y-4">
                {items.map((incident) => (
                  <IncidentCard key={incident.slug} incident={incident} />
                ))}
              </ol>
            </section>
          ))
        )}
      </div>
    </section>
  );
}
