const STEPS = [
  { key: "workspace", label: "Workspace" },
  { key: "users", label: "Equipe" },
  { key: "finish", label: "Finalisation" },
];

export default function WizardStepper({ currentStep }) {
  return (
    <ol className="flex items-center gap-3 text-sm text-white/70">
      {STEPS.map((step, index) => {
        const isActive = step.key === currentStep;
        const isDone = STEPS.findIndex((s) => s.key === currentStep) > index;

        return (
          <li key={step.key} className="flex items-center gap-3">
            <span
              className={`w-8 h-8 rounded-full flex items-center justify-center border ${
                isActive || isDone
                  ? "bg-primary text-black border-primary"
                  : "border-white/20"
              }`}
            >
              {index + 1}
            </span>
            <span className={isActive ? "text-white font-semibold" : ""}>
              {step.label}
            </span>
          </li>
        );
      })}
    </ol>
  );
}
