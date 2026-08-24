import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  publicDir: false,
  build: {
    // Output hasil build ke folder public CI4
    outDir: 'public',
    emptyOutDir: false,
    manifest: true,
    rollupOptions: {
      input: 'src/css/app.css',
      output: {
        assetFileNames: 'css/[name]-[hash].css' // cache busting via hash
      }
    }
  }
});