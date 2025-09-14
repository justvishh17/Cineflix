// js/ai-assistant.js - AI-powered features for movie recommendations and descriptions

/**
 * The core function that communicates with the Google Gemini API.
 * @param {string} prompt The question to send to the AI.
 * @returns {Promise<string>} The text response from the AI.
 */
async function callGeminiAPI(prompt) {
    // IMPORTANT: Paste your Google AI Studio API Key here.
    const apiKey = "PASTE YOUR KEY HERE";

    if (!apiKey || apiKey === "PASTE YOUR KEY HERE") {
        showCustomAlert("AI feature is not configured. API Key is missing.");
        return null;
    }
    const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${apiKey}`;

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ contents: [{ parts: [{ text: prompt }] }] })
        });
        if (!response.ok) {
            console.error("API Error Response:", await response.text());
            return "Error: Could not connect to the AI service.";
        }
        const result = await response.json();
        return result.candidates?.[0]?.content?.parts?.[0]?.text || "The AI did not provide a response.";
    } catch (error) {
        console.error("Fetch Error:", error);
        return "Error: Could not connect to the AI service.";
    }
}

/**
 * Handles the main AI Assistant modal for movie recommendations.
 */
async function handleAIAssistant() {
    const input = document.getElementById('ai-prompt-input');
    const responseArea = document.getElementById('ai-response-area');
    const query = input.value.trim();
    if (!query) return;

    responseArea.textContent = 'Thinking...';
    const movieList = JSON.stringify(movies.map(m => m.title));
    const prompt = `From this list of available titles: ${movieList}. Please recommend the single best title that matches this user's request: "${query}". Respond with ONLY the exact title from the list. If no title is a good match, respond with "None".`;
    
    const recommendedTitle = await callGeminiAPI(prompt);
    
    document.querySelectorAll('.movie-card').forEach(card => card.classList.remove('highlight'));
    
    if (recommendedTitle && recommendedTitle.toLowerCase() !== 'none' && !recommendedTitle.includes("Error")) {
        const cleanedTitle = recommendedTitle.trim().replace(/["'.]/g, ""); // Clean the title
        const matchedCard = document.querySelector(`.movie-card[data-title="${cleanedTitle}"]`);
        if (matchedCard) {
            responseArea.textContent = `I recommend "${cleanedTitle}". I've highlighted it for you!`;
            matchedCard.classList.add('highlight');
            matchedCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => document.getElementById('ai-assistant-modal').classList.remove('active'), 2500);
        } else {
            responseArea.textContent = `I found a match, "${cleanedTitle}", but couldn't locate it on the page.`;
        }
    } else {
        responseArea.textContent = "Sorry, I couldn't find a good match in our current library.";
    }
    input.value = '';
}

/**
 * Generates a new summary for a movie card.
 * @param {HTMLElement} button The button that was clicked.
 */
async function handleGetAiSummary(button) {
    const card = button.closest('.movie-card');
    const title = card.dataset.title;
    const descriptionEl = card.querySelector('.movie-description');

    button.innerHTML = 'Generating...';
    button.disabled = true;

    const prompt = `Generate a new, one-sentence, and exciting spoiler-free summary for the movie or series titled "${title}".`;
    const summary = await callGeminiAPI(prompt);

    if (summary && !summary.includes("Error")) {
        descriptionEl.textContent = summary;
        button.remove(); // Remove the button after use
    } else {
        showCustomAlert(summary || 'Could not generate AI summary.');
        button.innerHTML = '✨ AI Summary';
        button.disabled = false;
    }
}

/**
 * Generates a description for the admin forms.
 * @param {string} formPrefix Either 'add' or 'edit'.
 */
async function handleGenerateDescription(formPrefix) {
    const title = document.getElementById(`${formPrefix}-media-title`).value.trim();
    const year = document.getElementById(`${formPrefix}-media-year`).value.trim();
    const descTextarea = document.getElementById(`${formPrefix}-media-desc`);
    const button = document.getElementById(`${formPrefix}-generate-desc-btn`);

    if (!title || !year) {
        showCustomAlert('Please enter a Title and Year first.');
        return;
    }

    button.innerHTML = 'Generating...';
    button.disabled = true;

    const prompt = `Generate a compelling, one-sentence, spoiler-free description for the movie or series titled "${title}" (${year}).`;
    const description = await callGeminiAPI(prompt);

    if (description && !description.includes("Error")) {
        descTextarea.value = description.trim();
    } else {
        showCustomAlert(description || 'Could not generate a description.');
    }
    
    button.innerHTML = '✨ Generate Description';
    button.disabled = false;
}

/**
 * Finds similar movies based on the current movie (placeholder for future implementation)
 * @param {HTMLElement} button The button that was clicked
 */
async function handleFindSimilar(button) {
    const card = button.closest('.movie-card');
    const title = card.dataset.title;
    
    // This is a placeholder function for future implementation
    showCustomAlert(`Finding movies similar to "${title}" - Feature coming soon!`);
}

// Export functions if using modules (optional for direct script inclusion)
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        callGeminiAPI,
        handleAIAssistant,
        handleGetAiSummary,
        handleGenerateDescription,
        handleFindSimilar
    };
}