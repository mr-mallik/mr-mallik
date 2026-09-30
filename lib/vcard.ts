import { readFileSync } from "node:fs";
import path from "node:path";

import { EXTERNAL_LINKS, PAGE_COPY, PROFILE, SITE } from "@/app/constants";

const CONTACT_PHOTO_PATH = path.join(process.cwd(), "public", "images", "gulger-mallik@1x1.png");

// vCard 3.0 is the version both iOS Contacts and Android Contacts import reliably.
// Lines must be CRLF-terminated and folded at 75 octets (RFC 2425 §5.8.1).
function fold(line: string): string {
  if (line.length <= 75) return line;
  const chunks = [line.slice(0, 75)];
  for (let i = 75; i < line.length; i += 74) {
    chunks.push(` ${line.slice(i, i + 74)}`);
  }
  return chunks.join("\r\n");
}

function escapeText(value: string): string {
  return value.replace(/\\/g, "\\\\").replace(/\n/g, "\\n").replace(/([,;])/g, "\\$1");
}

type VcardOptions = {
  /** Essentials only (no photo or social profiles) so the card fits in a scannable QR code. */
  compact?: boolean;
};

export function buildContactVcard({ compact = false }: VcardOptions = {}): string {
  const [givenName, ...rest] = SITE.ownerName.split(" ");
  const familyName = rest.join(" ");

  const essentials = [
    "BEGIN:VCARD",
    "VERSION:3.0",
    `N:${escapeText(familyName)};${escapeText(givenName)};;;`,
    `FN:${escapeText(SITE.ownerName)}`,
    `ORG:${escapeText(PROFILE.affiliationName)}`,
    `TITLE:${escapeText(PAGE_COPY.homepageRolePrefix.replace(/ at$/, ""))}`,
    `TEL;TYPE=CELL:${PROFILE.phoneInternational}`,
    `EMAIL;TYPE=INTERNET,HOME,pref:${PROFILE.primaryEmail}`,
    `EMAIL;TYPE=INTERNET,WORK:${PROFILE.workEmail}`,
    `URL:${PROFILE.websiteCanonicalUrl}`,
  ];

  const extras = compact
    ? []
    : [
        `NICKNAME:${escapeText(SITE.brandName)}`,
        `URL;TYPE=WORK:${EXTERNAL_LINKS.cosmokode}`,
        `X-SOCIALPROFILE;TYPE=linkedin:${PROFILE.linkedInUrl}`,
        `X-SOCIALPROFILE;TYPE=youtube:${PROFILE.youTubeUrl}`,
        `PHOTO;ENCODING=b;TYPE=PNG:${readFileSync(CONTACT_PHOTO_PATH).toString("base64")}`,
      ];

  const lines = [...essentials, ...extras, "END:VCARD"];

  return `${lines.map(fold).join("\r\n")}\r\n`;
}
