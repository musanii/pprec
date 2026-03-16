import defaultTheme from 'tailwindcss/defaultTheme'


export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                brand:{
                primary: "#1A56A4", // Royal Blue
                secondary: "#F4F6F9", // Grey
                accent:"#FFFFFF"
                }
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading:['Montserrat', 'sans-serif']
            },
        },
    },
    plugins: [],
};
