import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
  plugins: [vue()],
  server: {
    host: "0.0.0.0",
    port: 3000,
  },
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
      "@assets": path.resolve(__dirname, "./src/assets"),
      "@icons": path.resolve(__dirname, "./src/assets/icons"),
      "@bg": path.resolve(__dirname, "./src/assets/bg"),
      "@main-components": path.resolve(__dirname, "./src/components/main"),
      "@user-components": path.resolve(__dirname, "./src/components/user"),
      "@school-components": path.resolve(__dirname, "./src/components/school"),
      "@admin-components": path.resolve(__dirname, "./src/components/admin"),
      "@subpages": path.resolve(__dirname, "./src/subpages"),
      "@auth": path.resolve(__dirname, "./src/auth"),
      "@user": path.resolve(__dirname, "./src/user"),
      "@school": path.resolve(__dirname, "./src/school"),
      "@admin": path.resolve(__dirname, "./src/admin"),
    },
  },
});
