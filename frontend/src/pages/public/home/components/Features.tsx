import {
  Database,
  Globe,
  Monitor,
  RefreshCw,
  Smartphone,
  Users,
  Wifi,
  WifiOff,
} from "lucide-react";
import Card from "../../../../components/ui/Card";
import { useInView } from "../../../../hooks/useInView";
import ThreeBackdrop from "./ThreeBackdrop";

const features = [
  {
    icon: Globe,
    title: "Application Web",
    description:
      "Gérez vos stocks à distance depuis n'importe quel navigateur. Interface intuitive et puissante.",
    tone: "primary",
  },
  {
    icon: Monitor,
    title: "Application Desktop",
    description:
      "Logiciel local pour une gestion rapide et directe en entrepôt, même sans connexion internet.",
    tone: "tertiary",
  },
  {
    icon: Smartphone,
    title: "Application Mobile",
    description:
      "Suivez et gérez vos stocks en déplacement avec notre app iOS et Android.",
    tone: "secondary",
  },
  {
    icon: RefreshCw,
    title: "Synchronisation Temps Réel",
    description:
      "Toutes vos données sont synchronisées instantanément entre tous vos appareils et sites.",
    tone: "primary",
  },
  {
    icon: WifiOff,
    title: "Mode Hors Ligne",
    description:
      "Continuez à travailler sans interruption même sans connexion. Synchronisation automatique au retour.",
    tone: "success",
  },
  {
    icon: Database,
    title: "Multi-Entrepôts",
    description:
      "Gérez un nombre illimité d'entrepôts et de sites depuis une seule plateforme centralisée.",
    tone: "tertiary",
  },
  {
    icon: Users,
    title: "Multi-Entreprises",
    description:
      "Solution parfaite pour les groupes avec plusieurs entités juridiques et équipes.",
    tone: "secondary",
  },
  {
    icon: Wifi,
    title: "Sécurité Maximale",
    description:
      "Chiffrement de bout en bout, sauvegardes automatiques et conformité RGPD garantie.",
    tone: "primary",
  },
  {
    icon: Users,
    title: "Team Collaboration",
    description:
      "Collaborez efficacement avec vos équipes grâce à des outils de communication et de gestion intégrés.",
    tone: "primary",
  },
];

const toneStyles = {
  primary: { badge: "bg-primary/10", icon: "text-primary" },
  tertiary: { badge: "bg-tertiary/10", icon: "text-tertiary" },
  secondary: { badge: "bg-secondary/10", icon: "text-secondary" },
  success: { badge: "bg-success/10", icon: "text-success" },
};

function FeatureCard({ feature, index }) {
  const { ref, inView } = useInView();
  const Icon = feature.icon;
  const tone = toneStyles[feature.tone];

  return (
    <div
      ref={ref}
      style={{ transitionDelay: `${(index % 4) * 80}ms` }}
      className={`transition-all duration-700 ${
        inView ? "translate-y-0 opacity-100" : "translate-y-8 opacity-0"
      }`}
    >
      <Card className="h-full border-border bg-card p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
        <div className={`mb-4 flex h-12 w-12 items-center justify-center rounded-xl ${tone.badge}`}>
          <Icon size={22} className={tone.icon} />
        </div>
        <h3 className="mb-2 text-base font-semibold text-card-foreground">
          {feature.title}
        </h3>
        <p className="text-sm leading-relaxed text-muted-foreground">
          {feature.description}
        </p>
      </Card>
    </div>
  );
}

export default function Features() {
  const { ref, inView } = useInView();

  return (
    <section id="fonctionnalites" className="relative overflow-hidden bg-surface py-20 transition-colors duration-300 md:py-32 dark:bg-surface-dark">
      <ThreeBackdrop className="absolute right-0 top-0 h-72 w-72 opacity-60 md:h-96 md:w-96" count={10} mobileCount={6} intensity={0.45} />
      <div className="relative z-10 mx-auto w-full max-w-[min(1860px,98vw)] px-2 sm:px-3 lg:px-4">
        <div
          ref={ref}
          className={`mx-auto mb-16 max-w-3xl text-center transition-all duration-700 ${
            inView ? "translate-y-0 opacity-100" : "translate-y-8 opacity-0"
          }`}
        >
          <div className="mb-4 inline-block rounded-full bg-primary-fixed px-4 py-2 dark:bg-primary-fixed/20">
            <span className="text-sm font-semibold text-primary dark:text-primary-fixed-dim">
              Fonctionnalités
            </span>
          </div>
          <h2 className="mb-6 text-3xl font-bold text-foreground md:text-5xl">
            Une plateforme complète pour tous vos besoins
          </h2>
          <p className="text-lg text-muted-foreground">
            Des outils professionnels conçus pour s'adapter à votre façon de
            travailler, où que vous soyez, avec ou sans connexion.
          </p>
        </div>

        <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          {features.map((feature, index) => (
            <FeatureCard key={feature.title} feature={feature} index={index} />
          ))}
        </div>
      </div>
    </section>
  );
}