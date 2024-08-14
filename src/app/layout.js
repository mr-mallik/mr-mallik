import { Marcellus } from "next/font/google";
import "@/assets/styles/globals.css";

const marcel = Marcellus({ weight: "400", subsets: ["latin"] });

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
        <title>Gulger Mallik | Software Engineer | Full Stack Developer | mrmallik.com</title>
        <meta name="description" content="Gulger Mallik is a skilled Software Engineer and Full Stack Developer. Explore mrmallik.com for my portfolio, projects, and professional experience in web development, software engineering, and more." />
        <meta name="keywords" content="Gulger Mallik, Software Engineer, Full Stack Developer, Web Developer, mrmallik.com, portfolio, projects, JavaScript, Python, React, Node.js, AWS, cloud computing, software development" />
        <meta name="author" content="Gulger Mallik" />
        <meta name="robots" content="index, follow" />

        <meta property="og:title" content="Gulger Mallik | Software Engineer | Full Stack Developer | mrmallik.com" />
        <meta property="og:description" content="Explore the portfolio and projects of Gulger Mallik, a talented Software Engineer and Full Stack Developer. Visit mrmallik.com for more details." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://www.mrmallik.com" />
        <meta property="og:image" content="https://www.mrmallik.com/images/profile.jpg" />
        <meta property="og:site_name" content="Gulger Mallik's Portfolio" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Gulger Mallik | Software Engineer | Full Stack Developer | mrmallik.com" />
        <meta name="twitter:description" content="Explore the portfolio and projects of Gulger Mallik, a talented Software Engineer and Full Stack Developer. Visit mrmallik.com for more details." />
        <meta name="twitter:image" content="https://www.mrmallik.com/images/profile.jpg" />
        <meta name="twitter:site" content="@_mrmallik_" />
        <meta name="twitter:creator" content="@_mrmallik_" />
        <meta name="twitter:url" content="https://www.mrmallik.com" />
      </head>
      <body className={marcel.className}>
        {children}
      </body>
    </html>
  );
}
