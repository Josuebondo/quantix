import { Link } from "react-router-dom";

export default function UserActions() {
  return (
    <div className="flex items-center gap-3">
      <Link to="/login" className="font-medium hover:text-primary">
        Connexion
      </Link>

      <Link
        to="/register"
        className="rounded-xl bg-primary px-5 py-2.5 text-white transition hover:opacity-90"
      >
        Essayer gratuitement
      </Link>
    </div>
  );
}
