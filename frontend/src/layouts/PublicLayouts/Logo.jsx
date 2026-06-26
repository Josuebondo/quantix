import { Link } from "react-router-dom";
import logo from "../../assets/images/quantix_logo.jpeg";

export default function Logo() {
  return (
    <Link to="/" className="flex items-center gap-3">
      <img
        src={logo}
        alt="Quantix"
        className="h-10 w-10 rounded-xl object-cover"
      />

      <div className="hidden sm:block">
        <h1 className="text-lg font-bold text-primary">Quantix</h1>
        <p className="text-xs text-on-surface-variant">Smart Inventory</p>
      </div>
    </Link>
  );
}
