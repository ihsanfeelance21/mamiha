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
    // 👇 TAMBAHKAN BLOK WATCH INI 👇
    watch: {
      // Abaikan folder public agar hasil render tidak memicu render ulang
      exclude: ['public/**'] 
    },
    
    rollupOptions: {
      input: 'src/css/app.css',
      output: {
        assetFileNames: 'css/[name].css' // File akan disimpan di public/css/app.css
      }
    }
  }
});