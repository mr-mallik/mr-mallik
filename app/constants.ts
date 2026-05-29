export const SITE = {
  ownerName: "Gulger Mallik",
  brandName: "mr mallik",
  title: "Gulger Mallik",
  copyrightSuffix: "All rights reserved.",
} as const;

export const PROFILE = {
  primaryEmail: "gulgermallik@gmail.com",
  resumeEmail: "hello@gulger.xyz",
  phone: "07767924720",
  websiteUrl: "https://mrmallik.com",
  websiteLabel: "mrmallik.com",
  linkedInUrl: "https://www.linkedin.com/in/mrmallik/",
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
  projects: "Projects",
  workExperience: "Work Experience",
  experience: "Experience",
  education: "Education",
  skills: "Skills",
  publications: "Publications",
  showcase: "Showcase",
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
  pdfFormat: "PDF format",
  blogs: "blogs",
} as const;

export const PAGE_COPY = {
  homepageRolePrefix: "Researcher at The",
  homeIntroCompanyPrefix: "I am a founding software engineer at",
  homeIntroCompanySuffix:
    "building thoughtful tools for the next layer of the web. I like to build systems that accelerate businesses and bring confidence in the era of Artificial Intelligence.",
  homePreviousPrefix: "Previously, I worked with",
  homePreviousSuffix:
    "across research and engineering. You can reach me via",
  homeCodePrefix: "or see my code on",
  homeResumePrefix: "A detailed resume is available for download in",
  homeResearchPrefix:
    "My research focuses on Explainable AI, Multi-critera Decision Making, and Sustainable Software Engineering, read my publications on",
  homeBlogPrefix: "I share my learnings, milestones, and reflections on",
  homeBlogSuffix:
    ", a space where I publish practical notes and stories about software engineering, applied research, and the evolving tech landscape.",
  homeSocialParagraph:
    "I am a social person and love connecting with like-minded individuals. If you want to chat about anything, feel free to reach out to me via the contact details above. I am always open to discussing new ideas, potential collaborations, or just having a friendly conversation about technology and research.",
  projectsPageDescription:
    "A selection of projects across applied AI research and software engineering.",
  publicationsPageDescription:
    "Research publications and manuscripts across explainable AI and applied software systems.",
  experiencePageDescription:
    "Professional roles across applied AI research and software engineering.",
  resumeViewModeLegend: "Experience view mode",
} as const;

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