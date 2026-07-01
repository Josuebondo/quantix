import { Link } from "react-router-dom";
import { APP_NAME } from "../../constants";

export default function Footer() {
  const year = new Date().getFullYear();

  return (
    <footer className="py-12  bg-surface-container-lowest border-t border-outline-variant/30 relative z-10">
      <div className="max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-4 gap-12">
        <div className="col-span-1 md:col-span-2">
          <Link className="flex items-center gap-2 mb-6" to="#">
            <img
              alt="Quantix Logo"
              className="h-8 w-auto"
              src="https://lh3.googleusercontent.com/aida-public/AB6AXuByTgnshUXeLHiMfcs13K9-C_L_UZfZ0Qr28GMef71095Nmuoynkk5hioUIiR_P3MUGLumoFWVzFYpxYIt2Wk86aThwY5W9dWf61jqM-PX5KAE15C86AinWhFNd6B90dpzNeb8HptBJsC6kEcCDJ61eJnO--pwp-zgcwdhTdQKHbcAg9LdAwvUEhYNRCFzx7vqjD5llJvUiD7A2WuBsIVkyU6IHnZBYZm_cz3jamhq02R_rdZNX9ja4LkY9Vtfhp7_CV56Pkpco9tY"
            />
            <span className="font-headline-md text-2xl font-bold text-on-surface">
              Quantix
            </span>
          </Link>
          <p className="text-on-surface-variant max-w-sm mb-8">
            La plateforme de gestion de stock intelligente pour les entreprises
            tournées vers l'avenir. Optimisez, suivez, évoluez.
          </p>
          <div className="flex gap-4">
            <Link
              className="w-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors"
              to="#"
            >
              <span className="material-symbols-outlined">share</span>
            </Link>
            <Link
              className="w-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors"
              to="#"
            >
              <span className="material-symbols-outlined">public</span>
            </Link>
          </div>
        </div>
        <div>
          <h5 className="font-bold mb-6 text-on-surface">Produit</h5>
          <ul className="space-y-4 text-on-surface-variant">
            <li>
              <Link className="hover:text-primary transition-colors" to="#">
                Fonctionnalités
              </Link>
            </li>
            <li>
              <Link className="hover:text-primary transition-colors" to="#">
                Intégrations
              </Link>
            </li>
            <li>
              <Link className="hover:text-primary transition-colors" to="#">
                API
              </Link>
            </li>
          </ul>
        </div>
        <div>
          <h5 className="font-bold mb-6 text-on-surface">Société</h5>
          <ul className="space-y-4 text-on-surface-variant">
            <li>
              <Link className="hover:text-primary transition-colors" to="#">
                À propos
              </Link>
            </li>
            <li>
              <Link className="hover:text-primary transition-colors" to="#">
                Blog
              </Link>
            </li>
            <li>
              <Link className="hover:text-primary transition-colors" to="#">
                Contact
              </Link>
            </li>
          </ul>
        </div>
      </div>
      <div className="max-w-container-max mx-auto px-gutter mt-20 pt-8 border-t border-outline-variant/10 text-center text-on-surface-variant text-sm">
        © {year} {APP_NAME}. Tous droits réservés.
      </div>
    </footer>
  );
}
