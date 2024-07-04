import { Marcellus } from "next/font/google";
import "./assets/styles/globals.css";

const marcel = Marcellus({ weight: "400", subsets: ["latin"] });

export const metadata = {
  title: "Gulger Mallik | Mr. Mallik",
  description: "Gulger Mallik",
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body className={marcel.className}>
        {children}
        </body>
    </html>
  );
}
