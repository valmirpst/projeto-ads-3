import { visitsService } from "../../services/visits-service.js";

document.addEventListener("DOMContentLoaded", async () => {
  const container = document.getElementById("analytics-container");
  if (!container) return;

  const { data: visits, error } = await visitsService.fetchRecentVisits();
  if (error) {
    console.error("Erro ao carregar analytics:", error);
    container.innerHTML = `
            <div class="alert alert-danger border-0 mb-0">
                Erro ao carregar dados de acesso. Tente novamente mais tarde.
            </div>
        `;
    return;
  }

  if (!visits || visits.length === 0) {
    container.innerHTML = `
              <div class="alert alert-secondary border-0 mb-0">
                  <i class="bi bi-info-circle me-2"></i>Nenhum acesso registrado nos últimos 30 dias.
              </div>
          `;
    return;
  }

  // uso do reduce aq pra cumprir a rúbrica da sprint 1
  const stats = visits.reduce(
    (acc, visit) => {
      acc.page_views += 1;
      if (!acc.sessoesContadas[visit.session_id]) {
        acc.sessoesContadas[visit.session_id] = true;
        acc.unique_visitors += 1;
      }

      return acc;
    },
    {
      page_views: 0,
      unique_visitors: 0,
      sessoesContadas: {} as Record<string, boolean>,
    },
  );

  container.innerHTML = `
          <h5 class="card-title mb-4">Tráfego do Site (Últimos 30 dias)</h5>
          <div class="row text-center">
              <div class="col-6 border-end">
                  <h3 class="display-6 fw-bold text-primary mb-1">${stats.page_views}</h3>
                  <p class="text-muted mb-0">Visitas Totais</p>
              </div>
              <div class="col-6">
                  <h3 class="display-6 fw-bold text-success mb-1">${stats.unique_visitors}</h3>
                  <p class="text-muted mb-0">Visitantes Únicos</p>
              </div>
          </div>
      `;
});
