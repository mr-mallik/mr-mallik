import Image from "next/image"

const testimonialAvatars = [
  "/images/gulger-mallik@1x1.png",
  "/images/gulger-mallik@1x1.png",
  "/images/gulger-mallik@1x1.png",
  "/images/gulger-mallik@1x1.png",
  "/images/gulger-mallik@1x1.png",
];

export default function TestimonialsSection() {
  return (
    <section className="rounded-2xl bg-stone-50 p-8 text-center dark:bg-stone-900/30 md:p-12">
        <div className="mb-6 flex justify-center -space-x-2">
          {testimonialAvatars.map((src, i) => (
            <div
              key={i}
              className="h-10 w-10 overflow-hidden rounded-full border-2 border-background"
            >
              <Image
                src={src}
                alt="Testimonial avatar"
                width={40}
                height={40}
                className="h-full w-full object-cover"
              />
            </div>
          ))}
        </div>

        <blockquote className="mx-auto max-w-2xl text-lg font-medium leading-relaxed text-[var(--ui-text-primary)] md:text-xl">
          &ldquo;Gulger is an exceptional software engineer who transformed our product entirely.
          His creativity, depth of knowledge, and attention to detail far exceeded our expectations.
          Stellar work!&rdquo;
        </blockquote>

        <div className="mt-5">
          <p className="text-sm font-semibold text-[var(--ui-text-primary)]">
            Alex Johnson, Product Manager
          </p>
          <p className="text-xs text-[var(--ui-text-muted)]">TechStartup Inc.</p>
        </div>
      </section>
  )
}