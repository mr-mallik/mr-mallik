"use client";

import { useMemo, useRef, useState } from "react";
import Script from "next/script";
import { HugeiconsIcon } from "@hugeicons/react";
import { SentIcon } from "@hugeicons/core-free-icons";
import { motion } from "motion/react";

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

type FieldName = "name" | "email" | "service" | "message";

type FieldErrors = Partial<Record<FieldName, string>>;

const RECAPTCHA_SITE_KEY = process.env.NEXT_PUBLIC_RECAPTCHA_SITE_KEY;
// Must match RECAPTCHA_CONTACT_ACTION in lib/recaptcha.ts, which verifies it server-side.
const RECAPTCHA_ACTION = "CONTACT_FORM";

declare global {
  interface Window {
    grecaptcha?: {
      enterprise: {
        ready: (callback: () => void) => void;
        execute: (siteKey: string, options: { action: string }) => Promise<string>;
      };
    };
  }
}

const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function validateFields(values: {
  name: string;
  email: string;
  service: string | null;
  message: string;
}): FieldErrors {
  const errors: FieldErrors = {};

  if (!values.name.trim()) {
    errors.name = "Please enter your name so I know who I'm talking to.";
  }

  const email = values.email.trim();
  if (!email) {
    errors.email = "Please enter your email so I can get back to you.";
  } else if (!EMAIL_PATTERN.test(email)) {
    errors.email = "That email address doesn't look quite right - please double-check it.";
  }

  if (!values.service) {
    errors.service = "Please select a service so I know how I can help.";
  }

  const message = values.message.trim();
  if (!message) {
    errors.message = "Please write a short message about what you'd like to discuss.";
  } else if (message.length < 10) {
    errors.message = "Your message is a bit short - a sentence or two helps me understand what you need.";
  }

  return errors;
}

async function getRecaptchaToken(): Promise<string | null> {
  if (!RECAPTCHA_SITE_KEY || !window.grecaptcha?.enterprise) {
    return null;
  }

  try {
    const grecaptcha = window.grecaptcha.enterprise;
    await new Promise<void>((resolve) => grecaptcha.ready(resolve));
    return await grecaptcha.execute(RECAPTCHA_SITE_KEY, { action: RECAPTCHA_ACTION });
  } catch {
    return null;
  }
}

function FieldError({ id, message }: { id: string; message?: string }) {
  if (!message) {
    return null;
  }
  return (
    <p id={id} role="alert" className="mt-1.5 text-xs text-[var(--ui-accent)]">
      {message}
    </p>
  );
}

