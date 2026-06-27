import { Cloud, HardDrive, Smartphone } from "lucide-react";
import { useInView } from "../../../../hooks/useInView";
import ThreeBackdrop from "./ThreeBackdrop";

const platforms = [
  {
    icon: Cloud,
    title: "Web Cloud",
    description:
      "Accédez à votre inventaire depuis n'importe où, sur n'importe quel navigateur.",
    image:
      "https://images.unsplash.com/photo-1695668548342-c0c1ad479aee?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjbG91ZCUyMHNlcnZlciUyMHN5bmNocm9uaXphdGlvbiUyMHRlY2hub2xvZ3l8ZW58MXx8fHwxNzgyNTkwNzU2fDA&ixlib=rb-4.1.0&q=80&w=1080",
    features: ["Interface intuitive", "Temps réel", "Multi-utilisateurs", "Tableaux de bord personnalisables"],
    tone: "primary",
  },
  {
    icon: HardDrive,
    title: "Desktop Local",
    description:
      "Performance maximale pour vos opérations en entrepôt, avec ou sans connexion.",
    image:
      "https://images.unsplash.com/photo-1587293852726-70cdb56c2866?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjB3YXJlaG91c2UlMjBpbnZlbnRvcnklMjBtYW5hZ2VtZW50fGVufDF8fHx8MTc4MjU5MDc1NXww&ixlib=rb-4.1.0&q=80&w=1080",
    features: ["Mode hors ligne", "Sync automatique", "Performance optimale", "Lecteurs de codes-barres"],
    tone: "tertiary",
  },
  {
    icon: Smartphone,
    title: "Mobile App",
    description: "Suivez et gérez vos stocks en déplacement avec iOS et Android.",
    image:
      "https://images.unsplash.com/photo-1592228533283-d78f7c1cf453?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2JpbGUlMjBhcHAlMjB3YXJlaG91c2UlMjBtYW5hZ2VtZW50fGVufDF8fHx8MTc4MjU5MDc1Nnww&ixlib=rb-4.1.0&q=80&w=1080",
    features: ["iOS & Android", "Scanner intégré", "Notifications push", "Géolocalisation"],
    tone: "secondary",
  },
];

const toneStyles = {
  primary: { badge: "bg-primary/10", icon: "text-primary", panel: "hover:border-primary dark:hover:border-primary-fixed-dim" },
  tertiary: { badge: "bg-tertiary/10", icon: "text-tertiary", panel: "hover:border-tertiary dark:hover:border-tertiary-fixed" },
  secondary: { badge: "bg-secondary/10", icon: "text-secondary", panel: "hover:border-secondary dark:hover:border-secondary-fixed" },
};

