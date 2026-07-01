import { useState } from "react";

export default function InviteUsers({ value, onNext, onBack, saving }) {
  const [email, setEmail] = useState("");
  const invitations = value.invitations || [];

  const addInvitation = () => {
    if (!email.trim()) return;
    onNext(
      { invitations: [...invitations, { email: email.trim(), role: "Admin" }] },
      true,
    );
    setEmail("");
  };

  return (
    <div className="space-y-4">
      <p className="text-white/70 text-sm">
        Ajoutez des membres optionnels. Vous pourrez aussi les inviter plus
        tard.
      </p>
      <div className="flex gap-2">
        <input
          className="auth-input w-full"
          placeholder="email@entreprise.com"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <button
          type="button"
          onClick={addInvitation}
          className="px-4 rounded-xl bg-white/10 hover:bg-white/20 transition-colors"
        >
          Ajouter
        </button>
      </div>
      <ul className="space-y-2">
        {invitations.map((item, idx) => (
          <li key={`${item.email}-${idx}`} className="text-white/80 text-sm">
            {item.email} ({item.role})
          </li>
        ))}
      </ul>
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
          disabled={saving}
          onClick={() => onNext({ invitations })}
          className="auth-btn-primary w-full py-3.5 bg-primary text-black font-semibold rounded-xl"
        >
          {saving ? "Sauvegarde..." : "Continuer"}
        </button>
      </div>
    </div>
  );
}
