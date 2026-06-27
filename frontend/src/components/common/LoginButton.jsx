import { Link } from "react-router-dom";
export default function LoginButton() {
  return (
    <Link className="py-2 text-left text-primary" to="/login">
      Connexion
    </Link>
  );
}
