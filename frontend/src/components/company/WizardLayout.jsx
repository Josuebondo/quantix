import WizardStepper from "./WizardStepper";

export default function WizardLayout({
  title,
  subtitle,
  currentStep,
  children,
}) {
  return (
    <div className="min-h-screen bg-slate-950 bg-pattern text-white px-4 py-8">
      <div className="mx-auto max-w-4xl space-y-6">
        <header className="auth-card p-6 space-y-3">
          <WizardStepper currentStep={currentStep} />
          <h1 className="text-2xl font-semibold">{title}</h1>
          <p className="text-white/70">{subtitle}</p>
        </header>
        <section className="auth-card p-6">{children}</section>
      </div>
    </div>
  );
}
