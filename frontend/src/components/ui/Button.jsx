import { forwardRef } from "react";
import { cn } from "../../utils/cn";

const styles = {
  primary: "bg-primary text-on-primary hover:opacity-90",
  secondary:
    "bg-surface-container text-on-surface hover:bg-surface-container-high",
  ghost: "bg-transparent text-on-surface-variant hover:bg-surface-container",
  danger: "bg-danger text-white hover:opacity-90",
};

const sizes = {
  sm: "h-9 px-3 text-sm",
  md: "h-10 px-4 text-sm",
  lg: "h-11 px-5 text-base",
};

const Button = forwardRef(function Button(
  { className, variant = "primary", size = "md", type = "button", ...props },
  ref,
) {
  return (
    <button
      ref={ref}
      type={type}
      className={cn(
        "inline-flex items-center justify-center rounded-xl font-medium transition-all active:scale-[0.98] disabled:pointer-events-none disabled:opacity-50",
        styles[variant],
        sizes[size],
        className,
      )}
      {...props}
    />
  );
});

export default Button;
