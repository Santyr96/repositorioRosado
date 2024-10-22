/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                noto: ["Noto Sans JP", "sans-serif"],
                work: ["Work Sans", "sans-serif"],
            },
            transitionProperty: {
                'height': 'height',
              },
        },
    },
    plugins: [
        require("tailwindcss-animated"),
        function ({ addUtilities }) {
            addUtilities({
                ".text-shadow-purple": {
                    "text-shadow": "2px 2px 2px rgba(238, 153, 249, 0.8)",
                },
                ".text-shadow-lg": {
                    "text-shadow": "4px 4px 4px rgba(0, 0, 0, 0.7)",
                },
            });
        },
    ],
};
