import { NextResponse } from "next/server";
import { PDFDocument, rgb, StandardFonts } from "pdf-lib";
import {
  PROFILE,
  SECTION_TITLES,
  SITE,
  STATUS_LABELS,
} from "@/app/constants";

import achievementItems from "@/data/achievements.json";
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

type AchievementItem = {
  badge: string;
  title: string;
  description: string;
  date: string;
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

function cleanText(text: string): string {
  // Replace all special characters with ASCII equivalents
  return text
    .replace(/[\u2022\u2023\u25E6\u2043\u2219]/g, "-") // bullets
    .replace(/[\u00B7\u2027\u30FB]/g, "-") // middle dots
    .replace(/[\u2014\u2015]/g, "-") // em dashes
    .replace(/[\u2013\u2011\u2012]/g, "-") // en dashes, non-breaking hyphens
    .replace(/[\u2018\u2019\u201B\u2039\u203A]/g, "'") // single quotes
    .replace(/[\u201C\u201D\u201E\u00AB\u00BB]/g, '"') // double quotes
    .replace(/[\u2026]/g, "...") // ellipsis
    .replace(/[\u00A0\u2000-\u200B\u202F\u205F\u3000]/g, " ") // various spaces
    .replace(/[\u00C0-\u00C5]/g, "A") // accented A
    .replace(/[\u00C8-\u00CB]/g, "E") // accented E
    .replace(/[\u00CC-\u00CF]/g, "I") // accented I
    .replace(/[\u00D2-\u00D6]/g, "O") // accented O
    .replace(/[\u00D9-\u00DC]/g, "U") // accented U
    .replace(/[\u00E0-\u00E5]/g, "a") // accented a
    .replace(/[\u00E8-\u00EB]/g, "e") // accented e
    .replace(/[\u00EC-\u00EF]/g, "i") // accented i
    .replace(/[\u00F2-\u00F6]/g, "o") // accented o
    .replace(/[\u00F9-\u00FC]/g, "u") // accented u
    .replace(/[\u00D1]/g, "N") // Ñ
    .replace(/[\u00F1]/g, "n") // ñ
    .replace(/[\u00C7]/g, "C") // Ç
    .replace(/[\u00E7]/g, "c") // ç
    // Remove any remaining non-ASCII characters
    .replace(/[^\x20-\x7E]/g, "");
}

function wrapText(text: string, maxWidth: number, font: any, fontSize: number): string[] {
  const words = text.split(" ");
  const lines: string[] = [];
  let currentLine = "";

  for (const word of words) {
    const testLine = currentLine ? `${currentLine} ${word}` : word;
    const width = font.widthOfTextAtSize(testLine, fontSize);

    if (width > maxWidth && currentLine) {
      lines.push(currentLine);
      currentLine = word;
    } else {
      currentLine = testLine;
    }
  }

  if (currentLine) {
    lines.push(currentLine);
  }

  return lines;
}

export async function GET() {
  const items = workItems as WorkItem[];
  const achievements = achievementItems as AchievementItem[];
  const education = educationItems as EducationItem[];
  const publications = publicationsItems as Publication[];
  const skills = skillsItems as SkillCategory[];

  const pdfDoc = await PDFDocument.create();
  const helvetica = await pdfDoc.embedFont(StandardFonts.Helvetica);
  const helveticaBold = await pdfDoc.embedFont(StandardFonts.HelveticaBold);

  let page = pdfDoc.addPage([612, 792]); // Letter size
  const margin = 72;
  const maxWidth = 612 - margin * 2;
  let y = 792 - margin;

  const addNewPageIfNeeded = (spaceNeeded: number) => {
    if (y - spaceNeeded < margin) {
      page = pdfDoc.addPage([612, 792]);
      y = 792 - margin;
      return true;
    }
    return false;
  };

  // Header - Name
  const cleanName = cleanText(SITE.ownerName.toUpperCase());
  page.drawText(cleanName, {
    x: margin + (maxWidth - helveticaBold.widthOfTextAtSize(cleanName, 16)) / 2,
    y,
    size: 16,
    font: helveticaBold,
    color: rgb(0, 0, 0),
  });
  y -= 20;

  // Contact Info
  const contactText = cleanText(`${PROFILE.primaryEmail} | ${PROFILE.linkedInDisplay} | ${PROFILE.websiteLabel}`);
  page.drawText(contactText, {
    x: margin + (maxWidth - helvetica.widthOfTextAtSize(contactText, 10)) / 2,
    y,
    size: 10,
    font: helvetica,
    color: rgb(0, 0, 0),
  });
  y -= 30;

  // Skills Section
  addNewPageIfNeeded(100);
  page.drawText(cleanText(SECTION_TITLES.skills.toUpperCase()), {
    x: margin,
    y,
    size: 12,
    font: helveticaBold,
    color: rgb(0, 0, 0),
  });
  y -= 3;
  page.drawLine({
    start: { x: margin, y },
    end: { x: 612 - margin, y },
    thickness: 1,
    color: rgb(0.7, 0.7, 0.7),
  });
  y -= 15;

  for (const group of skills) {
    addNewPageIfNeeded(20);
    const categoryText = cleanText(`${group.category}: `);
    page.drawText(categoryText, {
      x: margin,
      y,
      size: 10,
      font: helveticaBold,
      color: rgb(0, 0, 0),
    });
    
    const skillsText = cleanText(group.skills.join(", "));
    const categoryWidth = helveticaBold.widthOfTextAtSize(categoryText, 10);
    const lines = wrapText(skillsText, maxWidth - categoryWidth, helvetica, 10);
    
    page.drawText(lines[0], {
      x: margin + categoryWidth,
      y,
      size: 10,
      font: helvetica,
      color: rgb(0, 0, 0),
    });
    y -= 12;
    
    for (let i = 1; i < lines.length; i++) {
      addNewPageIfNeeded(12);
      page.drawText(lines[i], {
        x: margin + categoryWidth,
        y,
        size: 10,
        font: helvetica,
        color: rgb(0, 0, 0),
      });
      y -= 12;
    }
  }
  y -= 15;

  // Experience Section
  addNewPageIfNeeded(100);
  page.drawText(cleanText(SECTION_TITLES.experience.toUpperCase()), {
    x: margin,
    y,
    size: 12,
    font: helveticaBold,
    color: rgb(0, 0, 0),
  });
  y -= 3;
  page.drawLine({
    start: { x: margin, y },
    end: { x: 612 - margin, y },
    thickness: 1,
    color: rgb(0.7, 0.7, 0.7),
  });
  y -= 15;

  for (const item of items) {
    addNewPageIfNeeded(80);
    
    // Role at Company
    page.drawText(cleanText(`${item.role} at ${item.company}`), {
      x: margin,
      y,
      size: 11,
      font: helveticaBold,
      color: rgb(0, 0, 0),
    });
    y -= 12;

    // Period and Location
    const metaText = cleanText(`${item.period}${item.location ? ` - ${item.location}` : ""}`);
    page.drawText(metaText, {
      x: margin,
      y,
      size: 9,
      font: helvetica,
      color: rgb(0.4, 0.4, 0.4),
    });
    y -= 15;

    // Details
    for (const detail of item.details) {
      const cleanedDetail = cleanText(detail);
      const lines = wrapText(`- ${cleanedDetail}`, maxWidth - 10, helvetica, 9);
      
      for (const line of lines) {
        addNewPageIfNeeded(11);
        page.drawText(line, {
          x: margin + 10,
          y,
          size: 9,
          font: helvetica,
          color: rgb(0, 0, 0),
        });
        y -= 11;
      }
    }
    y -= 10;
  }
  y -= 10;

  // Achievements Section
  addNewPageIfNeeded(100);
  page.drawText(cleanText(SECTION_TITLES.achievements.toUpperCase()), {
    x: margin,
    y,
    size: 12,
    font: helveticaBold,
    color: rgb(0, 0, 0),
  });
  y -= 3;
  page.drawLine({
    start: { x: margin, y },
    end: { x: 612 - margin, y },
    thickness: 1,
    color: rgb(0.7, 0.7, 0.7),
  });
  y -= 15;

  for (const item of achievements) {
    addNewPageIfNeeded(60);
    
    page.drawText(cleanText(item.title), {
      x: margin,
      y,
      size: 11,
      font: helveticaBold,
      color: rgb(0, 0, 0),
    });
    y -= 12;

    page.drawText(cleanText(item.date), {
      x: margin,
      y,
      size: 9,
      font: helvetica,
      color: rgb(0.4, 0.4, 0.4),
    });
    y -= 12;

    const cleanedDesc = cleanText(item.description);
    const lines = wrapText(cleanedDesc, maxWidth, helvetica, 9);
    for (const line of lines) {
      addNewPageIfNeeded(11);
      page.drawText(line, {
        x: margin,
        y,
        size: 9,
        font: helvetica,
        color: rgb(0, 0, 0),
      });
      y -= 11;
    }
    y -= 10;
  }
  y -= 10;

  // Education Section
  addNewPageIfNeeded(100);
  page.drawText(cleanText(SECTION_TITLES.education.toUpperCase()), {
    x: margin,
    y,
    size: 12,
    font: helveticaBold,
    color: rgb(0, 0, 0),
  });
  y -= 3;
  page.drawLine({
    start: { x: margin, y },
    end: { x: 612 - margin, y },
    thickness: 1,
    color: rgb(0.7, 0.7, 0.7),
  });
  y -= 15;

  for (const item of [...education].reverse()) {
    addNewPageIfNeeded(40);
    
    page.drawText(cleanText(`${item.degree} at ${item.institution}`), {
      x: margin,
      y,
      size: 11,
      font: helveticaBold,
      color: rgb(0, 0, 0),
    });
    y -= 12;

    const eduMeta = cleanText(`${item.duration} - ${item.location}${item.grade ? ` | Grade: ${item.grade}` : ""}`);
    page.drawText(eduMeta, {
      x: margin,
      y,
      size: 9,
      font: helvetica,
      color: rgb(0.4, 0.4, 0.4),
    });
    y -= 15;
  }
  y -= 10;

  // Publications Section
  addNewPageIfNeeded(100);
  page.drawText(cleanText(SECTION_TITLES.publications.toUpperCase()), {
    x: margin,
    y,
    size: 12,
    font: helveticaBold,
    color: rgb(0, 0, 0),
  });
  y -= 3;
  page.drawLine({
    start: { x: margin, y },
    end: { x: 612 - margin, y },
    thickness: 1,
    color: rgb(0.7, 0.7, 0.7),
  });
  y -= 15;

  for (const pub of publications) {
    addNewPageIfNeeded(80);
    
    const cleanedTitle = cleanText(pub.title);
    const titleLines = wrapText(cleanedTitle, maxWidth, helveticaBold, 11);
    for (const line of titleLines) {
      addNewPageIfNeeded(13);
      page.drawText(line, {
        x: margin,
        y,
        size: 11,
        font: helveticaBold,
        color: rgb(0, 0, 0),
      });
      y -= 13;
    }

    const cleanedAbstract = cleanText(pub.abstract);
    const abstractLines = wrapText(cleanedAbstract, maxWidth, helvetica, 9);
    for (const line of abstractLines) {
      addNewPageIfNeeded(11);
      page.drawText(line, {
        x: margin,
        y,
        size: 9,
        font: helvetica,
        color: rgb(0, 0, 0),
      });
      y -= 11;
    }
    y -= 3;

    const pubMeta = cleanText(`Status: ${pub.status}${pub.doi ? ` | DOI: ${pub.doi}` : ""}`);
    addNewPageIfNeeded(11);
    page.drawText(pubMeta, {
      x: margin,
      y,
      size: 9,
      font: helvetica,
      color: rgb(0.4, 0.4, 0.4),
    });
    y -= 15;
  }

  const pdfBytes = await pdfDoc.save();
  const pdfBuffer = Buffer.from(pdfBytes);

  return new NextResponse(pdfBuffer, {
    headers: {
      "Content-Type": "application/pdf",
      "Content-Disposition": "attachment; filename=gulger-mallik-resume.pdf",
    },
  });
}
