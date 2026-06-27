import { Check, Star } from "lucide-react";
import Button from "../../../../components/ui/Button";
import Card from "../../../../components/ui/Card";
import { useInView } from "../../../../hooks/useInView";
import ThreeBackdrop from "./ThreeBackdrop";

const plans = [
  {
    name: "Starter",
    price: "49",
    period: "/mois",
    description: "Parfait pour les petites entreprises",
    features: [
      "1 entreprise",
      "Jusqu'à 3 entrepôts",
      "5 utilisateurs",
      "Application web",
      "Application mobile",
      "Support email",
      "10 Go de stockage",
      "Synchronisation temps réel",
    ],
    cta: "Commencer",
    popular: false,
  },
  {
    name: "Business",
    price: "149",
    period: "/mois",
    description: "Pour les entreprises en croissance",
    features: [
      "3 entreprises",
      "Jusqu'à 15 entrepôts",
      "25 utilisateurs",
      "Application web",
      "Application desktop",
      "Application mobile",
      "Mode hors ligne",
      "Support prioritaire 24/7",
      "100 Go de stockage",
      "Synchronisation temps réel",
      "Rapports avancés",
      "API complète",
    ],
    cta: "Essayer gratuitement",
    popular: true,
  },
  {
    name: "Enterprise",
    price: "Sur mesure",
    period: "",
    description: "Solution personnalisée pour grandes entreprises",
    features: [
      "Entreprises illimitées",
      "Entrepôts illimités",
      "Utilisateurs illimités",
      "Toutes les applications",
      "Mode hors ligne avancé",
      "Support dédié 24/7",
      "Stockage illimité",
      "Synchronisation temps réel",
      "Rapports personnalisés",
      "API complète",
      "Formation sur site",
      "SLA garanti 99.99%",
      "Hébergement dédié",
    ],
    cta: "Nous contacter",
    popular: false,
  },
];

function PricingCard({ plan, index }) {
  const { ref, inView } = useInView();

  return (
    <div ref={ref} style={{ transitionDelay: `${index * 100}ms`, transitionDuration: "700ms" }} className={`transition-all ${inView ? "translate-y-0 opacity-100" : "translate-y-10 opacity-0"}`}>
      <Card
        className={`relative flex h-full flex-col p-8 ${
          plan.popular
            ? "border-2 border-primary shadow-2xl dark:border-primary-fixed-dim md:scale-105"
            : "border-border"
        } bg-card transition-shadow duration-300 hover:shadow-xl`}
      >
        {plan.popular ? (
          <div className="absolute -top-4 left-1/2 -translate-x-1/2">
            <span className="inline-flex items-center rounded-full bg-primary px-4 py-1 text-sm text-on-primary shadow-lg dark:bg-primary-fixed-dim dark:text-on-primary-fixed">
              <Star className="mr-1 h-3 w-3 fill-current" />
              Plus populaire
            </span>
          </div>
        ) : null}

        <div className="mb-8 text-center">
          <h3 className="mb-2 text-2xl font-bold text-card-foreground">{plan.name}</h3>
          <p className="mb-6 text-sm text-muted-foreground">{plan.description}</p>
          <div className="flex items-baseline justify-center gap-1">
            {plan.price === "Sur mesure" ? (
              <span className="text-3xl font-bold text-card-foreground">{plan.price}</span>
            ) : (
              <>
                <span className="text-5xl font-bold text-card-foreground">{plan.price}€</span>
                <span className="text-muted-foreground">{plan.period}</span>
              </>
            )}
          </div>
        </div>

        <Button
          className={`mb-8 w-full transition-colors duration-200 ${
            plan.popular
              ? "bg-primary text-on-primary hover:bg-on-primary-fixed-variant dark:bg-primary-fixed-dim dark:text-on-primary-fixed dark:hover:bg-primary-fixed"
                : "border-2 border-primary bg-transparent text-primary hover:bg-primary-fixed dark:border-primary-fixed-dim dark:text-primary-fixed-dim"
          }`}
          size="lg"
        >
          {plan.cta}
        </Button>

        <div className="flex-1 space-y-3">
          {plan.features.map((feature) => (
            <div key={feature} className="flex items-start gap-3">
              <Check className="mt-0.5 flex-shrink-0 text-success" size={18} />
              <span className="text-sm text-card-foreground/80">{feature}</span>
            </div>
          ))}
        </div>
      </Card>
    </div>
  );
}

export default function Pricing() {
  const { ref: headerRef, inView: headerInView } = useInView();
  const { ref: ctaRef, inView: ctaInView } = useInView();

  return (
    <section id="tarifs" className="relative overflow-hidden bg-background py-20 transition-colors duration-300 md:py-32 dark:bg-background-dark">
      <ThreeBackdrop className="absolute inset-x-0 top-0 mx-auto h-72 w-72 opacity-45 md:h-[30rem] md:w-[30rem]" count={12} mobileCount={6} intensity={0.35} />
      <div className="relative z-10 mx-auto w-full max-w-[min(1860px,98vw)] px-2 sm:px-3 lg:px-4">
        <div ref={headerRef} className={`mx-auto mb-16 max-w-3xl text-center transition-all duration-700 ${headerInView ? "translate-y-0 opacity-100" : "translate-y-8 opacity-0"}`}>
          <div className="mb-4 inline-block rounded-full bg-primary-fixed px-4 py-2 dark:bg-primary-fixed/20">
            <span className="text-sm font-semibold text-primary dark:text-primary-fixed-dim">Tarifs</span>
          </div>
          <h2 className="mb-6 text-3xl font-bold text-foreground md:text-5xl">Des tarifs transparents et évolutifs</h2>
          <p className="text-lg text-muted-foreground">
            Choisissez le plan qui correspond à vos besoins. Tous les plans incluent 14 jours d'essai gratuit.
          </p>
        </div>

        <div className="grid items-start gap-8 md:grid-cols-3">
          {plans.map((plan, index) => (
            <PricingCard key={plan.name} plan={plan} index={index} />
          ))}
        </div>

        <div ref={ctaRef} className={`mt-16 text-center transition-all duration-700 ${ctaInView ? "translate-y-0 opacity-100" : "translate-y-6 opacity-0"}`}>
          <p className="mb-4 text-muted-foreground">
            Besoin d'un plan personnalisé ? Notre équipe est là pour vous aider.
          </p>
          <Button
            variant="secondary"
            size="lg"
            className="border-primary text-primary hover:bg-primary-fixed dark:border-primary-fixed-dim dark:text-primary-fixed-dim dark:hover:bg-surface-dark"
          >
            Planifier une démo
          </Button>
        </div>
      </div>
    </section>
  );
}