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
  wizardResume: (sessionId) =>
    api.get("/api/wizard/resume", { params: { session: sessionId } }),
  wizardAutosave: (payload) =>
    api.post("/api/wizard/autosave", payload, {
      meta: { silentLoading: true },
      headers: { "X-Silent-Loading": "true" },
    }),
  wizardDeploy: (payload, idempotencyKey) =>
    api.post("/api/wizard/deploy", payload, {
      headers: {
        "X-Idempotency-Key":
          idempotencyKey || crypto?.randomUUID?.() || String(Date.now()),
      },
    }),
  wizardPermissions: () => api.get("/api/wizard/permissions"),
  wizardGenerateSku: (payload) => api.post("/api/wizard/generate-sku", payload),

  // Frontend aliases mapped to existing backend endpoints
  wizardGet: (sessionId) =>
    api.get("/api/wizard/resume", { params: { session: sessionId } }),
  wizardNext: (payload) =>
    api.post("/api/wizard/autosave", payload, {
      meta: { silentLoading: true },
      headers: { "X-Silent-Loading": "true" },
    }),
  wizardFinish: (payload) =>
    api.post("/api/wizard/deploy", payload, {
      headers: {
        "X-Idempotency-Key": crypto?.randomUUID?.() || String(Date.now()),
      },
    }),
};
