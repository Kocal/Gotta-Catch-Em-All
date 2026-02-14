import { Controller } from "@hotwired/stimulus";

/**
 * Controller Stimulus unique pour gérer le toggle des Pokemon capturés.
 * Utilise un toggle optimiste pour une UX reactive instantanee.
 *
 * @extends Controller
 *
 * @property {HTMLElement} counterTarget - Element affichant le compteur de Pokemon capturés
 * @property {boolean} hasCounterTarget - Indique si le target counter existe
 * @property {string[]} caughtClasses - Classes CSS a appliquer quand un Pokemon est capture
 * @property {string[]} uncaughtClasses - Classes CSS a appliquer quand un Pokemon n'est pas capture
 */
export default class extends Controller {
    /** @type {string[]} */
    static targets = ["counter"];

    /** @type {string[]} */
    static classes = ["caught", "uncaught"];

    /**
     * Toggle le statut capture d'un Pokemon.
     *
     * @param {MouseEvent} event - L'evenement click sur le bouton Pokemon
     * @returns {Promise<void>}
     */
    async toggle(event) {
        event.preventDefault();

        const button = /** @type {HTMLButtonElement} */ (event.currentTarget);
        const img = /** @type {HTMLImageElement} */ (button.querySelector("img"));
        const toggleUrl = /** @type {string} */ (button.dataset.pokemonToggleUrl);
        const wasCaught = button.dataset.pokemonCaught === "true";

        // Toggle optimiste immediat
        this.#setCaughtState(button, img, !wasCaught);

        try {
            const response = await fetch(toggleUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
        } catch (error) {
            console.error("Erreur lors du toggle:", error);
            this.#setCaughtState(button, img, wasCaught);
        }
    }

    /**
     * Met a jour l'etat caught et les classes CSS associees.
     *
     * @param {HTMLButtonElement} button - Le bouton du Pokemon
     * @param {HTMLImageElement} img - L'image du Pokemon
     * @param {boolean} isCaught - Le nouvel etat de capture
     */
    #setCaughtState(button, img, isCaught) {
        const wasCaught = button.dataset.pokemonCaught === "true";
        button.dataset.pokemonCaught = isCaught.toString();

        if (isCaught) {
            img.classList.add(...this.caughtClasses);
            img.classList.remove(...this.uncaughtClasses);
        } else {
            img.classList.remove(...this.caughtClasses);
            img.classList.add(...this.uncaughtClasses);
        }

        // Met a jour le compteur
        if (wasCaught !== isCaught) {
            this.#updateCounter(isCaught ? 1 : -1);
        }
    }

    /**
     * Met a jour le compteur de Pokemon captures.
     *
     * @param {number} delta - La valeur a ajouter au compteur (+1 ou -1)
     */
    #updateCounter(delta) {
        if (this.hasCounterTarget) {
            const current = Number(this.counterTarget.textContent);
            this.counterTarget.textContent = (current + delta).toString();
        }
    }
}
