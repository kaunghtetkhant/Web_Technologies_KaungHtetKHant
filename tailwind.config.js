/** @type {import('tailwindcss').Config} */
export default {
    content: ["./index.html", "./src/**/*.{js,ts,jsx,tsx}"],
    theme: {
        extend: {
            fontFamily: {
                lato: ["Lato", "sans-serif"],
            },
            fontWeight: {
                light: "300",
                regular: "400",
                medium: "500",
                semibold: "600",
                bold: "700",
            },
            colors: {
                primary: "#E3462C",
                secondary: "#F9D045",
                accent: "#253239",
                surface: "#FFF8E7",
                neutral: "#F4F4F4",
            },
        },
    },
    plugins: [],
};
