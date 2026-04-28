// Jawi Converter — Local Dictionary Mode
// Set GUNA_API_JAWI = true when external API (e.g. Ejawi) is ready
const GUNA_API_JAWI = false;

async function tukarKeJawi(rumiInputId, jawiOutputId) {
    const rumiEl = document.getElementById(rumiInputId);
    const jawiEl = document.getElementById(jawiOutputId);
    if (!rumiEl || !jawiEl) return;

    const rumiText = rumiEl.value.trim();
    if (!rumiText) { jawiEl.focus(); return; }

    let jawiText = '';

    if (GUNA_API_JAWI) {
        // ── MASA DEPAN: Panggilan API Ejawi ──────────────────────────────
        // const res = await fetch('https://api.ejawi.com/v1/convert', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/json' },
        //     body: JSON.stringify({ text: rumiText })
        // });
        // const data = await res.json();
        // jawiText = data.jawi || rumiText;
        // ─────────────────────────────────────────────────────────────────
    } else {
        jawiText = localRumiToJawiMapping(rumiText);
    }

    jawiEl.value = jawiText;
    jawiEl.focus();
}

function localRumiToJawiMapping(text) {
    // Digraphs — must be processed before single chars to avoid double-replacement
    const digraphs = {
        'ng': 'ڠ',
        'ny': 'ڽ',
        'sy': 'ش',
        'ch': 'چ',
        'kh': 'خ',
        'gh': 'غ',
        'th': 'ث',
    };

    // Single character mapping (Rumi → Jawi)
    const singles = {
        'a': 'ا',
        'b': 'ب',
        'c': 'چ',
        'd': 'د',
        'e': 'ي',
        'f': 'ف',
        'g': 'ݢ',
        'h': 'ه',
        'i': 'ي',
        'j': 'ج',
        'k': 'ک',
        'l': 'ل',
        'm': 'م',
        'n': 'ن',
        'o': 'و',
        'p': 'ڤ',
        'q': 'ق',
        'r': 'ر',
        's': 'س',
        't': 'ت',
        'u': 'و',
        'v': 'ۏ',
        'w': 'و',
        'x': 'يکس',
        'y': 'ي',
        'z': 'ز',
    };

    const lower = text.toLowerCase();
    let result = '';
    let i = 0;

    while (i < lower.length) {
        // Try digraph first (2-char lookahead)
        if (i + 1 < lower.length) {
            const two = lower[i] + lower[i + 1];
            if (digraphs[two]) {
                result += digraphs[two];
                i += 2;
                continue;
            }
        }
        // Single character
        const ch = lower[i];
        result += (singles[ch] !== undefined) ? singles[ch] : ch;
        i++;
    }

    return result;
}
