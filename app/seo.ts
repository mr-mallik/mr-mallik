import type { Metadata } from "next";

import { EXTERNAL_LINKS, PROFILE, SITE } from "@/app/constants";

const SITE_URL = new URL(PROFILE.websiteUrl);

export const DEFAULT_OG_IMAGE_PATH = "/images/seo_image.png";
export const DEFAULT_OG_IMAGE_URL = new URL(DEFAULT_OG_IMAGE_PATH, SITE_URL).toString();
export const DEFAULT_OG_IMAGE_ALT = `${SITE.ownerName} portfolio, research, and software engineering profile`;

export const SITE_DESCRIPTION =
  "Portfolio of Gulger Mallik (mrmallik), a researcher at the University of Huddersfield and founding software engineer at Cosmokode Ltd, with projects, publications, experience, a resume, and a blog focused on applied AI, explainable AI, and software engineering.";

export const SITE_KEYWORDS = [
  "Gulger Mallik",
  "mrmallik",
  "mr mallik",
  "software engineer",
  "AI researcher",
  "researcher",
  "portfolio",
  "resume",
  "CV",
  "projects",
  "publications",
  "blog",
  "explainable AI",
  "multi-criteria decision making",
  "sustainable software engineering",
  "applied AI",
  "full-stack engineer",
];

export const PERSON_SAME_AS = [
  PROFILE.linkedInUrl,
  PROFILE.githubUrl,
  PROFILE.orcidUrl,
];

const PERSON_ID = absoluteUrl("#person");
const WEBSITE_ID = absoluteUrl("#website");

const BASE_ROBOTS = {
  index: true,
  follow: true,
  googleBot: {
    index: true,
    follow: true,
    "max-image-preview": "large",
    "max-snippet": -1,
    "max-video-preview": -1,
  },
} as const;

const NO_INDEX_ROBOTS = {
  index: false,
  follow: true,
  googleBot: {
    index: false,
    follow: true,
    "max-image-preview": "large",
    "max-snippet": -1,
    "max-video-preview": -1,
  },
} as const;

type MetadataImageInput = {
  url: string;
  alt: string;
};

type PageMetadataInput = {
  title: string;
  description: string;
  path: string;
  keywords?: string[];
  image?: string | null;
  imageAlt?: string | null;
  noIndex?: boolean;
  type?: "website" | "article";
  publishedTime?: string | null;
  modifiedTime?: string | null;
  section?: string;
  tags?: string[];
};

type JsonLdValue = Record<string, unknown>;

function buildRobots(noIndex = false) {
  return noIndex ? NO_INDEX_ROBOTS : BASE_ROBOTS;
}

export function absoluteUrl(path = "/"): string {
  return new URL(path, SITE_URL).toString();
}

export function resolveUrl(input?: string | null): string | undefined {
  if (!input) {
    return undefined;
  }

  const trimmed = input.trim();
  if (!trimmed) {
    return undefined;
  }

  try {
    return new URL(trimmed).toString();
  } catch {
    return new URL(trimmed, SITE_URL).toString();
  }
}

export function sanitizeJsonLd(data: JsonLdValue): string {
  return JSON.stringify(data).replace(/</g, "\\u003c");
}

export function buildOgImage(
  image?: string | null,
  alt = DEFAULT_OG_IMAGE_ALT,
): MetadataImageInput {
  return {
    url: resolveUrl(image) ?? DEFAULT_OG_IMAGE_URL,
    alt: alt.trim() || DEFAULT_OG_IMAGE_ALT,
  };
}

export function createPageMetadata({
  title,
  description,
  path,
  keywords = [],
  image,
  imageAlt,
  noIndex = false,
  type = "website",
  publishedTime,
  modifiedTime,
  section,
  tags,
}: PageMetadataInput): Metadata {
  const ogImage = buildOgImage(image, imageAlt ?? title);

  return {
    metadataBase: SITE_URL,
    title,
    description,
    keywords: [...SITE_KEYWORDS, ...keywords],
    alternates: {
      canonical: path,
    },
    applicationName: SITE.brandName,
    category: "portfolio",
    authors: [{ name: SITE.ownerName, url: PROFILE.websiteUrl }],
    creator: SITE.ownerName,
    publisher: SITE.ownerName,
    formatDetection: {
      email: false,
      address: false,
      telephone: false,
    },
    robots: buildRobots(noIndex),
    openGraph: {
      type,
      url: absoluteUrl(path),
      siteName: SITE.ownerName,
      title,
      description,
      images: [
        {
          url: ogImage.url,
          alt: ogImage.alt,
          width: 1200,
          height: 630,
        },
      ],
      ...(publishedTime ? { publishedTime } : {}),
      ...(modifiedTime ? { modifiedTime } : {}),
      ...(section ? { section } : {}),
      ...(tags && tags.length > 0 ? { tags } : {}),
    },
    twitter: {
      card: "summary_large_image",
      title,
      description,
      images: [ogImage.url],
    },
  };
}

