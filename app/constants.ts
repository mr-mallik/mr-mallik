export const SITE = {
  ownerName: "Gulger Mallik",
  brandName: "mr mallik",
  title: "Gulger Mallik",
  copyrightSuffix: "All rights reserved.",
} as const;

export const PROFILE = {
  primaryEmail: "gulgermallik@gmail.com",
  phone: "07767924720",
  websiteUrl: "https://mrmallik.com",
  websiteLabel: "mrmallik.com",
  linkedInUrl: "https://www.linkedin.com/in/mrmallik/",
  linkedInDisplay: "linkedin.com/in/mrmallik/",
  githubUrl: "https://github.com/mr-mallik",
  orcidUrl: "https://orcid.org/0009-0002-5110-8575",
  affiliationName: "University of Huddersfield",
  affiliationUrl: "https://hud.ac.uk",
  profileImageAlt: "Profile picture of Gulger Mallik",
} as const;

export const ROUTES = {
  home: "/",
  resume: "/resume",
  projects: "/projects",
  publications: "/publications",
  blogs: "/blogs",
  about: "/about",
  contact: "/contact",
} as const;

export const EXTERNAL_LINKS = {
  cosmokode: "https://cosmokode.com",
} as const;

export const MAIL = {
  subject: "Lets Connect",
  bodyLines: [
    "Hi Gulger,",
    "I came across your profile and would like to connect with you.",
    "Best regards,",
  ],
} as const;

export const SECTION_TITLES = {
  projects: "Selected Works",
  workExperience: "Work Experience",
  experience: "Experience",
  education: "Education",
  skills: "Skills",
  publications: "Publications",
  showcase: "Worked alongside",
  blog: "Blog",
} as const;

export const LINK_LABELS = {
  back: "Back",
  home: "Home",
  resume: "Resume",
  viewAllProjects: "View all projects",
  viewAllPublications: "View all publications",
  download: "Download",
  summarised: "summarised",
  detailed: "detailed",
  pdfFormat: "resume",
  blogs: "blogs",
} as const;

export const PAGE_COPY = {
  homepageRolePrefix: "Researcher at",
  homeIntroCompanyPrefix: "I'm a founding software engineer at",
  homeIntroCompanySuffix:
    "where I help build thoughtful products for the next wave of the web. I enjoy creating systems that help teams move faster, make better decisions, and feel more confident using AI.",
  homePreviousPrefix: "Before that, I worked with",
  homePreviousSuffix:
    "across research and engineering. You can reach me through",
  homeCodePrefix: "or explore my work on",
  homeResumePrefix: "A more detailed",
  homeResumeSuffix: "is available for download",
  homeResearchPrefix:
    "My research explores Explainable AI, Multi-critera Decision Making, and Sustainable Software Engineering. You can read my publications on",
  homeBlogPrefix: "I share ideas, lessons, and progress on",
  homeBlogSuffix:
    ", where I write practical notes and reflections on software engineering, applied research, and the evolving tech landscape.",
  homeSocialParagraph:
    "I enjoy meeting thoughtful people and hearing new perspectives. If you'd like to talk about technology, research, or possible collaboration, feel free to reach out using the contact details above.",
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