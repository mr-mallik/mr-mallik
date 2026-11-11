/**
 * Public post-incident report: GitHub access-token compromise, 25 Oct to 11 Nov 2026.
 *
 * This is the sanitised, public version of the internal report. It deliberately
 * leaves out repository and organisation names, secret names, commit hashes,
 * client identities, hostnames and evidence paths. Keep it that way when editing:
 * add specifics to the internal report, not here.
 *
 * Title, date and summary come from the registry in app/incident-report/incidents.ts.
 * Indexing is controlled by INCIDENTS_INDEXABLE in that file.
 */
import type { Metadata } from "next";

import { ROUTES } from "@/app/constants";
import Header from "@/components/header";
import { getIncident, INCIDENTS_INDEXABLE } from "@/app/incident-report/incidents";
import {
  buildWebPageJsonLd,
  createPageMetadata,
  DEFAULT_OG_IMAGE_PATH,
  sanitizeJsonLd,
} from "@/app/seo";

const INCIDENT = getIncident("20261111");

const PATH = ROUTES.incidentReport20261111;
const TITLE = `Incident Report: ${INCIDENT.title} (${INCIDENT.displayDate})`;
const DESCRIPTION = INCIDENT.summary;

export const metadata: Metadata = createPageMetadata({
  title: TITLE,
  description: DESCRIPTION,
  path: PATH,
  keywords: ["incident report", "post-mortem", "GitHub security", "GitHub Actions", "supply chain"],
  noIndex: !INCIDENTS_INDEXABLE,
  type: "article",
  publishedTime: "2026-11-11T12:00:00Z",
  modifiedTime: "2026-11-11T12:00:00Z",
});

/* ─────────────────────────────  Content  ───────────────────────────── */

const SUMMARY_FACTS: { label: string; value: string }[] = [
  { label: "Status", value: "Resolved" },
  { label: "Severity", value: "High" },
  { label: "Attacker active", value: "25 Oct to 11 Nov 2026" },
  { label: "Contained", value: "11 Nov 2026, 11:14 UTC" },
  { label: "Repositories touched", value: "64 (none merged)" },
  { label: "Secrets exposed", value: "1 repository (rotated)" },
];

const SECTIONS = [
  { id: "summary", title: "Summary" },
  { id: "what-happened", title: "What happened" },
  { id: "timeline", title: "Timeline" },
  { id: "root-cause", title: "Root cause" },
  { id: "impact", title: "Impact" },
  { id: "actions", title: "Actions taken" },
  { id: "preventions", title: "Preventions" },
  { id: "lessons", title: "Lessons learned" },
] as const;

type TimelineEntry = { when: string; what: string; tone?: "attack" | "response" };

const TIMELINE: TimelineEntry[] = [
  {
    when: "Before 25 Oct",
    what: "A server run by a third party is compromised through a separate codebase hosted on it. A GitHub access token stored on that server is taken.",
    tone: "attack",
  },
  {
    when: "25 Oct, 17:41–19:40",
    what: "First probe wave: short-lived branches are created and deleted within seconds in 53 repositories to test write access. First small commit pairs are pushed straight to the default branch of a few repositories.",
    tone: "attack",
  },
  {
    when: "27 Oct, 06:23",
    what: "A malicious GitHub Actions workflow is committed to one repository. It runs and leaks that repository's deployment secrets.",
    tone: "attack",
  },
  {
    when: "29 Oct, ~06:30–07:00",
    what: "Second probe wave across the same repositories. More commit pairs. The malicious workflow runs twice more.",
    tone: "attack",
  },
  {
    when: "10 Nov, 13:20–15:03",
    what: "Fake “Dependency Audit” workflows are added in four repositories. Every run is cancelled before it does anything.",
    tone: "attack",
  },
  {
    when: "10 Nov 15:03 → 11 Nov 08:51",
    what: "A decoy branch and pull request (“docs: dependency audit notes”) are pushed to 64 repositories to trigger push-based workflows. The malicious workflow runs six more times. The last attacker action is at 08:51.",
    tone: "attack",
  },
  {
    when: "11 Nov, ~10:09",
    what: "Suspicious activity is spotted. The investigation starts and evidence is collected across every affected repository.",
    tone: "response",
  },
  {
    when: "11 Nov, 10:54",
    what: "The malicious workflow and its run logs are deleted. The exfiltration path is closed.",
    tone: "response",
  },
  {
    when: "11 Nov, late morning",
    what: "Cleanup applied: decoy branches deleted, pull requests closed, fake workflows disabled. Exposed secrets rotated. The stolen token is revoked on GitHub and removed from the server.",
    tone: "response",
  },
  {
    when: "11 Nov, 11:14",
    what: "A verification scan finds no remaining attacker branches, workflows or runs. The incident is contained.",
    tone: "response",
  },
  {
    when: "11 Nov",
    what: "The parties responsible for the compromised server and the affected repositories are notified.",
    tone: "response",
  },
];

