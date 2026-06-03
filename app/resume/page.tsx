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

export default function ResumePage() {
  const [viewMode, setViewMode] = useState<ResumeViewMode>(
    RESUME_VIEW_MODES.summarised,
  );
  const items = workItems as WorkItem[];
  const education = educationItems as EducationItem[];
  const publications = publicationsItems as Publication[];
  const skills = skillsItems as SkillCategory[];

  const handleDownload = () => {
    window.print();
  };

  return (
    <div className="mx-auto max-w-[660px]">
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
          <h1 className="hero-name">
            {SITE.ownerName}
          </h1>
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
          <div
            key={`${item.role}-${item.period}`}
            className="resume-fade-in mt-6"
          >
            <p className="ui-item-title">
              <span>
                {item.role} @{" "}
                {item.url ? (
                  <Link
                    href={item.url}
                    target="_blank"
                    rel="noreferrer"
                    className="ui-link"
                  >
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
          <div
            key={`${item.degree}-${item.duration}`}
            className="resume-fade-in mt-6"
          >
            <p className="ui-item-title">
              <span className="font-medium">{item.degree}</span>
              <span className="ui-text-muted"> @ {item.institution}</span>
            </p>
            <p className="ui-meta-text mt-1">
              {item.duration} &#8226; {item.location}
              {item.grade ? (
                <>
                  <span className="font-medium"> &#124; {STATUS_LABELS.educationGradePrefix} {item.grade}</span>
                </>
              ) : null}{" "}
            </p>
          </div>
        ))}
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
