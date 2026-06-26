import quantixLogo from "../../assets/images/quantix_logo.jpeg";

export default function Footer() {
  return (
    <footer className="w-full border-t border-outline-variant bg-surface-container-highest">
      <div className="mx-auto flex max-w-container-max flex-col items-center justify-between gap-8 px-gutter py-8 md:flex-row md:py-12">
        <div className="flex flex-col items-center gap-2 md:items-start">
          <img
            src={quantixLogo}
            alt="Quantix Logo"
            className="h-8 w-auto object-contain opacity-80 grayscale"
          />
          <p className="text-sm text-on-surface-variant">
            © 2024 Quantix Management. All rights reserved.
          </p>
        </div>

        <div className="flex flex-wrap items-center justify-center gap-6 text-sm">
          <a
            href="#"
            className="font-medium text-on-surface-variant hover:text-primary"
          >
            Privacy Policy
          </a>
          <a
            href="#"
            className="font-medium text-on-surface-variant hover:text-primary"
          >
            Terms of Service
          </a>
          <a
            href="#"
            className="font-medium text-on-surface-variant hover:text-primary"
          >
            Security
          </a>
          <a
            href="#"
            className="font-medium text-on-surface-variant hover:text-primary"
          >
            Status
          </a>
        </div>
      </div>
    </footer>
  );
}
