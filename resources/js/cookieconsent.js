export function initCookieConsent() {
    if (!document.querySelector('link[href*="cookieconsent"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.css';
        document.head.appendChild(link);
    }

    if (!document.querySelector('script[src*="cookieconsent"]')) {
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/gh/orestbida/cookieconsent@3.1.0/dist/cookieconsent.umd.js';
        script.onload = () => {
            runCookieConsent();
        };
        document.head.appendChild(script);
    } else {
        runCookieConsent();
    }
}

function runCookieConsent() {
    // @ts-ignore
    if (typeof CookieConsent === 'undefined') {
        console.error('CookieConsent library not loaded');
        return;
    }

    // @ts-ignore
    CookieConsent.run({
        guiOptions: {
            consentModal: {
                layout: "box",
                position: "bottom right",
                equalWeightButtons: true,
                flipButtons: false
            },
            preferencesModal: {
                layout: "box",
                position: "right",
                equalWeightButtons: true,
                flipButtons: false
            }
        },
        categories: {
            necessary: {
                readOnly: true
            },
            functionality: {},
            analytics: {},
            marketing: {}
        },
        language: {
            default: "ca",
            autoDetect: "browser",
            translations: {
                ca: {
                    consentModal: {
                        title: "Benvingut a Hipatia",
                        description: "Fem servir cookies per assegurar el funcionament del lloc, recordar preferencies i entendre com s'utilitza la plataforma. Pots acceptar-les totes o configurar-les ara.",
                        acceptAllBtn: "Acceptar tot",
                        acceptNecessaryBtn: "Nomes necessaries",
                        showPreferencesBtn: "Configurar",
                        footer: "<a href=\"/privacy\">Politica de privacitat</a>\n<a href=\"/terms\">Termes d'ús</a>"
                    },
                    preferencesModal: {
                        title: "Preferencies de cookies",
                        acceptAllBtn: "Acceptar tot",
                        acceptNecessaryBtn: "Nomes necessaries",
                        savePreferencesBtn: "Desar preferencies",
                        closeIconLabel: "Tancar",
                        serviceCounterLabel: "Serveis",
                        sections: [
                            {
                                title: "Us de cookies",
                                description: "A Hipatia usem cookies per mantenir la sessio, recordar les preferencies i millorar el servei. Pots escollir quines categories vols activar."
                            },
                            {
                                title: "Cookies estrictament necessaries <span class=\"pm__badge\">Sempre actives</span>",
                                description: "Imprescindibles per a funcions basiques com l'autenticacio, la seguretat i la navegacio correcta.",
                                linkedCategory: "necessary"
                            },
                            {
                                title: "Cookies de funcionalitat",
                                description: "Guarden preferencies com l'idioma o opcions d'interficie per oferir-te una experiencia personalitzada.",
                                linkedCategory: "functionality"
                            },
                            {
                                title: "Cookies analytics",
                                description: "Ens ajuden a comprendre l'ús de la plataforma i a detectar punts de millora. Les dades son anonimitzades quan es possible.",
                                linkedCategory: "analytics"
                            },
                            {
                                title: "Cookies de marketing",
                                description: "S'utilitzen per mostrar comunicacions rellevants o mesurar campanyes, quan el servei ho requereix.",
                                linkedCategory: "marketing"
                            },
                            {
                                title: "Mes informacio",
                                description: "Si tens dubtes, pots <a class=\"cc__link\" href=\"/privacy\">consultar la politica de privacitat</a>."
                            }
                        ]
                    }
                }
            }
        }
    });
}