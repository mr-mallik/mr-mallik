import { ExperienceSection } from "@/components/experience-section";
import Header from "@/components/header";

export default function ExperiencePage() {
  return (
    <section className="mx-auto w-full max-w-2xl py-2 sm:py-8">
      <div className="space-y-5 sm:space-y-7">
        <Header link="/" title="Experience" description="Professional roles across applied AI research and software engineering." />
        <ExperienceSection heading={false} />
      </div>
    </section>
  );
}
