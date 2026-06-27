import { HomePage, FeaturesPage, LoginPage } from "../pages";

export const APP_ROUTES = [
  // ==========================
  // PUBLIC
  // ==========================
  {
    path: "/",
    title: "Accueil",
    layout: "public",
    requireAuth: false,
    component: HomePage,
  },
  {
    path: "/documentation",
    title: "Documentation",
    layout: "public",
    requireAuth: false,
    // component: DocumentationPage,
  },
  {
    path: "/features",
    title: "Documentation",
    layout: "public",
    requireAuth: false,
    component: FeaturesPage,
  },
  {
    path: "/pricing",
    title: "Tarifs",
    layout: "public",
    requireAuth: false,
    // component: PricingPage,
  },
  {
    path: "/about",
    title: "À propos",
    layout: "public",
    requireAuth: false,
    // component: AboutPage,
  },
  {
    path: "/contact",
    title: "Contact",
    layout: "public",
    requireAuth: false,
    // component: ContactPage,
  },

  // ==========================
  // AUTHENTIFICATION
  // ==========================
  {
    path: "/login",
    title: "Connexion",
    layout: "auth",
    requireAuth: false,
    component: LoginPage,
  },
  {
    path: "/logout",
    title: "Déconnexion",
    layout: "auth",
    requireAuth: false,
    // component: LogoutPage,
  },
  {
    path: "/get-started",
    title: "Créer un compte",
    layout: "auth",
    requireAuth: false,
    // component: RegisterPage,
  },
  {
    path: "/forgot-password",
    title: "Mot de passe oublié",
    layout: "auth",
    requireAuth: false,
    // component: ForgotPasswordPage,
  },
  {
    path: "/reset-password",
    title: "Réinitialiser",
    layout: "auth",
    requireAuth: false,
    // component: ResetPasswordPage,
  },
  {
    path: "/accept-invitation",
    title: "Invitation",
    layout: "auth",
    requireAuth: false,
    // component: AcceptInvitationPage,
  },
  {
    path: "/account/activate",
    title: "Activation compte",
    layout: "auth",
    requireAuth: false,
    // component: ActivateAccountPage,
  },

  // ==========================
  // ENTREPRISE
  // ==========================
  {
    path: "/company/register",
    title: "Créer entreprise",
    layout: "auth",
    requireAuth: false,
    // component: CompanyRegisterPage,
  },
  {
    path: "/company/configuration",
    title: "Configuration entreprise",
    layout: "auth",
    requireAuth: false,
    // component: CompanyConfigurationPage,
  },
  {
    path: "/company/activate",
    title: "Activation entreprise",
    layout: "auth",
    requireAuth: false,
    // component: CompanyActivationPage,
  },

  // ==========================
  // DASHBOARD
  // ==========================
  {
    path: "/dashboard",
    title: "Dashboard",
    layout: "dashboard",
    requireAuth: true,
    // component: DashboardPage,
  },

  // ... toutes les autres routes dashboard ...

  {
    path: "/403",
    title: "Accès refusé",
    layout: "auth",
    requireAuth: false,
    // component: ForbiddenPage,
  },
  {
    path: "/404",
    title: "Page introuvable",
    layout: "auth",
    requireAuth: false,
    // component: NotFoundPage,
  },
];
export const SIDEBAR_ITEMS = [
  {
    label: "Dashboard",
    icon: "dashboard",
    path: "/dashboard",
  },
  {
    label: "Produits",
    icon: "inventory_2",
    path: "/products",
  },
  {
    label: "Stock",
    icon: "inventory",
    path: "/stock",
  },
  {
    label: "Mouvements",
    icon: "swap_horiz",
    path: "/movements",
  },
  {
    label: "Documents",
    icon: "description",
    path: "/documents",
  },
  {
    label: "Entrepôts",
    icon: "warehouse",
    path: "/warehouses",
  },
  {
    label: "Utilisateurs",
    icon: "group",
    path: "/users",
  },
  {
    label: "Rapports",
    icon: "assessment",
    path: "/reports",
  },
  {
    label: "Paramètres",
    icon: "settings",
    path: "/settings",
  },
];
