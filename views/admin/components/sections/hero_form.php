<div class="section-form-template d-none" data-type="hero">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" id="hero-title" name="title">
    </div>
    <div class="mb-3">
        <label class="form-label">Subtitle</label>
        <input type="text" class="form-control" id="hero-subtitle" name="subtitle">
    </div>
    <div class="mb-3">
        <label class="form-label">Background Image</label>
        <input type="file" class="form-control" id="hero-bg-image-file" name="backgroundImage_file" accept="image/*">
        <input type="hidden" id="hero-current-bg-image" name="currentBackgroundImage">
        <div id="hero-bg-image-preview" class="mt-2 d-none">
            <img src="" alt="Background Image Preview" style="height: 100px; object-fit: contain;">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Text Color</label>
        <input type="color" class="form-control form-control-color" id="hero-text-color" name="textColor" value="#000000">
    </div>

    <hr>
    <p class="text-muted small mb-2">Button (optional)</p>

    <div class="mb-3">
        <label class="form-label">Button Text</label>
        <input type="text" class="form-control" id="hero-btn-text" name="buttonText" placeholder="Ex: Saiba Mais">
    </div>
    <div class="mb-3">
        <label class="form-label">Button Link</label>
        <input type="text" class="form-control" id="hero-btn-link" name="buttonLink" placeholder="Ex: #sobre">
    </div>
    <div class="row">
        <div class="col-6 mb-3">
            <label class="form-label">Button Color</label>
            <input type="color" class="form-control form-control-color" id="hero-btn-color" name="buttonColor" value="#0d6efd">
        </div>
        <div class="col-6 mb-3">
            <label class="form-label">Button Text Color</label>
            <input type="color" class="form-control form-control-color" id="hero-btn-text-color" name="buttonTextColor" value="#ffffff">
        </div>
    </div>
</div>