function PlatformRow({ platform, index }) {
  const { ref, inView } = useInView();
  const Icon = platform.icon;
  const isReversed = index % 2 !== 0;
  const tone = toneStyles[platform.tone];

  return (
    <div
      ref={ref}
      className={`grid items-center gap-8 transition-all duration-800 md:grid-cols-2 ${
        inView ? "translate-y-0 opacity-100" : "translate-y-12 opacity-0"
      } ${isReversed ? "md:grid-flow-dense" : ""}`}
      style={{ transitionDuration: "800ms" }}
    >
      <div className={isReversed ? "md:col-start-2" : ""}>
        <div className="relative overflow-hidden rounded-2xl border border-border shadow-xl">
          <img src={platform.image} alt={platform.title} className="h-80 w-full object-cover" />
          <div className="absolute inset-0 bg-gradient-to-t from-on-surface/70 to-transparent" />
          <div className="absolute bottom-6 left-6 right-6">
            <div className="flex items-center gap-3 text-white">
              <div className="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                <Icon size={20} />
              </div>
              <h3 className="text-xl font-bold">{platform.title}</h3>
            </div>
          </div>
        </div>
      </div>

      <div className={`space-y-6 ${isReversed ? "md:col-start-1" : ""}`}>
        <div className={`inline-flex items-center gap-2 rounded-full px-4 py-2 ${tone.badge}`}>
          <Icon size={18} className={tone.icon} />
          <span className={`text-sm font-semibold ${tone.icon}`}>
            {platform.title}
          </span>
        </div>
        <p className="text-xl text-muted-foreground">{platform.description}</p>
        <div className="grid grid-cols-2 gap-3">
          {platform.features.map((feature) => (
            <div
              key={feature}
              className={`rounded-xl border border-border bg-card p-4 transition-colors duration-200 ${tone.panel}`}
            >
              <div className="flex items-center gap-2">
                <div className="h-2 w-2 flex-shrink-0 rounded-full bg-success" />
                <span className="text-sm text-card-foreground">{feature}</span>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}

export default function Platforms() {
  const { ref, inView } = useInView();
  const { ref: syncRef, inView: syncInView } = useInView();

  return (
    <section id="plateformes" className="relative overflow-hidden bg-surface py-20 transition-colors duration-300 md:py-32 dark:bg-surface-dark">
      <ThreeBackdrop className="absolute left-0 top-8 h-72 w-72 opacity-55 md:h-[28rem] md:w-[28rem]" count={11} mobileCount={6} intensity={0.42} />
      <div className="relative z-10 mx-auto w-full max-w-[min(1860px,98vw)] px-2 sm:px-3 lg:px-4">
        <div
          ref={ref}
          className={`mx-auto mb-16 max-w-3xl text-center transition-all duration-700 ${
            inView ? "translate-y-0 opacity-100" : "translate-y-8 opacity-0"
          }`}
        >
          <div className="mb-4 inline-block rounded-full bg-primary-fixed px-4 py-2 dark:bg-primary-fixed/20">
            <span className="text-sm font-semibold text-primary dark:text-primary-fixed-dim">
              Plateformes
            </span>
          </div>
          <h2 className="mb-6 text-3xl font-bold text-foreground md:text-5xl">
            Trois plateformes, une synchronisation parfaite
          </h2>
          <p className="text-lg text-muted-foreground">
            Travaillez comme vous le souhaitez avec nos applications web,
            desktop et mobile. Toutes vos données sont synchronisées en temps réel.
          </p>
        </div>

        <div className="space-y-16">
          {platforms.map((platform, index) => (
            <PlatformRow key={platform.title} platform={platform} index={index} />
          ))}
        </div>

        <div
          ref={syncRef}
          className={`mt-20 rounded-2xl bg-gradient-to-r from-primary to-tertiary p-8 text-on-primary transition-all duration-800 md:p-12 ${
            syncInView ? "translate-y-0 opacity-100" : "translate-y-12 opacity-0"
          }`}
          style={{ transitionDuration: "800ms" }}
        >
          <div className="grid items-center gap-8 md:grid-cols-2">
            <div>
              <h3 className="mb-4 text-3xl font-bold">
                Synchronisation en temps réel
              </h3>
              <p className="mb-6 text-lg text-on-primary/85">
                Chaque modification est instantanément propagée à tous vos appareils et sites.
                Même en mode hors ligne, vos données sont synchronisées dès le retour de la connexion.
              </p>
              <div className="flex flex-wrap gap-4">
                {[["<1s", "Latence moyenne"], ["100%", "Fiabilité"], ["24/7", "Disponibilité"]].map(
                  ([value, label]) => (
                    <div key={label} className="rounded-xl bg-white/10 px-5 py-3 backdrop-blur-sm">
                      <div className="text-2xl font-bold">{value}</div>
                      <div className="text-sm text-on-primary/75">{label}</div>
                    </div>
                  ),
                )}
              </div>
            </div>
            <div className="flex justify-center">
              <div className="relative h-48 w-48">
                <div className="absolute inset-0 animate-ping rounded-full border-4 border-white/20" style={{ animationDuration: "2.5s" }} />
                <div className="absolute inset-4 animate-ping rounded-full border-4 border-white/30" style={{ animationDuration: "2s", animationDelay: "0.3s" }} />
                <div className="absolute inset-8 flex items-center justify-center rounded-full bg-white/15 backdrop-blur-sm">
                  <span className="material-symbols-outlined text-5xl">bolt</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}