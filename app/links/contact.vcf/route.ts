import { buildContactVcard } from "@/lib/vcard";

// Served as text/vcard + inline so iOS Safari opens the "Create New Contact" sheet
// directly, while Android Chrome (which cannot render vCards) downloads the file
// and hands it to the Contacts app.
export function GET() {
  return new Response(buildContactVcard(), {
    headers: {
      "Content-Type": "text/vcard; charset=utf-8",
      "Content-Disposition": 'inline; filename="gulger-mallik.vcf"',
      "Cache-Control": "public, max-age=3600",
    },
  });
}
