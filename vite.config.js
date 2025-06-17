import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import fs from "fs";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        host: "0.0.0.0",
        port: 5173,
        https: {
            key: fs.readFileSync("ssl/vite.key"),
            cert: fs.readFileSync("ssl/vite.crt"),
        },
        hmr: {
            host: process.env.VITE_DEV_SERVER_HOST || "10.1.3.242",
            protocol: "wss",
            port: 5173,
        },
    },
});