const CONTRIBUTING_FACTORS: { factor: string; effect: string }[] = [
  {
    factor: "The token had broad scope",
    effect:
      "It could write to every repository the account could reach, including workflow files, not just the one repository the server needed.",
  },
  {
    factor: "The token never expired",
    effect: "It stayed usable for the whole 17 days.",
  },
  {
    factor: "Default branches weren’t protected",
    effect: "Commits and workflow files went straight to the default branch with no pull request or review.",
  },
  {
    factor: "Any workflow could read secrets",
    effect:
      "The planted workflow could read deployment secrets, and encoding them got past GitHub’s log masking.",
  },
  {
    factor: "Workflows ran on any push",
    effect: "Pushing a branch was enough to run code.",
  },
  {
    factor: "No alerts on account activity",
    effect: "Probes across many repositories went unnoticed for about 17 days.",
  },
];

const ACTIONS: { phase: string; items: string[] }[] = [
  {
    phase: "Containment",
    items: [
      "Deleted the malicious workflow and all of its run logs, so the leaked values are no longer in the logs.",
      "Disabled every attacker-added workflow.",
    ],
  },
  {
    phase: "Eradication",
    items: [
      "Deleted every decoy and probe branch (64 decoy branches, 0 failures).",
      "Closed all 64 decoy pull requests. None had been merged.",
      "Checked the default-branch commit pairs for any leftover changes.",
    ],
  },
  {
    phase: "Credential recovery",
    items: [
      "Revoked the stolen token on GitHub and removed it from the compromised server.",
      "Rotated the exposed deployment secrets. The old values no longer work.",
      "Rotated keys for other potentially exposed projects as a precaution.",
    ],
  },
  {
    phase: "Verification and notification",
    items: [
      "Ran a full verification scan: no attacker branches, workflows or runs remain.",
      "Audited the account. No new SSH or GPG keys, gists, collaborators, invitations, email changes, webhooks, deploy keys or visibility changes.",
      "Notified the parties responsible for the compromised server and the owners of the affected repositories.",
    ],
  },
];

const PREVENTIONS_IN_PLACE = [
  "The stolen token is revoked everywhere, and the exposed secrets are rotated.",
  "No personal access token is kept on any third-party or client-managed server.",
  "A repeatable scan script checks every repository for unexpected branches, workflows and direct pushes to the default branch.",
  "A baseline of known-good keys, webhooks, deploy keys and collaborators is recorded, so changes stand out.",
];

const PREVENTIONS_HARDENING = [
  "Servers get repository-scoped deploy keys or fine-grained tokens with the fewest permissions, an expiry date and no workflow scope.",
  "Branch protection on default branches: pull requests required, force-pushes blocked.",
  "Required review for changes to workflow files (CODEOWNERS on .github/workflows).",
  "Deployment secrets moved into protected environments with required reviewers.",
  "The default GITHUB_TOKEN set to read-only, and push triggers limited to protected branches.",
  "Secret scanning, push protection and alerts on unusual account activity.",
  "Strong two-factor authentication (passkeys or security keys) required on the account and in every organisation.",
];

const LESSONS = [
  {
    title: "A credential is only as safe as the weakest place it’s stored",
    body: "The breach came through a separate codebase on a shared server, not through GitHub. Any secret on a host shares that host’s risk.",
  },
  {
    title: "Scope and expiry limit the damage",
    body: "A token limited to one repository with read-only access would have turned an account-wide incident into a minor one.",
  },
  {
    title: "CI/CD is part of the attack surface",
    body: "Workflows that run on any push and can read secrets let anyone with write access run code. Protect workflows like production code.",
  },
  {
    title: "Detection matters as much as prevention",
    body: "The attacker was noisy: dozens of repositories, within minutes. Basic alerts would have cut 17 days down to hours.",
  },
];

