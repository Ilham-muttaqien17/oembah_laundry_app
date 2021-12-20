const plugin = require("tailwindcss/plugin");
module.exports = {
    content: ["./page/*.{html,js}", "./page/*.{php}", "*.{html,js,php}"],
    theme: {
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
            colors: {
                "gray-soft": "#F7F4FF",
                "dark-blue": "#170055",
                hero: "#4813D9",
                "gold-yellow": "#FFB800",
            },
        },
    },
    plugins: [
        plugin(function ({ addUtilities }) {
            const utilities = {
                ".bg-hero-landing": {
                    "background-image": "url(/img/background-hero.svg)",
                    "background-size": "cover",
                    "background-position": "bottom",
                    "background-repeat": "no-repeat",
                },
            };
            addUtilities(utilities);
        }),
    ],
};
