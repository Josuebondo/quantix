export default function FinishSetup({
  state,
  onBack,
  onFinish,
  finishing,
  error,
}) {
  return (
    <div className="space-y-5">
      <div className="rounded-xl border border-white/10 bg-white/5 p-4 text-sm text-white/80 space-y-1">
        <p>Workspace: {state.workspaceName || "-"}</p>
        <p>Site: {state.siteName || "-"}</p>
        <p>Categories: {(state.categories || []).join(", ") || "-"}</p>
        <p>Invitations: {(state.invitations || []).length}</p>
      </div>

      {error ? <p className="text-red-400 text-sm">{error}</p> : null}

      <div className="flex gap-3">
        <button
          type="button"
          onClick={onBack}
          className="w-full py-3.5 rounded-xl bg-white/10 hover:bg-white/20 transition-colors"
        >
          Retour
        </button>
        <button
          type="button"
          onClick={onFinish}
          disabled={finishing}
          className="auth-btn-primary w-full py-3.5 bg-primary text-black font-semibold rounded-xl"
        >
          {finishing ? "Finalisation..." : "Terminer"}
        </button>
      </div>
    </div>
  );
}
