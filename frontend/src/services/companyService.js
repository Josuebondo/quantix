import api from "./api";

export const companyService = {
  getTeams: () => api.get("/api/company/teams"),
  getTeamsList: () => api.get("/api/company/teams/list"),
  getEntrepots: () => api.get("/api/company/entrepots"),
  getMouvements: () => api.get("/api/company/mouvements"),
  getTeamData: () => api.get("/api/team/data"),
  inviteTeamMember: (payload) => api.post("/api/team/invite", payload),
  acceptInvitation: (payload) => api.post("/api/accept-invitation", payload),

  wizardInit: (payload) => api.post("/api/wizard/init", payload),
  wizardResume: () => api.get("/api/wizard/resume"),
  wizardAutosave: (payload) => api.post("/api/wizard/autosave", payload),
  wizardDeploy: (payload) => api.post("/api/wizard/deploy", payload),
  wizardPermissions: () => api.get("/api/wizard/permissions"),
  wizardGenerateSku: (payload) => api.post("/api/wizard/generate-sku", payload),
};
