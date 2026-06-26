import api from "./api";

export const documentService = {
  list: () => api.get("/documents"),
  drafts: () => api.get("/document/brouillons"),
  create: (payload) => api.post("/document", payload),
};
