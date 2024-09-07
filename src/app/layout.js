import { Marcellus } from "next/font/google";
import "@/assets/styles/globals.css";
import { Analytics } from "@vercel/analytics/react"
import { SpeedInsights } from "@vercel/speed-insights/next"

const marcel = Marcellus({ weight: "400", subsets: ["latin"] });

const title = `Gulger Mallik | Software Engineer | Full Stack Developer | mrmallik.com`;
const description = "Gulger Mallik is a skilled Software Engineer and Full Stack Developer. Explore mrmallik.com for my portfolio, projects, and professional experience in web development, software engineering, and more.";
const keywords = 'Gulger Mallik, Software Engineer, Full Stack Developer, Web Developer, mrmallik.com, portfolio, projects, JavaScript, Python, React, Node.js, AWS, cloud computing, software development';

export const metadata = {
  title: title,
  description: description,
  keywords: keywords,
  openGraph: {
    title: title,
    description: description,
    url: `${process.env.BASE_URL}`,
    site_name: "Gulger Mallik's Portfolio",
    images: [
      {
        url: `${process.env.BASE_URL}/assets/images/seo-image.png`,
        width: 800,
        height: 600,
      },
    ],
  },
  twitter: {
    card: 'summary_large_image',
    title: title,
    description: description,
    site: "@its_mrmallik",
    url: "@its_mrmallik",
    creator: "https://www.mrmallik.com",
    images: [`${process.env.BASE_URL}/assets/images/seo-image.png`],
  },
};

export default function RootLayout({ children }) {
  
  return (
    <html lang="en">
      <head>
        <meta charSet="UTF-8"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png" />
        <link rel="manifest" href="/site.webmanifest" />
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5" />
        <meta name="apple-mobile-web-app-title" content="MrMallik" />
        <meta name="application-name" content="MrMallik" />
        <meta name="msapplication-TileColor" content="#da532c" />
        <meta name="theme-color" content="#000000" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="author" content="Gulger Mallik" />
        <meta name="robots" content="index, follow" />
      </head>
      <body className={`${marcel.className}`}>
        {/* <AnimatedCursor
          innerSize={15}
          outerSize={15}
          color="255, 255 ,255"
          outerAlpha={0.4}
          innerScale={0.7}
          outerScale={5}
        /> */}
        {children}
        <Analytics />
        <SpeedInsights />
      </body>
    </html>
  );
}
