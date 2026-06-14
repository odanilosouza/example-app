type ButtonProps<T extends React.ElementType = "button"> = {
  as?: T;
  variant?: "primary" | "secondary" | "ghost";
  className?: string;
} & Omit<React.ComponentPropsWithoutRef<T>, "className">;

export function Button<T extends React.ElementType = "button">({
  as,
  variant = "primary",
  className = "",
  ...props
}: ButtonProps<T>) {
  const Component = as || "button";
  const base = "inline-flex items-center justify-center rounded-md px-4 py-2 text-sm font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none";
  const variants: Record<string, string> = {
    primary: "bg-indigo-600 text-white hover:bg-indigo-700",
    secondary: "bg-slate-100 text-slate-900 hover:bg-slate-200",
    ghost: "bg-transparent text-slate-700 hover:bg-slate-100"
  };

  return <Component className={`${base} ${variants[variant]} ${className}`} {...props} />;
}
