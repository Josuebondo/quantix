import { AuthProvider } from "./contexts/AuthContext";
import LoadingOverlay from "./components/ui/LoadingOverlay";
import ToastContainer from "./components/ui/Toast";
import AppRouter from "./router";

export default function App() {
  return (
    <AuthProvider>
      <LoadingOverlay />
      <ToastContainer />
      <AppRouter />
    </AuthProvider>
  );
}
