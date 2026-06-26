import api from "./api";

export const userService = {
  me: () => api.get("/api/auth/me"),
  updateProfile: (payload) => api.put("/auth/profile", payload),
  changePassword: (payload) => api.post("/auth/change-password", payload),
};
