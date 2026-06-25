import api from "./api";

export const authService = {
  login: (payload) => api.post("/api/auth/login", payload),
  register: (payload) => api.post("/api/auth/register", payload),
  registerCompany: (payload) => api.post("/api/auth/register-company", payload),
  refresh: () => api.post("/api/auth/refresh"),
  verify: () => api.get("/api/auth/verify"),
  me: () => api.get("/api/auth/me"),
  logout: () => api.post("/api/auth/logout"),
  activateCompany: (payload) => api.post("/api/company/activate", payload),
};
