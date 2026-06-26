"use client";

import { useState } from "react";
import Link from "next/link";
import {
  LINK_LABELS,
  PAGE_COPY,
  PROFILE,
  RESUME_VIEW_MODES,
  ResumeViewMode,
  ROUTES,
  SECTION_TITLES,
  SITE,
  STATUS_LABELS,
} from "@/app/constants";
import Header from "@/components/header";

import educationItems from "@/data/education.json";
import publicationsItems from "@/data/publications.json";
import skillsItems from "@/data/skills.json";
import workItems from "@/data/work.json";

type WorkItem = {
  company: string;
  role: string;
  period: string;
  location: string;
  url?: string;
  summary: string;
  details: string[];
};

type EducationItem = {
  degree: string;
  institution: string;
  location: string;
  grade?: string;
  duration: string;
};

type SkillCategory = {
  category: string;
  skills: string[];
};

type Publication = {
  title: string;
  abstract: string;
  doi?: string | null;
  status: string;
};

function esc(str: string): string {
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;");
}

function buildResumeHtml(
  items: WorkItem[],
  education: EducationItem[],
  skills: SkillCategory[],
  publications: Publication[],
): string {
  const experienceRows = items
    .map(
      (item) => `
    <div class="entry">
      <div class="entry-header">
        <div>
          <span class="entry-title">${esc(item.role)}</span>
          <span class="entry-org"> -${esc(item.company)}</span>
        </div>
        <span class="entry-meta">${esc(item.period)}${item.location ? ` · ${esc(item.location)}` : ""}</span>
      </div>
      <ul class="entry-list">
        ${item.details.map((d) => `<li>${esc(d)}</li>`).join("\n        ")}
      </ul>
    </div>`,
    )
    .join("\n");

  const educationRows = [...education]
    .reverse()
    .map(
      (item) => `
    <div class="entry">
      <div class="entry-header">
        <div>
          <span class="entry-title">${esc(item.degree)}</span>
          <span class="entry-org"> -${esc(item.institution)}</span>
        </div>
        <span class="entry-meta">${esc(item.duration)} · ${esc(item.location)}${item.grade ? ` · ${esc(item.grade)}` : ""}</span>
      </div>
    </div>`,
    )
    .join("\n");

  const skillRows = skills
    .map(
      (g) =>
        `<p class="skill-row"><strong>${esc(g.category)}:</strong> ${esc(g.skills.join(", "))}</p>`,
    )
    .join("\n    ");

  const pubRows = publications
    .map(
      (p) => `
    <div class="entry">
      <p class="entry-title">${esc(p.title)}</p>
      <p class="entry-abstract">${esc(p.abstract)}</p>
      <p class="entry-meta">Status: ${esc(p.status)}${p.doi ? ` · DOI: ${esc(p.doi)}` : ""}</p>
    </div>`,
    )
    .join("\n");

  return `<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>${esc(SITE.ownerName)} -Resume</title>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
      font-size: 13px;
      line-height: 1.55;
      color: #111;
      background: #fff;
      padding: 40px;
      max-width: 800px;
      margin: 0 auto;
    }

    /* ── Header ── */
    .resume-header { text-align: center; margin-bottom: 28px; }
    .resume-name {
      font-size: 22px;
      font-weight: 700;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      margin-bottom: 6px;
    }
    .resume-contact {
      font-size: 11.5px;
      color: #444;
    }
    .resume-contact a { color: #0a66c2; text-decoration: none; }
    .resume-contact span { margin: 0 6px; color: #ccc; }

    /* ── Section ── */
    .section { margin-bottom: 22px; }
    .section-title {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: #555;
      border-bottom: 1px solid #ddd;
      padding-bottom: 4px;
      margin-bottom: 12px;
    }

    /* ── Entry ── */
    .entry { margin-bottom: 12px; }
    .entry:last-child { margin-bottom: 0; }
    .entry-header {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      gap: 12px;
      flex-wrap: wrap;
    }
    .entry-title { font-weight: 600; font-size: 13px; }
    .entry-org { color: #444; font-weight: 400; }
    .entry-meta { font-size: 11.5px; color: #666; white-space: nowrap; }
    .entry-list {
      margin-top: 5px;
      padding-left: 18px;
      color: #333;
    }
    .entry-list li { margin-bottom: 2px; }
    .entry-abstract { font-size: 12px; color: #444; margin-top: 3px; }

    /* ── Skills ── */
    .skill-row { margin-bottom: 4px; color: #333; }
    .skill-row strong { color: #111; }

    /* ── Print ── */
    @media print {
      body { padding: 20px; font-size: 12px; }
      @page { margin: 15mm 18mm; size: A4; }
      a { color: #111 !important; }
    }
  </style>
</head>
<body>
  <header class="resume-header">
    <p class="resume-name">${esc(SITE.ownerName)}</p>
    <p class="resume-contact">
      ${esc(PROFILE.phone)}
      <span>|</span>
      <a href="mailto:${esc(PROFILE.primaryEmail)}">${esc(PROFILE.primaryEmail)}</a>
      <span>|</span>
      <a href="${esc(PROFILE.linkedInUrl)}">${esc(PROFILE.linkedInDisplay)}</a>
      <span>|</span>
      <a href="${esc(PROFILE.websiteUrl)}">${esc(PROFILE.websiteLabel)}</a>
    </p>
  </header>

  <section class="section">
    <h2 class="section-title">Experience</h2>
    ${experienceRows}
  </section>

  <section class="section">
    <h2 class="section-title">Education</h2>
    ${educationRows}
  </section>

  <section class="section">
    <h2 class="section-title">Skills</h2>
    ${skillRows}
  </section>

  <section class="section">
    <h2 class="section-title">Publications</h2>
    ${pubRows}
  </section>
</body>
</html>`;
}

