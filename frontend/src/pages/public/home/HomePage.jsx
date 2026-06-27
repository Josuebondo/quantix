import {
  Benefits,
  ContactCTA,
  Features,
  Hero,
  Platforms,
  Pricing,
} from "./components";

export default function HomePage() {
  return (
    <div className="overflow-hidden">
      <Hero />
      <Features />
      <Platforms />
      <Benefits />
      <Pricing />
      <ContactCTA />
    </div>
  );
}
