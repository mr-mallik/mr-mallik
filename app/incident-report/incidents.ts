/**
 * Registry of published incident reports.
 *
 * Each entry drives the /incident-report index and the header of its report page.
 * To publish a new report:
 *   1. Create app/incident-report/<YYYYMMDD>/page.tsx (copy an existing report).
 *   2. Add an entry below with the same slug.
 *
 * Keep entries sanitised: no repository, organisation, client or secret names.
 */

export type IncidentSeverity = "Low" | "Medium" | "High" | "Critical";
export type IncidentStatus = "Investigating" | "Monitoring" | "Resolved";

export type Incident = {
  /** URL segment, YYYYMMDD. Must match the folder name under app/incident-report/. */
  slug: string;
  /** ISO date the report was published (YYYY-MM-DD). Used for sorting. */
  date: string;
  /** Human-readable date, e.g. "11 Nov 2026". */
  displayDate: string;
  title: string;
  summary: string;
  severity: IncidentSeverity;
  status: IncidentStatus;
  /** Period the incident covered, shown on the index card. */
  window: string;
  tags: string[];
};

/** Incident pages are reachable by URL but hidden from search engines until this is true. */
export const INCIDENTS_INDEXABLE = false;

export const INCIDENTS: Incident[] = [
  {
    slug: "20261111",
    date: "2026-11-11",
    displayDate: "11 Nov 2026",
    title: "GitHub Access Token Compromise",
    summary:
      "A GitHub access token stored on a third-party server was stolen after the server was compromised through a separate codebase. This report covers what happened, the timeline, the root cause, what was done and what has changed since.",
    severity: "High",
    status: "Resolved",
    window: "25 Oct to 11 Nov 2026",
    tags: ["GitHub", "GitHub Actions", "Credential exposure"],
  },
];

/** Incidents, newest first. */
export function getIncidents(): Incident[] {
  return [...INCIDENTS].sort((a, b) => b.date.localeCompare(a.date));
}

export function getIncident(slug: string): Incident {
  const incident = INCIDENTS.find((i) => i.slug === slug);
  if (!incident) {
    throw new Error(`Unknown incident slug: ${slug}`);
  }
  return incident;
}

export function incidentHref(slug: string): string {
  return `/incident-report/${slug}`;
}
