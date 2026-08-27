import { visitsService } from "../services/visits-service.js";

document.addEventListener("DOMContentLoaded", async () => {
  setTimeout(async () => {
    try {
      let sessionId = sessionStorage.getItem("cms_session");
      if (!sessionId) {
        sessionId = "sess_" + Date.now() + Math.random().toString(36).substr(2, 9);
        sessionStorage.setItem("cms_session", sessionId);
      }

      await visitsService.trackVisit(sessionId, window.location.pathname);
    } catch (e) {
      console.error("Erro ao registrar analytics:", e);
    }
  }, 1000);
});
