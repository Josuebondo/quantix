import api from "./api";

export const articleService = {
  list: () => api.get("/api/articles"),
};
