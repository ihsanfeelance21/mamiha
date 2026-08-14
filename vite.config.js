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

    rollupOptions: {
      input: 'src/css/app.css',
      output: {
        assetFileNames: 'css/[name].css' // File akan disimpan di public/css/app.css
      }
    }
  }
});