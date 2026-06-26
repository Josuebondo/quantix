import { Link } from "react-router-dom";
import { APP_NAME } from "../../constants";

export default function Footer() {
  const year = new Date().getFullYear();

  return (
    <footer className="border-t border-outline-variant bg-surface text-on-surface">
      <div className="mx-auto flex max-w-7xl flex-col items-center justify-between gap-6 px-6 py-8 md:flex-row">
        <div>
          <h3 className="text-lg font-semibold">{APP_NAME}</h3>
          <p className="mt-1 text-sm text-on-surface-variant">
            Plateforme SaaS de gestion de stock moderne.
          </p>
        </div>

        <div className="flex flex-wrap items-center gap-5 text-sm">
          <Link
            to="/documentation"
            className="hover:text-primary transition-colors"
          >
            Documentation
          </Link>

          <Link to="/login" className="hover:text-primary transition-colors">
            Connexion
          </Link>

          <Link
            to="/get-started"
            className="hover:text-primary transition-colors"
          >
            Commencer
          </Link>
        </div>
      </div>

      <div className="border-t border-outline-variant px-6 py-4 text-center text-sm text-on-surface-variant">
        © {year} {APP_NAME}. Tous droits réservés.
      </div>
    </footer>
  );
}