export function buildPersonJsonLd(): JsonLdValue {
  return {
    "@context": "https://schema.org",
    "@type": "Person",
    "@id": PERSON_ID,
    name: SITE.ownerName,
    alternateName: [SITE.brandName, "mrmallik"],
    url: PROFILE.websiteUrl,
    image: absoluteUrl("/images/gulger-mallik@1x1.png"),
    sameAs: PERSON_SAME_AS,
    jobTitle: "Founder and Director",
    worksFor: {
      "@type": "Organization",
      "@id": absoluteUrl("#cosmokode"),
      name: "Cosmokode Ltd",
      url: EXTERNAL_LINKS.cosmokode,
      founder: {
        "@id": PERSON_ID,
      },
      employee: {
        "@id": PERSON_ID,
      },
    },
    alumniOf: {
      "@type": "CollegeOrUniversity",
      name: PROFILE.affiliationName,
      url: PROFILE.affiliationUrl,
    },
    knowsAbout: [
      "Applied AI",
      "Explainable AI",
      "Software Engineering",
      "Machine Learning",
      "Decision Making",
      "Sustainable Software Engineering",
      "Full-Stack Development",
    ],
  };
}

export function buildCosmokodeJsonLd(): JsonLdValue {
  return {
    "@context": "https://schema.org",
    "@type": "Organization",
    "@id": absoluteUrl("#cosmokode"),
    name: "Cosmokode Ltd",
    url: EXTERNAL_LINKS.cosmokode,
    founder: {
      "@id": PERSON_ID,
    },
    employee: {
      "@id": PERSON_ID,
    },
    member: {
      "@id": PERSON_ID,
    },
    sameAs: [EXTERNAL_LINKS.cosmokode],
  };
}

export function buildWebSiteJsonLd(): JsonLdValue {
  return {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "@id": WEBSITE_ID,
    name: SITE.title,
    alternateName: SITE.brandName,
    url: PROFILE.websiteUrl,
    description: SITE_DESCRIPTION,
    inLanguage: "en-GB",
    publisher: {
      "@id": PERSON_ID,
    },
  };
}

export function buildWebPageJsonLd({
  title,
  description,
  path,
  image,
  type = "WebPage",
}: {
  title: string;
  description: string;
  path: string;
  image?: string | null;
  type?: "WebPage" | "ProfilePage" | "CollectionPage";
}): JsonLdValue {
  const ogImage = buildOgImage(image, title);

  return {
    "@context": "https://schema.org",
    "@type": type,
    name: title,
    url: absoluteUrl(path),
    description,
    image: ogImage.url,
    inLanguage: "en-GB",
    isPartOf: {
      "@id": WEBSITE_ID,
    },
    about: {
      "@id": PERSON_ID,
    },
  };
}

export function buildBreadcrumbJsonLd(
  items: Array<{ name: string; path: string }>,
): JsonLdValue {
  return {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    itemListElement: items.map((item, index) => ({
      "@type": "ListItem",
      position: index + 1,
      name: item.name,
      item: absoluteUrl(item.path),
    })),
  };
}

export function buildBlogPostingJsonLd({
  title,
  description,
  path,
  image,
  publishedTime,
  modifiedTime,
  keywords = [],
}: {
  title: string;
  description: string;
  path: string;
  image?: string | null;
  publishedTime?: string | null;
  modifiedTime?: string | null;
  keywords?: string[];
}): JsonLdValue {
  const ogImage = buildOgImage(image, title);

  return {
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "@id": absoluteUrl(path),
    mainEntityOfPage: absoluteUrl(path),
    headline: title,
    description,
    image: [ogImage.url],
    author: {
      "@id": PERSON_ID,
    },
    publisher: {
      "@id": PERSON_ID,
    },
    url: absoluteUrl(path),
    datePublished: publishedTime ?? undefined,
    dateModified: modifiedTime ?? publishedTime ?? undefined,
    inLanguage: "en-GB",
    keywords,
  };
}

export function buildCreativeWorkJsonLd({
  title,
  description,
  path,
  image,
  publishedTime,
  modifiedTime,
  keywords = [],
}: {
  title: string;
  description: string;
  path: string;
  image?: string | null;
  publishedTime?: string | null;
  modifiedTime?: string | null;
  keywords?: string[];
}): JsonLdValue {
  const ogImage = buildOgImage(image, title);

  return {
    "@context": "https://schema.org",
    "@type": "CreativeWork",
    "@id": absoluteUrl(path),
    mainEntityOfPage: absoluteUrl(path),
    name: title,
    description,
    image: [ogImage.url],
    author: {
      "@id": PERSON_ID,
    },
    url: absoluteUrl(path),
    datePublished: publishedTime ?? undefined,
    dateModified: modifiedTime ?? publishedTime ?? undefined,
    inLanguage: "en-GB",
    keywords,
  };
}

export function buildCollectionPageJsonLd({
  title,
  description,
  path,
  items,
}: {
  title: string;
  description: string;
  path: string;
  items: Array<{
    name: string;
    path: string;
    description?: string | null;
    image?: string | null;
  }>;
}): JsonLdValue {
  return {
    "@context": "https://schema.org",
    "@type": "CollectionPage",
    name: title,
    description,
    url: absoluteUrl(path),
    inLanguage: "en-GB",
    isPartOf: {
      "@id": WEBSITE_ID,
    },
    mainEntity: {
      "@type": "ItemList",
      itemListElement: items.map((item, index) => ({
        "@type": "ListItem",
        position: index + 1,
        url: absoluteUrl(item.path),
        name: item.name,
        ...(item.description ? { description: item.description } : {}),
        ...(item.image ? { image: resolveUrl(item.image) ?? DEFAULT_OG_IMAGE_URL } : {}),
      })),
    },
  };
}
