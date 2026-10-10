export const SITE = {
  ownerName: "Gulger Mallik",
  brandName: "mr mallik",
  title: "Gulger Mallik",
  copyrightSuffix: "All rights reserved.",
} as const;

// Spellings people actually type when searching for Gulger Mallik.
// Surfaced in structured data, llms.txt, and visible copy so search and
// answer engines resolve them to the same person.
export const NAME_VARIANTS = [
  "Mr Mallik",
  "Gulgar Mallik",
  "Gulger Malik",
  "Gulgar Malik",
  "Gulger Mallick",
  "Gulzar Mallik",
] as const;

export const LOCATION = {
  locality: "Huddersfield",
  region: "England",
  country: "GB",
  countryLabel: "United Kingdom",
} as const;

export const PROFILE = {
  primaryEmail: "gulgermallik@gmail.com",
  workEmail: "gulger.mallik@hud.ac.uk",
  phone: "07767924720",
  phoneInternational: "+447767924720",
  // Server-only: NEXT_PUBLIC_APP_URL is not NEXT_PUBLIC_-prefixed, so it is
  // undefined in the browser bundle. Client components must use
  // websiteCanonicalUrl instead or they will hydration-mismatch.
  websiteUrl: process.env.NEXT_PUBLIC_APP_URL || "https://www.mrmallik.com",
  websiteCanonicalUrl: "https://www.mrmallik.com",
  websiteLabel: "mrmallik.com",
  linkedInUrl: "https://www.linkedin.com/in/mrmallik/",
  linkedInDisplay: "linkedin.com/in/mrmallik/",
  githubUrl: "https://github.com/mr-mallik",
  orcidUrl: "https://orcid.org/0009-0002-5110-8575",
  twitterHandle: "@gulger_mallik",
  affiliationName: "University of Huddersfield",
  affiliationUrl: "https://hud.ac.uk",
  profileImageAlt: "Profile picture of Gulger Mallik",
  youTubeUrl: "https://www.youtube.com/@its_mrmallik",
  youtubeDisplay: "youtube.com/@its_mrmallik",
} as const;

export const ROUTES = {
  home: "/",
  resume: "/resume",
  projects: "/projects",
  publications: "/publications",
  experience: "/experience",
  blogs: "/blogs",
  about: "/about",
  contact: "/contact",
  links: "/links",
  contactCard: "/links/contact.vcf",
} as const;

// Shareable in-page anchors, e.g. mrmallik.com/#kind-words
export const SECTION_IDS = {
  testimonials: "kind-words",
} as const;

// Routes rendered without the site navigation, footer, and scroll helpers.
export const STANDALONE_ROUTES = [ROUTES.links] as const;

export const EXTERNAL_LINKS = {
  cosmokode: "https://cosmokode.com",
  testimonialForm: "https://forms.gle/ne3uAGKhF3f38ZAP7",
} as const;

export const MAIL = {
  subject: "Let's connect",
  bodyLines: [
    "Hi Gulger,",
    "I came across your profile and would like to connect with you.",
    "Best regards,",
  ],
} as const;

export const SECTION_TITLES = {
  projects: "Selected works",
  workExperience: "Work experience",
  experience: "Experience",
  achievements: "Achievements",
  education: "Education",
  skills: "Skills",
  publications: "Publications",
  showcase: "Worked alongside",
  testimonials: "Kind words",
  blog: "Blog",
} as const;

export const LINK_LABELS = {
  back: "Back",
  home: "Home",
  resume: "Resume",
  viewAllProjects: "View all projects",
  viewAllPublications: "View all publications",
  download: "Download",
  summarised: "Summarised",
  detailed: "Detailed",
  pdfFormat: "resume",
  viewAllPosts: "View all posts",
} as const;

export const PAGE_COPY = {
  roleTitle: "PhD Researcher",
  homepageRolePrefix: "PhD Researcher at the",
  homeIntroCompanyPrefix: "I'm a co-founder of",
  homeIntroCompanySuffix:
    ", a studio building AI-powered products for businesses and startups. I enjoy creating systems that help teams move faster, make better decisions, and feel more confident using AI.",
  projectsPageDescription:
    "A selection of projects that bring applied AI research and software engineering together.",
  publicationsPageDescription:
    "Research publications and manuscripts exploring explainable AI and practical software systems.",
  experiencePageDescription:
    "Professional roles spanning applied AI research and software engineering.",
  blogsPageDescription:
    "Ideas, lessons, and reflections on software engineering, applied research, and the evolving tech landscape.",
  resumeViewModeLegend: "Experience view mode",
} as const;

export const SOCIAL_LINKS = [
  {
    "label": "LinkedIn",
    "url": "https://www.linkedin.com/in/mrmallik/",
    "handle": "mrmallik",
    "icon": "Linkedin02Icon"
  },
  {
    "label": "GitHub",
    "url": "https://github.com/mr-mallik",
    "handle": "mr-mallik",
    "icon": "GithubIcon"
  },
  {
    "label": "Gmail",
    "url": "mailto:gulgermallik@gmail.com",
    "handle": "gulgermallik@gmail.com",
    "icon": "MailAtSign01Icon"
  },
] as const;

export const SOCIAL_HANDLES = {
  linkedIn: "mrmallik",
  github: "mr-mallik",
} as const;

export const STATUS_LABELS = {
  publicationStatusPrefix: "Status:",
  publicationDoiPrefix: "DOI:",
  educationGradePrefix: "Grade:",
} as const;

export const RESUME_VIEW_MODES = {
  summarised: "summarised",
  detailed: "detailed",
} as const;

export type ResumeViewMode =
  (typeof RESUME_VIEW_MODES)[keyof typeof RESUME_VIEW_MODES];
