import { Controller } from "@hotwired/stimulus";

/**
 * Controller Stimulus pour rechercher et mettre en évidence les pokémons.
 * Intercepte Ctrl+F pour afficher un champ de recherche personnalisé.
 */
export default class extends Controller {
    static targets = ["input", "searchBox", "count"];
    static classes = ["highlight", "current"];

    /** @type {HTMLElement[]} */
    #matchedElements = [];

    /** @type {number} */
    #currentIndex = -1;

    connect() {
        document.addEventListener("keydown", this.#onKeyDown);
    }

    disconnect() {
        document.removeEventListener("keydown", this.#onKeyDown);
        this.#clearHighlights();
    }

    /**
     * Intercepte Ctrl+F pour ouvrir la recherche custom.
     * @param {KeyboardEvent} event
     */
    #onKeyDown = (event) => {
        if ((event.ctrlKey || event.metaKey) && event.key === "f") {
            event.preventDefault();
            this.open();
        }

        if (event.key === "Escape" && this.#isOpen()) {
            this.close();
        }
    };

    /**
     * Ouvre le champ de recherche.
     */
    open() {
        this.searchBoxTarget.classList.remove("hidden");
        this.inputTarget.focus();
        this.inputTarget.select();
    }

    /**
     * Ferme le champ de recherche.
     */
    close() {
        this.searchBoxTarget.classList.add("hidden");
        this.#clearHighlights();
        this.inputTarget.value = "";
        this.#updateCount();
    }

    /**
     * @returns {boolean}
     */
    #isOpen() {
        return !this.searchBoxTarget.classList.contains("hidden");
    }

    /**
     * Recherche en temps réel lors de la saisie.
     */
    search() {
        this.#clearHighlights();

        const query = this.inputTarget.value.trim().toLowerCase();
        if (!query) {
            this.#updateCount();
            return;
        }

        const srOnlyElements = this.element.querySelectorAll(".sr-only");

        for (const srOnly of srOnlyElements) {
            const text = srOnly.textContent?.toLowerCase() || "";
            if (text.includes(query)) {
                const parent = srOnly.parentElement;
                if (parent) {
                    parent.classList.add(...this.highlightClasses);
                    this.#matchedElements.push(parent);
                }
            }
        }

        this.#currentIndex = this.#matchedElements.length > 0 ? 0 : -1;
        this.#updateCurrentHighlight();
        this.#updateCount();
    }

    /**
     * Navigue vers le résultat suivant.
     * @param {KeyboardEvent} event
     */
    next(event) {
        event.preventDefault();
        if (this.#matchedElements.length === 0) return;

        this.#currentIndex = (this.#currentIndex + 1) % this.#matchedElements.length;
        this.#updateCurrentHighlight();
        this.#scrollToCurrent();
    }

    /**
     * Navigue vers le résultat précédent.
     * @param {KeyboardEvent} event
     */
    previous(event) {
        event.preventDefault();
        if (this.#matchedElements.length === 0) return;

        this.#currentIndex =
            this.#currentIndex <= 0 ? this.#matchedElements.length - 1 : this.#currentIndex - 1;
        this.#updateCurrentHighlight();
        this.#scrollToCurrent();
    }

    /**
     * Gère les touches dans le champ de recherche.
     * @param {KeyboardEvent} event
     */
    handleKeydown(event) {
        if (event.key === "Enter") {
            if (event.shiftKey) {
                this.previous(event);
            } else {
                this.next(event);
            }
        }
    }

    /**
     * Met à jour le highlight du résultat courant.
     */
    #updateCurrentHighlight() {
        // Retire la classe current de tous les éléments
        for (const el of this.#matchedElements) {
            el.classList.remove(...this.currentClasses);
        }

        // Ajoute la classe current à l'élément actuel
        if (this.#currentIndex >= 0 && this.#matchedElements[this.#currentIndex]) {
            this.#matchedElements[this.#currentIndex].classList.add(...this.currentClasses);
        }
    }

    /**
     * Scroll vers le résultat courant.
     */
    #scrollToCurrent() {
        if (this.#currentIndex >= 0 && this.#matchedElements[this.#currentIndex]) {
            this.#matchedElements[this.#currentIndex].scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        }
    }

    /**
     * Met à jour le compteur de résultats.
     */
    #updateCount() {
        if (this.hasCountTarget) {
            const total = this.#matchedElements.length;
            const current = total > 0 ? this.#currentIndex + 1 : 0;
            this.countTarget.textContent = `${current} / ${total}`;
        }
    }

    /**
     * Supprime tous les highlights.
     */
    #clearHighlights() {
        for (const el of this.#matchedElements) {
            el.classList.remove(...this.highlightClasses, ...this.currentClasses);
        }
        this.#matchedElements = [];
        this.#currentIndex = -1;
    }
}
