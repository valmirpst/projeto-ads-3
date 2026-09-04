import { visitsService } from "../../services/visits-service.js";
import { postsService } from "../../services/posts-service.js";

document.addEventListener("DOMContentLoaded", async () => {
  const container = document.getElementById("analytics-container");
  if (!container) return;

  const { data: visits, error: visitsError } = await visitsService.fetchRecentVisits();
  const { data: posts, error: postsError } = await postsService.fetchAllPosts();

  let htmlContent = "";

  if (visitsError) {
    htmlContent += `
        <div class="alert alert-danger border-0 mb-3">
            Erro ao carregar dados de acesso.
        </div>`;
  } else if (!visits || visits.length === 0) {
    htmlContent += `
        <div class="alert alert-secondary border-0 mb-3">
            <i class="bi bi-info-circle me-2"></i>Nenhum acesso registrado nos últimos 30 dias.
        </div>`;
  } else {
    const stats = visits.reduce(
      (acc, visit) => {
        acc.page_views += 1;
        if (!acc.sessoesContadas[visit.session_id]) {
          acc.sessoesContadas[visit.session_id] = true;
          acc.unique_visitors += 1;
        }
        return acc;
      },
      { page_views: 0, unique_visitors: 0, sessoesContadas: {} as Record<string, boolean> },
    );

    htmlContent += `
        <h5 class="card-title mb-4">Tráfego do Site (Últimos 30 dias)</h5>
        <div class="row text-center mb-4">
            <div class="col-6 border-end">
                <h3 class="display-6 fw-bold text-primary mb-1">${stats.page_views}</h3>
                <p class="text-muted mb-0">Visitas Totais</p>
            </div>
            <div class="col-6">
                <h3 class="display-6 fw-bold text-success mb-1">${stats.unique_visitors}</h3>
                <p class="text-muted mb-0">Visitantes Únicos</p>
            </div>
        </div>
        <hr class="my-4">
    `;
  }

  if (postsError) {
    htmlContent += `
        <div class="alert alert-danger border-0 mb-0">
            Erro ao carregar dados de posts.
        </div>`;
  } else if (!posts || posts.length === 0) {
    htmlContent += `
        <div class="alert alert-secondary border-0 mb-0">
            <i class="bi bi-info-circle me-2"></i>Nenhum post registrado ainda.
        </div>`;
  } else {
    const publishedPosts = posts.filter((p) => p.status === "published");
    const draftPosts = posts.filter((p) => p.status === "draft");

    const totalWords = publishedPosts.reduce((acc, post) => {
      const numeroDePalavras = post.content ? post.content.split(/\s+/).length : 0; // o regex /\s+/ é espaço em branco
      return acc + numeroDePalavras;
    }, 0);

    const recentFormattedPosts = publishedPosts
      .slice(0, 3)
      .map((post) => {
        const publishData = post.published_at ? new Date(post.published_at).toLocaleDateString("pt-BR") : "Sem data";
        return `<li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
        <span>${post.title}</span>
        <span class="badge bg-light text-dark rounded-pill">${publishData}</span>
              </li>`;
      })
      .join("");

    htmlContent += `
        <h5 class="card-title mb-4">Analytics de Conteúdo</h5>
        <div class="row text-center mb-4">
            <div class="col-4 border-end">
                <h3 class="display-6 fw-bold text-info mb-1">${publishedPosts.length}</h3>
                <p class="text-muted mb-0">Publicados</p>
            </div>
            <div class="col-4 border-end">
                <h3 class="display-6 fw-bold text-secondary mb-1">${draftPosts.length}</h3>
                <p class="text-muted mb-0">Rascunhos</p>
            </div>
            <div class="col-4">
                <h3 class="display-6 fw-bold text-warning mb-1">${totalWords}</h3>
                <p class="text-muted mb-0">Palavras Totais</p>
            </div>
        </div>
        
        <h6 class="mt-4 mb-3 text-muted fw-bold">ÚLTIMAS PUBLICAÇÕES</h6>
        <ul class="list-group list-group-flush">
            ${recentFormattedPosts || '<li class="list-group-item text-muted px-0">Nenhuma publicação recente.</li>'}
        </ul>
    `;
  }

  container.innerHTML = htmlContent;
});
