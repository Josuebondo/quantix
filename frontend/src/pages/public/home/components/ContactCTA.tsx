import { Mail, MapPin, Phone } from "lucide-react";
import ThreeBackdrop from "./ThreeBackdrop";

export default function ContactCTA() {
  return (
    <section id="contact" className="relative overflow-hidden bg-on-surface py-20 text-on-primary transition-colors duration-300 md:py-28 dark:bg-background-dark">
      <ThreeBackdrop className="absolute inset-0 mx-auto h-full w-full opacity-35" count={10} mobileCount={5} intensity={0.3} />
      <div className="relative z-10 mx-auto w-full max-w-[min(1860px,98vw)] px-2 sm:px-3 lg:px-4">
        <div className="rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur-sm md:p-12">
          <div className="grid gap-10 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div className="space-y-6">
              <div className="inline-flex rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white/85">
                Contact
              </div>
              <h2 className="text-3xl font-bold md:text-5xl">
                Lancez Quantix avec une équipe qui vous accompagne vraiment.
              </h2>
              <p className="max-w-2xl text-base leading-relaxed text-white/70 md:text-lg">
                Besoin d'une démo, d'une configuration multi-entreprise ou d'un accompagnement pour votre premier déploiement ? Nous pouvons vous aider à cadrer la mise en place.
              </p>
              <div className="flex flex-col gap-3 sm:flex-row">
                <a
                  href="/company/register"
                  className="inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3 font-medium text-on-primary transition-colors duration-200 hover:bg-on-primary-fixed-variant"
                >
                  Créer mon compte
                </a>
                <a
                  href="mailto:contact@quantix.fr"
                  className="inline-flex items-center justify-center rounded-xl border border-white/15 px-6 py-3 font-medium text-on-primary/90 transition-colors duration-200 hover:bg-white/10"
                >
                  Écrire à Quantix
                </a>
              </div>
            </div>

            <div className="grid gap-4 rounded-2xl border border-white/10 bg-black/10 p-6">
              {[
                { Icon: Mail, label: "Email", value: "contact@quantix.fr" },
                { Icon: Phone, label: "Téléphone", value: "+33 1 23 45 67 89" },
                { Icon: MapPin, label: "Adresse", value: "Paris, France" },
              ].map(({ Icon, label, value }) => (
                <div key={label} className="flex items-center gap-3 rounded-xl bg-white/5 p-4">
                  <Icon className="text-primary-fixed-dim" size={18} />
                  <div>
                    <div className="text-xs text-white/50">{label}</div>
                    <div className="text-sm font-medium text-white">{value}</div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}