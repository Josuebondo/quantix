import { CheckCircle2 } from "lucide-react";
import { useInView } from "../../../../hooks/useInView";
import ThreeBackdrop from "./ThreeBackdrop";

const benefits = [
  "Réduction des erreurs de stock jusqu'à 95%",
  "Gain de temps de 40% sur les opérations",
  "Visibilité complète en temps réel",
  "Collaboration facilitée entre équipes",
  "Rapports et analytics avancés",
  "Support client 24/7 en français",
];

export default function Benefits() {
  const { ref: imgRef, inView: imgInView } = useInView();
  const { ref: contentRef, inView: contentInView } = useInView();

  return (
    <section id="avantages" className="relative overflow-hidden bg-background py-20 transition-colors duration-300 md:py-32 dark:bg-background-dark">
      <ThreeBackdrop className="absolute right-4 top-10 h-64 w-full opacity-55 md:h-96 md:w-96" count={9} mobileCount={5} intensity={0.38} />
      <div className="relative z-10 mx-auto w-full max-w-[min(1860px,98vw)] px-2 sm:px-3 lg:px-4">
        <div className="grid items-center gap-12 md:grid-cols-2">
          <div
            ref={imgRef}
            className={`order-2 transition-all duration-800 md:order-1 ${
              imgInView ? "translate-x-0 opacity-100" : "-translate-x-10 opacity-0"
            }`}
            style={{ transitionDuration: "800ms" }}
          >
            <div className="relative">
              <div className="overflow-hidden rounded-2xl border border-border shadow-2xl">
                <img
                  src="https://images.unsplash.com/photo-1608222351212-18fe0ec7b13b?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxidXNpbmVzcyUyMHRlYW0lMjBsYXB0b3AlMjBkYXNoYm9hcmR8ZW58MXx8fHwxNzgyNTkwNzU5fDA&ixlib=rb-4.1.0&q=80&w=1080"
                  alt="Équipe utilisant Quantix"
                  className="h-full w-full object-cover"
                />
              </div>
              

                <div className="absolute -right-5 -top-4 rounded-xl border border-border bg-card p-4 shadow-lg transition-transform duration-300 hover:scale-105">
                    <div className="text-center">
                    <div className="text-3xl font-bold text-success">+95%</div>
                    <div className="text-xs text-muted-foreground">Précision</div>
                    </div>
                </div>


                <div className="absolute -bottom-4 -left-5 rounded-xl border border-border bg-card p-4 shadow-lg transition-transform duration-300 hover:scale-105">
                    <div className="text-center">
                    <div className="text-3xl font-bold text-primary dark:text-primary-fixed-dim">-40%</div>
                    <div className="text-xs text-muted-foreground">Temps gagné</div>
                    </div>
                </div>

            </div>
          </div>

          <div
            ref={contentRef}
            className={`order-1 space-y-8 transition-all duration-800 md:order-2 ${
              contentInView ? "translate-x-0 opacity-100" : "translate-x-10 opacity-0"
            }`}
            style={{ transitionDuration: "800ms" }}
          >
            <div>
              <div className="mb-4 inline-block rounded-full bg-primary-fixed px-4 py-2 dark:bg-primary-fixed/20">
                <span className="text-sm font-semibold text-primary dark:text-primary-fixed-dim">
                  Avantages
                </span>
              </div>
              <h2 className="mb-6 text-3xl font-bold text-foreground md:text-5xl">
                Optimisez vos opérations avec Quantix
              </h2>
              <p className="text-lg leading-relaxed text-muted-foreground">
                Rejoignez des centaines d'entreprises qui ont transformé leur gestion de stock grâce à notre solution innovante.
              </p>
            </div>

            <div className="space-y-3">
              {benefits.map((benefit) => (
                <div key={benefit} className="flex items-start gap-3 rounded-xl p-3 transition-colors duration-200 hover:bg-muted/50">
                  <CheckCircle2 className="mt-0.5 flex-shrink-0 text-success" size={22} />
                  <span className="text-foreground/85">{benefit}</span>
                </div>
              ))}
            </div>

            <div className="pt-2">
              <div className="rounded-2xl bg-gradient-to-r from-primary to-tertiary p-6 text-on-primary">
                <div className="flex items-center gap-4">
                  <div className="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-white/15">
                    <span className="material-symbols-outlined text-3xl">rocket_launch</span>
                  </div>
                  <div>
                    <h4 className="mb-1 font-semibold">Prêt à commencer ?</h4>
                    <p className="text-sm text-on-primary/85">
                      Essai gratuit de 14 jours, sans carte bancaire requise
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}