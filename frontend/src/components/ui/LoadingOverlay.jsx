import Loader from "./Loader";
import { useLoading } from "../../hooks/useLoading";

export default function LoadingOverlay() {
  const { isLoading } = useLoading();

  if (!isLoading) return null;

  return (
    <div className="fixed inset-0 z-[9999] flex items-center justify-center bg-surface/70 backdrop-blur-sm">
      <Loader size={220} />
    </div>
  );
}