export function ContactForm({ services, initialType }: ContactFormProps) {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [service, setService] = useState<string | null>(initialType);
  const [message, setMessage] = useState("");
  const [fieldErrors, setFieldErrors] = useState<FieldErrors>({});
  const [error, setError] = useState<string | null>(null);
  const [status, setStatus] = useState<"idle" | "sending" | "sent">("idle");

  const nameRef = useRef<HTMLInputElement>(null);
  const emailRef = useRef<HTMLInputElement>(null);
  const serviceTriggerRef = useRef<HTMLButtonElement>(null);
  const messageRef = useRef<HTMLTextAreaElement>(null);

  const items = useMemo(
    () => [{ label: "Select a service", value: null }, ...services],
    [services],
  );

  const clearFieldError = (field: FieldName) => {
    setFieldErrors((current) => {
      if (!current[field]) {
        return current;
      }
      const next = { ...current };
      delete next[field];
      return next;
    });
  };

  const focusFirstInvalid = (errors: FieldErrors) => {
    if (errors.name) {
      nameRef.current?.focus();
    } else if (errors.email) {
      emailRef.current?.focus();
    } else if (errors.service) {
      serviceTriggerRef.current?.focus();
    } else if (errors.message) {
      messageRef.current?.focus();
    }
  };

  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();

    const errors = validateFields({ name, email, service, message });
    setFieldErrors(errors);
    if (Object.keys(errors).length > 0) {
      focusFirstInvalid(errors);
      return;
    }

    setError(null);
    setStatus("sending");

    const recaptchaToken = await getRecaptchaToken();

    try {
      const response = await fetch("/api/contact", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ name, email, service, message, recaptchaToken }),
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
      noValidate
      onSubmit={handleSubmit}
      className="overflow-hidden rounded-xl border border-[var(--ui-border-soft)] bg-background"
    >
      {RECAPTCHA_SITE_KEY ? (
        <Script
          src={`https://www.google.com/recaptcha/enterprise.js?render=${RECAPTCHA_SITE_KEY}`}
        />
      ) : null}

      <div className="flex items-center justify-between border-b border-[var(--ui-border-subtle)] bg-[var(--ui-bg-elevated)] px-5 py-3">
        <span className="text-sm font-medium text-[var(--ui-text-primary)]">
          New message
        </span>
        <span className="text-xs text-[var(--ui-text-muted)]">
          To: {PROFILE.primaryEmail}
        </span>
      </div>

      <div className="border-b border-[var(--ui-border-subtle)] px-5 py-3">
        <div className="flex items-center gap-3">
          <label
            htmlFor="contact-name"
            className="w-16 shrink-0 text-xs font-medium uppercase tracking-wider text-[var(--ui-text-muted)]"
          >
            Name
          </label>
          <input
            id="contact-name"
            ref={nameRef}
            type="text"
            autoComplete="name"
            value={name}
            onChange={(e) => {
              setName(e.target.value);
              clearFieldError("name");
            }}
            placeholder="Your full name"
            aria-invalid={Boolean(fieldErrors.name)}
            aria-describedby={fieldErrors.name ? "contact-name-error" : undefined}
            className="w-full bg-transparent text-sm text-[var(--ui-text-primary)] outline-none placeholder:text-[var(--ui-text-muted)]"
          />
        </div>
        <FieldError id="contact-name-error" message={fieldErrors.name} />
      </div>

      <div className="border-b border-[var(--ui-border-subtle)] px-5 py-3">
        <div className="flex items-center gap-3">
          <label
            htmlFor="contact-email"
            className="w-16 shrink-0 text-xs font-medium uppercase tracking-wider text-[var(--ui-text-muted)]"
          >
            Email
          </label>
          <input
            id="contact-email"
            ref={emailRef}
            type="email"
            autoComplete="email"
            value={email}
            onChange={(e) => {
              setEmail(e.target.value);
              clearFieldError("email");
            }}
            placeholder="you@example.com"
            aria-invalid={Boolean(fieldErrors.email)}
            aria-describedby={fieldErrors.email ? "contact-email-error" : undefined}
            className="w-full bg-transparent text-sm text-[var(--ui-text-primary)] outline-none placeholder:text-[var(--ui-text-muted)]"
          />
        </div>
        <FieldError id="contact-email-error" message={fieldErrors.email} />
      </div>

      <div className="border-b border-[var(--ui-border-subtle)] px-5 py-3">
        <div className="flex items-center gap-3">
          <span className="w-16 shrink-0 text-xs font-medium uppercase tracking-wider text-[var(--ui-text-muted)]">
            Service
          </span>
          <Select
            items={items}
            value={service}
            onValueChange={(value) => {
              setService(value as string | null);
              clearFieldError("service");
              setError(null);
            }}
          >
            <SelectTrigger
              ref={serviceTriggerRef}
              aria-invalid={Boolean(fieldErrors.service)}
              aria-describedby={fieldErrors.service ? "contact-service-error" : undefined}
              className="w-full max-w-64 border-none px-0 hover:border-none"
            >
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
        <FieldError id="contact-service-error" message={fieldErrors.service} />
      </div>

      <div className="px-5 py-4">
        <textarea
          ref={messageRef}
          value={message}
          onChange={(e) => {
            setMessage(e.target.value);
            clearFieldError("message");
          }}
          placeholder={`Hi Gulger, I'd like to talk about ${service ?? "your services"}...`}
          rows={10}
          aria-label="Message"
          aria-invalid={Boolean(fieldErrors.message)}
          aria-describedby={fieldErrors.message ? "contact-message-error" : undefined}
          className="w-full resize-y bg-transparent text-sm leading-relaxed text-[var(--ui-text-primary)] outline-none placeholder:text-[var(--ui-text-muted)]"
        />
        <FieldError id="contact-message-error" message={fieldErrors.message} />
      </div>

      <div className="flex flex-wrap items-center gap-3 border-t border-[var(--ui-border-subtle)] px-5 py-3">
        <motion.button
          type="submit"
          disabled={status === "sending"}
          className="flex items-center rounded-full bg-[var(--ui-accent)] cursor-pointer px-6 py-2.5 text-sm font-medium text-background transition-opacity hover:opacity-80 disabled:cursor-not-allowed disabled:opacity-60"
          whileHover={status === "sending" ? undefined : { scale: 1.04 }}
          whileTap={status === "sending" ? undefined : { scale: 0.96 }}
        >
          <HugeiconsIcon icon={SentIcon} className="mr-2 h-4 w-4" aria-hidden="true" />
          {status === "sending" ? "Sending..." : "Send message"}
        </motion.button>
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

      {RECAPTCHA_SITE_KEY ? (
        <p className="border-t border-[var(--ui-border-subtle)] px-5 py-2 text-[10px] leading-relaxed text-[var(--ui-text-muted)]">
          This site is protected by reCAPTCHA Enterprise; the Google{" "}
          <a
            href="https://policies.google.com/privacy"
            target="_blank"
            rel="noreferrer"
            className="underline"
          >
            Privacy Policy
          </a>{" "}
          and{" "}
          <a
            href="https://policies.google.com/terms"
            target="_blank"
            rel="noreferrer"
            className="underline"
          >
            Terms of Service
          </a>{" "}
          apply.
        </p>
      ) : null}
    </form>
  );
}