/* ─────────────────────────────  Small building blocks  ───────────────────────────── */

function SectionHeading({ id, index, title }: { id: string; index: number; title: string }) {
  return (
    <h2 id={id} className="ui-section-title scroll-mt-24 flex items-baseline gap-3">
      <span className="ui-meta-text font-mono tabular-nums" aria-hidden="true">
        {String(index).padStart(2, "0")}
      </span>
      {title}
    </h2>
  );
}

function BulletList({ items }: { items: string[] }) {
  return (
    <ul className="ui-body-text space-y-2 pl-5 list-disc marker:text-[var(--ui-accent)]">
      {items.map((item) => (
        <li key={item}>{item}</li>
      ))}
    </ul>
  );
}

function Callout({ children, tone = "neutral" }: { children: React.ReactNode; tone?: "neutral" | "success" }) {
  const accent = tone === "success" ? "var(--ui-success)" : "var(--ui-accent)";
  return (
    <div
      className="ui-bg-elevated ui-body-text rounded-lg border-l-4 px-5 py-4"
      style={{ borderLeftColor: accent }}
    >
      {children}
    </div>
  );
}

/* ─────────────────────────────  Page  ───────────────────────────── */

export default function IncidentReport20261111Page() {
  return (
    <article className="w-full ui-container ui-container-narrow py-4 sm:py-8 lg:py-12">
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{
          __html: sanitizeJsonLd(
            buildWebPageJsonLd({
              title: TITLE,
              description: DESCRIPTION,
              path: PATH,
              image: DEFAULT_OG_IMAGE_PATH,
            }),
          ),
        }}
      />

      <div className="space-y-10 sm:space-y-14">
        {/* Header */}
        <div className="space-y-5">
          <Header link={ROUTES.incidentReports} title={TITLE} description={DESCRIPTION} />
          <p className="ui-meta-text">
            Published 11 November 2026 · Gulger Mallik · All times UTC
          </p>
        </div>

        {/* At a glance */}
        <section aria-label="At a glance">
          <dl className="grid grid-cols-2 gap-px overflow-hidden rounded-xl border border-[var(--ui-border-soft)] bg-[var(--ui-border-soft)] sm:grid-cols-3">
            {SUMMARY_FACTS.map(({ label, value }) => (
              <div key={label} className="bg-background px-4 py-4 sm:px-5">
                <dt className="ui-meta-text uppercase tracking-wide">{label}</dt>
                <dd
                  className={`mt-1 text-[length:var(--ui-fs-md)] font-semibold ${
                    label === "Status" ? "text-[var(--ui-success)]" : "ui-text-primary"
                  }`}
                >
                  {value}
                </dd>
              </div>
            ))}
          </dl>
        </section>

        <div className="grid gap-10 lg:grid-cols-[13rem_minmax(0,1fr)] lg:gap-14">
          {/* Contents */}
          <nav aria-label="Contents" className="lg:sticky lg:top-24 lg:self-start">
            <p className="ui-meta-text mb-3 uppercase tracking-wide">Contents</p>
            <ol className="space-y-2 text-[length:var(--ui-fs-sm)]">
              {SECTIONS.map((s, i) => (
                <li key={s.id}>
                  <a href={`#${s.id}`} className="ui-text-secondary hover:text-[var(--ui-text-link)]">
                    <span className="font-mono tabular-nums ui-text-muted mr-2">{i + 1}.</span>
                    {s.title}
                  </a>
                </li>
              ))}
            </ol>
          </nav>

          <div className="min-w-0 space-y-14">
            {/* 1. Summary */}
            <section className="space-y-4">
              <SectionHeading id="summary" index={1} title="Summary" />
              <p className="ui-body-text">
                A server run by a third party was compromised through a separate codebase hosted on it. That
                server held a GitHub personal access token for my account, and the attacker used it. For about
                17 days they had write access to the repositories the account could reach, across several
                organisations.
              </p>
              <p className="ui-body-text">
                They probed repositories for write access, pushed small commits to default branches and added
                GitHub Actions workflows. In one repository, a planted workflow leaked deployment secrets. They
                also pushed decoy pull requests to 64 repositories to trigger more workflows.
              </p>
              <Callout tone="success">
                <strong className="ui-text-primary">Current status:</strong> resolved. The stolen token is
                revoked on GitHub and removed from the server. Exposed secrets are rotated and no longer work.
                Every attacker branch, workflow and run is removed. None of the decoy pull requests was merged.
                The responsible parties have been told.
              </Callout>
            </section>

            {/* 2. What happened */}
            <section className="space-y-5">
              <SectionHeading id="what-happened" index={2} title="What happened" />
              <div className="space-y-6">
                {[
                  {
                    h: "Initial access",
                    p: "The attacker got into a server run by a third party through a different codebase deployed on it. A GitHub personal access token with repository and workflow permissions was stored on the same server. Every malicious action was done as my account with that token. There’s no sign of a vulnerability in GitHub itself.",
                  },
                  {
                    h: "Reconnaissance",
                    p: "Twice, a randomly named branch was created, pushed and deleted within about ten seconds in 53 repositories. This is a quiet way to find out which repositories a token can write to.",
                  },
                  {
                    h: "Direct commits to default branches",
                    p: "Pairs of commits titled “ci: refresh build cache” and “ci: restore” were pushed straight to the default branch of five repositories. Each pair added a change and then reverted it. This most likely triggered CI where secrets are available, without changing the final code.",
                  },
                  {
                    h: "Secret exfiltration",
                    p: "In one repository, a workflow named “exfil” printed the repository’s deployment secrets to the job log. The values were base64-encoded and reversed first, so GitHub’s automatic masking didn’t catch them. It ran successfully nine times.",
                  },
                  {
                    h: "Decoy pull requests",
                    p: "A branch with a three-line “dependency audit notes” file was pushed to 64 repositories, each with a matching pull request. The pull request was camouflage. The push was the point, because it fires any workflow set to run on push.",
                  },
                  {
                    h: "Fake audit workflows",
                    p: "Workflows called “Dependency Audit” were added in four repositories. All of their runs were cancelled before the payload step, so nothing ran.",
                  },
                ].map(({ h, p }) => (
                  <div key={h} className="space-y-1.5">
                    <h3 className="ui-item-title">{h}</h3>
                    <p className="ui-body-text">{p}</p>
                  </div>
                ))}
              </div>
            </section>

            {/* 3. Timeline */}
            <section className="space-y-5">
              <SectionHeading id="timeline" index={3} title="Timeline" />
              <div className="flex flex-wrap gap-4 ui-meta-text">
                <span className="inline-flex items-center gap-2">
                  <span className="h-2.5 w-2.5 rounded-full bg-[var(--ui-danger)]" aria-hidden="true" />
                  Attacker activity
                </span>
                <span className="inline-flex items-center gap-2">
                  <span className="h-2.5 w-2.5 rounded-full bg-[var(--ui-success)]" aria-hidden="true" />
                  Response
                </span>
              </div>
              <ol className="relative space-y-6 border-l border-[var(--ui-border-soft)] pl-6">
                {TIMELINE.map(({ when, what, tone }) => (
                  <li key={when + what} className="relative">
                    <span
                      className="absolute -left-[1.85rem] top-1.5 h-3 w-3 rounded-full ring-4 ring-[var(--background)]"
                      style={{
                        background: tone === "response" ? "var(--ui-success)" : "var(--ui-danger)",
                      }}
                      aria-hidden="true"
                    />
                    <p className="font-mono text-[length:var(--ui-fs-xs)] font-semibold ui-text-primary">
                      {when}
                      <span className="sr-only">{tone === "response" ? " (response)" : " (attacker activity)"}</span>
                    </p>
                    <p className="ui-body-text mt-1">{what}</p>
                  </li>
                ))}
              </ol>
              <p className="ui-meta-text">
                Time from first observed attacker activity to containment: about 17 days. From detection to
                containment: about an hour.
              </p>
            </section>

            {/* 4. Root cause */}
            <section className="space-y-5">
              <SectionHeading id="root-cause" index={4} title="Root cause" />
              <Callout>
                <strong className="ui-text-primary">Primary cause:</strong> a third-party server was compromised
                through a separate codebase deployed on it. That server stored a long-lived GitHub personal access
                token with broad repository and workflow permissions. Whoever controlled the server could act as
                my account.
              </Callout>
              <h3 className="ui-item-title pt-2">Contributing factors</h3>
              <div className="overflow-x-auto rounded-xl border border-[var(--ui-border-soft)]">
                <table className="w-full min-w-[32rem] text-left">
                  <thead className="ui-bg-elevated">
                    <tr className="ui-meta-text uppercase tracking-wide">
                      <th scope="col" className="px-4 py-3 font-medium">Factor</th>
                      <th scope="col" className="px-4 py-3 font-medium">Effect</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-[var(--ui-border-subtle)]">
                    {CONTRIBUTING_FACTORS.map(({ factor, effect }) => (
                      <tr key={factor} className="align-top">
                        <th scope="row" className="px-4 py-3 font-semibold ui-text-primary text-[length:var(--ui-fs-sm)]">
                          {factor}
                        </th>
                        <td className="px-4 py-3 ui-text-secondary text-[length:var(--ui-fs-sm)] leading-relaxed">
                          {effect}
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </section>

            {/* 5. Impact */}
            <section className="space-y-5">
              <SectionHeading id="impact" index={5} title="Impact" />
              <div className="grid gap-4 sm:grid-cols-2">
                <div className="rounded-xl border border-[var(--ui-border-soft)] p-5 space-y-3">
                  <h3 className="ui-item-title">Confirmed</h3>
                  <BulletList
                    items={[
                      "Deployment secrets from one repository were exposed. They have been rotated and the old values don’t work.",
                      "Unauthorised commits, branches, workflows and pull requests across up to 64 repositories. All removed or closed.",
                    ]}
                  />
                </div>
                <div className="rounded-xl border border-[var(--ui-border-soft)] p-5 space-y-3">
                  <h3 className="ui-item-title">Verified not affected</h3>
                  <BulletList
                    items={[
                      "No pull request was merged, and no lasting code changes remain.",
                      "No new SSH or GPG keys, gists or account email changes.",
                      "No new collaborators, invitations or organisation members.",
                      "No private repositories made public.",
                      "No organisation-level secrets exposed.",
                    ]}
                  />
                </div>
              </div>
            </section>

            {/* 6. Actions taken */}
            <section className="space-y-5">
              <SectionHeading id="actions" index={6} title="Actions taken" />
              <div className="space-y-6">
                {ACTIONS.map(({ phase, items }) => (
                  <div key={phase} className="space-y-2">
                    <h3 className="ui-item-title">{phase}</h3>
                    <BulletList items={items} />
                  </div>
                ))}
              </div>
            </section>

            {/* 7. Preventions */}
            <section className="space-y-5">
              <SectionHeading id="preventions" index={7} title="Preventions" />
              <div className="space-y-2">
                <h3 className="ui-item-title">In place</h3>
                <BulletList items={PREVENTIONS_IN_PLACE} />
              </div>
              <div className="space-y-2">
                <h3 className="ui-item-title">Being rolled out</h3>
                <BulletList items={PREVENTIONS_HARDENING} />
              </div>
            </section>

            {/* 8. Lessons learned */}
            <section className="space-y-5">
              <SectionHeading id="lessons" index={8} title="Lessons learned" />
              <div className="grid gap-4 sm:grid-cols-2">
                {LESSONS.map(({ title, body }) => (
                  <div key={title} className="ui-bg-elevated rounded-xl p-5 space-y-2">
                    <h3 className="ui-item-title">{title}</h3>
                    <p className="ui-body-text">{body}</p>
                  </div>
                ))}
              </div>
            </section>

            <footer className="border-t border-[var(--ui-border-subtle)] pt-6">
              <p className="ui-meta-text">
                This is a sanitised public summary. Repository, organisation and client names, secret names and
                internal evidence are left out on purpose. If you think you were affected, please get in touch
                through the <a href={ROUTES.contact} className="ui-link">contact page</a>.
              </p>
            </footer>
          </div>
        </div>
      </div>
    </article>
  );
}
