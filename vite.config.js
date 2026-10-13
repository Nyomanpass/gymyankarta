import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import { randomUUID } from "node:crypto";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
        {
            name: "application-release",
            apply: "build",
            generateBundle() {
                this.emitFile({ type: "asset", fileName: "release.json", source: JSON.stringify({ version: randomUUID() }) });
            },
        },
    ],
    // server: {
    //     cors: true,
    //     host: "0.0.0.0",
    //     port: 5173,
    //     https: {
    //         key: fs.readFileSync("ssl/vite.key"),
    //         cert: fs.readFileSync("ssl/vite.crt"),
    //     },
    //     hmr: {
    //         host: process.env.VITE_DEV_SERVER_HOST || "192.168.110.234",
    //         protocol: "wss",
    //         port: 5173,
    //     },
    // },
});
