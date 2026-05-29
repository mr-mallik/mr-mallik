import { ProjectsSection } from "@/components/projects-section";
import Header from "@/components/header";
import Link from "next/dist/client/link";

export default function ProjectsPage() {
  return (
    <section className="mx-auto w-full max-w-2xl py-2 sm:py-8">
      <div className="space-y-5 sm:space-y-7">
        <Header
          link="/"
          title="Projects"
          description="A selection of projects across applied AI research and software engineering."
        />
        <ProjectsSection heading={false} />
      </div>
    </section>
  );
}