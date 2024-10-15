const preset = require("./vendor/filament/support/tailwind.config.preset");

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [preset],
    content: ["./resources/views/**/*.blade.php", "./src/**/*.php"],
    darkMode: "class",
    theme: {
        extend: {},
    },
};