export default function ResumePage() {
  const [viewMode, setViewMode] = useState<ResumeViewMode>(
    RESUME_VIEW_MODES.summarised,
  );
  const items = workItems as WorkItem[];
  const education = educationItems as EducationItem[];
  const publications = publicationsItems as Publication[];
  const skills = skillsItems as SkillCategory[];

  const handleDownload = () => {
    const html = buildResumeHtml(items, education, skills, publications);
    const blob = new Blob([html], { type: "text/html;charset=utf-8" });
    const url = URL.createObjectURL(blob);
    const anchor = document.createElement("a");
    anchor.href = url;
    anchor.download = "gulger-mallik-resume.html";
    anchor.click();
    URL.revokeObjectURL(url);
  };

  return (
    <div className="max-w-3xl mx-auto w-full px-6 md:px-10">
      <div className="resume-fade-in">
        <div className="mb-10">
          <Header link={ROUTES.home}>
            <button
              type="button"
              onClick={handleDownload}
              className="ui-subtle-button"
            >
              {LINK_LABELS.download}
            </button>
          </Header>
        </div>
      </div>

      <div className="resume-fade-in">
        <header className="flex flex-col items-center justify-center gap-3 text-center">
          <h1 className="hero-name">{SITE.ownerName}</h1>
          <p className="ui-control-text max-w-full sm:text-center">
            {PROFILE.phone} &#124; {PROFILE.primaryEmail} &#124;{" "}
            <Link
              href={PROFILE.linkedInUrl}
              target="_blank"
              rel="noreferrer"
              className="ui-link"
            >
              {PROFILE.linkedInDisplay}
            </Link>{" "}
            &#124;{" "}
            <Link
              href={PROFILE.websiteUrl}
              target="_blank"
              rel="noreferrer"
              className="ui-link"
            >
              {PROFILE.websiteLabel}
            </Link>
          </p>
        </header>
      </div>

      <section className="mt-10">
        <div className="resume-fade-in">
          <div className="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <p className="ui-resume-title">{SECTION_TITLES.experience}</p>
            <fieldset className="ui-control-text flex items-center gap-4">
              <legend className="sr-only">{PAGE_COPY.resumeViewModeLegend}</legend>
              <label className="inline-flex cursor-pointer items-center gap-1.5">
                <input
                  type="radio"
                  name="experience-view"
                  value={RESUME_VIEW_MODES.summarised}
                  checked={viewMode === RESUME_VIEW_MODES.summarised}
                  onChange={() => setViewMode(RESUME_VIEW_MODES.summarised)}
                  className="ui-radio-control"
                />
                <span>{LINK_LABELS.summarised}</span>
              </label>
              <label className="inline-flex cursor-pointer items-center gap-1.5">
                <input
                  type="radio"
                  name="experience-view"
                  value={RESUME_VIEW_MODES.detailed}
                  checked={viewMode === RESUME_VIEW_MODES.detailed}
                  onChange={() => setViewMode(RESUME_VIEW_MODES.detailed)}
                  className="ui-radio-control"
                />
                <span>{LINK_LABELS.detailed}</span>
              </label>
            </fieldset>
          </div>
          <div className="ui-divider" />
        </div>

        {items.map((item) => (
          <div key={`${item.role}-${item.period}`} className="resume-fade-in mt-6">
            <p className="ui-item-title">
              <span>
                {item.role} @{" "}
                {item.url ? (
                  <Link href={item.url} target="_blank" rel="noreferrer" className="ui-link">
                    {item.company}
                  </Link>
                ) : (
                  <span>{item.company}</span>
                )}
              </span>
            </p>

            <p className="ui-meta-text mt-1">
              {item.period}
              {item.location ? <>{" "}&bull;{" "}{item.location}</> : null}
            </p>

            {viewMode === RESUME_VIEW_MODES.summarised ? (
              <div className="ui-body-text mt-3">
                <p>{item.summary}</p>
              </div>
            ) : null}

            {viewMode === RESUME_VIEW_MODES.detailed ? (
              <ul className="ui-body-text ui-list-marker mt-3 list-disc space-y-2 pl-5">
                {item.details.map((detail) => (
                  <li key={detail}>{detail}</li>
                ))}
              </ul>
            ) : null}
          </div>
        ))}
      </section>

      <section className="mt-10">
        <div className="resume-fade-in">
          <p className="ui-resume-title">{SECTION_TITLES.education}</p>
          <div className="ui-divider" />
        </div>

        {[...education].reverse().map((item) => (
          <div key={`${item.degree}-${item.duration}`} className="resume-fade-in mt-6">
            <p className="ui-item-title">
              <span className="font-medium">{item.degree}</span>
              <span className="ui-text-muted"> @ {item.institution}</span>
            </p>
            <p className="ui-meta-text mt-1">
              {item.duration} &#8226; {item.location}
              {item.grade ? (
                <span className="font-medium"> &#124; {STATUS_LABELS.educationGradePrefix} {item.grade}</span>
              ) : null}
            </p>
          </div>
        ))}
      </section>

      <section className="mt-10">
        <div className="resume-fade-in">
          <p className="ui-resume-title">{SECTION_TITLES.skills}</p>
          <div className="ui-divider" />
          <div className="ui-body-text mt-4">
            {skills.map((group, index) => (
              <p key={group.category} className={index === 0 ? "" : "mt-2"}>
                <span className="font-medium">{group.category}:</span>{" "}
                {group.skills.join(", ")}
              </p>
            ))}
          </div>
        </div>
      </section>

      <section className="mt-10">
        <div className="resume-fade-in">
          <p className="ui-resume-title">{SECTION_TITLES.publications}</p>
          <div className="ui-divider" />
          <div className="mt-4 space-y-4">
            {publications.map((publication) => (
              <article key={publication.title} className="space-y-2">
                <p className="ui-item-title">{publication.title}</p>
                <p className="ui-body-text text-sm">{publication.abstract}</p>
                <p className="ui-meta-text">
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
              </article>
            ))}
          </div>
        </div>
      </section>
    </div>
  );
}
