import { AuthProvider } from "./contexts/AuthContext";
import PageLoader from "./components/ui/Loader";
import ToastContainer from "./components/ui/Toast";
import AppRouter from "./router";

export default function App() {
  return (
    <AuthProvider>
      <PageLoader />
      <ToastContainer />
      <AppRouter />
    </AuthProvider>
  );
}
