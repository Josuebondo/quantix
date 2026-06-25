import { forwardRef } from "react";
import { cn } from "../../utils/cn";

const Input = forwardRef(function Input({ className, error, ...props }, ref) {
  return (
    <input
      ref={ref}
      className={cn(
        "w-full rounded-xl border bg-surface-container-lowest px-3 py-2 text-sm text-on-surface shadow-sm outline-none transition-all",
        error
          ? "border-error focus:ring-2 focus:ring-error/20"
          : "border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20",
        className,
      )}
      {...props}
    />
  );
});

export default Input;
