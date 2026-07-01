import { useState } from "react";

export default function WorkspaceConfiguration({ value, onNext, saving }) {
  const [local, setLocal] = useState({
    workspaceName: value.workspaceName || "",
    siteName: value.siteName || "",
    categoriesText: (value.categories || []).join(", "),
    currency: value.currency || "USD",
    country: value.country || "RDC",
    timezone: value.timezone || "UTC+1",
  });

  const submit = (event) => {
    event.preventDefault();

    const categories = local.categoriesText
      .split(",")
      .map((x) => x.trim())
      .filter(Boolean);

    onNext({
      workspaceName: local.workspaceName,
      siteName: local.siteName,
      categories,
      currency: local.currency,
      country: local.country,
      timezone: local.timezone,
    });
  };

  return (
    <form className="space-y-4" onSubmit={submit}>
      <input
        className="auth-input w-full"
        placeholder="Nom du workspace"
        value={local.workspaceName}
        onChange={(e) =>
          setLocal((prev) => ({ ...prev, workspaceName: e.target.value }))
        }
        required
      />
      <input
        className="auth-input w-full"
        placeholder="Nom du site principal"
        value={local.siteName}
        onChange={(e) =>
          setLocal((prev) => ({ ...prev, siteName: e.target.value }))
        }
        required
      />
      <input
        className="auth-input w-full"
        placeholder="Categories (separees par des virgules)"
        value={local.categoriesText}
        onChange={(e) =>
          setLocal((prev) => ({ ...prev, categoriesText: e.target.value }))
        }
        required
      />
      <div className="grid grid-cols-1 md:grid-cols-3 gap-3">
        <input
          className="auth-input"
          placeholder="Devise"
          value={local.currency}
          onChange={(e) =>
            setLocal((prev) => ({ ...prev, currency: e.target.value }))
          }
        />
        <input
          className="auth-input"
          placeholder="Pays"
          value={local.country}
          onChange={(e) =>
            setLocal((prev) => ({ ...prev, country: e.target.value }))
          }
        />
        <input
          className="auth-input"
          placeholder="Timezone"
          value={local.timezone}
          onChange={(e) =>
            setLocal((prev) => ({ ...prev, timezone: e.target.value }))
          }
        />
      </div>
      <button
        type="submit"
        disabled={saving}
        className="auth-btn-primary w-full py-3.5 bg-primary text-black font-semibold rounded-xl"
      >
        {saving ? "Sauvegarde..." : "Continuer"}
      </button>
    </form>
  );
}
