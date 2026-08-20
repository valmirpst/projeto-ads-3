export type HeroConfig = {
  backgroundImage?: string;
  textColor?: string;
  title?: string;
  subtitle?: string;
  buttonText?: string;
  buttonLink?: string;
  buttonColor?: string;
  buttonTextColor?: string;
};

export function renderHeroSection(config: HeroConfig): HTMLElement {
  const container = document.createElement("section");

  if (config.backgroundImage) {
    container.style.backgroundImage = `url(${config.backgroundImage})`;
    container.style.backgroundSize = "cover";
    container.style.backgroundPosition = "center";
    container.style.backgroundRepeat = "no-repeat";
  }

  container.style.padding = "4rem 2rem";
  container.style.display = "flex";
  container.style.flexDirection = "column";
  container.style.justifyContent = "center";
  container.style.alignItems = "center";
  container.style.minHeight = "85vh";
  container.style.textAlign = "center";
  container.style.color = config.textColor || "#000";

  const title = document.createElement("h1");
  title.textContent = config.title || "Default Hero Title";
  title.style.fontSize = "4rem";
  title.style.marginBottom = "1rem";
  title.style.maxWidth = "800px";
  container.appendChild(title);

  if (config.subtitle) {
    const subtitle = document.createElement("p");
    subtitle.textContent = config.subtitle;
    subtitle.style.fontSize = "1.5rem";
    subtitle.style.marginBottom = "2rem";
    subtitle.style.maxWidth = "800px";
    container.appendChild(subtitle);
  }

  if (config.buttonText) {
    const button = document.createElement("a");
    button.textContent = config.buttonText;
    button.href = config.buttonLink || "#";
    button.style.display = "inline-block";
    button.style.padding = "0.75rem 1.5rem";
    button.style.backgroundColor = config.buttonColor || "#007bff";
    button.style.color = config.buttonTextColor || "#fff";
    button.style.textDecoration = "none";
    button.style.borderRadius = "0.25rem";
    button.style.fontWeight = "bold";
    container.appendChild(button);
  }

  return container;
}
