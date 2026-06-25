import { useLoading } from "../../hooks/useLoading";

export default function Loader() {
  const { isLoading } = useLoading();

  if (!isLoading) return null;

  return (
    <div className="pointer-events-none fixed inset-0 z-[70] grid place-items-center bg-slate-900/20 backdrop-blur-[1px]">
      <div className="rounded-xl border border-outline-variant bg-surface-container-lowest p-4 shadow-lg">
        <div className="h-8 w-8 rounded-full border-4 border-primary/20 border-t-primary spin" />
      </div>
    </div>
  );
}
