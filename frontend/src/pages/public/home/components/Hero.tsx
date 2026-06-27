import { ArrowRight, Play } from "lucide-react";
import { useInView } from "../../../../hooks/useInView";
import ThreeBackdrop from "./ThreeBackdrop";

export default function Hero() {
  const { ref, inView } = useInView(0.05);

  return (
    <section className="relative flex min-h-screen items-center overflow-hidden bg-background pt-20">
      <div className="pointer-events-none absolute inset-0 overflow-hidden">
        <div className="absolute -left-32 -top-32 h-[500px] w-[500px] rounded-full bg-primary/10 blur-3xl dark:bg-primary/5" />
        <div className="absolute -bottom-32 -right-32 h-[500px] w-[500px] rounded-full bg-success/10 blur-3xl dark:bg-success/5" />
      </div>

      <ThreeBackdrop
        className="absolute inset-x-0 top-20 z-0 h-[calc(100vh-5rem)] opacity-90"
        count={30}
        mobileCount={15}
        intensity={0.95}
      />

      <div className="relative z-10 mx-auto w-full max-w-[min(1860px,98vw)] px-2 sm:px-3 lg:px-4">
        <div
          ref={ref}
          className={`relative grid grid-cols-1 items-center gap-stack-lg transition-all duration-1000 lg:grid-cols-2 ${
            inView ? "translate-y-0 opacity-100" : "translate-y-10 opacity-0"
          }`}
        >
          <div className="flex w-full flex-col justify-center rounded-3xl border border-outline-variant/10 bg-surface/40 p-6 backdrop-blur-sm md:bg-none md:p-10 lg:max-w-3xl lg:bg-transparent lg:p-0">
            <div className="mb-6 flex flex-wrap gap-2">
              <span className="inline-flex items-center rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-sm font-medium text-primary">
                IA-Propulsé
              </span>
              <span className="inline-flex items-center rounded-full border border-outline-variant/30 bg-surface-container-highest px-3 py-1 text-sm font-medium text-on-surface-variant">
                SaaS Platform
              </span>
              <span className="inline-flex items-center rounded-full border border-outline-variant/30 bg-surface-container-highest px-3 py-1 text-sm font-medium text-on-surface-variant">
                Natif Mobile
              </span>
            </div>

            <span className="mb-4 font-label-sm text-label-sm uppercase tracking-widest text-primary">
              La logistique réinventée
            </span>

            <h1 className="mb-8 text-display-xl-mobile leading-tight text-on-surface drop-shadow-sm md:text-display-xl">
              Gérez votre stock <span className="text-primary">intelligemment</span> avec Quantix
            </h1>

            <p className="mb-12 max-w-xl text-body-lg text-on-surface-variant">
              Une interface élégante pour des opérations complexes. Pilotez vos produits, entrepôts et équipes en temps réel avec une précision chirurgicale.
            </p>

            <div className="flex flex-col gap-4 sm:flex-row">
              <a
                href="/company/register"
                className="inline-flex items-center justify-center rounded-xl bg-primary px-8 py-4 text-center text-base font-bold text-on-primary shadow-lg shadow-primary/20 transition-all hover:brightness-110 active:scale-95"
              >
                Commencer gratuitement
                <ArrowRight className="ml-2" size={20} />
              </a>
              <a
                href="#tarifs"
                className="inline-flex items-center justify-center gap-2 rounded-xl border border-outline-variant/30 bg-surface-container-high px-8 py-4 text-center text-base font-bold text-on-surface transition-all hover:bg-surface-container-highest active:scale-95 dark:bg-surface-container-high dark:hover:bg-surface-container-highest"
              >
                <Play size={20} />
                Voir la démo
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
