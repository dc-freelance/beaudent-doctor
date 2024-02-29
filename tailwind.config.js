const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: [
                    "Inter",
                    "Lexend Deca",
                    // "Plus Jakarta Sans",
                    ...defaultTheme.fontFamily.sans,
                ],
                poppins: "'Poppins', sans-serif",
            },
            colors: {
                primary: "#D04848",
                secondary: "#F000B8",
                accent: "#37CDBE",
                neutral: "#3D4451",
                "base-100": "#FFFFFF",
                info: "#3ABFF8",
                success: "#36D399",
                warning: "#F3B95F",
                error: "#F87272",
                accent: "#806043",
                neutral: "#3D4451",
                "base-100": "#FFFFFF",
            },
            fontWeight: {
                thin: 100,
                light: 300,
                normal: 400,
                medium: 500,
                semibold: 600,
                bold: 700,
                extrabold: 800,
                black: 900,
            },
            // font Size
            fontSize: {
                tiny: "0.5rem",
                xs: "0.75rem",
                sm: "0.8125rem",
                base: "1rem",
                lg: "1.125rem",
                xl: "1.25rem",
                "2xl": "1.5rem",
                "3xl": "1.875rem",
                "4xl": "2.25rem",
                "5xl": "3rem",
                "6xl": "4rem",
                "7xl": "5rem",
            },
        },
    },

    plugins: [
        require("flowbite/plugin")({
            charts: true,
        }),
    ],
};
