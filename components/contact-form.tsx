"use client";

import { useMemo, useState } from "react";
import { HugeiconsIcon } from "@hugeicons/react";
import { SentIcon } from "@hugeicons/core-free-icons";

import { PROFILE } from "@/app/constants";
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";

export type ServiceItem = {
  label: string;
  value: string;
};

type ContactFormProps = {
  services: ServiceItem[];
  initialType: string | null;
};

export function ContactForm({ services, initialType }: ContactFormProps) {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [service, setService] = useState<string | null>(initialType);
  const [message, setMessage] = useState("");
  const [error, setError] = useState<string | null>(null);
  const [status, setStatus] = useState<"idle" | "sending" | "sent">("idle");

  const items = useMemo(
    () => [{ label: "Select a service", value: null }, ...services],
    [services],
  );

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    if (!service) {
      setError("Please select a service so I know how I can help.");
      return;
    }
    setError(null);
    setStatus("sending");

    try {
      const response = await fetch("/api/contact", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, email, service, message }),
      });

      const payload = (await response.json().catch(() => null)) as {
        success?: boolean;
        message?: string;
      } | null;

      if (!response.ok || !payload?.success) {
        setStatus("idle");
        setError(
          payload?.message ??
            "Failed to send your message. Please try again later.",
        );
        return;
      }

      setStatus("sent");
      setName("");
      setEmail("");
      setMessage("");
    } catch {
      setStatus("idle");
      setError("Failed to send your message. Please check your connection and try again.");
    }
  };

  return (
    <form
      onSubmit={handleSubmit}
      className="overflow-hidden rounded-xl border border-[var(--ui-border-soft)] bg-background"
    >
      <div className="flex items-center justify-between border-b border-[var(--ui-border-subtle)] bg-[var(--ui-bg-elevated)] px-5 py-3">
        <span className="text-sm font-medium text-[var(--ui-text-primary)]">
          New message
        </span>
        <span className="text-xs text-[var(--ui-text-muted)]">
          To: {PROFILE.primaryEmail}
        </span>
      </div>

      <div className="flex items-center gap-3 border-b border-[var(--ui-border-subtle)] px-5 py-3">
        <label
          htmlFor="contact-name"
          className="w-16 shrink-0 text-xs font-medium uppercase tracking-wider text-[var(--ui-text-muted)]"
        >
          Name
        </label>
        <input
          id="contact-name"
          type="text"
          required
          autoComplete="name"
          value={name}
          onChange={(e) => setName(e.target.value)}
          placeholder="Your full name"
          className="w-full bg-transparent text-sm text-[var(--ui-text-primary)] outline-none placeholder:text-[var(--ui-text-muted)]"
        />
      </div>

      <div className="flex items-center gap-3 border-b border-[var(--ui-border-subtle)] px-5 py-3">
        <label
          htmlFor="contact-email"
          className="w-16 shrink-0 text-xs font-medium uppercase tracking-wider text-[var(--ui-text-muted)]"
        >
          Email
        </label>
        <input
          id="contact-email"
          type="email"
          required
          autoComplete="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          placeholder="you@example.com"
          className="w-full bg-transparent text-sm text-[var(--ui-text-primary)] outline-none placeholder:text-[var(--ui-text-muted)]"
        />
      </div>

      <div className="flex items-center gap-3 border-b border-[var(--ui-border-subtle)] px-5 py-3">
        <span className="w-16 shrink-0 text-xs font-medium uppercase tracking-wider text-[var(--ui-text-muted)]">
          Service
        </span>
        <Select
          items={items}
          value={service}
          onValueChange={(value) => {
            setService(value as string | null);
            setError(null);
          }}
        >
          <SelectTrigger className="w-full max-w-64 border-none px-0 hover:border-none">
            <SelectValue />
          </SelectTrigger>
          <SelectContent>
            <SelectGroup>
              <SelectLabel>Services</SelectLabel>
              {services.map((item) => (
                <SelectItem key={item.value} value={item.value}>
                  {item.label}
                </SelectItem>
              ))}
            </SelectGroup>
          </SelectContent>
        </Select>
      </div>

      <textarea
        required
        value={message}
        onChange={(e) => setMessage(e.target.value)}
        placeholder={`Hi Gulger, I'd like to talk about ${service ?? "your services"}...`}
        rows={10}
        className="w-full resize-y bg-transparent px-5 py-4 text-sm leading-relaxed text-[var(--ui-text-primary)] outline-none placeholder:text-[var(--ui-text-muted)]"
        aria-label="Message"
      />

      <div className="flex flex-wrap items-center gap-3 border-t border-[var(--ui-border-subtle)] px-5 py-3">
        <button
          type="submit"
          disabled={status === "sending"}
          className="flex items-center rounded-full bg-[var(--ui-accent)] cursor-pointer px-6 py-2.5 text-sm font-medium text-background transition-opacity hover:opacity-80 disabled:cursor-not-allowed disabled:opacity-60"
        >
          <HugeiconsIcon icon={SentIcon} className="mr-2 h-4 w-4" aria-hidden="true" />
          {status === "sending" ? "Sending..." : "Send message"}
        </button>
        {status === "sent" ? (
          <span className="text-xs font-medium text-[var(--ui-accent)]" role="status">
            Message sent - thank you! I&apos;ll get back to you soon.
          </span>
        ) : (
          <span className="text-xs text-[var(--ui-text-muted)]">
            Every email is read and responded to personally. I aim to reply within 1-2 business days.
          </span>
        )}
        {error ? (
          <span className="text-xs text-[var(--ui-accent)]" role="alert">
            {error}
          </span>
        ) : null}
      </div>
    </form>
  );
}
